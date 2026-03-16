<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPatientTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function admin_can_see_patient_list()
    {
        Patient::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.patients.index'));

        $response->assertStatus(200);
        $response->assertViewHas('patients');
    }

    /** @test */
    public function admin_can_register_patient()
    {
        $patientData = [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'date_of_birth' => '1995-05-15',
            'gender' => 'female',
            'status' => 'active',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.patients.store'), $patientData);

        $response->assertRedirect(route('admin.patients.index'));
        $this->assertDatabaseHas('patients', [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'patient_id' => 'P-00001',
        ]);
    }

    /** @test */
    public function admin_can_update_patient()
    {
        $patient = Patient::factory()->create();

        $updateData = [
            'name' => 'Updated Patient',
            'phone' => '1112223333',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'status' => 'inactive',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.patients.update', $patient), $updateData);

        $response->assertRedirect(route('admin.patients.index'));
        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'name' => 'Updated Patient',
            'status' => 'inactive',
        ]);
    }

    /** @test */
    public function admin_can_delete_patient()
    {
        $patient = Patient::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.patients.destroy', $patient));

        $response->assertRedirect(route('admin.patients.index'));
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }
}
