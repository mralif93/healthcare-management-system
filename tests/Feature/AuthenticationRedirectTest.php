<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationRedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    }

    /** @test */
    public function guests_are_redirected_to_login()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');

        $response = $this->get('/doctor');
        $response->assertRedirect('/login');

        $response = $this->get('/staff');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_is_redirected_to_admin_dashboard_after_login()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
            'password' => bcrypt($password = 'password123'),
        ]);

        $response = $this->post('/login', [
            'staff_id' => $admin->staff_id,
            'password' => $password,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function doctor_is_redirected_to_doctor_dashboard_after_login()
    {
        $doctor = User::factory()->create([
            'role' => 'doctor',
            'status' => 'active',
            'password' => bcrypt($password = 'password123'),
        ]);

        $response = $this->post('/login', [
            'staff_id' => $doctor->staff_id,
            'password' => $password,
        ]);

        $response->assertRedirect(route('doctor.dashboard'));
    }

    /** @test */
    public function staff_is_redirected_to_staff_dashboard_after_login()
    {
        $staff = User::factory()->create([
            'role' => 'staff',
            'status' => 'active',
            'password' => bcrypt($password = 'password123'),
        ]);

        $response = $this->post('/login', [
            'staff_id' => $staff->staff_id,
            'password' => $password,
        ]);

        $response->assertRedirect(route('staff.dashboard'));
    }

    /** @test */
    public function inactive_user_cannot_login()
    {
        $user = User::factory()->create([
            'status' => 'inactive',
            'password' => bcrypt($password = 'password123'),
        ]);

        $response = $this->post('/login', [
            'staff_id' => $user->staff_id,
            'password' => $password,
        ]);

        $response->assertSessionHasErrors('staff_id');
        $this->assertGuest();
    }

    /** @test */
    public function authenticated_user_is_redirected_away_from_guest_routes()
    {
        $doctor = User::factory()->create(['role' => 'doctor', 'status' => 'active']);

        // Try accessing home page
        $response = $this->actingAs($doctor)->get('/');
        $response->assertRedirect(route('doctor.dashboard'));

        // Try accessing login page
        $response = $this->actingAs($doctor)->get('/login');
        $response->assertRedirect(route('doctor.dashboard'));
    }

    /** @test */
    public function user_cannot_access_other_roles_portal()
    {
        $doctor = User::factory()->create(['role' => 'doctor', 'status' => 'active']);

        $response = $this->actingAs($doctor)->get('/admin');
        $response->assertStatus(403);

        $response = $this->actingAs($doctor)->get('/staff');
        $response->assertStatus(403);
    }
}
