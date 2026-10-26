<?php

namespace Tests\Feature;

use App\Filament\Resources\ContactInquiries\Pages\ListContactInquiries;
use App\Models\ContactInquiry;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentContactInquiryResourceTest extends TestCase
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

    public function test_unauthenticated_user_cannot_access_contact_inquiries(): void
    {
        $response = $this->get('/admin/contact-inquiries');
        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_view_contact_inquiries_table(): void
    {
        $inquiry = ContactInquiry::create([
            'name' => 'Kavita Singh',
            'email' => 'kavita@example.com',
            'phone' => '9123456789',
            'subject' => 'Donation Receipt Verification Issue',
            'message' => 'I submitted donation yesterday and wanted to confirm my receipt status.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/contact-inquiries');
        $response->assertOk();

        Livewire::actingAs($this->admin)
            ->test(ListContactInquiries::class)
            ->assertCanSeeTableRecords([$inquiry])
            ->assertSee('Kavita Singh')
            ->assertSee('Donation Receipt Verification Issue');
    }

    public function test_admin_can_mark_inquiry_as_read_via_table_action(): void
    {
        $inquiry = ContactInquiry::create([
            'name' => 'Rahul Verma',
            'email' => 'rahul@example.com',
            'phone' => '9888877777',
            'subject' => 'Volunteering in Varanasi',
            'message' => 'I would like to participate in next week relief drive.',
            'status' => 'pending',
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListContactInquiries::class)
            ->callTableAction('mark_read', $inquiry)
            ->assertHasNoTableActionErrors();

        $this->assertEquals('read', $inquiry->fresh()->status);
    }

    public function test_admin_can_mark_inquiry_as_replied_via_table_action(): void
    {
        $inquiry = ContactInquiry::create([
            'name' => 'Sneha Patel',
            'email' => 'sneha@example.com',
            'phone' => '9877766655',
            'subject' => 'CSR Partnership Discussion',
            'message' => 'Proposal for company grant.',
            'status' => 'read',
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListContactInquiries::class)
            ->callTableAction('mark_replied', $inquiry)
            ->assertHasNoTableActionErrors();

        $this->assertEquals('replied', $inquiry->fresh()->status);
    }

    public function test_admin_can_delete_inquiry_via_table_action(): void
    {
        $inquiry = ContactInquiry::create([
            'name' => 'Spam Sender',
            'email' => 'spam@example.com',
            'phone' => '9000000000',
            'subject' => 'Loan Offer',
            'message' => 'Unsolicited advertisement.',
            'status' => 'pending',
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListContactInquiries::class)
            ->callTableAction('delete', $inquiry)
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseMissing('contact_inquiries', [
            'id' => $inquiry->id,
        ]);
    }
}
