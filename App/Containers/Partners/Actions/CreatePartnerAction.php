<?php

declare(strict_types=1);

namespace App\Containers\Partners\Actions;

use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Containers\Partners\Models\Partner;
use App\Containers\Partners\Values\InputData\PartnerInputData;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\Partners
 */
final class CreatePartnerAction
{
    /**
     * @param \App\Containers\Partners\Contracts\PartnersRepositoryInterface $partnersRepository
     * @param \Illuminate\Database\DatabaseManager $databaseManager ,
     */
    public function __construct(
        private readonly PartnersRepositoryInterface $partnersRepository,
        private readonly DatabaseManager $databaseManager,
    ) {
    }

    /**
     * @param \App\Containers\Partners\Values\InputData\PartnerInputData $data
     *
     * @return \App\Containers\Partners\Models\Partner
     *
     * @throws \Throwable
     */
    public function run(PartnerInputData $data): Partner
    {
        return $this->databaseManager->transaction(function () use ($data): Partner {
            $partner = $this->partnersRepository->create($data->getAttributes());

            return $partner;
        });
    }
}
