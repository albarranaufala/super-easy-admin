<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_attribute_id',
        'primary_id',
        'value'
    ];
}
