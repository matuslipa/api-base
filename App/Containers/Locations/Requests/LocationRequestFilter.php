<?php

declare(strict_types=1);

namespace App\Containers\Locations\Requests;

use App\Containers\Instances\Contracts\InstancesRepositoryInterface;
use App\Containers\Locations\Models\Location;
use App\Containers\Locations\Values\InputData\LocationInputData;
use App\Core\Parents\Requests\RequestFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Containers\Locations
 */
final class LocationRequestFilter extends RequestFilter
{
    public const FIELD_NAME = Location::ATTR_NAME;

    public const FIELD_CITY = Location::ATTR_CITY;

    public const FIELD_ADDRESS = Location::ATTR_ADDRESS;

    public const FIELD_INSTANCE_ID = Location::ATTR_INSTANCE_ID;

    /**
     * @param ValidatorFactory $validatorFactory
     * @param InstancesRepositoryInterface $instancesRepository
     */
    public function __construct(
        private readonly ValidatorFactory $validatorFactory,
        private readonly InstancesRepositoryInterface $instancesRepository,
    ) {
    }

    /**
     * Get values for model.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\Locations\Models\Location|null $location
     *
     * @return \App\Containers\Locations\Values\InputData\LocationInputData
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getValidatedData(
        Request $request,
        ?Location $location = null
    ): LocationInputData {
        $this->validate($request, $location);
        $rawData = $request->only([
            self::FIELD_NAME,
            self::FIELD_CITY,
            self::FIELD_ADDRESS,
            self::FIELD_INSTANCE_ID,
        ]);
        return new LocationInputData($rawData);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Containers\Locations\Models\Location|null $location
     *
     * @return string[] validated fields
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request, ?Location $location = null): array
    {
        $rules = $this->getRules($request, $location);
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
     * @param \App\Containers\Locations\Models\Location|null $location
     * @return mixed[]
     */
    private function getRules(Request $request, ?Location $location = null): array
    {
        $isPatch = $request->isMethod(Request::METHOD_PATCH);

        $sometimesRequired = $isPatch ? 'sometimes' : 'required';

        return [
            self::FIELD_NAME => [
                $sometimesRequired,
                'string',
                'max:190',
            ],
            self::FIELD_CITY => [
                $sometimesRequired,
                'string',
                'max:190',
            ],
            self::FIELD_ADDRESS => [
                $sometimesRequired,
                'string',
                'max:190',
            ],
            self::FIELD_INSTANCE_ID => [
                $sometimesRequired,
                'int',
                function (string $attribute, int $value, callable $fail): void {
                    $this->validateInstanceExist($value, $fail);
                },
            ],
        ];
    }

    /**
     * @param int $value
     * @param callable $fail
     */
    private function validateInstanceExist(int $value, callable $fail): void
    {
        $query = $this->instancesRepository->query()->wherePrimaryKey($value);

        if (! $query->someExists()) {
            $fail('validation.exists');
        }
    }
}
