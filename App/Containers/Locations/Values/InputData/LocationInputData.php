<?php

declare(strict_types=1);

namespace App\Containers\Locations\Values\InputData;

/**
 * @package App\Containers\Locations
 */
final class LocationInputData
{
    /**
     * @param array $attributes
     */
    public function __construct(
        private readonly array $attributes,
    ) {
    }

    /**
     * @return mixed[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
