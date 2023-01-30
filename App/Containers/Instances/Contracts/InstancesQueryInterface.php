<?php

declare(strict_types=1);

namespace App\Containers\Instances\Contracts;

use App\Core\Contracts\QueryBuilderInterface;

/**
 * @package App\Containers\Instances
 */
interface InstancesQueryInterface extends QueryBuilderInterface
{
    /**
     * @param string $identification
     * @return $this
     */
    public function whereIdentification(string $identification): self;

    /**
     * @param string $domain
     * @return $this
     */
    public function whereDomain(string $domain): self;

    /**
     * @param bool $hasApp
     * @return $this
     */
    public function whereHasApp(bool $hasApp = true): self;

    /**
     * @param bool $isDefault
     * @return $this
     */
    public function whereIsDefault(bool $isDefault = true): self;

    /**
     * @param string $name
     * @return $this
     */
    public function whereName(string $name): self;

    /**
     * Eager-load locations
     *
     * @return $this
     */
    public function withLocations(): self;

    /**
     * Eager-load partner
     *
     * @return $this
     */
    public function withPartner(): self;
}
