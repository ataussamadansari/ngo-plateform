<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageSiteSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentSiteSettingsTest extends TestCase
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

    public function test_unauthenticated_user_cannot_access_settings_page(): void
    {
        $response = $this->get('/admin/settings');

        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_super_admin_can_access_settings_page(): void
    {
        $response = $this->actingAs($this->superAdmin)->get('/admin/settings');

        $response->assertOk();
        $response->assertSee('White-Label Platform Settings');
        $response->assertSee('Branding & Theming');
        $response->assertSee('Tax & 80G Compliance');
    }

    public function test_settings_page_populates_existing_database_values(): void
    {
        $this->actingAs($this->superAdmin);

        Livewire::test(ManageSiteSettings::class)
            ->assertSchemaStateSet([
                'ngo_name' => 'Kashi Seva Foundation',
                'primary_color' => '#16a34a',
                'ngo_pan_number' => 'AABTK1234F',
            ]);
    }

    public function test_admin_can_update_settings_and_cache_is_invalidated_immediately(): void
    {
        $this->actingAs($this->superAdmin);

        Livewire::test(ManageSiteSettings::class)
            ->fillForm([
                'ngo_name' => 'Varanasi Seva Mission',
                'primary_color' => '#059669',
                'secondary_color' => '#1e293b',
                'ngo_pan_number' => 'PAN9876543',
                '80g_reg_number' => '80G-NEW-2026',
                'receipt_prefix' => 'VSM',
                'volunteer_prefix' => 'VSM-VOL',
                'contact_email' => 'contact@varanasiseva.org',
                'contact_phone' => '+91 9988776655',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        // 1. Verify database was updated
        $this->assertEquals('Varanasi Seva Mission', SiteSetting::where('key', 'ngo_name')->value('value'));
        $this->assertEquals('#059669', SiteSetting::where('key', 'primary_color')->value('value'));
        $this->assertEquals('80G-NEW-2026', SiteSetting::where('key', '80g_reg_number')->value('value'));

        // 2. Verify global setting() helper returns new value immediately (cache cleared)
        $this->assertEquals('Varanasi Seva Mission', setting('ngo_name'));
        $this->assertEquals('#059669', setting('primary_color'));
    }

    public function test_inactive_admin_cannot_access_settings_page(): void
    {
        $response = $this->actingAs($this->inactiveUser)->get('/admin/settings');

        $response->assertForbidden();
    }
}
