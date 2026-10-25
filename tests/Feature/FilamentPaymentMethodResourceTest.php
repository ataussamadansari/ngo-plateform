<?php

namespace Tests\Feature;

use App\Filament\Resources\PaymentMethods\Pages\CreatePaymentMethod;
use App\Filament\Resources\PaymentMethods\Pages\EditPaymentMethod;
use App\Filament\Resources\PaymentMethods\Pages\ListPaymentMethods;
use App\Models\PaymentMethod;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentPaymentMethodResourceTest extends TestCase
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

    public function test_unauthenticated_user_cannot_access_payment_methods(): void
    {
        $response = $this->get('/admin/payment-methods');
        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_view_payment_methods_table(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/payment-methods');
        $response->assertOk();
        $response->assertSee('Payment Methods');
        $response->assertSee('UPI Payment');
        $response->assertSee('State Bank of India');
    }

    public function test_payment_methods_table_renders_existing_records(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(ListPaymentMethods::class)
            ->assertCanSeeTableRecords(PaymentMethod::all());
    }

    public function test_admin_can_create_upi_qr_payment_method(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreatePaymentMethod::class)
            ->fillForm([
                'type' => 'upi_qr',
                'label' => 'Secondary HDFC UPI QR',
                'upi_id' => 'kashiseva@hdfc',
                'is_active' => true,
                'display_order' => 5,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('payment_methods', [
            'type' => 'upi_qr',
            'label' => 'Secondary HDFC UPI QR',
            'upi_id' => 'kashiseva@hdfc',
            'is_active' => true,
            'display_order' => 5,
        ]);
    }

    public function test_admin_can_create_bank_account_payment_method(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreatePaymentMethod::class)
            ->fillForm([
                'type' => 'bank_account',
                'label' => 'ICICI Bank Current Account',
                'bank_name' => 'ICICI Bank',
                'account_holder_name' => 'Kashi Seva Foundation ICICI',
                'account_number' => '998877665544',
                'ifsc_code' => 'ICIC0001234',
                'branch_name' => 'Sigra Varanasi',
                'is_active' => true,
                'display_order' => 10,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('payment_methods', [
            'type' => 'bank_account',
            'label' => 'ICICI Bank Current Account',
            'bank_name' => 'ICICI Bank',
            'account_number' => '998877665544',
            'ifsc_code' => 'ICIC0001234',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_edit_existing_payment_method(): void
    {
        $this->actingAs($this->admin);

        $record = PaymentMethod::where('type', 'upi_qr')->first();

        Livewire::test(EditPaymentMethod::class, ['record' => $record->id])
            ->fillForm([
                'label' => 'Updated Kashi UPI VPA',
                'upi_id' => 'updatedkashi@upi',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('payment_methods', [
            'id' => $record->id,
            'label' => 'Updated Kashi UPI VPA',
            'upi_id' => 'updatedkashi@upi',
        ]);
    }

    public function test_public_donate_page_reflects_active_payment_methods(): void
    {
        // 1. Create a newly active payment method with highest priority
        PaymentMethod::create([
            'type' => 'bank_account',
            'label' => 'Punjab National Bank Trust Account',
            'bank_name' => 'Punjab National Bank',
            'account_holder_name' => 'Kashi Seva Foundation PNB',
            'account_number' => '11223344556677',
            'ifsc_code' => 'PUNB0123456',
            'branch_name' => 'Varanasi Cantt',
            'is_active' => true,
            'display_order' => 0,
        ]);

        $response = $this->get('/donate');
        $response->assertOk();
        $response->assertSee('Punjab National Bank');
        $response->assertSee('11223344556677');
        $response->assertSee('PUNB0123456');
    }

    public function test_deactivating_payment_method_hides_it_from_public_donate_page(): void
    {
        $bankMethod = PaymentMethod::where('type', 'bank_account')->first();
        $this->assertNotNull($bankMethod);

        // Before deactivation, verify it's shown
        $response = $this->get('/donate');
        $response->assertSee($bankMethod->bank_name);
        $response->assertSee($bankMethod->account_number);

        // Deactivate via update
        $bankMethod->update(['is_active' => false]);

        // After deactivation, it should not appear on /donate
        $response = $this->get('/donate');
        $response->assertDontSee($bankMethod->account_number);
    }
}
