<?php

declare(strict_types=1);

namespace App\Containers\Instances\Queries;

use App\Containers\Instances\Contracts\InstancesQueryInterface;
use App\Containers\Instances\Models\Instance;
use App\Core\Parents\Queries\QueryBuilder;

/**
 * @package App\Containers\Instances
 * @property \App\Containers\Instances\Models\Instance $model
 */
final class InstancesQueryBuilder extends QueryBuilder implements InstancesQueryInterface
{
    /**
     * @param string $identification
     * @return \App\Containers\Instances\Queries\InstancesQueryBuilder
     */
    public function whereIdentification(string $identification): self
    {
        return $this->where(Instance::ATTR_IDENTIFICATION, '=', $identification);
    }

    /**
     * @param string $domain
     * @return \App\Containers\Instances\Queries\InstancesQueryBuilder
     */
    public function whereDomain(string $domain): self
    {
        return $this->where(Instance::ATTR_DOMAIN, '=', $domain);
    }

    /**
     * @inheritDoc
     */
    public function whereHasApp(bool $hasApp = true): self
    {
        return $this->where(Instance::ATTR_HAS_APP, '=', $hasApp);
    }

    /**
     * @inheritDoc
     */
    public function whereIsDefault(bool $isDefault = true): self
    {
        return $this->where(Instance::ATTR_IS_DEFAULT, '=', $isDefault);
    }

    /**
     * @inheritDoc
     */
    public function whereName(string $name): self
    {
        return $this->where(Instance::ATTR_NAME, '=', $name);
    }

    /**
     * @inheritDoc
     */
    public function withLocations(): self
    {
        return $this->with(Instance::RELATION_LOCATIONS);
    }

    /**
     * @inheritDoc
     */
    public function withPartner(): self
    {
        return $this->with(Instance::RELATION_PARTNER);
    }
}
