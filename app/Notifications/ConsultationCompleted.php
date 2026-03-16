<?php

namespace App\Notifications;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConsultationCompleted extends Notification
{
    use Queueable;

    public function __construct(public Consultation $consultation)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $patient = $this->consultation->patient;
        $doctor  = $this->consultation->doctor;
        $date    = \Carbon\Carbon::parse($this->consultation->consultation_date)->format('d M Y');

        return [
            'type'            => 'consultation_completed',
            'icon'            => 'hgi-stethoscope',
            'title'           => 'Consultation Completed',
            'message'         => "Dr. {$doctor->name} completed a consultation for {$patient->name} on {$date}.",
            'consultation_id' => $this->consultation->id,
        ];
    }
}
