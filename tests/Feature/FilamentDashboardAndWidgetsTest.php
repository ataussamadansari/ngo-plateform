<?php

namespace Tests\Feature;

use App\Filament\Widgets\CampaignCategoryAllocationChartWidget;
use App\Filament\Widgets\CampaignsProgressWidget;
use App\Filament\Widgets\CommunityEngagementChartWidget;
use App\Filament\Widgets\DonationPaymentModesChartWidget;
use App\Filament\Widgets\FinancialOverviewWidget;
use App\Filament\Widgets\MonthlyActivityChartWidget;
use App\Filament\Widgets\PendingDonationsQuickActionWidget;
use App\Filament\Widgets\PendingVolunteersWidget;
use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\ContactInquiry;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\FundDistribution;
use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Filament\Pages\Dashboard;
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
            ->test(Dashboard::class)
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

    public function test_monthly_activity_chart_widget_renders_real_inflow_and_outflow_data(): void
    {
        Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Monthly Donor A',
            'donor_phone' => '9870000001',
            'amount' => 12500.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR-MONTHLY-01',
            'status' => 'verified',
            'verified_at' => now(),
            'created_at' => now(),
        ]);

        FundDistribution::create([
            'campaign_id' => $this->campaign->id,
            'title' => 'Direct Ration Kits',
            'beneficiary_name' => 'Local Vendor',
            'description' => '50 Ration Kits',
            'amount_spent' => 4500.00,
            'distribution_date' => now()->toDateString(),
            'is_public' => true,
            'created_by' => $this->admin->id,
            'created_at' => now(),
        ]);

        $test = Livewire::actingAs($this->admin)
            ->test(MonthlyActivityChartWidget::class)
            ->assertSee('Monthly Activity & Financial Flow')
            ->assertSee('Verified donations (inflow) vs ground distributions (outflow)');

        $component = $test->instance();
        $this->assertEquals('line', $component->getType());

        $data = $component->getData();
        $this->assertCount(2, $data['datasets']);
        $this->assertEquals('Verified Donations (₹)', $data['datasets'][0]['label']);
        $this->assertEquals('Funds Distributed (₹)', $data['datasets'][1]['label']);

        // Latest month values match inserted data
        $latestDonation = end($data['datasets'][0]['data']);
        $latestDistribution = end($data['datasets'][1]['data']);
        $this->assertEquals(12500.00, (float) $latestDonation);
        $this->assertEquals(4500.00, (float) $latestDistribution);

        // Filter switching works
        $test->set('filter', '12m');
        $data12 = $test->instance()->getData();
        $this->assertCount(12, $data12['labels']);
    }

    public function test_donation_payment_modes_chart_widget_renders_accurate_mode_breakdown(): void
    {
        Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'UPI Contributor',
            'donor_phone' => '9870000002',
            'amount' => 7000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR-UPI-01',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Bank Contributor',
            'donor_phone' => '9870000003',
            'amount' => 3000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'UTR-BANK-01',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $test = Livewire::actingAs($this->admin)
            ->test(DonationPaymentModesChartWidget::class)
            ->assertSee('Donation Channels');

        $component = $test->instance();
        $this->assertEquals('doughnut', $component->getType());

        $data = $component->getData();
        $this->assertEquals(['UPI QR', 'Bank Transfer', 'Cash'], $data['labels']);
        $this->assertEquals([7000.00, 3000.00, 0.0], $data['datasets'][0]['data']);

        // Switch to transaction count filter
        $test->set('filter', 'count');
        $dataCount = $test->instance()->getData();
        $this->assertEquals([1, 1, 0], $dataCount['datasets'][0]['data']);
    }

    public function test_community_engagement_chart_widget_renders_volunteers_registrations_and_inquiries(): void
    {
        Volunteer::create([
            'full_name' => 'Rahul Verma',
            'email' => 'rahul@example.com',
            'phone' => '9822334455',
            'city' => 'Varanasi',
            'skills' => ['Teaching', 'Sports'],
            'status' => 'pending',
        ]);

        $event = Event::create([
            'title' => 'Clean Ganga Drive',
            'slug' => 'clean-ganga-drive',
            'description' => 'Community riverbank cleaning',
            'banner_image' => 'events/clean-ganga.jpg',
            'location_name' => 'Assi Ghat',
            'address' => 'Ghat Road, Assi, Varanasi',
            'event_date' => now()->addDays(10)->toDateString(),
            'start_time' => '08:00:00',
            'status' => 'upcoming',
        ]);

        EventRegistration::create([
            'event_id' => $event->id,
            'participant_name' => 'Sunil Gupta',
            'participant_phone' => '9899001122',
            'role_assigned' => 'Volunteer Participant',
            'attendance_status' => 'registered',
        ]);

        ContactInquiry::create([
            'name' => 'Maya Patel',
            'email' => 'maya@example.com',
            'subject' => 'Corporate CSR Collaboration',
            'message' => 'Looking to sponsor child education kits.',
            'status' => 'pending',
        ]);

        $test = Livewire::actingAs($this->admin)
            ->test(CommunityEngagementChartWidget::class)
            ->assertSee('Community Growth & Applications Activity');

        $component = $test->instance();
        $this->assertEquals('bar', $component->getType());

        $data = $component->getData();
        $this->assertCount(3, $data['datasets']);
        $this->assertEquals('Volunteer Applicants', $data['datasets'][0]['label']);
        $this->assertEquals('Event Registrations', $data['datasets'][1]['label']);
        $this->assertEquals('Public Inquiries', $data['datasets'][2]['label']);

        $latestVolunteer = end($data['datasets'][0]['data']);
        $latestRegistration = end($data['datasets'][1]['data']);
        $latestInquiry = end($data['datasets'][2]['data']);

        $this->assertEquals(1, $latestVolunteer);
        $this->assertEquals(1, $latestRegistration);
        $this->assertEquals(1, $latestInquiry);
    }

    public function test_campaign_category_allocation_chart_widget_aggregates_raised_amounts_by_category(): void
    {
        $this->campaign->update([
            'raised_amount' => 45000.00,
            'status' => 'active',
        ]);

        $category2 = CauseCategory::where('slug', 'child-education')->first();
        if ($category2) {
            Campaign::create([
                'category_id' => $category2->id,
                'title' => 'School Kits 2026',
                'slug' => 'school-kits-2026',
                'short_description' => 'Providing books and bags.',
                'full_story' => 'Help students attend school.',
                'thumbnail_image' => 'campaigns/school-kits.jpg',
                'goal_amount' => 50000.00,
                'raised_amount' => 25000.00,
                'distributed_amount' => 0.00,
                'start_date' => now(),
                'status' => 'active',
            ]);
        }

        $test = Livewire::actingAs($this->admin)
            ->test(CampaignCategoryAllocationChartWidget::class)
            ->assertSee('Funds Raised by Cause Category');

        $component = $test->instance();
        $this->assertEquals('pie', $component->getType());

        $data = $component->getData();
        $this->assertContains($this->campaign->category->name, $data['labels']);
        $this->assertContains(45000.00, $data['datasets'][0]['data']);
    }

    public function test_filament_dashboard_page_mounts_all_native_widgets_for_authenticated_admin(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');
        $response->assertOk();

        Livewire::actingAs($this->admin)
            ->test(Dashboard::class)
            ->assertSeeLivewire(FinancialOverviewWidget::class)
            ->assertSeeLivewire(MonthlyActivityChartWidget::class)
            ->assertSeeLivewire(DonationPaymentModesChartWidget::class)
            ->assertSeeLivewire(CommunityEngagementChartWidget::class)
            ->assertSeeLivewire(CampaignCategoryAllocationChartWidget::class)
            ->assertSeeLivewire(PendingDonationsQuickActionWidget::class)
            ->assertSeeLivewire(PendingVolunteersWidget::class)
            ->assertSeeLivewire(CampaignsProgressWidget::class);
    }
}
