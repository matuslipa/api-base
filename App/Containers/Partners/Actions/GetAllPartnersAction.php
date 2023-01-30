<?php

declare(strict_types=1);

namespace App\Containers\Partners\Actions;

use App\Containers\Partners\Contracts\PartnersQueryInterface;
use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Partners
 */
final class GetAllPartnersAction
{
    /**
     * @param \App\Containers\Partners\Contracts\PartnersRepositoryInterface $partnersRepository
     */
    public function __construct(
        private readonly PartnersRepositoryInterface $partnersRepository
    ) {
    }

    /**
     * @return \Illuminate\Support\Collection<\App\Containers\Partners\Models\Partner>
     */
    public function run(): Collection
    {
        return $this->query()->getAll();
    }

    /**
     * @return \App\Containers\Partners\Contracts\PartnersQueryInterface
     */
    public function query(): PartnersQueryInterface
    {
        return $this->partnersRepository->query();
    }
}
