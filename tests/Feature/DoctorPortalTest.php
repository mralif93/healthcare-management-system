<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Consultation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorPortalTest extends TestCase
{
    use RefreshDatabase;

    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
        $this->doctor = User::factory()->create(['role' => 'doctor']);
    }

    /** @test */
    public function doctor_can_access_dashboard()
    {
        $response = $this->actingAs($this->doctor)->get(route('doctor.dashboard'));
        $response->assertStatus(200);
    }

    /** @test */
    public function doctor_can_view_assigned_patients()
    {
        $patient = Patient::factory()->create();
        Appointment::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $this->doctor->id,
        ]);

        $response = $this->actingAs($this->doctor)->get(route('doctor.patients.index'));
        $response->assertStatus(200);
        $response->assertSee($patient->name);
    }

    /** @test */
    public function doctor_can_view_schedule()
    {
        $response = $this->actingAs($this->doctor)->get(route('doctor.schedule'));
        $response->assertStatus(200);
        $response->assertViewHas('appointments');
    }

    /** @test */
    public function doctor_can_record_consultation()
    {
        $patient = Patient::factory()->create();
        $appointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $this->doctor->id,
        ]);

        $consultationData = [
            'patient_id' => $patient->id,
            'appointment_id' => $appointment->id,
            'symptoms' => 'Fever and cough',
            'diagnosis' => 'Common cold',
            'prescription' => 'Paracetamol 500mg',
            'consultation_date' => now()->toDateString(),
        ];

        $response = $this->actingAs($this->doctor)->post(route('doctor.consultations.store'), $consultationData);

        $this->assertDatabaseHas('consultations', ['diagnosis' => 'Common cold']);
        $this->assertDatabaseHas('appointments', ['id' => $appointment->id, 'status' => 'completed']);
    }
}
