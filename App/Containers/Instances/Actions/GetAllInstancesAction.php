<?php

declare(strict_types=1);

namespace App\Containers\Instances\Actions;

use App\Containers\Instances\Contracts\InstancesQueryInterface;
use App\Containers\Instances\Contracts\InstancesRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Instances
 */
final class GetAllInstancesAction
{
    /**
     * @param \App\Containers\Instances\Contracts\InstancesRepositoryInterface $instancesRepository
     */
    public function __construct(
        private readonly InstancesRepositoryInterface $instancesRepository
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection<\App\Containers\Instances\Models\Instance>
     */
    public function run(): Collection
    {
        return $this->query()->getAll();
    }

    /**
     * @return \App\Containers\Instances\Contracts\InstancesQueryInterface
     */
    public function query(): InstancesQueryInterface
    {
        return $this->instancesRepository->query();
    }
}
