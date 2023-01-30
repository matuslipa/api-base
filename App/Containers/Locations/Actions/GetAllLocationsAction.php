<?php

declare(strict_types=1);

namespace App\Containers\Locations\Actions;

use App\Containers\Locations\Contracts\LocationsQueryInterface;
use App\Containers\Locations\Contracts\LocationsRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Locations
 */
final class GetAllLocationsAction
{
    /**
     * @param \App\Containers\Locations\Contracts\LocationsRepositoryInterface $locationsRepository
     */
    public function __construct(
        private readonly LocationsRepositoryInterface $locationsRepository
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection<\App\Containers\Locations\Models\Location>
     */
    public function run(): Collection
    {
        return $this->query()->getAll();
    }

    /**
     * @return \App\Containers\Locations\Contracts\LocationsQueryInterface
     */
    public function query(): LocationsQueryInterface
    {
        return $this->locationsRepository->query();
    }
}
