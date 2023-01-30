<?php

declare(strict_types=1);

namespace App\Containers\Instances\Requests;

use App\Containers\Instances\Contracts\InstancesRepositoryInterface;
use App\Containers\Instances\Models\Instance;
use App\Containers\Instances\Values\InputData\InstanceInputData;
use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Core\Parents\Requests\RequestFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Containers\Instances
 */
final class InstanceRequestFilter extends RequestFilter
{
    public const FIELD_NAME = Instance::ATTR_NAME;

    public const FIELD_IDENTIFICATION = Instance::ATTR_IDENTIFICATION;

    public const FIELD_DOMAIN = Instance::ATTR_DOMAIN;

    public const FIELD_PRIMARY_COLOR = Instance::ATTR_PRIMARY_COLOR;

    public const FIELD_SECONDARY_COLOR = Instance::ATTR_SECONDARY_COLOR;

    public const FIELD_BUTTON_COLOR = Instance::ATTR_BUTTON_COLOR;

    public const FIELD_TEXT_COLOR = Instance::ATTR_TEXT_COLOR;

    public const FIELD_PARTNER_ID = Instance::ATTR_PARTNER_ID;

    public const FIELD_IS_ACTIVE = Instance::ATTR_IS_ACTIVE;

    /**
     * @param \Illuminate\Validation\Factory $validatorFactory
     * @param \App\Containers\Instances\Contracts\InstancesRepositoryInterface $instancesRepository
     * @param \App\Containers\Partners\Contracts\PartnersRepositoryInterface $partnersRepository
     */
    public function __construct(
        private readonly ValidatorFactory $validatorFactory,
        private readonly InstancesRepositoryInterface $instancesRepository,
        private readonly PartnersRepositoryInterface $partnersRepository
    ) {
    }

    /**
     * Get values for model.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\Instances\Models\Instance|null $instance
     *
     * @return \App\Containers\Instances\Values\InputData\InstanceInputData
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getValidatedData(
        Request $request,
        ?Instance $instance = null
    ): InstanceInputData {
        $fields = $this->validate($request, $instance);
        $rawData = $request->only($fields);
        $data = new InstanceInputData([]);

        if (isset($rawData[self::FIELD_NAME])) {
            $data->setName($rawData[self::FIELD_NAME]);
        }

        if (isset($rawData[self::FIELD_IDENTIFICATION])) {
            $data->setIdentification($rawData[self::FIELD_IDENTIFICATION]);
        }

        if (isset($rawData[self::FIELD_DOMAIN])) {
            $data->setDomain($rawData[self::FIELD_DOMAIN]);
        }

        if (isset($rawData[self::FIELD_PRIMARY_COLOR])) {
            $data->setPrimaryColor($rawData[self::FIELD_PRIMARY_COLOR]);
        }

        if (isset($rawData[self::FIELD_SECONDARY_COLOR])) {
            $data->setSecondaryColor($rawData[self::FIELD_SECONDARY_COLOR]);
        }

        if (isset($rawData[self::FIELD_BUTTON_COLOR])) {
            $data->setButtonColor($rawData[self::FIELD_BUTTON_COLOR]);
        }

        if (isset($rawData[self::FIELD_TEXT_COLOR])) {
            $data->setTextColor($rawData[self::FIELD_TEXT_COLOR]);
        }

        if (isset($rawData[self::FIELD_IS_ACTIVE])) {
            $data->setIsActive((bool) $rawData[self::FIELD_IS_ACTIVE]);
        }

        if (isset($rawData[self::FIELD_PARTNER_ID])) {
            $data->setPartnerId((int) $rawData[self::FIELD_PARTNER_ID]);
        }

        return $data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\Instances\Models\Instance|null $instance
     *
     * @return string[] validated fields
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request, ?Instance $instance = null): array
    {
        $rules = $this->getRules($request, $instance);
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
     * @param \App\Containers\Instances\Models\Instance|null $instance
     * @return mixed[]
     */
    private function getRules(Request $request, ?Instance $instance = null): array
    {
        $isPatch = $request->isMethod(Request::METHOD_PATCH);

        $sometimesRequired = $isPatch ? 'sometimes' : 'required';

        $rules = [
            self::FIELD_NAME => [
                $sometimesRequired,
                'string',
                'max:50',
            ],
            self::FIELD_PARTNER_ID => [
                'present',
                'int',
                'nullable',
                function (string $attribute, int $value, callable $fail): void {
                    $this->validatePartnerExist($value, $fail);
                },
            ],
            self::FIELD_IS_ACTIVE => [
                'sometimes',
                'bool',
                'nullable',
            ],
        ];

        $rules += [
            self::FIELD_IDENTIFICATION => [
                $sometimesRequired,
                'string',
                'max:50',
                function (string $attribute, string $value, callable $fail) use ($instance): void {
                    $this->validateUniqueIdentification($value, $instance, $fail);
                },
            ],
            self::FIELD_DOMAIN => [
                $sometimesRequired,
                'string',
                'max:50',
                function (string $attribute, string $value, callable $fail) use ($instance): void {
                    $this->validateUniqueDomain($value, $instance, $fail);
                },
            ],
            self::FIELD_PRIMARY_COLOR => [
                $sometimesRequired,
                'string',
                'min:7',
                'max:7',
            ],
            self::FIELD_SECONDARY_COLOR => [
                $sometimesRequired,
                'string',
                'min:7',
                'max:7',
            ],
            self::FIELD_BUTTON_COLOR => [
                $sometimesRequired,
                'string',
                'min:7',
                'max:7',
            ],
            self::FIELD_TEXT_COLOR => [
                $sometimesRequired,
                'string',
                'min:7',
                'max:7',
            ],
        ];

        return $rules;
    }

    /**
     * @param int|null $value
     * @param callable $fail
     */
    private function validatePartnerExist(?int $value, callable $fail): void
    {
        if ($value === null) {
            return;
        }

        $query = $this->partnersRepository->query()->wherePrimaryKey($value);

        if (! $query->someExists()) {
            $fail('validation.exists');
        }
    }

    /**
     * @param string $value
     * @param \App\Containers\Instances\Models\Instance|null $instance
     * @param callable $fail
     */
    private function validateUniqueDomain(string $value, ?Instance $instance, callable $fail): void
    {
        $query = $this->instancesRepository->query()->whereDomain($value);

        if ($instance) {
            $query->wherePrimaryKeyNot($instance->getKey());
        }

        if ($query->someExists()) {
            $fail('validation.exists');
        }
    }

    /**
     * @param string $value
     * @param \App\Containers\Instances\Models\Instance|null $instance
     * @param callable $fail
     */
    private function validateUniqueIdentification(string $value, ?Instance $instance, callable $fail): void
    {
        $query = $this->instancesRepository->query()->whereIdentification($value);

        if ($instance) {
            $query->wherePrimaryKeyNot($instance->getKey());
        }

        if ($query->someExists()) {
            $fail('validation.exists');
        }
    }
}
