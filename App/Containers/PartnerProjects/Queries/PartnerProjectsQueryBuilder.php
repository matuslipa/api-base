<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Queries;

use App\Containers\PartnerProjects\Contracts\PartnerProjectsQueryInterface;
use App\Containers\PartnerProjects\Models\PartnerProject;
use App\Core\Parents\Queries\QueryBuilder;

/**
 * @package App\Containers\PartnerProjects
 * @property \App\Containers\PartnerProjects\Models\PartnerProject $model
 */
final class PartnerProjectsQueryBuilder extends QueryBuilder implements PartnerProjectsQueryInterface
{
    /**
     * @inheritDoc
     */
    public function wherePartnerId(int $partnerId): self
    {
        return $this->where(PartnerProject::ATTR_PARTNER_ID, '=', $partnerId);
    }

    /**
     * @inheritDoc
     */
    public function whereName(string $name): self
    {
        return $this->where(PartnerProject::ATTR_NAME, '=', $name);
    }
}
