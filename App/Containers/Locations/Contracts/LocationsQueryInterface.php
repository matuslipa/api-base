<?php

declare(strict_types=1);

namespace App\Containers\Locations\Contracts;

use App\Core\Contracts\QueryBuilderInterface;

/**
 * @package App\Containers\Locations
 */
interface LocationsQueryInterface extends QueryBuilderInterface
{
    /**
     * Eager-load instances
     *
     * @return LocationsQueryInterface
     */
    public function withInstance(): self;

    /**
     * Eager-load products
     *
     * @return LocationsQueryInterface
     */
    public function withProducts(): self;

    /**
     * @return $this
     */
    public function withSlotConfig(): self;

    /**
     * @param int $instanceId
     * @return $this
     */
    public function whereInstanceId(int $instanceId): self;

    /**
     * @param string $value
     * @return $this
     */
    public function whereName(string $value): self;
}
