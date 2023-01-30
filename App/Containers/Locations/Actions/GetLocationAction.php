<?php

declare(strict_types=1);

namespace App\Containers\Locations\Actions;

use App\Containers\Locations\Contracts\LocationsRepositoryInterface;
use App\Containers\Locations\Models\Location;

/**
 * @package App\Containers\Locations
 */
final class GetLocationAction
{
    /**
     * @param \App\Containers\Locations\Contracts\LocationsRepositoryInterface $locationsRepository
     */
    public function __construct(
        private readonly LocationsRepositoryInterface $locationsRepository
    ) {
    }

    /**
     * @param int $id
     *
     * @return \App\Containers\Locations\Models\Location
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function run(int $id): Location
    {
        return $this->locationsRepository->get($id);
    }
}
