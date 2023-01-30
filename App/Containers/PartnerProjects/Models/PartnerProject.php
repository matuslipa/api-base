<?php

declare(strict_types=1);

namespace App\Containers\PartnerProjects\Models;

use App\Containers\PartnerProjects\Contracts\PartnerProjectsQueryInterface;
use App\Containers\PartnerProjects\Queries\PartnerProjectsQueryBuilder;
use App\Core\Parents\Models\Model;
use App\Core\Values\Enums\CastTypesEnum;
use Carbon\CarbonImmutable;

/**
 * @package App\Containers\PartnerProjects
 */
final class PartnerProject extends Model
{
    /**
     * Attributes of the model.
     */
    public const ATTR_ID = 'id';

    public const ATTR_NAME = 'name';

    public const ATTR_PARTNER_ID = 'partner_id';

    public const ATTR_IS_ACTIVE = 'is_active';

    public const ATTR_CREATED_AT = self::CREATED_AT;

    public const ATTR_UPDATED_AT = self::UPDATED_AT;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        self::ATTR_NAME,
        self::ATTR_PARTNER_ID,
        self::ATTR_IS_ACTIVE,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        self::ATTR_NAME => CastTypesEnum::STRING,
        self::ATTR_PARTNER_ID => CastTypesEnum::INT,
        self::ATTR_IS_ACTIVE => CastTypesEnum::BOOL,

    ];

    /**
     * Create new model query.
     *
     * @return \App\Containers\PartnerProjects\Contracts\PartnerProjectsQueryInterface
     */
    public function newModelQuery(): PartnerProjectsQueryInterface
    {
        return (new PartnerProjectsQueryBuilder($this))->withoutGlobalScopes();
    }

    /**
     * Fill model with compact data.
     *
     * @param mixed[] $data
     */
    public function compactFill(array $data): void
    {
        // place some default values?

        $this->fill($data);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttributeValue(self::ATTR_NAME);
    }

    /**
     * @return int
     */
    public function getPartnerId(): int
    {
        return $this->getAttribute(self::ATTR_PARTNER_ID);
    }

    /**
     * @return \Carbon\CarbonImmutable
     */
    public function getCreatedAt(): CarbonImmutable
    {
        return $this->getAttributeValue(self::ATTR_CREATED_AT);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getAttribute(self::ATTR_IS_ACTIVE);
    }

    /**
     * @return \Carbon\CarbonImmutable
     */
    public function getUpdatedAt(): CarbonImmutable
    {
        return $this->getAttributeValue(self::ATTR_UPDATED_AT);
    }
}
