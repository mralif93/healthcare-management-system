<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'blood_group',
        'address',
        'medical_history',
        'allergies',
        'status',
    ];

    /**
     * Get the age from date_of_birth.
     */
    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->date_of_birth)->age;
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
