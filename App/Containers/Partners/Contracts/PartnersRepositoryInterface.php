<?php

declare(strict_types=1);

namespace App\Containers\Partners\Contracts;

use App\Containers\Partners\Models\Partner;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Partners
 */
interface PartnersRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return \App\Containers\Partners\Models\Partner
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get(int $id): Partner;

    /**
     * @return \Illuminate\Support\Collection<\App\Containers\Partners\Models\Partner>
     */
    public function getAll(): Collection;

    /**
     * @param mixed[] $data
     * @return \App\Containers\Partners\Models\Partner
     */
    public function create(array $data): Partner;

    /**
     * @param \App\Containers\Partners\Models\Partner $partner
     */
    public function save(Partner $partner): void;

    /**
     * @param \App\Containers\Partners\Models\Partner $partner
     */
    public function delete(Partner $partner): void;

    /**
     * @return \App\Containers\Partners\Contracts\PartnersQueryInterface
     */
    public function query(): PartnersQueryInterface;
}
