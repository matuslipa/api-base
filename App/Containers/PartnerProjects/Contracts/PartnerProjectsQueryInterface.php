<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Contracts;

use App\Core\Contracts\QueryBuilderInterface;

/**
 * @package App\Containers\PartnerProjects
 */
interface PartnerProjectsQueryInterface extends QueryBuilderInterface
{
    /**
     * @param int $partnerId
     * @return mixed
     */
    public function wherePartnerId(int $partnerId): self;

    /**
     * @param string $name
     * @return mixed
     */
    public function whereName(string $name): self;
}
