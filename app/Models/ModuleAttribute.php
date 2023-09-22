<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'type',
        'name'
    ];
}