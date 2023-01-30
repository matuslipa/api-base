<?php

declare(strict_types=1);

namespace App\Containers\Instances\Actions;

use App\Containers\Instances\Contracts\InstancesRepositoryInterface;
use App\Containers\Instances\Models\Instance;

/**
 * @package App\Containers\Instances
 */
final class GetInstanceAction
{
    /**
     * @param \App\Containers\Instances\Contracts\InstancesRepositoryInterface $instancesRepository
     */
    public function __construct(
        private readonly InstancesRepositoryInterface $instancesRepository
    ) {
    }

    /**
     * @param int $id
     *
     * @return \App\Containers\Instances\Models\Instance
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function run(int $id): Instance
    {
        return $this->instancesRepository->get($id);
    }
}
