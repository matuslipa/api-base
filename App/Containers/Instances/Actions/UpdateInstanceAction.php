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
final class UpdateInstanceAction
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
     * @param \App\Containers\Instances\Models\Instance $instance
     * @param \App\Containers\Instances\Values\InputData\InstanceInputData $data
     *
     * @return \App\Containers\Instances\Models\Instance
     *
     * @throws \Throwable
     */
    public function run(Instance $instance, InstanceInputData $data): Instance
    {
        return $this->databaseManager->transaction(function () use ($instance, $data): Instance {
            $instance->compactFill($data->getAttributes());
            $this->instancesRepository->save($instance);
            return $instance;
        });
    }
}
