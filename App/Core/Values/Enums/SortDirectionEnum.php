<?php

declare(strict_types=1);

namespace App\Core\Values\Enums;

use App\Core\Parents\Enums\InstantiableEnum;

/**
 * @method static \App\Core\Values\Enums\SortDirectionEnum ASC()
 * @method static \App\Core\Values\Enums\SortDirectionEnum DESC()
 */
final class SortDirectionEnum extends InstantiableEnum
{
    public const ASC = 'asc';

    public const DESC = 'desc';
}
