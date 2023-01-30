<?php

declare(strict_types=1);

namespace App\Containers\Partners\Repositories;

use App\Containers\Partners\Contracts\PartnersQueryInterface;
use App\Containers\Partners\Contracts\PartnersRepositoryInterface;
use App\Containers\Partners\Models\Partner;
use App\Containers\Partners\Queries\PartnersQueryBuilder;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Partners
 */
final class PartnersRepository implements PartnersRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function get(int $id): Partner
    {
        /** @var \App\Containers\Partners\Models\Partner $partner */
        $partner = $this->query()->getById($id);
        return $partner;
    }

    /**
     * @inheritDoc
     */
    public function getAll(): Collection
    {
        return $this->query()->getAll();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Partner
    {
        $partner = new Partner();
        $partner->compactFill($data);
        $this->save($partner);

        return $partner;
    }

    /**
     * @inheritDoc
     */
    public function save(Partner $partner): void
    {
        $partner->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(Partner $partner): void
    {
        $partner->delete();
    }

    /**
     * @inheritDoc
     */
    public function query(): PartnersQueryInterface
    {
        return new PartnersQueryBuilder(new Partner());
    }
}
