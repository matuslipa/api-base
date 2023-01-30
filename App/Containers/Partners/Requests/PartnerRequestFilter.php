<?php

declare(strict_types=1);

namespace App\Containers\Partners\Requests;

use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Containers\Partners\Models\Partner;
use App\Containers\Partners\Values\InputData\PartnerInputData;
use App\Core\Parents\Requests\RequestFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Containers\Partners
 */
final class PartnerRequestFilter extends RequestFilter
{
    public const FIELD_COMPANY_NAME = Partner::ATTR_COMPANY_NAME;

    public const FIELD_COMPANY_ICO = Partner::ATTR_COMPANY_ICO;

    public const FIELD_COMPANY_ADDRESS = Partner::ATTR_COMPANY_ADDRESS;

    public const FIELD_COMPANY_EMAIL = Partner::ATTR_COMPANY_EMAIL;

    public const FIELD_COMPANY_CONTACT_PERSON = Partner::ATTR_COMPANY_CONTACT_PERSON;

    public const FIELD_IS_DPH_PAYER = Partner::ATTR_IS_DPH_PAYER;

    public const FIELD_COMPANY_DIC = Partner::ATTR_COMPANY_DIC;

    public const FIELD_FILE_MARK = Partner::ATTR_FILE_MARK;

    public const FIELD_IC_DPH = Partner::ATTR_COMPANY_IC_DPH;

    public const FIELD_COMPANY_PHONE = Partner::ATTR_COMPANY_PHONE;

    public const FIELD_IS_ACTIVE = Partner::ATTR_IS_ACTIVE;

    /**
     * @param \Illuminate\Validation\Factory $validatorFactory
     * @param \App\Containers\Partners\Contracts\PartnersRepositoryInterface $partnersRepository
     */
    public function __construct(
        private readonly ValidatorFactory $validatorFactory,
        private readonly PartnersRepositoryInterface $partnersRepository,
    ) {
    }

    /**
     * Get values for model.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\Partners\Models\Partner|null $partner
     *
     * @return \App\Containers\Partners\Values\InputData\PartnerInputData
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getValidatedData(
        Request $request,
        ?Partner $partner = null
    ): PartnerInputData {
        $fields = $this->validate($request, $partner);
        $rawData = $request->only($fields);
        return new PartnerInputData($rawData);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\Partners\Models\Partner|null $partner
     *
     * @return string[] validated fields
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request, ?Partner $partner = null): array
    {
        $rules = $this->getRules($request, $partner);
        $validator = $this->validatorFactory->make($request->all(), $rules);
        $isDphPayer = (bool) $request->input(self::FIELD_IS_DPH_PAYER);
        $ico = $request->input(self::FIELD_COMPANY_ICO);
        $dic = $request->input(self::FIELD_COMPANY_DIC);
        $icDph = $request->input(self::FIELD_IC_DPH);

        if ($isDphPayer) {
            if ($ico === null) {
                $validator->errors()->add(self::FIELD_COMPANY_ICO, __('validation.required'));
                throw new ValidationException($validator);
            }

            if ($dic === null) {
                $validator->errors()->add(self::FIELD_COMPANY_DIC, __('validation.required'));
                throw new ValidationException($validator);
            }

            if ($icDph === null) {
                $validator->errors()->add(self::FIELD_IC_DPH, __('validation.required'));
                throw new ValidationException($validator);
            }
        }

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return \array_keys($rules);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\Partners\Models\Partner|null $partner
     * @return mixed[]
     */
    private function getRules(Request $request, ?Partner $partner = null): array
    {
        $isPatch = $request->isMethod(Request::METHOD_PATCH);

        $sometimesRequired = $isPatch ? 'sometimes' : 'required';

        return [
            self::FIELD_COMPANY_NAME => [
                $sometimesRequired,
                'string',
                'max:200',
                function (string $attribute, string $value, callable $fail) use ($partner): void {
                    $this->validateUniqueCompanyName($value, $partner, $fail);
                },
            ],
            self::FIELD_COMPANY_EMAIL => [
                $sometimesRequired,
                'email:rfc,dns',
                'max:' . Partner::LIMIT_EMAIL,
                function (string $attribute, string $value, callable $fail) use ($partner): void {
                    $this->validateUniqueEmail($value, $partner, $fail);
                },
            ],
            self::FIELD_COMPANY_PHONE => [
                $sometimesRequired,
                'string',
                'max:' . Partner::LIMIT_PHONE,
            ],
            self::FIELD_IS_ACTIVE => [
                $sometimesRequired,
                'bool',
            ],
            self::FIELD_IS_DPH_PAYER => [
                $sometimesRequired,
                'bool',
            ],
            self::FIELD_COMPANY_ADDRESS => [
                $sometimesRequired,
                'nullable',
                'string',
                'max:200',
            ],
            self::FIELD_COMPANY_CONTACT_PERSON => [
                $sometimesRequired,
                'nullable',
                'string',
                'max:200',
            ],
            self::FIELD_COMPANY_ICO => [
                $sometimesRequired,
                'string',
                'max:20',
            ],
            self::FIELD_COMPANY_DIC => [
                'present',
                'nullable',
                'string',
                'max:20',
            ],
            self::FIELD_FILE_MARK => [
                'present',
                'nullable',
                'string',
                'max:20',
            ],
            self::FIELD_IC_DPH => [
                'present',
                'nullable',
                'string',
                'max:30',
            ],
        ];
    }

    /**
     * Validate e-mail address is unique.
     *
     * @param string $value
     * @param \App\Containers\Partners\Models\Partner|null $partner
     * @param callable $fail
     */
    private function validateUniqueEmail(string $value, ?Partner $partner, callable $fail): void
    {
        $query = $this->partnersRepository->query()->whereEmail($value);

        if ($partner) {
            $query->wherePrimaryKeyNot($partner->getKey());
        }

        if ($query->someExists()) {
            $fail('validation.unique');
        }
    }

    /**
     * Validate e-mail address is unique.
     *
     * @param string $value
     * @param \App\Containers\Partners\Models\Partner|null $partner
     * @param callable $fail
     */
    private function validateUniqueCompanyName(string $value, ?Partner $partner, callable $fail): void
    {
        $query = $this->partnersRepository->query()->whereEmail($value);

        if ($partner) {
            $query->wherePrimaryKeyNot($partner->getKey());
        }

        if ($query->someExists()) {
            $fail('validation.unique');
        }
    }
}
