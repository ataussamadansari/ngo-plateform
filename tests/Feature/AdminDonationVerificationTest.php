<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDonationVerificationTest extends TestCase
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
        $this->actingAs($this->admin);

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

    public function test_admin_can_view_verification_queue_and_metrics(): void
    {
        Donation::create([
            'donor_name' => 'Pending Donor',
            'donor_phone' => '9876543210',
            'amount' => 1000,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'PENDING123',
            'status' => 'pending',
        ]);

        Donation::create([
            'donor_name' => 'Verified Donor',
            'donor_phone' => '9876543211',
            'amount' => 5000,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'VERIFIED123',
            'receipt_number' => 'KSF-2026-0001',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $response = $this->get(route('admin.donations.index'));

        $response->assertStatus(200);
        $response->assertSee('Donation Verification Queue');
        $response->assertSee('PENDING123');
        $response->assertSee('Pending Review');
    }

    public function test_admin_can_approve_pending_donation_atomically(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Dilip Kumar',
            'donor_email' => 'dilip@example.com',
            'donor_phone' => '9876543212',
            'amount' => 5000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTRAPPROVE123',
            'status' => 'pending',
        ]);

        $this->assertEquals(0.00, (float) $this->campaign->fresh()->raised_amount);

        $response = $this->post(route('admin.donations.approve', $donation));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $donation->refresh();
        $this->assertEquals('verified', $donation->status);
        $this->assertNotNull($donation->receipt_number);
        $this->assertStringStartsWith('KSF-2026-', $donation->receipt_number);
        $this->assertNotNull($donation->verified_at);

        // Campaign raised_amount must have incremented by 5000.00
        $this->assertEquals(5000.00, (float) $this->campaign->fresh()->raised_amount);
    }

    public function test_approving_already_verified_donation_is_prevented(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Dilip Kumar',
            'donor_phone' => '9876543212',
            'amount' => 5000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTRAPPROVE999',
            'receipt_number' => 'KSF-2026-0002',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $response = $this->post(route('admin.donations.approve', $donation));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_admin_can_reject_donation_with_remarks(): void
    {
        $donation = Donation::create([
            'donor_name' => 'Faulty Donor',
            'donor_phone' => '9876543213',
            'amount' => 2000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'REJECTME123',
            'status' => 'pending',
        ]);

        $response = $this->post(route('admin.donations.reject', $donation), [
            'admin_remarks' => 'UTR number does not exist on bank statement.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $donation->refresh();
        $this->assertEquals('rejected', $donation->status);
        $this->assertEquals('UTR number does not exist on bank statement.', $donation->admin_remarks);
    }

    public function test_admin_can_record_direct_cash_donation(): void
    {
        $payload = [
            'donor_name' => 'Cash Benefactor',
            'donor_email' => 'cash@example.com',
            'donor_phone' => '9876543214',
            'donor_pan' => 'ABCDE9999F',
            'amount' => 10000.00,
            'payment_mode' => 'cash',
            'campaign_id' => $this->campaign->id,
            'admin_remarks' => 'Handed over cash in charity office.',
        ];

        $response = $this->post(route('admin.donations.store'), $payload);

        $response->assertRedirect(route('admin.donations.index', ['status' => 'verified']));
        $response->assertSessionHas('success');

        $donation = Donation::where('donor_name', 'Cash Benefactor')->first();
        $this->assertNotNull($donation);
        $this->assertEquals('verified', $donation->status);
        $this->assertEquals(10000.00, (float) $donation->amount);
        $this->assertNotNull($donation->receipt_number);
        $this->assertStringStartsWith('KSF-2026-', $donation->receipt_number);

        // Campaign raised_amount must increment by 10,000.00
        $this->assertEquals(10000.00, (float) $this->campaign->fresh()->raised_amount);
    }
}
