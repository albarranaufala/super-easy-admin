<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function attributes(): HasMany
    {
        return $this->hasMany(ModuleAttribute::class);
    }

    public function fillableAttributes(): HasMany
    {
        return $this->hasMany(ModuleAttribute::class)->whereNotIn('type', ['primary']);
    }
}
