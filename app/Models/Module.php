<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Module extends Model
{
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
