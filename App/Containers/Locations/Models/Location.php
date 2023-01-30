<?php

declare(strict_types=1);

namespace App\Containers\Locations\Models;

use App\Containers\Instances\Models\Instance;
use App\Containers\Locations\Contracts\LocationsQueryInterface;
use App\Containers\Locations\Queries\LocationsQueryBuilder;
use App\Core\Parents\Models\Model;
use App\Core\Values\Enums\CastTypesEnum;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @package App\Containers\Locations
 */
final class Location extends Model
{
    /**
     * Attributes of the model.
     */
    public const ATTR_ID = 'id';

    public const ATTR_NAME = 'name';

    public const ATTR_ADDRESS = 'address';

    public const ATTR_CITY = 'city';

    public const ATTR_INSTANCE_ID = 'instance_id';

    public const ATTR_CREATED_AT = self::CREATED_AT;

    public const ATTR_UPDATED_AT = self::UPDATED_AT;

    /**
     * Relations
     */
    public const RELATION_INSTANCE = 'instance';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        self::ATTR_NAME,
        self::ATTR_CITY,
        self::ATTR_ADDRESS,
        self::ATTR_INSTANCE_ID,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        self::ATTR_NAME => CastTypesEnum::STRING,
        self::ATTR_CITY => CastTypesEnum::STRING,
        self::ATTR_ADDRESS => CastTypesEnum::STRING,
        self::ATTR_INSTANCE_ID => CastTypesEnum::INT,
    ];

    /**
     * Create new model query.
     *
     * @return \App\Containers\Locations\Contracts\LocationsQueryInterface
     */
    public function newModelQuery(): LocationsQueryInterface
    {
        return (new LocationsQueryBuilder($this))->withoutGlobalScopes();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class, self::ATTR_INSTANCE_ID, Instance::ATTR_ID);
    }

    /**
     * @return \App\Containers\Instances\Models\Instance|null
     */
    public function getInstance(): ?Instance
    {
        return $this->getRelationValue(self::RELATION_INSTANCE);
    }

    /**
     * @return string
     */
    public function getNameDictionary(): string
    {
        return $this->getAttribute(self::ATTR_NAME);
    }

    /**
     * @return string
     */
    public function getCityDictionary(): string
    {
        return $this->getAttribute(self::ATTR_CITY);
    }

    /**
     * @return string
     */
    public function getAddressDictionary(): string
    {
        return $this->getAttribute(self::ATTR_ADDRESS);
    }

    /**
     * @return int
     */
    public function getInstanceId(): int
    {
        return $this->getAttribute(self::ATTR_INSTANCE_ID);
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
