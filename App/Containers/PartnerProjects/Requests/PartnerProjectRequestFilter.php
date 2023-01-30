<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Requests;

use App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface;
use App\Containers\PartnerProjects\Models\PartnerProject;
use App\Containers\PartnerProjects\Values\InputData\PartnerProjectInputData;
use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Core\Parents\Requests\RequestFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Containers\PartnerProjects
 */
final class PartnerProjectRequestFilter extends RequestFilter
{
    public const FIELD_NAME = PartnerProject::ATTR_NAME;

    public const FIELD_PARTNER_ID = PartnerProject::ATTR_PARTNER_ID;

    public const FIELD_IS_ACTIVE = PartnerProject::ATTR_IS_ACTIVE;

    /**
     * @param \Illuminate\Validation\Factory $validatorFactory
     * @param \App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface $partnerProjectsRepository
     * @param \App\Containers\Partners\Contracts\PartnersRepositoryInterface $partnersRepository
     */
    public function __construct(
        private readonly ValidatorFactory $validatorFactory,
        private readonly PartnerProjectsRepositoryInterface $partnerProjectsRepository,
        private readonly PartnersRepositoryInterface $partnersRepository
    ) {
    }

    /**
     * Get values for model.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\PartnerProjects\Models\PartnerProject|null $partnerProject
     *
     * @return \App\Containers\PartnerProjects\Values\InputData\PartnerProjectInputData
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getValidatedData(
        Request $request,
        ?PartnerProject $partnerProject = null
    ): PartnerProjectInputData {
        $fields = $this->validate($request, $partnerProject);
        $rawData = $request->only($fields);
        return new PartnerProjectInputData($rawData);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\PartnerProjects\Models\PartnerProject|null $partnerProject
     *
     * @return string[] validated fields
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request, ?PartnerProject $partnerProject = null): array
    {
        $rules = $this->getRules($request);
        $validator = $this->validatorFactory->make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return \array_keys($rules);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed[]
     */
    private function getRules(Request $request): array
    {
        $isPatch = $request->isMethod(Request::METHOD_PATCH);

        $sometimesRequired = $isPatch ? 'sometimes' : 'required';

        $partnerId = (int) $request->input(self::FIELD_PARTNER_ID);

        return [
            self::FIELD_PARTNER_ID => [
                $sometimesRequired,
                'int',
                function (string $attribute, int $id, callable $fail): void {
                    $this->validatePartnerExist($id, $fail);
                },
            ],
            self::FIELD_NAME => [
                $sometimesRequired,
                'string',
                'max:200',
                function (string $attribute, string $name, callable $fail) use ($partnerId): void {
                    $this->validateProjectNameExist($name, $partnerId, $fail);
                },
            ],
            self::FIELD_IS_ACTIVE => [
                $sometimesRequired,
                'bool',
            ],
        ];
    }

    /**
     * @param int $id
     * @param callable $fail
     */
    private function validatePartnerExist(int $id, callable $fail): void
    {
        $exists = $this->partnersRepository->query()->wherePrimaryKey($id)->someExists();

        if (! $exists) {
            $fail('validation.exists');
        }
    }

    /**
     * @param string $name
     * @param int $id
     * @param callable $fail
     */
    private function validateProjectNameExist(string $name, int $id, callable $fail): void
    {
        $exists = $this->partnerProjectsRepository->query()->wherePartnerId($id)->whereName($name)->someExists();

        if ($exists) {
            $fail('validation.exists');
        }
    }
}
