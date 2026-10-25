<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureAdminRole;
use App\Models\CauseCategory;
use App\Models\PaymentMethod;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class AdminAuthAndHandoverTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->admin = User::where('role', 'super_admin')->first();
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_login_page(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertOk();
        $response->assertSee('Administrative Sign-In');
        $response->assertSee('Back-Office Portal');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@ksf.org',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(Auth::check());
        $this->assertEquals('super_admin', Auth::user()->role);
    }

    public function test_admin_login_fails_with_invalid_password(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@ksf.org',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertTrue(Auth::guest());
    }

    public function test_inactive_admin_cannot_login(): void
    {
        User::create([
            'name' => 'Disabled Admin',
            'email' => 'disabled@ksf.org',
            'password' => Hash::make('secret123'),
            'role' => 'super_admin',
            'is_active' => false,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'disabled@ksf.org',
            'password' => 'secret123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertTrue(Auth::guest());
    }

    public function test_admin_can_logout(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertTrue(Auth::guest());
    }

    public function test_manager_role_can_access_operational_admin_routes(): void
    {
        $manager = User::create([
            'name' => 'Finance Manager',
            'email' => 'manager@ksf.org',
            'password' => Hash::make('password123'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        $dashboardResponse = $this->actingAs($manager)->get(route('admin.dashboard'));
        $dashboardResponse->assertOk();

        $donationsResponse = $this->actingAs($manager)->get(route('admin.donations.index'));
        $donationsResponse->assertOk();
    }

    public function test_inactive_admin_cannot_access_dashboard_and_is_logged_out(): void
    {
        $inactive = User::create([
            'name' => 'Deactivated Staff',
            'email' => 'deactivated@ksf.org',
            'password' => Hash::make('password123'),
            'role' => 'manager',
            'is_active' => false,
        ]);

        $response = $this->actingAs($inactive)->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
        $this->assertTrue(Auth::guest());
    }

    public function test_role_middleware_forbids_unauthorized_role(): void
    {
        $manager = User::create([
            'name' => 'Operational Manager',
            'email' => 'opmanager@ksf.org',
            'password' => Hash::make('password123'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        $request = Request::create('/admin/settings', 'GET');
        $middleware = new EnsureAdminRole;

        $this->actingAs($manager);

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Unauthorized action. Specific administrator role required.');

        $middleware->handle($request, function () {}, 'super_admin');
    }

    public function test_turnkey_seeding_produces_fully_configured_platform(): void
    {
        $this->assertTrue(User::where('role', 'super_admin')->exists());
        $this->assertTrue(SiteSetting::where('key', 'ngo_name')->exists());
        $this->assertTrue(SiteSetting::where('key', '80g_reg_number')->exists());
        $this->assertGreaterThanOrEqual(5, CauseCategory::count());
        $this->assertTrue(PaymentMethod::where('is_active', true)->exists());
    }
}
