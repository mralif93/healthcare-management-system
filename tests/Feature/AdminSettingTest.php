<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSettingTest extends TestCase
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
    public function admin_can_see_settings_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.settings'));

        $response->assertStatus(200);
        $response->assertViewHas('settings');
        $this->assertDatabaseHas('settings', ['key' => 'app_name']);
    }

    /** @test */
    public function admin_can_update_settings()
    {
        // Initial seed happens in index
        $this->actingAs($this->admin)->get(route('admin.settings'));

        $updateData = [
            'app_name' => 'New Clinic Name',
            'clinic_phone' => '999999999',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.settings.update'), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('settings', [
            'key' => 'app_name',
            'value' => 'New Clinic Name',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'clinic_phone',
            'value' => '999999999',
        ]);
    }
}
