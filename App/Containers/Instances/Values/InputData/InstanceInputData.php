<?php

declare(strict_types=1);

namespace App\Containers\Instances\Values\InputData;

use App\Containers\Instances\Models\Instance;

/**
 * @package App\Containers\Instances
 */
final class InstanceInputData
{
    /**
     * @param array $attributes
     */
    public function __construct(
        private array $attributes,
    ) {
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->attributes[Instance::ATTR_NAME] = $name;
    }

    /**
     * @param string $name
     */
    public function setIdentification(string $name): void
    {
        $this->attributes[Instance::ATTR_IDENTIFICATION] = $name;
    }

    /**
     * @param string $name
     */
    public function setPrimaryColor(string $name): void
    {
        $this->attributes[Instance::ATTR_PRIMARY_COLOR] = $name;
    }

    /**
     * @param string $name
     */
    public function setSecondaryColor(string $name): void
    {
        $this->attributes[Instance::ATTR_SECONDARY_COLOR] = $name;
    }

    /**
     * @param string $name
     */
    public function setDomain(string $name): void
    {
        $this->attributes[Instance::ATTR_DOMAIN] = $name;
    }

    /**
     * @param string $name
     */
    public function setButtonColor(string $name): void
    {
        $this->attributes[Instance::ATTR_BUTTON_COLOR] = $name;
    }

    /**
     * @param string $name
     */
    public function setTextColor(string $name): void
    {
        $this->attributes[Instance::ATTR_TEXT_COLOR] = $name;
    }

    /**
     * @param int $id
     */
    public function setPartnerId(int $id): void
    {
        $this->attributes[Instance::ATTR_PARTNER_ID] = $id;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->attributes[Instance::ATTR_IS_ACTIVE] = $isActive;
    }

    /**
     * @return mixed[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param mixed[] $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }
}
