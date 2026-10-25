<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Models\FundDistribution;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardAndQuickActionsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Campaign $campaign;

    protected PaymentMethod $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->admin = User::where('role', 'super_admin')->first();
        $this->paymentMethod = PaymentMethod::where('is_active', true)->first();

        $category = CauseCategory::first();
        $this->campaign = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Emergency Flood Relief 2026',
            'slug' => 'emergency-flood-relief-2026',
            'short_description' => 'Providing ration kits and medical support.',
            'full_story' => 'Detailed relief plan for displaced families in Varanasi.',
            'thumbnail_image' => 'campaigns/flood.jpg',
            'goal_amount' => 100000.00,
            'raised_amount' => 0.00,
            'distributed_amount' => 0.00,
            'start_date' => now()->subDays(5),
            'status' => 'active',
            'is_urgent' => true,
        ]);
    }

    public function test_admin_dashboard_displays_accurate_financial_metrics(): void
    {
        // 1. Create verified donations (₹15,000 + ₹5,000 = ₹20,000)
        Donation::create([
            'campaign_id' => $this->campaign->id,
            'payment_method_id' => $this->paymentMethod->id,
            'donor_name' => 'Amitabh Bachchan',
            'donor_email' => 'amitabh@example.com',
            'donor_phone' => '9876543210',
            'amount' => 15000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR15000TEST1',
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $this->admin->id,
        ]);

        Donation::create([
            'campaign_id' => $this->campaign->id,
            'payment_method_id' => $this->paymentMethod->id,
            'donor_name' => 'Ratan Tata Trust',
            'donor_email' => 'tata@example.com',
            'donor_phone' => '9876543211',
            'amount' => 5000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'UTR5000TEST2',
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $this->admin->id,
        ]);

        // 2. Create pending donation (₹3,000 - should NOT count toward verified treasury)
        Donation::create([
            'campaign_id' => $this->campaign->id,
            'payment_method_id' => $this->paymentMethod->id,
            'donor_name' => 'Pending Donor',
            'donor_email' => 'pending@example.com',
            'donor_phone' => '9876543212',
            'amount' => 3000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTRPENDING99',
            'status' => 'pending',
        ]);

        // 3. Create fund distribution (₹8,000)
        FundDistribution::create([
            'campaign_id' => $this->campaign->id,
            'title' => 'First Aid Kits & Antibiotics',
            'beneficiary_name' => 'Kashi Medical Stores',
            'description' => 'Procurement of 50 first-aid kits and antibiotics',
            'amount_spent' => 8000.00,
            'distribution_date' => now()->toDateString(),
            'is_public' => true,
            'created_by' => $this->admin->id,
        ]);

        // Access Admin Dashboard
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertOk();
        // Verified: ₹20,000.00
        $response->assertSee('20,000.00');
        // Distributed: ₹8,000.00
        $response->assertSee('8,000.00');
        // Available Balance: ₹12,000.00
        $response->assertSee('12,000.00');
    }

    public function test_admin_dashboard_displays_pending_donations_quick_action_queue(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'payment_method_id' => $this->paymentMethod->id,
            'donor_name' => 'Rameshwar Nath',
            'donor_email' => 'rameshwar@example.com',
            'donor_phone' => '9988776655',
            'amount' => 4500.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR-QUICK-999',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('Rameshwar Nath');
        $response->assertSee('UTR-QUICK-999');

        // Approve donation from the queue action
        $approveResponse = $this->actingAs($this->admin)->post(
            route('admin.donations.approve', $donation->id)
        );

        $approveResponse->assertRedirect();
        $this->assertDatabaseHas('donations', [
            'id' => $donation->id,
            'status' => 'verified',
        ]);
        $this->assertEquals(4500.00, $this->campaign->fresh()->raised_amount);
    }

    public function test_admin_dashboard_displays_pending_volunteers_screening_queue(): void
    {
        $volunteer = Volunteer::create([
            'full_name' => 'Ananya Sharma',
            'email' => 'ananya@example.com',
            'phone' => '9811223344',
            'city' => 'Varanasi',
            'skills' => ['Medical doctor', 'Emergency triage'],
            'availability' => 'weekends',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('Ananya Sharma');
        $response->assertSee('Varanasi');

        // Approve volunteer directly
        $approveResponse = $this->actingAs($this->admin)->post(
            route('admin.volunteers.approve', $volunteer->id)
        );

        $approveResponse->assertRedirect();
        $fresh = $volunteer->fresh();
        $this->assertEquals('approved', $fresh->status);
        $this->assertNotNull($fresh->volunteer_code);
    }

    public function test_admin_dashboard_displays_active_campaigns_and_recent_distributions(): void
    {
        FundDistribution::create([
            'campaign_id' => $this->campaign->id,
            'title' => 'Bulk Ration Kits Distribution',
            'beneficiary_name' => 'Annapurna Ration Wholesalers',
            'description' => 'Bulk rice and lentils bags',
            'amount_spent' => 12500.00,
            'distribution_date' => now()->toDateString(),
            'is_public' => true,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('Emergency Flood Relief 2026');
        $response->assertSee('Annapurna Ration Wholesalers');
        $response->assertSee('12,500.00');
    }
}
