<?php

namespace Tests\Feature;

use App\Models\Donation;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DonationSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);
    }

    protected function createFakeImage(string $name = 'proof.png', int $sizeKb = 100): UploadedFile
    {
        $pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $content = base64_decode($pngBase64);

        if ($sizeKb > 1) {
            $content .= str_repeat('0', ($sizeKb * 1024) - strlen($content));
        }

        return UploadedFile::fake()->createWithContent($name, $content);
    }

    public function test_donation_page_renders_active_payment_methods_and_presets(): void
    {
        $response = $this->get('/donate');

        $response->assertStatus(200);
        $response->assertSee('Make a Donation');
        $response->assertSee('kashiseva@upi');
        $response->assertSee('State Bank of India');
        $response->assertSee('41238901234');
        $response->assertSee('SBIN0001234');
        $response->assertSee('1,000');
    }

    public function test_donor_can_submit_valid_manual_donation_with_screenshot(): void
    {
        Storage::fake('public');

        $payload = [
            'donor_name' => 'Ramesh Kumar',
            'donor_email' => 'ramesh@example.com',
            'donor_phone' => '+91 9876543210',
            'donor_pan' => 'ABCDE1234F',
            'amount' => 1500,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR432198765432',
            'donor_message' => 'Keep up the noble work!',
            'is_anonymous' => 0,
            'payment_screenshot' => $this->createFakeImage('proof.png', 50),
        ];

        $response = $this->post('/donate', $payload);

        $response->assertRedirect('/donate');
        $response->assertSessionHas('success');
        $response->assertSessionHas('submitted_utr', 'UTR432198765432');

        $this->assertDatabaseHas('donations', [
            'donor_name' => 'Ramesh Kumar',
            'donor_email' => 'ramesh@example.com',
            'utr_number' => 'UTR432198765432',
            'amount' => 1500.00,
            'status' => 'pending',
            'is_anonymous' => false,
        ]);

        $donation = Donation::where('utr_number', 'UTR432198765432')->first();
        $this->assertNotNull($donation->payment_screenshot);
        Storage::disk('public')->assertExists($donation->payment_screenshot);
    }

    public function test_duplicate_utr_is_rejected_with_validation_error(): void
    {
        Storage::fake('public');

        // Create first donation
        Donation::create([
            'donor_name' => 'First Donor',
            'donor_email' => 'first@example.com',
            'donor_phone' => '9876543210',
            'amount' => 500,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'DUPLICATE123456',
            'payment_screenshot' => 'donations/dummy.png',
            'status' => 'pending',
        ]);

        $payload = [
            'donor_name' => 'Second Donor',
            'donor_email' => 'second@example.com',
            'donor_phone' => '9876543211',
            'amount' => 1000,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'DUPLICATE123456',
            'payment_screenshot' => $this->createFakeImage('proof.png', 50),
        ];

        $response = $this->from('/donate')->post('/donate', $payload);

        $response->assertRedirect('/donate');
        $response->assertSessionHasErrors('utr_number');
        $this->assertEquals(1, Donation::where('utr_number', 'DUPLICATE123456')->count());
    }

    public function test_screenshot_file_validation_enforces_max_size_and_mimes(): void
    {
        Storage::fake('public');

        // 1. Test oversized file (> 2MB, e.g. 3000KB)
        $oversizedPayload = [
            'donor_name' => 'Ramesh Kumar',
            'donor_email' => 'ramesh@example.com',
            'donor_phone' => '+91 9876543210',
            'amount' => 500,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'OVERSIZED123456',
            'payment_screenshot' => $this->createFakeImage('huge.png', 3000), // 3MB
        ];

        $response = $this->post('/donate', $oversizedPayload);
        $response->assertSessionHasErrors('payment_screenshot');

        // 2. Test invalid mime type (e.g. text/plain or pdf)
        $invalidMimePayload = [
            'donor_name' => 'Ramesh Kumar',
            'donor_email' => 'ramesh@example.com',
            'donor_phone' => '+91 9876543210',
            'amount' => 500,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'INVALIDMIME123',
            'payment_screenshot' => UploadedFile::fake()->create('document.pdf', 500, 'application/pdf'),
        ];

        $response = $this->post('/donate', $invalidMimePayload);
        $response->assertSessionHasErrors('payment_screenshot');
    }

    public function test_rate_limiting_throttles_excessive_submissions(): void
    {
        Storage::fake('public');

        for ($i = 1; $i <= 5; $i++) {
            $payload = [
                'donor_name' => "Donor {$i}",
                'donor_email' => "donor{$i}@example.com",
                'donor_phone' => "987654321{$i}",
                'amount' => 500,
                'payment_mode' => 'upi_qr',
                'utr_number' => "THROTTLE_UTR_{$i}",
                'payment_screenshot' => $this->createFakeImage("proof_{$i}.png", 20),
            ];

            $response = $this->post('/donate', $payload);
            $this->assertNotEquals(429, $response->getStatusCode());
        }

        // 6th attempt should be throttled (throttle:5,1)
        $excessPayload = [
            'donor_name' => 'Donor 6',
            'donor_email' => 'donor6@example.com',
            'donor_phone' => '9876543216',
            'amount' => 500,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'THROTTLE_UTR_6',
            'payment_screenshot' => $this->createFakeImage('proof_6.png', 20),
        ];

        $response = $this->post('/donate', $excessPayload);
        $response->assertStatus(429);
    }
}
