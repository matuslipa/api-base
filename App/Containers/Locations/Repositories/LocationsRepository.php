<?php

declare(strict_types=1);

namespace App\Containers\Locations\Repositories;

use App\Containers\Locations\Contracts\LocationsQueryInterface;
use App\Containers\Locations\Contracts\LocationsRepositoryInterface;
use App\Containers\Locations\Models\Location;
use App\Containers\Locations\Queries\LocationsQueryBuilder;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Locations
 */
final class LocationsRepository implements LocationsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Location
    {
        /** @var \App\Containers\Locations\Models\Location $location */
        $location = $this->query()->getById($id);
        return $location;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): Collection
    {
        return $this->query()->getAll();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Location
    {
        $location = new Location();
        $location->compactFill($data);
        $this->save($location);

        return $location;
    }

    /**
     * @inheritDoc
     */
    public function save(Location $location): void
    {
        $location->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Location $location): void
    {
        $location->delete();
    }

    /**
     * @inheritDoc
     */
    public function query(): LocationsQueryInterface
    {
        return new LocationsQueryBuilder(new Location());
    }
}
