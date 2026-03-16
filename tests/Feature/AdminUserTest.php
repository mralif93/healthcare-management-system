<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
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
    public function admin_can_see_user_list()
    {
        User::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    /** @test */
    public function admin_can_create_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'doctor',
            'status' => 'active',
            'phone' => '1234567890',
            'specialization' => 'Cardiology',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), $userData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'doctor',
        ]);
    }

    /** @test */
    public function admin_can_update_user()
    {
        $user = User::factory()->create(['role' => 'staff']);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role' => 'admin',
            'status' => 'inactive',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $user), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
