<?php

namespace Tests\Feature;

use App\Models\CauseCategory;
use App\Models\SiteSetting;
use Database\Seeders\NgoWhiteLabelSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WhiteLabelSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ngo_white_label_seeder_populates_required_data(): void
    {
        $this->seed(NgoWhiteLabelSeeder::class);

        // Verify Super Admin
        $this->assertDatabaseHas('users', [
            'email' => 'admin@ksf.org',
            'role' => 'super_admin',
            'phone' => '+91 9876543210',
            'is_active' => true,
        ]);

        // Verify Categories
        $this->assertEquals(5, CauseCategory::count());
        $this->assertDatabaseHas('cause_categories', ['slug' => 'medical-aid', 'name' => 'Medical Aid']);
        $this->assertDatabaseHas('cause_categories', ['slug' => 'child-education', 'name' => 'Child Education']);

        // Verify White-Label Settings
        $this->assertEquals('Kashi Seva Foundation', setting('ngo_name'));
        $this->assertEquals('#16a34a', setting('primary_color'));
        $this->assertEquals('#0f172a', setting('secondary_color'));
        $this->assertEquals('KSF', setting('receipt_prefix'));
        $this->assertEquals('1', setting('has_80g'));
    }

    public function test_setting_helper_uses_cache_and_avoids_repeated_database_queries(): void
    {
        SiteSetting::create([
            'key' => 'custom_title',
            'value' => 'Direct Transparency',
            'group' => 'branding',
        ]);

        Cache::forget('site_settings');

        // First call caches the settings
        $initial = setting('custom_title');
        $this->assertEquals('Direct Transparency', $initial);

        // Verify that repeated calls do not query the database
        DB::enableQueryLog();
        $cached = setting('custom_title');
        $queries = DB::getQueryLog();
        DB::disableQueryLog();

        $this->assertEquals('Direct Transparency', $cached);
        $this->assertEmpty($queries, 'Repeated setting() calls should resolve from cache without database queries.');
    }

    public function test_updating_site_setting_clears_cache_automatically(): void
    {
        $setting = SiteSetting::create([
            'key' => 'org_motto',
            'value' => 'Old Motto',
            'group' => 'branding',
        ]);

        $this->assertEquals('Old Motto', setting('org_motto'));

        // Update model
        $setting->update(['value' => 'New Transparent Motto']);

        // The helper should immediately reflect the updated value
        $this->assertEquals('New Transparent Motto', setting('org_motto'));
    }

    public function test_deleting_site_setting_clears_cache_automatically(): void
    {
        $setting = SiteSetting::create([
            'key' => 'temporary_promo',
            'value' => 'Diwali Drive',
            'group' => 'branding',
        ]);

        $this->assertEquals('Diwali Drive', setting('temporary_promo'));

        // Delete model
        $setting->delete();

        // The helper should fallback to default
        $this->assertEquals('default_val', setting('temporary_promo', 'default_val'));
    }

    public function test_home_page_renders_with_dynamic_white_label_theming(): void
    {
        $this->seed(NgoWhiteLabelSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Kashi Seva Foundation');
        $response->assertSee('--color-primary: #16a34a', false);
        $response->assertSee('--color-secondary: #0f172a', false);
        $response->assertSee('Medical Aid');
    }

    public function test_public_storage_symlink_exists(): void
    {
        $this->assertTrue(
            file_exists(public_path('storage')),
            'Public storage symlink must exist for uploaded receipts and proofs.'
        );
    }
}
