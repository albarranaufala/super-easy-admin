<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Module extends Model
{
    public const TYPE_TEXT = 'text';
    public const TYPE_SWITCH = 'switch';
    public const TYPE_SELECT = 'select';
    public const TYPE_REFERENCE = 'reference';
    public const AVAILABLE_TYPES = [
        self::TYPE_TEXT,
        self::TYPE_SWITCH,
        self::TYPE_SELECT,
        self::TYPE_REFERENCE
    ];

    protected $fillable = [
        'name'
    ];

    public function primaryAttribute(): HasOne
    {
        return $this->hasOne(ModuleAttribute::class)->where('type', 'primary');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ModuleAttribute::class)->whereNot('type', 'primary');
    }
}
