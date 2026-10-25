<?php

namespace Tests\Feature;

use App\Filament\Resources\Donations\Pages\CreateDonation;
use App\Filament\Resources\Donations\Pages\ListDonations;
use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentDonationResourceTest extends TestCase
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
            'title' => 'Emergency Medical Fund',
            'slug' => 'emergency-medical-fund',
            'short_description' => 'Providing critical medical care',
            'full_story' => 'Detailed story of ground relief and emergency support...',
            'thumbnail_image' => 'campaigns/medical.jpg',
            'start_date' => now(),
            'goal_amount' => 100000.00,
            'raised_amount' => 0.00,
            'status' => 'active',
        ]);
    }

    public function test_unauthenticated_user_cannot_access_donations(): void
    {
        $response = $this->get('/admin/donations');
        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_view_donations_list(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/donations');
        $response->assertSuccessful();
    }

    public function test_table_renders_donations(): void
    {
        $pending = Donation::create([
            'donor_name' => 'Ramesh Kumar',
            'donor_phone' => '9876543210',
            'amount' => 2500.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR123456789',
            'status' => 'pending',
            'campaign_id' => $this->campaign->id,
        ]);

        $verified = Donation::create([
            'donor_name' => 'Sita Devi',
            'donor_phone' => '9876543211',
            'amount' => 5000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'UTR987654321',
            'receipt_number' => 'KSF-2026-0001',
            'status' => 'verified',
            'campaign_id' => $this->campaign->id,
            'verified_at' => now(),
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListDonations::class)
            ->assertCanSeeTableRecords([$pending, $verified]);
    }

    public function test_admin_can_approve_pending_donation_via_table_action(): void
    {
        $donation = Donation::create([
            'donor_name' => 'Amit Sharma',
            'donor_phone' => '9876543212',
            'amount' => 4000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'APPROVE-UTR-01',
            'status' => 'pending',
            'campaign_id' => $this->campaign->id,
        ]);

        $this->assertEquals(0.00, (float) $this->campaign->fresh()->raised_amount);

        Livewire::actingAs($this->admin)
            ->test(ListDonations::class)
            ->callTableAction('approve', $donation)
            ->assertHasNoTableActionErrors();

        $donation->refresh();
        $this->assertEquals('verified', $donation->status);
        $this->assertNotNull($donation->receipt_number);
        $this->assertStringStartsWith('KSF-2026-', $donation->receipt_number);
        $this->assertEquals(4000.00, (float) $this->campaign->fresh()->raised_amount);
    }

    public function test_admin_can_reject_pending_donation_via_table_action(): void
    {
        $donation = Donation::create([
            'donor_name' => 'Anil Verma',
            'donor_phone' => '9876543213',
            'amount' => 1500.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'REJECT-UTR-01',
            'status' => 'pending',
            'campaign_id' => $this->campaign->id,
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListDonations::class)
            ->callTableAction('reject', $donation, data: [
                'admin_remarks' => 'Bank statement did not match UTR number.',
            ])
            ->assertHasNoTableActionErrors();

        $donation->refresh();
        $this->assertEquals('rejected', $donation->status);
        $this->assertEquals('Bank statement did not match UTR number.', $donation->admin_remarks);
    }

    public function test_admin_can_create_offline_donation_via_form(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateDonation::class)
            ->fillForm([
                'donor_name' => 'Vikram Singh',
                'donor_phone' => '9876543214',
                'donor_email' => 'vikram@example.com',
                'donor_pan' => 'ABCDE1234F',
                'donor_address' => 'Assi Ghat, Varanasi',
                'amount' => 12000.00,
                'payment_mode' => 'cash',
                'campaign_id' => $this->campaign->id,
                'admin_remarks' => 'Direct cash donation handed over at office.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $donation = Donation::where('donor_name', 'Vikram Singh')->first();
        $this->assertNotNull($donation);
        $this->assertEquals('verified', $donation->status);
        $this->assertEquals(12000.00, (float) $donation->amount);
        $this->assertNotNull($donation->receipt_number);
        $this->assertStringStartsWith('KSF-2026-', $donation->receipt_number);
        $this->assertEquals(12000.00, (float) $this->campaign->fresh()->raised_amount);
    }

    public function test_admin_can_download_receipt_pdf_for_verified_donation(): void
    {
        $donation = Donation::create([
            'donor_name' => 'Pooja Hegde',
            'donor_phone' => '9876543215',
            'amount' => 5000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'POOJA-UTR-99',
            'receipt_number' => 'KSF-2026-0005',
            'status' => 'verified',
            'campaign_id' => $this->campaign->id,
            'verified_at' => now(),
        ]);

        $component = Livewire::actingAs($this->admin)
            ->test(ListDonations::class)
            ->callTableAction('download_receipt', $donation);

        $component->assertFileDownloaded("receipt-{$donation->receipt_number}.pdf");
    }
}
