<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentAdminPanelAuthTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;

    protected User $manager;

    protected User $inactiveUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->superAdmin = User::where('role', 'super_admin')->first();

        $this->manager = User::create([
            'name' => 'Field Operations Manager',
            'email' => 'manager@ksf.org',
            'password' => bcrypt('password123'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        $this->inactiveUser = User::create([
            'name' => 'Inactive Staff Member',
            'email' => 'inactive@ksf.org',
            'password' => bcrypt('password123'),
            'role' => 'manager',
            'is_active' => false,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_filament_dashboard_and_is_redirected_to_filament_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_filament_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
    }

    public function test_legacy_login_route_redirects_to_filament_login(): void
    {
        $response = $this->get('/login');

        $response->assertRedirect('/admin/login');
    }

    public function test_super_admin_can_access_filament_dashboard(): void
    {
        $response = $this->actingAs($this->superAdmin)->get('/admin');

        $response->assertOk();
    }

    public function test_manager_can_access_filament_dashboard(): void
    {
        $response = $this->actingAs($this->manager)->get('/admin');

        $response->assertOk();
    }

    public function test_inactive_admin_cannot_access_filament_dashboard(): void
    {
        $response = $this->actingAs($this->inactiveUser)->get('/admin');

        $response->assertForbidden();
    }

    public function test_authenticated_admin_can_logout_via_filament_logout(): void
    {
        $response = $this->actingAs($this->superAdmin)->post('/admin/logout');

        $response->assertRedirect('/admin/login');
        $this->assertGuest();
    }
}
