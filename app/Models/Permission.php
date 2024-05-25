<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    public const ACTION_VIEW = 'view';
    public const ACTION_CREATE = 'create';
    public const ACTION_UPDATE = 'update';
    public const ACTION_DELETE = 'delete';
    public const AVAILABLE_ACTIONS = [
        self::ACTION_VIEW,
        self::ACTION_CREATE,
        self::ACTION_UPDATE,
        self::ACTION_DELETE
    ];

    protected $fillable = [
        'role_id',
        'module_id',
        'action',
        'query', // any, own, mixed, etc.
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
