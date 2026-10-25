<?php

namespace Tests\Feature;

use App\Models\Donation;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);
    }

    public function test_donation_status_page_renders_successfully(): void
    {
        $response = $this->get('/donation-status');

        $response->assertStatus(200);
        $response->assertSee('Check Donation Status');
        $response->assertSee('Your Support Creates Real Change');
    }

    public function test_lookup_by_utr_number_displays_pending_donation(): void
    {
        Donation::create([
            'donor_name' => 'Aarav Sharma',
            'donor_email' => 'aarav@example.com',
            'donor_phone' => '9876543210',
            'amount' => 2000,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR987654321012',
            'payment_screenshot' => 'donations/dummy.png',
            'status' => 'pending',
        ]);

        $response = $this->get('/donation-status?query=UTR987654321012');

        $response->assertStatus(200);
        $response->assertSee('Verification in Progress');
        $response->assertSee('UTR987654321012');
        $response->assertSee('Aarav Sharma');
        $response->assertSee('2,000.00');
    }

    public function test_lookup_by_phone_displays_matching_donations(): void
    {
        Donation::create([
            'donor_name' => 'Priya Verma',
            'donor_email' => 'priya@example.com',
            'donor_phone' => '+919876500000',
            'amount' => 5000,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'BANKREF11223344',
            'payment_screenshot' => 'donations/dummy.png',
            'status' => 'pending',
        ]);

        $response = $this->get('/donation-status?query=+919876500000');

        $response->assertStatus(200);
        $response->assertSee('Priya Verma');
        $response->assertSee('BANKREF11223344');
        $response->assertSee('5,000.00');
    }

    public function test_verified_donation_displays_verified_badge_and_receipt_section(): void
    {
        Donation::create([
            'donor_name' => 'Mohd. Ayaan Khan',
            'donor_email' => 'ayaan@example.com',
            'donor_phone' => '9876541122',
            'amount' => 2000,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR432198765432',
            'receipt_number' => 'KSF-2026-0001',
            'payment_screenshot' => 'donations/dummy.png',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $response = $this->get('/donation-status?query=UTR432198765432');

        $response->assertStatus(200);
        $response->assertSee('Donation Verified');
        $response->assertSee('Receipt Available');
        $response->assertSee('KSF-2026-0001');
        $response->assertSee('Mohd. Ayaan Khan');
        $response->assertSee('Download Receipt (PDF)');
    }

    public function test_rejected_donation_displays_rejection_remarks(): void
    {
        Donation::create([
            'donor_name' => 'Test Rejected',
            'donor_email' => 'rejected@example.com',
            'donor_phone' => '9876549999',
            'amount' => 100,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'REJECTEDUTR123',
            'payment_screenshot' => 'donations/dummy.png',
            'status' => 'rejected',
            'admin_remarks' => 'Bank statement shows payment failed / reversed by beneficiary bank.',
        ]);

        $response = $this->get('/donation-status?query=REJECTEDUTR123');

        $response->assertStatus(200);
        $response->assertSee('Verification Unsuccessful');
        $response->assertSee('Bank statement shows payment failed / reversed by beneficiary bank.');
    }

    public function test_unknown_query_displays_not_found_message(): void
    {
        $response = $this->get('/donation-status?query=NONEXISTENT_UTR_999');

        $response->assertStatus(200);
        $response->assertSee('No Donations Found');
        $response->assertSee('NONEXISTENT_UTR_999');
    }
}
