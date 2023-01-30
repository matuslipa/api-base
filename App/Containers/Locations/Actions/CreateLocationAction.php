<?php

declare(strict_types=1);

namespace App\Containers\Locations\Actions;

use App\Containers\Locations\Contracts\LocationsRepositoryInterface;
use App\Containers\Locations\Models\Location;
use App\Containers\Locations\Values\InputData\LocationInputData;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\Locations
 */
final class CreateLocationAction
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
     * @param \App\Containers\Locations\Values\InputData\LocationInputData $data
     *
     * @return \App\Containers\Locations\Models\Location
     *
     * @throws \Throwable
     */
    public function run(LocationInputData $data): Location
    {
        return $this->databaseManager->transaction(function () use ($data): Location {
            return $this->locationsRepository->create($data->getAttributes());
        });
    }
}
