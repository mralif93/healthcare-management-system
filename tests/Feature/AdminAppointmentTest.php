<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAppointmentTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $patient;
    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->patient = Patient::factory()->create();
        $this->doctor = User::factory()->create(['role' => 'doctor', 'specialization' => 'General Medicine']);
    }

    /** @test */
    public function admin_can_see_appointment_list()
    {
        Appointment::factory()->count(3)->create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.appointments.index'));

        $response->assertStatus(200);
        $response->assertViewHas('appointments');
    }

    /** @test */
    public function admin_can_schedule_appointment()
    {
        $appointmentData = [
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
            'appointment_time' => '10:00',
            'status' => 'pending',
            'reason' => 'Regular Checkup',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.appointments.store'), $appointmentData);

        $response->assertRedirect(route('admin.appointments.index'));
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'reason' => 'Regular Checkup',
        ]);
    }

    /** @test */
    public function admin_can_update_appointment()
    {
        $appointment = Appointment::factory()->create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
        ]);

        $updateData = [
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'appointment_date' => now()->addDays(2)->format('Y-m-d'),
            'appointment_time' => '14:30',
            'status' => 'confirmed',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.appointments.update', $appointment), $updateData);

        $response->assertRedirect(route('admin.appointments.index'));
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'confirmed',
            'appointment_time' => '14:30',
        ]);
    }

    /** @test */
    public function admin_can_delete_appointment()
    {
        $appointment = Appointment::factory()->create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.appointments.destroy', $appointment));

        $response->assertRedirect(route('admin.appointments.index'));
        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }
}
