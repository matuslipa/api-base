<?php

declare(strict_types=1);

namespace App\Containers\Partners\Contracts;

use App\Core\Contracts\QueryBuilderInterface;

/**
 * @package App\Containers\Partners
 */
interface PartnersQueryInterface extends QueryBuilderInterface
{
    /**
     * Filter only customers with given email address.
     *
     * @param string $email
     * @return $this
     */
    public function whereEmail(string $email): self;

    /**
     * @param string $name
     * @return $this
     */
    public function whereName(string $name): self;
}
