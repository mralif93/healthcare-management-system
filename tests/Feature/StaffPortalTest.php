<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffPortalTest extends TestCase
{
    use RefreshDatabase;

    protected $staff;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
        $this->staff = User::factory()->create(['role' => 'staff']);
    }

    /** @test */
    public function staff_can_access_dashboard()
    {
        $response = $this->actingAs($this->staff)->get(route('staff.dashboard'));
        $response->assertStatus(200);
    }

    /** @test */
    public function staff_can_register_patient()
    {
        $patientData = [
            'name' => 'Staff Registered Patient',
            'phone' => '555123456',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'status' => 'active',
        ];

        $response = $this->actingAs($this->staff)->post(route('staff.patients.store'), $patientData);

        $response->assertRedirect(route('staff.patients.index'));
        $this->assertDatabaseHas('patients', ['name' => 'Staff Registered Patient']);
    }

    /** @test */
    public function staff_can_book_appointment()
    {
        $patient = Patient::factory()->create();
        $doctor = User::factory()->create(['role' => 'doctor']);

        $appointmentData = [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
            'appointment_time' => '11:00',
            'reason' => 'Staff booking test',
        ];

        $response = $this->actingAs($this->staff)->post(route('staff.appointments.store'), $appointmentData);

        $response->assertRedirect(route('staff.appointments.index'));
        $this->assertDatabaseHas('appointments', ['reason' => 'Staff booking test']);
    }

    /** @test */
    public function staff_can_view_doctor_schedules()
    {
        $doctor = User::factory()->create(['role' => 'doctor']);
        
        $response = $this->actingAs($this->staff)->get(route('staff.doctor-schedules', [
            'doctor_id' => $doctor->id,
            'date' => now()->toDateString()
        ]));

        $response->assertStatus(200);
        $response->assertViewHas('appointments');
    }
}
