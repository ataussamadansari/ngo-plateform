<?php

namespace Tests\Feature;

use App\Filament\Resources\Campaigns\CampaignResource;
use App\Filament\Resources\Campaigns\Pages\EditCampaign;
use App\Filament\Resources\Campaigns\RelationManagers\DonationsRelationManager;
use App\Filament\Resources\Campaigns\RelationManagers\FundDistributionsRelationManager;
use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Models\FundDistribution;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentStorageAndRelationsAuditTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);
    }

    public function test_public_storage_url_resolves_to_relative_path_and_not_hardcoded_port_80(): void
    {
        $url = Storage::disk('public')->url('payment_methods/default_upi_qr.svg');

        $this->assertEquals('/storage/payment_methods/default_upi_qr.svg', $url);
        $this->assertStringNotContainsString('http://localhost/', $url);
    }

    public function test_default_upi_qr_svg_exists_in_storage_app_public(): void
    {
        $this->assertTrue(Storage::disk('public')->exists('payment_methods/default_upi_qr.svg'));
    }

    public function test_campaign_edit_page_mounts_donations_and_fund_distributions_relations(): void
    {
        $category = CauseCategory::create([
            'name' => 'Education',
            'slug' => 'education',
            'is_active' => true,
        ]);

        $campaign = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Assi Ghat Evening School',
            'slug' => 'assi-ghat-school',
            'short_description' => 'Evening education for children.',
            'full_story' => 'Full story about the evening school on Assi Ghat.',
            'thumbnail_image' => 'campaigns/thumb.jpg',
            'start_date' => now()->toDateString(),
            'goal_amount' => 100000.00,
            'raised_amount' => 25000.00,
            'distributed_amount' => 10000.00,
            'status' => 'active',
        ]);

        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'donor_name' => 'Kavita Verma',
            'donor_phone' => '9876543210',
            'donor_email' => 'kavita@example.com',
            'amount' => 5000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'TESTUTR999',
            'status' => 'verified',
            'receipt_number' => 'KSF-2026-9999',
        ]);

        $distribution = FundDistribution::create([
            'campaign_id' => $campaign->id,
            'title' => 'School Books & Stationery',
            'beneficiary_name' => 'Varanasi Stationery Mart',
            'amount_spent' => 10000.00,
            'description' => 'Textbooks and notebooks for 100 students.',
            'created_by' => $this->admin->id,
            'distribution_date' => now(),
            'is_public' => true,
        ]);

        $relations = CampaignResource::getRelations();
        $this->assertContains(DonationsRelationManager::class, $relations);
        $this->assertContains(FundDistributionsRelationManager::class, $relations);

        Livewire::actingAs($this->admin)
            ->test(EditCampaign::class, ['record' => $campaign->getKey()])
            ->assertSeeLivewire(DonationsRelationManager::class);
    }

    public function test_volunteer_table_has_inspect_action(): void
    {
        $volunteer = Volunteer::create([
            'full_name' => 'Deepak Mishra',
            'phone' => '9876500000',
            'email' => 'deepak@example.com',
            'city' => 'Varanasi',
            'status' => 'pending',
            'skills' => ['Teaching', 'Logistics'],
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/volunteers')
            ->assertSuccessful()
            ->assertSee('Deepak Mishra')
            ->assertSee('Inspect');
    }
}
