<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
        'notes',
    ];

    /**
     * Get the patient associated with the appointment.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor associated with the appointment.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
