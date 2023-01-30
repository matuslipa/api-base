<?php

declare(strict_types=1);

namespace App\Containers\Locations\Actions;

use App\Containers\Locations\Contracts\LocationsRepositoryInterface;
use App\Containers\Locations\Models\Location;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\Locations
 */
final class DeleteLocationAction
{
    /**
     * @param \App\Containers\Locations\Contracts\LocationsRepositoryInterface $locationsRepository
     * @param \Illuminate\Database\DatabaseManager $databaseManager
     */
    public function __construct(
        private readonly LocationsRepositoryInterface $locationsRepository,
        private readonly DatabaseManager $databaseManager,
    ) {
    }

    /**
     * @param \App\Containers\Locations\Models\Location $location
     * @throws \Throwable
     */
    public function run(Location $location): void
    {
        $this->databaseManager->transaction(function () use ($location): void {
            $this->locationsRepository->delete($location);
        });
    }
}
