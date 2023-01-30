<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Actions;

use App\Containers\PartnerProjects\Contracts\PartnerProjectsQueryInterface;
use App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\PartnerProjects
 */
final class GetAllPartnerProjectsAction
{
    /**
     * @param \App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface $partnerProjectsRepository
     */
    public function __construct(
        private readonly PartnerProjectsRepositoryInterface $partnerProjectsRepository
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection<\App\Containers\PartnerProjects\Models\PartnerProject>
     */
    public function run(): Collection
    {
        return $this->partnerProjectsRepository->query()->getAll();
    }

    /**
     * @param int $partnerId
     * @return \App\Containers\PartnerProjects\Contracts\PartnerProjectsQueryInterface
     */
    public function query(int $partnerId): PartnerProjectsQueryInterface
    {
        return $this->partnerProjectsRepository->query()->wherePartnerId($partnerId);
    }
}
