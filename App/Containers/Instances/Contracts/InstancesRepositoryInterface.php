<?php

declare(strict_types=1);

namespace App\Containers\Instances\Contracts;

use App\Containers\Instances\Models\Instance;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Instances
 */
interface InstancesRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return \App\Containers\Instances\Models\Instance
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): Instance;

    /**
     * @return \Illuminate\Support\Collection<\App\Containers\Instances\Models\Instance>
     */
    public function getAll(): Collection;

    /**
     * @param mixed[] $data
     * @return \App\Containers\Instances\Models\Instance
     */
    public function create(array $data): Instance;

    /**
     * @param \App\Containers\Instances\Models\Instance $instance
     */
    public function save(Instance $instance): void;

    /**
     * @param \App\Containers\Instances\Models\Instance $instance
     */
    public function delete(Instance $instance): void;

    /**
     * @return \App\Containers\Instances\Contracts\InstancesQueryInterface
     */
    public function query(): InstancesQueryInterface;
}
