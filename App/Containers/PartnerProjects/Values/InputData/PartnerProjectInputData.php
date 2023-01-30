<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Values\InputData;

/**
 * @package App\Containers\PartnerProjects
 */
final class PartnerProjectInputData
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
