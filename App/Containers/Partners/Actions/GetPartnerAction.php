<?php

declare(strict_types=1);

namespace App\Containers\Partners\Actions;

use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Containers\Partners\Models\Partner;

/**
 * @package App\Containers\Partners
 */
final class GetPartnerAction
{
    /**
     * @param \App\Containers\Partners\Contracts\PartnersRepositoryInterface $partnersRepository
     */
    public function __construct(
        private readonly PartnersRepositoryInterface $partnersRepository
    ) {
    }

    /**
     * @param int $id
     *
     * @return \App\Containers\Partners\Models\Partner
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function run(int $id): Partner
    {
        return $this->partnersRepository->get($id);
    }
}
