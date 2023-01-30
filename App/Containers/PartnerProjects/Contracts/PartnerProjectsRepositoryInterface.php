<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Contracts;

use App\Containers\PartnerProjects\Models\PartnerProject;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\PartnerProjects
 */
interface PartnerProjectsRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return \App\Containers\PartnerProjects\Models\PartnerProject
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): PartnerProject;

    /**
     * @return \Illuminate\Support\Collection<\App\Containers\PartnerProjects\Models\PartnerProject>
     */
    public function getAll(): Collection;

    /**
     * @param mixed[] $data
     * @return \App\Containers\PartnerProjects\Models\PartnerProject
     */
    public function create(array $data): PartnerProject;

    /**
     * @param \App\Containers\PartnerProjects\Models\PartnerProject $partnerProject
     */
    public function save(PartnerProject $partnerProject): void;

    /**
     * @param \App\Containers\PartnerProjects\Models\PartnerProject $partnerProject
     */
    public function delete(PartnerProject $partnerProject): void;

    /**
     * @return \App\Containers\PartnerProjects\Contracts\PartnerProjectsQueryInterface
     */
    public function query(): PartnerProjectsQueryInterface;
}
