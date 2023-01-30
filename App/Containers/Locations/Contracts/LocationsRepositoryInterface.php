<?php

declare(strict_types=1);

namespace App\Containers\Locations\Contracts;

use App\Containers\Locations\Models\Location;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Locations
 */
interface LocationsRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return \App\Containers\Locations\Models\Location
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): Location;

    /**
     * @return \Illuminate\Support\Collection<\App\Containers\Locations\Models\Location>
     */
    public function getAll(): Collection;

    /**
     * @param mixed[] $data
     * @return \App\Containers\Locations\Models\Location
     */
    public function create(array $data): Location;

    /**
     * @param \App\Containers\Locations\Models\Location $location
     */
    public function save(Location $location): void;

    /**
     * @param \App\Containers\Locations\Models\Location $location
     */
    public function delete(Location $location): void;

    /**
     * @return \App\Containers\Locations\Contracts\LocationsQueryInterface
     */
    public function query(): LocationsQueryInterface;
}
