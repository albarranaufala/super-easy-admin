<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'type',
        'name',
        'additional_info'
    ];

    protected $casts = [
        'additional_info' => 'array',
    ];

    protected $appends = ['default_value'];

    protected function defaultValue(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if ($attributes['type'] === 'text') {
                    return "";
                } elseif ($attributes['type'] === 'switch') {
                    return "0";
                }
            }
        );
    }
}
