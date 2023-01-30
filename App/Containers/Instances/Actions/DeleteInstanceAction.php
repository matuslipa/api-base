<?php

declare(strict_types=1);

namespace App\Containers\Instances\Actions;

use App\Containers\Instances\Contracts\InstancesRepositoryInterface;
use App\Containers\Instances\Models\Instance;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\Instances
 */
final class DeleteInstanceAction
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
     * @throws \Throwable
     */
    public function run(Instance $instance): void
    {
        $this->databaseManager->transaction(function () use ($instance): void {
            $this->instancesRepository->delete($instance);
        });
    }
}
