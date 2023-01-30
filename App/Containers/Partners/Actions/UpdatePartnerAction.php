<?php

declare(strict_types=1);

namespace App\Containers\Partners\Actions;

use App\Containers\Instances\Actions\CreateInstanceFromPartnerAction;
use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Containers\Partners\Models\Partner;
use App\Containers\Partners\Values\InputData\PartnerInputData;
use Illuminate\Database\DatabaseManager;

/**
 * @package App\Containers\Partners
 */
final class UpdatePartnerAction
{
    /**
     * @param \App\Containers\Partners\Contracts\PartnersRepositoryInterface $partnersRepository
     * @param \Illuminate\Database\DatabaseManager $databaseManager
     * @param \App\Containers\Instances\Actions\CreateInstanceFromPartnerAction $createInstanceFromPartnerAction
     */
    public function __construct(
        private readonly PartnersRepositoryInterface $partnersRepository,
        private readonly DatabaseManager $databaseManager,
        private readonly CreateInstanceFromPartnerAction $createInstanceFromPartnerAction
    ) {
    }

    /**
     * @param \App\Containers\Partners\Models\Partner $partner
     * @param \App\Containers\Partners\Values\InputData\PartnerInputData $data
     *
     * @return \App\Containers\Partners\Models\Partner
     *
     * @throws \Throwable
     */
    public function run(Partner $partner, PartnerInputData $data): Partner
    {
        return $this->databaseManager->transaction(function () use ($partner, $data): Partner {
            $partner->compactFill($data->getAttributes());
            $this->partnersRepository->save($partner);
            if ($data->getCreateInstance()) {
                $this->createInstanceFromPartnerAction->run($partner);
            }

            return $partner;
        });
    }
}
