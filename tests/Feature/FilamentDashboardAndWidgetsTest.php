<?php

namespace Tests\Feature;

use App\Filament\Widgets\CampaignsProgressWidget;
use App\Filament\Widgets\FinancialOverviewWidget;
use App\Filament\Widgets\PendingDonationsQuickActionWidget;
use App\Filament\Widgets\PendingVolunteersWidget;
use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Models\FundDistribution;
use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentDashboardAndWidgetsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Campaign $campaign;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->admin = User::where('role', 'super_admin')->first();

        $category = CauseCategory::first();
        $this->campaign = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Emergency Relief 2026',
            'slug' => 'emergency-relief-2026',
            'short_description' => 'Providing relief kits and medical support.',
            'full_story' => 'Detailed relief plan for displaced families.',
            'thumbnail_image' => 'campaigns/flood.jpg',
            'goal_amount' => 100000.00,
            'raised_amount' => 0.00,
            'distributed_amount' => 0.00,
            'start_date' => now()->subDays(5),
            'status' => 'active',
            'is_urgent' => true,
        ]);
    }

    public function test_filament_dashboard_renders_financial_overview_widget_with_accurate_metrics(): void
    {
        // 1. Create verified donations (₹20,000 total)
        Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Amitabh Bachchan',
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
            'donor_name' => 'Ratan Tata Trust',
            'donor_phone' => '9876543211',
            'amount' => 5000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'UTR5000TEST2',
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $this->admin->id,
        ]);

        // 2. Create pending donation (₹3,000)
        Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Pending Donor',
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

        // Direct widget test
        Livewire::actingAs($this->admin)
            ->test(FinancialOverviewWidget::class)
            ->assertSee('Total Verified Raised')
            ->assertSee('20,000.00')
            ->assertSee('Ground Distributed')
            ->assertSee('8,000.00')
            ->assertSee('Net Treasury Balance')
            ->assertSee('12,000.00')
            ->assertSee('Pending Verifications')
            ->assertSee('1');

        // Full Dashboard HTTP rendering test
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertOk();

        // Dashboard Livewire component renders widget
        Livewire::actingAs($this->admin)
            ->test(\Filament\Pages\Dashboard::class)
            ->assertSeeLivewire(FinancialOverviewWidget::class);
    }

    public function test_pending_donations_widget_allows_direct_verification_and_updates_campaign_balance(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Rameshwar Nath',
            'donor_phone' => '9988776655',
            'amount' => 4500.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR-QUICK-999',
            'status' => 'pending',
        ]);

        $this->assertEquals(0.00, (float) $this->campaign->fresh()->raised_amount);

        Livewire::actingAs($this->admin)
            ->test(PendingDonationsQuickActionWidget::class)
            ->assertCanSeeTableRecords([$donation])
            ->callTableAction('approve', $donation)
            ->assertHasNoTableActionErrors();

        $fresh = $donation->fresh();
        $this->assertEquals('verified', $fresh->status);
        $this->assertNotNull($fresh->receipt_number);
        $this->assertStringStartsWith('KSF-2026-', $fresh->receipt_number);
        $this->assertEquals(4500.00, (float) $this->campaign->fresh()->raised_amount);
    }

    public function test_pending_donations_widget_allows_direct_rejection_with_remarks(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Fake Sender',
            'donor_phone' => '9988776600',
            'amount' => 1200.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'INVALID-UTR-00',
            'status' => 'pending',
        ]);

        Livewire::actingAs($this->admin)
            ->test(PendingDonationsQuickActionWidget::class)
            ->assertCanSeeTableRecords([$donation])
            ->callTableAction('reject', $donation, [
                'admin_remarks' => 'UTR not found in bank statement records.',
            ])
            ->assertHasNoTableActionErrors();

        $fresh = $donation->fresh();
        $this->assertEquals('rejected', $fresh->status);
        $this->assertEquals('UTR not found in bank statement records.', $fresh->admin_remarks);
    }

    public function test_pending_volunteers_widget_allows_direct_approval_and_code_generation(): void
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

        Livewire::actingAs($this->admin)
            ->test(PendingVolunteersWidget::class)
            ->assertCanSeeTableRecords([$volunteer])
            ->callTableAction('approve', $volunteer)
            ->assertHasNoTableActionErrors();

        $fresh = $volunteer->fresh();
        $this->assertEquals('approved', $fresh->status);
        $this->assertNotNull($fresh->volunteer_code);
        $this->assertMatchesRegularExpression('/^[A-Z0-9]+-VOL-\d{4}-\d{4}$/', $fresh->volunteer_code);
    }

    public function test_pending_volunteers_widget_allows_direct_rejection(): void
    {
        $volunteer = Volunteer::create([
            'full_name' => 'Ineligible Applicant',
            'email' => 'ineligible@example.com',
            'phone' => '9811223399',
            'city' => 'Delhi',
            'skills' => ['General support'],
            'status' => 'pending',
        ]);

        Livewire::actingAs($this->admin)
            ->test(PendingVolunteersWidget::class)
            ->assertCanSeeTableRecords([$volunteer])
            ->callTableAction('reject', $volunteer)
            ->assertHasNoTableActionErrors();

        $this->assertEquals('rejected', $volunteer->fresh()->status);
    }

    public function test_campaigns_progress_widget_renders_active_campaigns(): void
    {
        $this->campaign->update([
            'raised_amount' => 50000.00,
            'distributed_amount' => 20000.00,
        ]);

        Livewire::actingAs($this->admin)
            ->test(CampaignsProgressWidget::class)
            ->assertCanSeeTableRecords([$this->campaign])
            ->assertSee('Emergency Relief 2026')
            ->assertSee('50%');
    }
}
