<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Actions;

use App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface;
use App\Containers\PartnerProjects\Models\PartnerProject;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\PartnerProjects
 */
final class DeletePartnerProjectAction
{
    /**
     * @param \App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface $partnerProjectsRepository
     * @param \Illuminate\Database\DatabaseManager $databaseManager
     */
    public function __construct(
        private readonly PartnerProjectsRepositoryInterface $partnerProjectsRepository,
        private readonly DatabaseManager $databaseManager,
    ) {
    }

    /**
     * @param \App\Containers\PartnerProjects\Models\PartnerProject $partnerProject
     * @throws \Throwable
     */
    public function run(PartnerProject $partnerProject): void
    {
        $this->databaseManager->transaction(function () use ($partnerProject): void {
            $this->partnerProjectsRepository->delete($partnerProject);
        });
    }
}
