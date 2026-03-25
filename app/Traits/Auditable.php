<?php

namespace App\Traits;

use App\Models\AuditLog;
use App\Services\AuditLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    /**
     * Temporary storage for pre-update attribute snapshot.
     * Declared as a real PHP property so Eloquent's __set() is bypassed
     * and it is never included in SQL UPDATE statements.
     */
    public ?array $_auditOldValues = null;

    /**
     * Fields to exclude from diff. Declare this property in the using class
     * to extend exclusions (e.g. security/lockout fields on User).
     *
     * NOTE: $auditExclude is intentionally NOT declared here as a trait
     * property. PHP 8.1+ throws a fatal "incompatible property composition"
     * error if both the trait and the using class declare the same property
     * with different default values. The base defaults are handled via the
     * BASE_AUDIT_EXCLUDE constant below, so no property is needed here.
     */

    /**
     * Core fields always stripped from every audit diff, regardless of the
     * model's own $auditExclude list.
     */
    private const BASE_AUDIT_EXCLUDE = ['password', 'remember_token', 'qr_token', 'updated_at'];

    public static function bootAuditable(): void
    {
        // After created
        static::created(function ($model) {
            $label = class_basename($model);
            $name  = $model->name ?? $model->patient_id ?? $model->appointment_id ?? "#{$model->id}";
            AuditLogger::log(
                AuditLog::ACTION_CREATE,
                "{$label} '{$name}' was created.",
                $model,
                null,
                $model->getAuditableAttributes()
            );
        });

        // Before update — capture old values
        static::updating(function ($model) {
            $model->_auditOldValues = $model->getOriginalAuditableAttributes();
        });

        // After updated
        static::updated(function ($model) {
            $label   = class_basename($model);
            $name    = $model->name ?? $model->patient_id ?? $model->appointment_id ?? "#{$model->id}";
            $changed = array_keys($model->getDirty());
            $changed = array_diff($changed, array_merge(self::BASE_AUDIT_EXCLUDE, $model->auditExclude ?? []));

            if (empty($changed)) return;

            AuditLogger::log(
                AuditLog::ACTION_UPDATE,
                "{$label} '{$name}' was updated. Fields changed: " . implode(', ', $changed),
                $model,
                $model->_auditOldValues ?? [],
                $model->getAuditableAttributes()
            );
        });

        // Before delete — capture snapshot
        static::deleting(function ($model) {
            $label = class_basename($model);
            $name  = $model->name ?? $model->patient_id ?? $model->appointment_id ?? "#{$model->id}";
            AuditLogger::log(
                AuditLog::ACTION_DELETE,
                "{$label} '{$name}' was deleted.",
                $model,
                $model->getAuditableAttributes(),
                null
            );
        });
    }

    /**
     * Get model attributes minus excluded fields.
     */
    public function getAuditableAttributes(): array
    {
        $exclude = array_unique(array_merge(self::BASE_AUDIT_EXCLUDE, $this->auditExclude ?? []));
        return array_diff_key($this->getAttributes(), array_flip($exclude));
    }

    /**
     * Get original (pre-update) attributes minus excluded fields.
     */
    public function getOriginalAuditableAttributes(): array
    {
        $exclude = array_unique(array_merge(self::BASE_AUDIT_EXCLUDE, $this->auditExclude ?? []));
        return array_diff_key($this->getOriginal(), array_flip($exclude));
    }
}
