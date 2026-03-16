<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentBooked extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $patient = $this->appointment->patient;
        $date    = \Carbon\Carbon::parse($this->appointment->appointment_date)->format('d M Y');
        $time    = \Carbon\Carbon::parse($this->appointment->appointment_time)->format('h:i A');

        return [
            'type'           => 'appointment_booked',
            'icon'           => 'hgi-calendar-check-out',
            'title'          => 'New Appointment Booked',
            'message'        => "Patient {$patient->name} is scheduled on {$date} at {$time}.",
            'appointment_id' => $this->appointment->id,
        ];
    }
}
