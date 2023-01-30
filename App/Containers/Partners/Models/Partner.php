<?php

declare(strict_types=1);

namespace App\Containers\Partners\Models;

use App\Containers\Instances\Models\Instance;
use App\Containers\Partners\Contracts\PartnersQueryInterface;
use App\Containers\Partners\Queries\PartnersQueryBuilder;
use App\Core\Parents\Models\Model;
use App\Core\Values\Enums\CastTypesEnum;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @package App\Containers\Partners
 */
final class Partner extends Model
{
    /**
     * Attributes of the model.
     */
    public const ATTR_ID = 'id';

    public const ATTR_COMPANY_NAME = 'company_name';

    public const ATTR_COMPANY_ICO = 'company_ico';

    public const ATTR_COMPANY_IC_DPH = 'company_ic_dph';

    public const ATTR_COMPANY_ADDRESS = 'company_address';

    public const ATTR_COMPANY_EMAIL = 'company_email';

    public const ATTR_IS_DPH_PAYER = 'is_dph_payer';

    public const ATTR_COMPANY_DIC = 'company_dic';

    public const ATTR_FILE_MARK = 'file_mark';

    public const ATTR_COMPANY_CONTACT_PERSON = 'company_contact_person';

    public const ATTR_COMPANY_PHONE = 'company_phone';

    public const ATTR_IS_ACTIVE = 'is_active';

    public const ATTR_CREATED_AT = self::CREATED_AT;

    public const ATTR_UPDATED_AT = self::UPDATED_AT;

    /**
     * Model limits.
     */
    public const LIMIT_EMAIL = 50;

    public const LIMIT_PHONE = 30;

    /**
     * Relations.
     */
    public const RELATION_INSTANCE = 'instance';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        self::ATTR_COMPANY_NAME,
        self::ATTR_COMPANY_ICO,
        self::ATTR_COMPANY_ADDRESS,
        self::ATTR_COMPANY_EMAIL,
        self::ATTR_COMPANY_CONTACT_PERSON,
        self::ATTR_COMPANY_PHONE,
        self::ATTR_IS_ACTIVE,
        self::ATTR_IS_DPH_PAYER,
        self::ATTR_FILE_MARK,
        self::ATTR_COMPANY_DIC,
        self::ATTR_COMPANY_IC_DPH,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var string[]
     */
    protected $casts = [
        self::ATTR_COMPANY_NAME => CastTypesEnum::STRING,
        self::ATTR_COMPANY_ICO => CastTypesEnum::STRING,
        self::ATTR_COMPANY_ADDRESS => CastTypesEnum::STRING,
        self::ATTR_COMPANY_EMAIL => CastTypesEnum::STRING,
        self::ATTR_COMPANY_CONTACT_PERSON => CastTypesEnum::STRING,
        self::ATTR_COMPANY_PHONE => CastTypesEnum::STRING,
        self::ATTR_IS_ACTIVE => CastTypesEnum::BOOL,
        self::ATTR_IS_DPH_PAYER => CastTypesEnum::BOOL,
        self::ATTR_COMPANY_DIC => CastTypesEnum::STRING,
        self::ATTR_FILE_MARK => CastTypesEnum::STRING,
        self::ATTR_COMPANY_IC_DPH => CastTypesEnum::STRING,
    ];

    /**
     * Create new model query.
     *
     * @return \App\Containers\Partners\Contracts\PartnersQueryInterface
     */
    public function newModelQuery(): PartnersQueryInterface
    {
        return (new PartnersQueryBuilder($this))->withoutGlobalScopes();
    }

    /**
     * Fill model with compact data.
     *
     * @param mixed[] $data
     */
    public function compactFill(array $data): void
    {
        // place some default values?
        $data[self::ATTR_IS_ACTIVE] ??= $this->attributes[self::ATTR_IS_ACTIVE] ?? true;
        $data[self::ATTR_IS_DPH_PAYER] ??= $this->attributes[self::ATTR_IS_DPH_PAYER] ?? true;
        $this->fill($data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function instance(): HasOne
    {
        return $this->hasOne(Instance::class, Instance::ATTR_PARTNER_ID);
    }

    /**
     * @return \App\Containers\Instances\Models\Instance|null
     */
    public function getInstance(): ?Instance
    {
        return $this->getRelationValue(self::RELATION_INSTANCE);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getAttribute(self::ATTR_IS_ACTIVE);
    }

    /**
     * @return string|null
     */
    public function getIcDph(): ?string
    {
        return $this->getAttribute(self::ATTR_COMPANY_IC_DPH);
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->getAttribute(self::ATTR_COMPANY_NAME);
    }

    /**
     * @return string|null
     */
    public function getFileMark(): ?string
    {
        return $this->getAttribute(self::ATTR_FILE_MARK);
    }

    /**
     * @return string|null
     */
    public function getCompanyIco(): ?string
    {
        return $this->getAttribute(self::ATTR_COMPANY_ICO);
    }

    /**
     * @return bool
     */
    public function getIsDphPayer(): bool
    {
        return $this->getAttribute(self::ATTR_IS_DPH_PAYER);
    }

    /**
     * @return string|null
     */
    public function getCompanyDic(): ?string
    {
        return $this->getAttribute(self::ATTR_COMPANY_DIC);
    }

    /**
     * @return string|null
     */
    public function getCompanyEmail(): ?string
    {
        return $this->getAttribute(self::ATTR_COMPANY_EMAIL);
    }

    /**
     * @return string|null
     */
    public function getCompanyAddress(): ?string
    {
        return $this->getAttribute(self::ATTR_COMPANY_ADDRESS);
    }

    /**
     * @return string|null
     */
    public function getCompanyContactPerson(): ?string
    {
        return $this->getAttribute(self::ATTR_COMPANY_CONTACT_PERSON);
    }

    /**
     * @return string|null
     */
    public function getCompanyPhone(): ?string
    {
        return $this->getAttribute(self::ATTR_COMPANY_PHONE);
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
