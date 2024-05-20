<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ModuleAttribute extends Model
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

    protected function referencedModuleRows(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $additional_info = json_decode($attributes['additional_info']);
                if ($additional_info && isset($additional_info->reference_module_id)) {
                    return Row::forModule($additional_info->reference_module_id)->get();
                }
                return [];
            }
        );
    }
}
