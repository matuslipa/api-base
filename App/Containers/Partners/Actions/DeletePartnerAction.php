<?php

declare(strict_types=1);

namespace App\Containers\Partners\Actions;

use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Containers\Partners\Models\Partner;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\Partners
 */
final class DeletePartnerAction
{
    /**
     * @param \App\Containers\Partners\Contracts\PartnersRepositoryInterface $partnersRepository
     * @param \Illuminate\Database\DatabaseManager $databaseManager
     */
    public function __construct(
        private readonly PartnersRepositoryInterface $partnersRepository,
        private readonly DatabaseManager $databaseManager,
    ) {
    }

    /**
     * @param \App\Containers\Partners\Models\Partner $partner
     * @throws \Throwable
     */
    public function run(Partner $partner): void
    {
        $this->databaseManager->transaction(function () use ($partner): void {
            $this->partnersRepository->delete($partner);
        });
    }
}
