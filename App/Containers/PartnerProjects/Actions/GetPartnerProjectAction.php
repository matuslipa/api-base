<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Actions;

use App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface;
use App\Containers\PartnerProjects\Models\PartnerProject;

/**
 * @package App\Containers\PartnerProjects
 */
final class GetPartnerProjectAction
{
    /**
     * @param \App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface $partnerProjectsRepository
     */
    public function __construct(
        private readonly PartnerProjectsRepositoryInterface $partnerProjectsRepository
    ) {
    }

    /**
     * @param int $id
     *
     * @return \App\Containers\PartnerProjects\Models\PartnerProject
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function run(int $id): PartnerProject
    {
        return $this->partnerProjectsRepository->get($id);
    }
}
