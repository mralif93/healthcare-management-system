<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Log a generic action.
     */
    public static function log(
        string $action,
        string $description,
        ?Model $auditable = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?int $userId = null
    ): AuditLog {
        return AuditLog::create([
            'user_id'        => $userId ?? (Auth::check() ? Auth::id() : null),
            'action'         => $action,
            'auditable_type' => $auditable ? get_class($auditable) : null,
            'auditable_id'   => $auditable?->getKey(),
            'description'    => $description,
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'old_values'     => $oldValues,
            'new_values'     => $newValues,
        ]);
    }

    public static function login(Model $user): AuditLog
    {
        return self::log(
            AuditLog::ACTION_LOGIN,
            "User '{$user->name}' ({$user->role}) logged in.",
            null, null, null, $user->id
        );
    }

    public static function logout(Model $user): AuditLog
    {
        return self::log(
            AuditLog::ACTION_LOGOUT,
            "User '{$user->name}' ({$user->role}) logged out.",
            null, null, null, $user->id
        );
    }

    public static function created(Model $model, string $description): AuditLog
    {
        return self::log(
            AuditLog::ACTION_CREATE,
            $description,
            $model,
            null,
            $model->toArray()
        );
    }

    public static function updated(Model $model, string $description, array $oldValues): AuditLog
    {
        return self::log(
            AuditLog::ACTION_UPDATE,
            $description,
            $model,
            $oldValues,
            $model->toArray()
        );
    }

    public static function deleted(Model $model, string $description, array $oldValues): AuditLog
    {
        return self::log(
            AuditLog::ACTION_DELETE,
            $description,
            $model,
            $oldValues,
            null
        );
    }
}

