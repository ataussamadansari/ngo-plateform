<?php

namespace Tests\Feature;

use App\Models\ContactInquiry;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutAndContactInquiryTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->admin = User::where('role', 'super_admin')->first();
    }

    public function test_public_can_view_about_us_page_with_accreditations(): void
    {
        $response = $this->get(route('about'));

        $response->assertOk();
        $response->assertSee('Our Mission');
        $response->assertSee('Our Vision');
        $response->assertSee('The Grassroots Story');
        $response->assertSee('Legal Accreditations & Registrations', false);
        $response->assertSee(setting('80g_reg_number'));
        $response->assertSee(setting('ngo_reg_number'));
        $response->assertSee(setting('ngo_pan_number'));
    }

    public function test_public_can_view_contact_page(): void
    {
        $response = $this->get(route('contact.index'));

        $response->assertOk();
        $response->assertSee('We Are Here to Help & Connect', false);
        $response->assertSee(setting('contact_address'));
        $response->assertSee(setting('contact_phone'));
        $response->assertSee(setting('contact_email'));
        $response->assertSee('Send Us an Inquiry');
    }

    public function test_public_can_submit_contact_inquiry(): void
    {
        $payload = [
            'name' => 'Vikas Malhotra',
            'email' => 'vikas@example.com',
            'phone' => '9876543210',
            'subject' => 'Corporate CSR Partnership Opportunity',
            'message' => 'Our company would like to fund 50 water filtration units in Varanasi under CSR.',
        ];

        $response = $this->post(route('contact.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Vikas Malhotra',
            'email' => 'vikas@example.com',
            'phone' => '9876543210',
            'subject' => 'Corporate CSR Partnership Opportunity',
            'status' => 'pending',
        ]);
    }

    public function test_contact_inquiry_validation_enforces_required_fields(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => '',
            'email' => 'invalid-email',
            'subject' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        $this->assertEquals(0, ContactInquiry::count());
    }

    public function test_contact_inquiry_is_rate_limited(): void
    {
        $payload = [
            'name' => 'Spam Bot',
            'email' => 'spambot@example.com',
            'subject' => 'Quick Loan',
            'message' => 'Spam message test',
        ];

        // 5 allowed requests per minute (throttle:5,1)
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('contact.store'), $payload);
        }

        // 6th request should be throttled
        $response = $this->post(route('contact.store'), $payload);
        $response->assertStatus(429);
    }

    public function test_admin_can_view_and_update_inquiry_status(): void
    {
        $inquiry = ContactInquiry::create([
            'name' => 'Kavita Singh',
            'email' => 'kavita@example.com',
            'phone' => '9123456789',
            'subject' => 'Donation Receipt Verification Issue',
            'message' => 'I submitted donation yesterday and wanted to confirm my receipt status.',
            'status' => 'pending',
        ]);

        // Admin views inquiries
        $response = $this->actingAs($this->admin)->get(route('admin.inquiries.index'));
        $response->assertOk();
        $response->assertSee('Kavita Singh');
        $response->assertSee('Donation Receipt Verification Issue');

        // Admin marks as replied
        $patchResponse = $this->actingAs($this->admin)->patch(
            route('admin.inquiries.update', $inquiry->id),
            ['status' => 'replied']
        );

        $patchResponse->assertRedirect();
        $patchResponse->assertSessionHas('success');

        $this->assertDatabaseHas('contact_inquiries', [
            'id' => $inquiry->id,
            'status' => 'replied',
        ]);
    }
}
