<?php

declare(strict_types=1);

namespace App\Containers\Instances\Models;

use App\Containers\Instances\Contracts\InstancesQueryInterface;
use App\Containers\Instances\Queries\InstancesQueryBuilder;
use App\Containers\Locations\Models\Location;
use App\Containers\Partners\Models\Partner;
use App\Core\Parents\Models\Model;
use App\Core\Values\Enums\CastTypesEnum;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @package App\Containers\Instances
 */
final class Instance extends Model
{
    /**
     * Attributes of the model.
     */
    public const ATTR_ID = 'id';

    public const ATTR_NAME = 'name';

    public const ATTR_IDENTIFICATION = 'identification';

    public const ATTR_DOMAIN = 'domain';

    public const ATTR_PRIMARY_COLOR = 'primary_color';

    public const ATTR_SECONDARY_COLOR = 'secondary_color';

    public const ATTR_BUTTON_COLOR = 'button_color';

    public const ATTR_TEXT_COLOR = 'text_color';

    public const ATTR_IS_ACTIVE = 'is_active';

    public const ATTR_PARTNER_ID = 'partner_id';

    public const ATTR_CREATED_AT = self::CREATED_AT;

    public const ATTR_UPDATED_AT = self::UPDATED_AT;

    /**
     * Relations
     */
    public const RELATION_LOCATIONS = 'locations';

    public const RELATION_PARTNER = 'partner';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        self::ATTR_NAME,
        self::ATTR_IDENTIFICATION,
        self::ATTR_DOMAIN,
        self::ATTR_PRIMARY_COLOR,
        self::ATTR_SECONDARY_COLOR,
        self::ATTR_BUTTON_COLOR,
        self::ATTR_TEXT_COLOR,
        self::ATTR_IS_ACTIVE,
        self::ATTR_PARTNER_ID,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        self::ATTR_NAME => CastTypesEnum::STRING,
        self::ATTR_IDENTIFICATION => CastTypesEnum::STRING,
        self::ATTR_DOMAIN => CastTypesEnum::STRING,
        self::ATTR_PRIMARY_COLOR => CastTypesEnum::STRING,
        self::ATTR_SECONDARY_COLOR => CastTypesEnum::STRING,
        self::ATTR_BUTTON_COLOR => CastTypesEnum::STRING,
        self::ATTR_TEXT_COLOR => CastTypesEnum::STRING,
        self::ATTR_IS_ACTIVE => CastTypesEnum::BOOL,
        self::ATTR_PARTNER_ID => CastTypesEnum::INT,
    ];

    /**
     * Create new model query.
     *
     * @return \App\Containers\Instances\Contracts\InstancesQueryInterface
     */
    public function newModelQuery(): InstancesQueryInterface
    {
        return (new InstancesQueryBuilder($this))->withoutGlobalScopes();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, Location::ATTR_INSTANCE_ID);
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function getLocations(): ?Collection
    {
        return $this->getRelationValue(self::RELATION_LOCATIONS);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, self::ATTR_PARTNER_ID, Partner::ATTR_ID);
    }

    /**
     * @return \App\Containers\Partners\Models\Partner|null
     */
    public function getPartner(): ?Partner
    {
        return $this->getRelationValue(self::RELATION_PARTNER);
    }

    /**
     * @return int|null
     */
    public function getPartnerId(): ?int
    {
        return $this->getAttributeValue(self::ATTR_PARTNER_ID);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttributeValue(self::ATTR_NAME);
    }

    /**
     * @return string
     */
    public function getIdentification(): string
    {
        return $this->getAttributeValue(self::ATTR_IDENTIFICATION);
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->getAttributeValue(self::ATTR_IS_ACTIVE);
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->getAttributeValue(self::ATTR_DOMAIN);
    }

    /**
     * @return string
     */
    public function getPrimaryColor(): string
    {
        return $this->getAttributeValue(self::ATTR_PRIMARY_COLOR);
    }

    /**
     * @return string
     */
    public function getSecondaryColor(): string
    {
        return $this->getAttributeValue(self::ATTR_SECONDARY_COLOR);
    }

    /**
     * @return string
     */
    public function getButtonColor(): string
    {
        return $this->getAttributeValue(self::ATTR_BUTTON_COLOR);
    }

    /**
     * @return string
     */
    public function getTextColor(): string
    {
        return $this->getAttributeValue(self::ATTR_TEXT_COLOR);
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
     * @return \Carbon\CarbonImmutable
     */
    public function getCreatedAt(): CarbonImmutable
    {
        return $this->getAttributeValue(self::ATTR_CREATED_AT);
    }

    /**
     * @return \Carbon\CarbonImmutable
     */
    public function getUpdatedAt(): CarbonImmutable
    {
        return $this->getAttributeValue(self::ATTR_UPDATED_AT);
    }
}
