<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\Donation;
use App\Services\ReceiptPdfService;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationReceiptPdfTest extends TestCase
{
    use RefreshDatabase;

    protected Campaign $campaign;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $category = CauseCategory::first();
        $this->campaign = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Emergency Medical Fund',
            'slug' => 'emergency-medical-fund',
            'short_description' => 'Providing critical medical care',
            'full_story' => 'Detailed story of ground relief...',
            'thumbnail_image' => 'campaigns/medical.jpg',
            'start_date' => now(),
            'goal_amount' => 100000.00,
            'raised_amount' => 0.00,
            'status' => 'active',
        ]);
    }

    public function test_verified_donation_produces_downloadable_pdf_receipt(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Aarav Patel',
            'donor_email' => 'aarav@example.com',
            'donor_phone' => '9876543210',
            'donor_pan' => 'ABCDE1234F',
            'amount' => 5000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'RECEIPTTEST001',
            'receipt_number' => 'KSF-2026-0001',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $response = $this->get("/donations/{$donation->id}/receipt");

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('Receipt-KSF-2026-0001.pdf', $response->headers->get('content-disposition'));

        // Check PDF magic byte header
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_verified_donation_produces_streamable_preview_pdf(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Aarav Patel',
            'donor_email' => 'aarav@example.com',
            'donor_phone' => '9876543210',
            'amount' => 2500.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'RECEIPTTEST002',
            'receipt_number' => 'KSF-2026-0002',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $response = $this->get("/donations/{$donation->id}/receipt/preview");

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    public function test_pending_donation_cannot_generate_receipt(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Pending Donor',
            'donor_phone' => '9876543211',
            'amount' => 1000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'PENDINGRECEIPT1',
            'status' => 'pending',
        ]);

        $response = $this->get("/donations/{$donation->id}/receipt");

        $response->assertStatus(404);
    }

    public function test_rejected_donation_cannot_generate_receipt(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Rejected Donor',
            'donor_phone' => '9876543212',
            'amount' => 1000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'REJECTEDRECEIPT1',
            'status' => 'rejected',
            'admin_remarks' => 'Fake transaction ID',
        ]);

        $response = $this->get("/donations/{$donation->id}/receipt");

        $response->assertStatus(404);
    }

    public function test_receipt_view_contains_ngo_legal_credentials_and_80g_details(): void
    {
        $donation = Donation::create([
            'campaign_id' => $this->campaign->id,
            'donor_name' => 'Meera Sharma',
            'donor_email' => 'meera@example.com',
            'donor_phone' => '9876543215',
            'donor_pan' => 'XYZPK9876Q',
            'amount' => 15000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'MEERA80G123',
            'receipt_number' => 'KSF-2026-0005',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $pdfService = new ReceiptPdfService;
        $words = $pdfService->amountToWords((float) $donation->amount);
        $this->assertEquals('Rupees Fifteen Thousand Only', $words);

        $viewHtml = view('receipts.80g', [
            'donation' => $donation,
            'amountInWords' => $words,
            'ngoName' => setting('ngo_name'),
            'ngoTagline' => setting('ngo_tagline'),
            'ngoRegNumber' => setting('ngo_reg_number'),
            'ngoPanNumber' => setting('ngo_pan_number'),
            'has80g' => (bool) setting('has_80g'),
            'reg80gNumber' => setting('80g_reg_number'),
            'authorizedSignName' => setting('authorized_sign_name'),
            'authorizedSignImage' => setting('authorized_sign_image'),
            'contactAddress' => setting('contact_address'),
            'contactPhone' => setting('contact_phone'),
            'contactEmail' => setting('contact_email'),
        ])->render();

        $this->assertStringContainsString('Kashi Seva Foundation', $viewHtml);
        $this->assertStringContainsString('AABTK1234F', $viewHtml);
        $this->assertStringContainsString('AABTK1234FF20241', $viewHtml);
        $this->assertStringContainsString('Meera Sharma', $viewHtml);
        $this->assertStringContainsString('XYZPK9876Q', $viewHtml);
        $this->assertStringContainsString('MEERA80G123', $viewHtml);
        $this->assertStringContainsString('KSF-2026-0005', $viewHtml);
        $this->assertStringContainsString('Rupees Fifteen Thousand Only', $viewHtml);
    }
}
