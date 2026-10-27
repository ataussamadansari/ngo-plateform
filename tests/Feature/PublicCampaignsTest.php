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

class PublicCampaignsTest extends TestCase
{
    use RefreshDatabase;

    protected CauseCategory $medicalCategory;

    protected CauseCategory $educationCategory;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->admin = User::where('role', 'super_admin')->first();

        $this->medicalCategory = CauseCategory::firstOrCreate(
            ['slug' => 'medical-relief'],
            ['name' => 'Medical Relief', 'icon' => 'heart', 'is_active' => true]
        );

        $this->educationCategory = CauseCategory::firstOrCreate(
            ['slug' => 'child-education'],
            ['name' => 'Child Education', 'icon' => 'book', 'is_active' => true]
        );
    }

    public function test_public_can_browse_campaigns_directory(): void
    {
        $activeCampaign = Campaign::create([
            'category_id' => $this->medicalCategory->id,
            'title' => 'Emergency Oxygen & Medicine Fund',
            'slug' => 'emergency-oxygen-medicine-fund',
            'short_description' => 'Life-saving oxygen cylinders and critical medicines.',
            'full_story' => 'Detailed narrative about medical aid distribution.',
            'thumbnail_image' => 'campaigns/oxygen.jpg',
            'goal_amount' => 150000.00,
            'raised_amount' => 50000.00,
            'start_date' => now(),
            'status' => 'active',
            'is_urgent' => true,
        ]);

        $draftCampaign = Campaign::create([
            'category_id' => $this->educationCategory->id,
            'title' => 'Unreleased Future School Project',
            'slug' => 'unreleased-future-school-project',
            'short_description' => 'Internal draft planning for schools.',
            'full_story' => 'Draft details not ready for the public.',
            'thumbnail_image' => 'campaigns/school.jpg',
            'goal_amount' => 500000.00,
            'raised_amount' => 0.00,
            'start_date' => now(),
            'status' => 'draft',
        ]);

        $response = $this->get('/campaigns');

        $response->assertOk();
        $response->assertSee('Support Our Active Causes');
        $response->assertSee('Emergency Oxygen & Medicine Fund');
        $response->assertSee('50,000.00');
        $response->assertDontSee('Unreleased Future School Project');
    }

    public function test_campaigns_directory_supports_category_filtering(): void
    {
        $medicalCampaign = Campaign::create([
            'category_id' => $this->medicalCategory->id,
            'title' => 'Dialysis Relief Support',
            'slug' => 'dialysis-relief-support',
            'short_description' => 'Supporting renal dialysis patients.',
            'full_story' => 'Free dialysis sessions for underprivileged families.',
            'thumbnail_image' => 'campaigns/dialysis.jpg',
            'goal_amount' => 80000.00,
            'raised_amount' => 20000.00,
            'start_date' => now(),
            'status' => 'active',
        ]);

        $educationCampaign = Campaign::create([
            'category_id' => $this->educationCategory->id,
            'title' => 'Rural Scholarship Program',
            'slug' => 'rural-scholarship-program',
            'short_description' => 'Providing books and school uniforms.',
            'full_story' => 'Scholarships for rural girls in secondary education.',
            'thumbnail_image' => 'campaigns/scholarship.jpg',
            'goal_amount' => 120000.00,
            'raised_amount' => 60000.00,
            'start_date' => now(),
            'status' => 'active',
        ]);

        $response = $this->get('/campaigns?category='.$this->medicalCategory->slug);

        $response->assertOk();
        $response->assertSee('Dialysis Relief Support');
        $response->assertDontSee('Rural Scholarship Program');
    }

    public function test_campaign_detail_renders_rich_story_and_progress_bar(): void
    {
        $campaign = Campaign::create([
            'category_id' => $this->medicalCategory->id,
            'title' => 'Critical ICU Equipment Drive',
            'slug' => 'critical-icu-equipment-drive',
            'short_description' => 'Procuring advanced ICU monitors.',
            'full_story' => 'Our local hospital requires 5 advanced cardiac monitors to treat patients in rural districts.',
            'thumbnail_image' => 'campaigns/icu.jpg',
            'goal_amount' => 200000.00,
            'raised_amount' => 150000.00,
            'distributed_amount' => 80000.00,
            'start_date' => now(),
            'status' => 'active',
            'gallery_images' => ['campaigns/test1.jpg', 'campaigns/test2.jpg'],
        ]);

        FundDistribution::create([
            'campaign_id' => $campaign->id,
            'title' => 'First Cardiac Monitor Purchase',
            'beneficiary_name' => 'City Hospital Trust',
            'amount_spent' => 80000.00,
            'distribution_date' => now()->subDays(3),
            'payment_reference' => 'TXN-ICU-8899',
            'proof_bill_image' => 'distributions/bills/bill1.jpg',
            'description' => 'Procured and delivered 1 cardiac monitor to emergency trauma ward.',
            'is_public' => true,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->get('/campaigns/'.$campaign->slug);

        $response->assertOk();
        $response->assertSee('Critical ICU Equipment Drive');
        $response->assertSee('Our local hospital requires 5 advanced cardiac monitors');
        $response->assertSee('150,000.00');
        $response->assertSee('200,000.00');
        $response->assertSee('75%'); // 150k / 200k = 75%
        $response->assertSee('First Cardiac Monitor Purchase');
        $response->assertSee('80,000.00');
    }

    public function test_campaign_detail_displays_verified_donors_and_excludes_pending(): void
    {
        $campaign = Campaign::create([
            'category_id' => $this->medicalCategory->id,
            'title' => 'Heart Surgery Relief',
            'slug' => 'heart-surgery-relief',
            'short_description' => 'Pediatric heart surgeries.',
            'full_story' => 'Saving young lives through verified medical procedures.',
            'thumbnail_image' => 'campaigns/heart.jpg',
            'goal_amount' => 300000.00,
            'raised_amount' => 25000.00,
            'start_date' => now(),
            'status' => 'active',
        ]);

        // Verified public donation
        Donation::create([
            'campaign_id' => $campaign->id,
            'receipt_number' => 'KS-2026-0001',
            'donor_name' => 'Aarav Sharma',
            'donor_email' => 'aarav@example.com',
            'donor_phone' => '9876543210',
            'amount' => 15000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR123456789012',
            'payment_screenshot' => 'screenshots/screen1.jpg',
            'donor_message' => 'Praying for swift recovery.',
            'is_anonymous' => false,
            'status' => 'verified',
            'verified_by' => $this->admin->id,
            'verified_at' => now(),
        ]);

        // Verified anonymous donation
        Donation::create([
            'campaign_id' => $campaign->id,
            'receipt_number' => 'KS-2026-0002',
            'donor_name' => 'Sneha Guha',
            'donor_email' => 'sneha@example.com',
            'donor_phone' => '9876543211',
            'amount' => 10000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'UTR998877665544',
            'payment_screenshot' => 'screenshots/screen2.jpg',
            'is_anonymous' => true,
            'status' => 'verified',
            'verified_by' => $this->admin->id,
            'verified_at' => now(),
        ]);

        // Pending unverified donation
        Donation::create([
            'campaign_id' => $campaign->id,
            'receipt_number' => 'KS-2026-0003',
            'donor_name' => 'Pending Donor Roy',
            'donor_email' => 'pending@example.com',
            'donor_phone' => '9876543212',
            'amount' => 5000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR000000000001',
            'payment_screenshot' => 'screenshots/screen3.jpg',
            'is_anonymous' => false,
            'status' => 'pending',
        ]);

        $response = $this->get('/campaigns/'.$campaign->slug);

        $response->assertOk();
        // Sees verified donor
        $response->assertSee('Aarav Sharma');
        $response->assertSee('15,000.00');
        $response->assertSee('Praying for swift recovery.');

        // Sees anonymous supporter (masks private name)
        $response->assertSee('Anonymous Supporter');
        $response->assertSee('10,000.00');
        $response->assertDontSee('Sneha Guha');

        // Does NOT see pending donation
        $response->assertDontSee('Pending Donor Roy');
    }

    public function test_draft_campaign_returns_404_for_public(): void
    {
        $draftCampaign = Campaign::create([
            'category_id' => $this->educationCategory->id,
            'title' => 'Draft Campaign Hidden',
            'slug' => 'draft-campaign-hidden',
            'short_description' => 'Draft description.',
            'full_story' => 'Draft narrative.',
            'thumbnail_image' => 'campaigns/draft.jpg',
            'goal_amount' => 50000.00,
            'raised_amount' => 0.00,
            'start_date' => now(),
            'status' => 'draft',
        ]);

        $response = $this->get('/campaigns/'.$draftCampaign->slug);

        $response->assertNotFound();
    }

    public function test_paused_campaign_returns_404_for_public(): void
    {
        $pausedCampaign = Campaign::create([
            'category_id' => $this->educationCategory->id,
            'title' => 'Paused Campaign Under Review',
            'slug' => 'paused-campaign-under-review',
            'short_description' => 'Temporarily paused campaign.',
            'full_story' => 'Paused narrative.',
            'thumbnail_image' => 'campaigns/paused.jpg',
            'goal_amount' => 50000.00,
            'raised_amount' => 10000.00,
            'start_date' => now(),
            'status' => 'paused',
        ]);

        $response = $this->get('/campaigns/'.$pausedCampaign->slug);

        $response->assertNotFound();
    }

    public function test_campaign_detail_renders_all_rich_editor_html_formatting_tags(): void
    {
        $richStoryHtml = '<h3>Ground Reality & Needs</h3>'
            .'<p class="lead">Rural district hospitals often face sudden shortages of life-saving oxygen during seasonal surges.</p>'
            .'<p><strong>Hope Foundation</strong> is deploying 10L medical concentrators with complete maintenance backup directly to grassroots medical clinics.</p>'
            .'<ul><li>10L Medical Oxygen Concentrators</li><li>Dual Flow Splitters</li></ul>'
            .'<blockquote>Every rupee contributed is verified against bank statements and tracked through public GST tax invoices.</blockquote>'
            .'<table><thead><tr><th>Asset</th><th>Qty</th></tr></thead><tbody><tr><td>Concentrator</td><td>20</td></tr></tbody></table>'
            .'<p>Please support this <mark>urgent appeal</mark> immediately.</p>';

        $campaign = Campaign::create([
            'category_id' => $this->medicalCategory->id,
            'title' => 'Rural Oxygen Relief Drive',
            'slug' => 'rural-oxygen-relief-drive',
            'short_description' => 'Supplying 10L oxygen concentrators to district hospitals.',
            'full_story' => $richStoryHtml,
            'thumbnail_image' => 'campaigns/oxygen-drive.jpg',
            'goal_amount' => 500000.00,
            'raised_amount' => 125000.00,
            'start_date' => now(),
            'status' => 'active',
        ]);

        $response = $this->get('/campaigns/'.$campaign->slug);

        $response->assertOk();
        $response->assertSee('rich-story-content');
        $response->assertSee('<h3>Ground Reality & Needs</h3>', false);
        $response->assertSee('<strong>Hope Foundation</strong>', false);
        $response->assertSee('<li>10L Medical Oxygen Concentrators</li>', false);
        $response->assertSee('<blockquote>Every rupee contributed is verified', false);
        $response->assertSee('<table><thead><tr><th>Asset</th>', false);
        $response->assertSee('<mark>urgent appeal</mark>', false);
        // Ensure no raw HTML is escaped into literal &lt;p&gt; entities
        $response->assertDontSee('&lt;p&gt;&lt;strong&gt;Hope Foundation&lt;/strong&gt;');
    }
}
