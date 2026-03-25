<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'auditable_type',
        'auditable_id',
        'description',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Action constants
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_VIEW = 'view';
    const ACTION_SECURITY = 'security';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'System']);
    }

    public function auditable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeForAction(Builder $query, string $action): Builder
    {
        return $query->where('action', $action);
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function ($q) use ($term) {
            $q->where('description', 'like', "%{$term}%")
                ->orWhere('ip_address', 'like', "%{$term}%")
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$term}%"));
        });
    }

    // Helpers
    public function getActionBadgeColorAttribute(): string
    {
        return match ($this->action) {
                'login' => 'emerald',
                'logout' => 'slate',
                'create' => 'blue',
                'update' => 'amber',
                'delete' => 'red',
                'view' => 'violet',
                'security' => 'orange',
                default => 'slate',
            };
    }

    public function getActionIconAttribute(): string
    {
        return match ($this->action) {
                'login' => 'hgi-login-01',
                'logout' => 'hgi-logout-01',
                'create' => 'hgi-add-circle',
                'update' => 'hgi-edit-02',
                'delete' => 'hgi-delete-02',
                'view' => 'hgi-eye',
                'security' => 'hgi-shield-key',
                default => 'hgi-information-circle',
            };
    }

    public function getModelLabelAttribute(): string
    {
        if (!$this->auditable_type)
            return '—';
        return class_basename($this->auditable_type);
    }
}