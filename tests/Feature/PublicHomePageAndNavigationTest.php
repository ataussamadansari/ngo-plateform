<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Models\Event;
use App\Models\FundDistribution;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicHomePageAndNavigationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);
    }

    public function test_homepage_renders_with_real_time_impact_metrics(): void
    {
        $category = CauseCategory::first();
        $paymentMethod = PaymentMethod::first();

        $campaign = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Emergency Oxygen Supplies Drive',
            'slug' => 'emergency-oxygen-supplies',
            'short_description' => 'Direct oxygen concentrator aid for local district hospitals.',
            'full_story' => 'Full detailed story of emergency oxygen supplies for district hospital wards.',
            'thumbnail_image' => 'campaigns/thumbnails/oxygen.jpg',
            'goal_amount' => 50000.00,
            'raised_amount' => 15000.00,
            'distributed_amount' => 10000.00,
            'start_date' => now()->toDateString(),
            'status' => 'active',
            'is_urgent' => true,
        ]);

        // Verified donation
        Donation::create([
            'campaign_id' => $campaign->id,
            'payment_method_id' => $paymentMethod->id,
            'donor_name' => 'Dr. Anand Verma',
            'donor_email' => 'anand@example.com',
            'donor_phone' => '9876543210',
            'amount' => 15000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR123456789012',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        // Fund distribution
        $admin = User::first();
        FundDistribution::create([
            'campaign_id' => $campaign->id,
            'title' => 'Oxygen Cylinders Procurement',
            'beneficiary_name' => 'Kashi Medical Gases Ltd',
            'description' => 'Purchased 5 B-type cylinders from certified medical supplier.',
            'amount_spent' => 10000.00,
            'distribution_date' => now()->toDateString(),
            'is_public' => true,
            'created_by' => $admin->id,
        ]);

        // Approved Volunteer
        Volunteer::create([
            'full_name' => 'Pooja Tiwari',
            'email' => 'pooja@example.com',
            'phone' => '9111122222',
            'city' => 'Varanasi',
            'status' => 'approved',
            'volunteer_code' => 'KSF-VOL-2026-0005',
            'skills' => ['first_aid'],
            'availability' => 'weekends',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Direct Impact, Zero Deductions, 100% Transparency');
        $response->assertSee('₹15,000.00'); // Total Verified Raised
        $response->assertSee('₹10,000.00'); // Total Distributed
        $response->assertSee('Active Volunteers');
        $response->assertSee('Emergency Oxygen Supplies Drive');
    }

    public function test_homepage_displays_urgent_causes_and_upcoming_events(): void
    {
        $category = CauseCategory::first();

        $campaign = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Flood Relief Blanket Drive',
            'slug' => 'flood-relief-blanket-drive',
            'short_description' => 'Distributing warm blankets to flood affected families.',
            'full_story' => 'Full story about winter flood relief and blankets for homeless families.',
            'thumbnail_image' => 'campaigns/thumbnails/blanket.jpg',
            'goal_amount' => 30000.00,
            'raised_amount' => 5000.00,
            'distributed_amount' => 0.00,
            'start_date' => now()->toDateString(),
            'status' => 'active',
            'is_urgent' => true,
        ]);

        $event = Event::create([
            'title' => 'Community Cleanliness Drive at Assi Ghat',
            'slug' => 'assi-ghat-cleanliness-drive',
            'description' => 'Join volunteers in cleaning riverbanks.',
            'banner_image' => 'events/banners/clean.jpg',
            'location_name' => 'Assi Ghat Steps',
            'address' => 'Varanasi, UP',
            'event_date' => now()->addDays(4)->toDateString(),
            'start_time' => '07:00:00',
            'end_time' => '10:00:00',
            'status' => 'upcoming',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Flood Relief Blanket Drive');
        $response->assertSee('Urgent Appeal');
        $response->assertSee('Community Cleanliness Drive at Assi Ghat');
        $response->assertSee('Assi Ghat Steps');
    }

    public function test_homepage_links_to_transparency_ledger_and_donation(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(route('donate.index'));
        $response->assertSee(route('transparency.index'));
        $response->assertSee(route('volunteers.create'));
        $response->assertSee(route('events.index'));
        $response->assertSee(route('campaigns.index'));
    }

    public function test_global_layout_renders_legal_and_social_credentials(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(setting('ngo_name'));
        $response->assertSee(setting('ngo_reg_number'));
        $response->assertSee(setting('80g_reg_number'));
        $response->assertSee(setting('contact_email'));
        $response->assertSee(setting('contact_phone'));
        $response->assertSee('80G Tax Exemption Certified');
        $response->assertSee('Zero Platform Fees');
    }
}
