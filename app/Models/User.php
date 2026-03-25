<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Auditable;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Auditable;

    /**
     * Exclude security/lockout fields from the generic Auditable trait diff.
     * Each of these fields is logged explicitly via AuditLogger::log('security', ...)
     * so the generic "fields changed" entry would just be redundant noise.
     */
    protected array $auditExclude = [
        'password', 'remember_token', 'qr_token', 'updated_at',
        // Security fields — logged individually with descriptive messages
        'login_attempts', 'locked_until',
        'must_change_password', 'password_changed_at', 'password_expiry_exempt',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'staff_id',
        'role',
        'specialization',
        'phone',
        'status',
        'avatar',
        'must_change_password',
        'password_changed_at',
        'password_expiry_exempt',
        'login_attempts',
        'locked_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
            'password_changed_at' => 'datetime',
            'password_expiry_exempt' => 'boolean',
            'locked_until' => 'datetime',
        ];
    }

    /**
     * Returns true when the user's password has not been changed within the
     * last 6 months and is therefore considered expired.
     *
     * Rules:
     *  - Skipped if must_change_password is already active (avoids double-modal).
     *  - Skipped if the admin has marked this user as exempt.
     *  - Skipped if password_changed_at is null (clock not yet started).
     */
    /**
     * Returns true when the account is currently locked out due to too many failed login attempts.
     */
    public function isLockedOut(): bool
    {
        return $this->locked_until !== null && $this->locked_until->isFuture();
    }

    public function isPasswordExpired(): bool
    {
        if ($this->must_change_password)
            return false;
        if ($this->password_expiry_exempt)
            return false;
        if (is_null($this->password_changed_at))
            return false;

        return $this->password_changed_at->lessThan(now()->subMonths(6));
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function doctorConsultations()
    {
        return $this->hasMany(Consultation::class , 'doctor_id');
    }
}