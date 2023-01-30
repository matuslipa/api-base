<?php

declare(strict_types=1);

namespace App\Containers\Instances\Repositories;

use App\Containers\Instances\Contracts\InstancesQueryInterface;
use App\Containers\Instances\Contracts\InstancesRepositoryInterface;
use App\Containers\Instances\Models\Instance;
use App\Containers\Instances\Queries\InstancesQueryBuilder;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Instances
 */
final class InstancesRepository implements InstancesRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Instance
    {
        /** @var \App\Containers\Instances\Models\Instance $instance */
        $instance = $this->query()->getById($id);
        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): Collection
    {
        return $this->query()->getAll();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Instance
    {
        $instance = new Instance();
        $instance->compactFill($data);
        $this->save($instance);

        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function save(Instance $instance): void
    {
        $instance->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Instance $instance): void
    {
        $instance->delete();
    }

    /**
     * @inheritDoc
     */
    public function query(): InstancesQueryInterface
    {
        return new InstancesQueryBuilder(new Instance());
    }
}
