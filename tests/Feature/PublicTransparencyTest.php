<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Models\FundDistribution;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicTransparencyTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Campaign $campaignA;

    protected Campaign $campaignB;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->admin = User::where('role', 'super_admin')->first();

        $category = CauseCategory::first();
        $this->campaignA = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Clean Water Initiative',
            'slug' => 'clean-water-initiative',
            'short_description' => 'Providing clean drinking water filters',
            'full_story' => 'Installing water filtration systems across 10 rural schools...',
            'thumbnail_image' => 'campaigns/water.jpg',
            'start_date' => now(),
            'goal_amount' => 100000.00,
            'raised_amount' => 40000.00,
            'distributed_amount' => 25000.00,
            'status' => 'active',
        ]);

        $this->campaignB = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Orphan Education Support',
            'slug' => 'orphan-education-support',
            'short_description' => 'Tuition fees and school stationery',
            'full_story' => 'Supporting 50 orphan children with complete school fees...',
            'thumbnail_image' => 'campaigns/education.jpg',
            'start_date' => now(),
            'goal_amount' => 80000.00,
            'raised_amount' => 30000.00,
            'distributed_amount' => 10000.00,
            'status' => 'active',
        ]);
    }

    public function test_transparency_page_renders_with_accurate_verified_financial_metrics(): void
    {
        // Verified donation of ₹20,000
        Donation::create([
            'donor_name' => 'Verified Donor',
            'donor_phone' => '9876543210',
            'amount' => 20000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'VERIFIEDDON1',
            'receipt_number' => 'KSF-2026-0001',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        // Pending donation of ₹10,000 (must NOT be counted in verified total)
        Donation::create([
            'donor_name' => 'Pending Donor',
            'donor_phone' => '9876543211',
            'amount' => 10000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'PENDINGDON1',
            'status' => 'pending',
        ]);

        // Public distribution of ₹12,000
        FundDistribution::create([
            'title' => 'RO Filter Procurement',
            'beneficiary_name' => '5 Primary Schools',
            'amount_spent' => 12000.00,
            'distribution_date' => now(),
            'description' => 'Installed water filtration units.',
            'is_public' => true,
            'campaign_id' => $this->campaignA->id,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get('/transparency');

        $response->assertStatus(200);
        $response->assertSee('Every Single Rupee Accounted For');
        $response->assertSee('20,000.00'); // Verified total
        $response->assertSee('12,000.00'); // Disbursed total
        $response->assertSee('8,000.00');  // Net reserve (20,000 - 12,000)
        $response->assertDontSee('30,000.00'); // Should not include pending ₹10,000
    }

    public function test_transparency_page_excludes_private_internal_distributions(): void
    {
        FundDistribution::create([
            'title' => 'Public Medical Assistance',
            'beneficiary_name' => 'Children Ward',
            'amount_spent' => 5000.00,
            'distribution_date' => now(),
            'description' => 'Medical kits delivered.',
            'is_public' => true,
            'created_by' => $this->admin->id,
        ]);

        FundDistribution::create([
            'title' => 'Internal Operational Audit Fee',
            'beneficiary_name' => 'Audit Partner',
            'amount_spent' => 3000.00,
            'distribution_date' => now(),
            'description' => 'Internal accounting software subscription.',
            'is_public' => false,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get('/transparency');

        $response->assertStatus(200);
        $response->assertSee('Public Medical Assistance');
        $response->assertDontSee('Internal Operational Audit Fee');
    }

    public function test_campaign_specific_transparency_ledger_displays_cause_expenditures(): void
    {
        FundDistribution::create([
            'title' => 'Solar Filter Installation',
            'beneficiary_name' => 'Kashi Rural School #2',
            'amount_spent' => 15000.00,
            'distribution_date' => now(),
            'payment_reference' => 'WATER-SOLAR-01',
            'description' => 'Supplied solar water filter unit.',
            'is_public' => true,
            'campaign_id' => $this->campaignA->id,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get("/campaigns/{$this->campaignA->slug}/transparency");

        $response->assertStatus(200);
        $response->assertSee('Clean Water Initiative');
        $response->assertSee('Solar Filter Installation');
        $response->assertSee('15,000.00');
        $response->assertSee('WATER-SOLAR-01');
    }

    public function test_transparency_filter_by_campaign_works(): void
    {
        FundDistribution::create([
            'title' => 'Water Unit Distribution',
            'beneficiary_name' => 'Water Recipients',
            'amount_spent' => 5000.00,
            'distribution_date' => now(),
            'description' => 'Clean water kits.',
            'is_public' => true,
            'campaign_id' => $this->campaignA->id,
            'created_by' => $this->admin->id,
        ]);

        FundDistribution::create([
            'title' => 'School Books Distribution',
            'beneficiary_name' => 'Orphan Students',
            'amount_spent' => 8000.00,
            'distribution_date' => now(),
            'description' => 'School stationary sets.',
            'is_public' => true,
            'campaign_id' => $this->campaignB->id,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get("/transparency?campaign={$this->campaignA->id}");

        $response->assertStatus(200);
        $response->assertSee('Water Unit Distribution');
        $response->assertDontSee('School Books Distribution');
    }
}
