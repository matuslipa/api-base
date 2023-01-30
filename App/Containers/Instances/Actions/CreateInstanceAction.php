<?php

declare(strict_types=1);

namespace App\Containers\Instances\Actions;

use App\Containers\Instances\Contracts\InstancesRepositoryInterface;
use App\Containers\Instances\Models\Instance;
use App\Containers\Instances\Values\InputData\InstanceInputData;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\Instances
 */
final class CreateInstanceAction
{
    /**
     * @param \App\Containers\Instances\Contracts\InstancesRepositoryInterface $instancesRepository
     * @param \Illuminate\Database\DatabaseManager $databaseManager
     */
    public function __construct(
        private readonly InstancesRepositoryInterface $instancesRepository,
        private readonly DatabaseManager $databaseManager,
    ) {
    }

    /**
     * @param \App\Containers\Instances\Values\InputData\InstanceInputData $data
     *
     * @return \App\Containers\Instances\Models\Instance
     *
     * @throws \Throwable
     */
    public function run(InstanceInputData $data): Instance
    {
        return $this->databaseManager->transaction(function () use ($data): Instance {
            return $this->instancesRepository->create($data->getAttributes());
        });
    }
}
