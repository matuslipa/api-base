<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Repositories;

use App\Containers\PartnerProjects\Contracts\PartnerProjectsQueryInterface;
use App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface;
use App\Containers\PartnerProjects\Models\PartnerProject;
use App\Containers\PartnerProjects\Queries\PartnerProjectsQueryBuilder;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\PartnerProjects
 */
final class PartnerProjectsRepository implements PartnerProjectsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): PartnerProject
    {
        /** @var \App\Containers\PartnerProjects\Models\PartnerProject $partnerProject */
        $partnerProject = $this->query()->getById($id);
        return $partnerProject;
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
    public function create(array $data): PartnerProject
    {
        $partnerProject = new PartnerProject();
        $partnerProject->compactFill($data);
        $this->save($partnerProject);

        return $partnerProject;
    }

    /**
     * @inheritDoc
     */
    public function save(PartnerProject $partnerProject): void
    {
        $partnerProject->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(PartnerProject $partnerProject): void
    {
        $partnerProject->delete();
    }

    /**
     * @inheritDoc
     */
    public function query(): PartnerProjectsQueryInterface
    {
        return new PartnerProjectsQueryBuilder(new PartnerProject());
    }
}
