<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Actions;

use App\Containers\PartnerProjects\Contracts\PartnerProjectsRepositoryInterface;
use App\Containers\PartnerProjects\Models\PartnerProject;
use App\Containers\PartnerProjects\Values\InputData\PartnerProjectInputData;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\PartnerProjects
 */
final class UpdatePartnerProjectAction
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
     * @param \App\Containers\PartnerProjects\Values\InputData\PartnerProjectInputData $data
     *
     * @return \App\Containers\PartnerProjects\Models\PartnerProject
     *
     * @throws \Throwable
     */
    public function run(PartnerProject $partnerProject, PartnerProjectInputData $data): PartnerProject
    {
        return $this->databaseManager->transaction(function () use ($partnerProject, $data): PartnerProject {
            $partnerProject->compactFill($data->getAttributes());
            $this->partnerProjectsRepository->save($partnerProject);
            return $partnerProject;
        });
    }
}
