<?php

declare(strict_types=1);

namespace App\Core\Values\Enums;

use App\Core\Parents\Enums\InstantiableEnum;

/**
 * @method static \App\Core\Values\Enums\ResponseTypeEnum UNKNOWN()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum GENERAL()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum UNAUTHENTICATED()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum UNAUTHORIZED()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum NOT_FOUND()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum METHOD_NOT_ALLOWED()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum DUPLICITY()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum CONFLICT()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum LOCKED()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum LENGTH_REQUIRED()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum FILE_UPLOAD_ERROR()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum INVALID_RESOURCE_PARAMETERS()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum INVALID_COMBINATION()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum VALIDATION_ERROR()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum SHOP_NOT_RECOGNIZED()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum FORBIDDEN()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum BAD_USAGE()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum GONE()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum EXPIRED_TOKEN()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum CONDITIONS_NOT_MET()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum NOT_IMPLEMENTED()
 * @method static \App\Core\Values\Enums\ResponseTypeEnum SERVICE_ERROR()
 */
final class ResponseTypeEnum extends InstantiableEnum
{
    public const UNKNOWN = 'Unknown';

    public const GENERAL = 'GeneralError';

    public const UNAUTHENTICATED = 'Unauthenticated';

    public const UNAUTHORIZED = 'Unauthorized';

    public const NOT_FOUND = 'NotFound';

    public const METHOD_NOT_ALLOWED = 'MethodNotAllowed';

    public const DUPLICITY = 'Duplicity';

    public const CONFLICT = 'Conflict';

    public const LOCKED = 'Locked';

    public const LENGTH_REQUIRED = 'LengthRequired';

    public const FILE_UPLOAD_ERROR = 'FileUploadError';

    public const INVALID_RESOURCE_PARAMETERS = 'InvalidResourceParameters';

    public const INVALID_COMBINATION = 'InvalidCombination';

    public const VALIDATION_ERROR = 'ValidationError';

    public const SHOP_NOT_RECOGNIZED = 'ShopNotRecognized';

    public const FORBIDDEN = 'Forbidden';

    public const BAD_USAGE = 'BadUsage';

    public const GONE = 'Gone';

    public const EXPIRED_TOKEN = 'ExpiredToken';

    public const CONDITIONS_NOT_MET = 'ConditionsNotMet';

    public const NOT_IMPLEMENTED = 'NotImplemented';

    public const SERVICE_ERROR = 'ServiceError';
}
