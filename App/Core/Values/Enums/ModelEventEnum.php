<?php

declare(strict_types=1);

namespace App\Core\Values\Enums;

final class ModelEventEnum
{
    public const CREATING = 'creating';

    public const CREATED = 'created';

    public const SAVING = 'saving';

    public const SAVED = 'saved';

    public const SAVE_FINISHED = 'save_finished';

    public const UPDATED = 'updated';

    public const UPDATING = 'updating';

    public const DELETING = 'deleting';

    public const DELETED = 'deleted';

    public const BEFORE_DELETED = 'deleted';
}
