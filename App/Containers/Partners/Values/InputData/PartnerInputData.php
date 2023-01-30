<?php

declare(strict_types=1);

namespace App\Containers\Partners\Values\InputData;

/**
 * @package App\Containers\Partners
 */
final class PartnerInputData
{
    /**
     * @var bool
     */
    private bool $createInstance = false;

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

    /**
     * @return bool
     */
    public function getCreateInstance(): bool
    {
        return $this->createInstance;
    }

    /**
     * @param bool $createInstance
     */
    public function setCreateInstance(bool $createInstance): void
    {
        $this->createInstance = $createInstance;
    }
}
