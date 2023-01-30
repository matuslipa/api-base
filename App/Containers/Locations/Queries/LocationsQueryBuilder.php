<?php

declare(strict_types=1);

namespace App\Containers\Locations\Queries;

use App\Containers\Locations\Contracts\LocationsQueryInterface;
use App\Containers\Locations\Models\Location;
use App\Core\Parents\Queries\QueryBuilder;

/**
 * @package App\Containers\Locations
 * @property \App\Containers\Locations\Models\Location $model
 */
final class LocationsQueryBuilder extends QueryBuilder implements LocationsQueryInterface
{
    /**
     * @inheritDoc
     */
    public function withInstance(): self
    {
        return $this->with(Location::RELATION_INSTANCE);
    }

    /**
     * @inheritDoc
     */
    public function withProducts(): self
    {
        return $this->with(Location::RELATION_PRODUCTS);
    }

    /**
     * @inheritDoc
     */
    public function withSlotConfig(): self
    {
        return $this->with(Location::RELATION_SLOT_CONFIGS);
    }

    /**
     * @inheritDoc
     */
    public function whereInstanceId(int $instanceId): self
    {
        return $this->where(Location::ATTR_INSTANCE_ID, '=', $instanceId);
    }

    /**
     * @inheritDoc
     */
    public function whereName(string $value): self
    {
        return $this->where(Location::ATTR_NAME, '=', $value);
    }
}
