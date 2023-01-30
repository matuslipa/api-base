<?php

declare(strict_types=1);

namespace App\Containers\Partners\Queries;

use App\Containers\Partners\Contracts\PartnersQueryInterface;
use App\Containers\Partners\Models\Partner;
use App\Core\Parents\Queries\QueryBuilder;

/**
 * @package App\Containers\Partners
 * @property \App\Containers\Partners\Models\Partner $model
 */
final class PartnersQueryBuilder extends QueryBuilder implements PartnersQueryInterface
{
    /**
     * @inheritDoc
     */
    public function whereEmail(string $email): self
    {
        return $this->where(Partner::ATTR_COMPANY_EMAIL, '=', $email);
    }

    /**
     * @inheritDoc
     */
    public function whereName(string $name): self
    {
        return $this->where(Partner::ATTR_COMPANY_NAME, '=', $name);
    }
}
