<?php

declare(strict_types=1);

namespace App\Core\Values\Enums;

use App\Core\Parents\Enums\InstantiableEnum;

/**
 * @method static \App\Core\Values\Enums\DataTypeEnum MIXED()
 * @method static \App\Core\Values\Enums\DataTypeEnum INT()
 * @method static \App\Core\Values\Enums\DataTypeEnum DECIMAL()
 * @method static \App\Core\Values\Enums\DataTypeEnum MONETARY()
 * @method static \App\Core\Values\Enums\DataTypeEnum DATE()
 * @method static \App\Core\Values\Enums\DataTypeEnum DATETIME()
 * @method static \App\Core\Values\Enums\DataTypeEnum STRING()
 * @method static \App\Core\Values\Enums\DataTypeEnum BOOL()
 */
final class DataTypeEnum extends InstantiableEnum
{
    public const MIXED = 'mixed';

    public const INT = 'int';

    public const DECIMAL = 'decimal';

    public const MONETARY = 'monetary';

    public const DATE = 'date';

    public const DATETIME = 'datetime';

    public const STRING = 'string';

    public const BOOL = 'bool';
}
