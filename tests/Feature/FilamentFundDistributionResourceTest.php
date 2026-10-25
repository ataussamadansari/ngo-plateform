<?php

namespace Tests\Feature;

use App\Filament\Resources\FundDistributions\Pages\CreateFundDistribution;
use App\Filament\Resources\FundDistributions\Pages\EditFundDistribution;
use App\Filament\Resources\FundDistributions\Pages\ListFundDistributions;
use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\FundDistribution;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentFundDistributionResourceTest extends TestCase
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
            'title' => 'Winter Relief Drive',
            'slug' => 'winter-relief-drive',
            'short_description' => 'Winter blankets and relief',
            'full_story' => 'Distributing warm clothes to homeless individuals...',
            'thumbnail_image' => 'campaigns/winter.jpg',
            'start_date' => now(),
            'goal_amount' => 50000.00,
            'raised_amount' => 25000.00,
            'distributed_amount' => 0.00,
            'status' => 'active',
        ]);
    }

    protected function createFakeImage(string $name = 'bill.png', int $sizeKb = 50): UploadedFile
    {
        $pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $content = base64_decode($pngBase64);

        if ($sizeKb > 1) {
            $content .= str_repeat('0', ($sizeKb * 1024) - strlen($content));
        }

        return UploadedFile::fake()->createWithContent($name, $content);
    }

    public function test_unauthenticated_user_cannot_access_fund_distributions(): void
    {
        $response = $this->get('/admin/fund-distributions');
        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_view_fund_distributions_list(): void
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/fund-distributions');
        $response->assertSuccessful();
    }

    public function test_table_renders_existing_fund_distributions(): void
    {
        $distribution = FundDistribution::create([
            'title' => 'Purchase of 100 Thermal Blankets',
            'beneficiary_name' => 'Assi Ghat Night Shelter',
            'amount_spent' => 12500.00,
            'distribution_date' => now()->subDay(),
            'payment_reference' => 'CHQ-100234',
            'description' => 'Purchased directly from local handloom cooperative.',
            'is_public' => true,
            'campaign_id' => $this->campaign->id,
            'created_by' => $this->admin->id,
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListFundDistributions::class)
            ->assertCanSeeTableRecords([$distribution]);
    }

    public function test_admin_can_create_distribution_with_proofs_and_atomically_sync_campaign(): void
    {
        Storage::fake('public');

        $bill = $this->createFakeImage('invoice_bill.png');
        $photo = $this->createFakeImage('field_photo.png');

        $this->assertEquals(0.00, (float) $this->campaign->distributed_amount);

        Livewire::actingAs($this->admin)
            ->test(CreateFundDistribution::class)
            ->fillForm([
                'title' => 'Dry Ration Kits Distribution',
                'beneficiary_name' => '150 Daily Wage Worker Families',
                'amount_spent' => 18000.00,
                'distribution_date' => now()->format('Y-m-d'),
                'campaign_id' => $this->campaign->id,
                'payment_reference' => 'NEFT-88392019',
                'description' => 'Distributed 5kg rice, 2kg dal, oil and spices to 150 families.',
                'is_public' => true,
                'proof_bill_image' => $bill,
                'impact_photos' => [$photo],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $distribution = FundDistribution::where('title', 'Dry Ration Kits Distribution')->first();
        $this->assertNotNull($distribution);
        $this->assertEquals(18000.00, (float) $distribution->amount_spent);
        $this->assertTrue($distribution->is_public);
        $this->assertNotNull($distribution->proof_bill_image);
        $this->assertNotEmpty($distribution->impact_photos);

        // Check file storage
        Storage::disk('public')->assertExists($distribution->proof_bill_image);
        Storage::disk('public')->assertExists($distribution->impact_photos[0]);

        // Campaign distributed_amount must have incremented by 18,000.00
        $this->assertEquals(18000.00, (float) $this->campaign->fresh()->distributed_amount);

        // Public transparency page must reflect this distribution
        $transparencyResponse = $this->get('/transparency');
        $transparencyResponse->assertStatus(200);
        $transparencyResponse->assertSee('Dry Ration Kits Distribution');
        $transparencyResponse->assertSee('18,000.00');
    }

    public function test_private_distribution_is_hidden_from_public_transparency(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateFundDistribution::class)
            ->fillForm([
                'title' => 'Internal Security Equipment',
                'beneficiary_name' => 'Tech Security Vendor',
                'amount_spent' => 4500.00,
                'distribution_date' => now()->format('Y-m-d'),
                'description' => 'Office security cameras and hardware.',
                'is_public' => false,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $transparencyResponse = $this->get('/transparency');
        $transparencyResponse->assertStatus(200);
        $transparencyResponse->assertDontSee('Internal Security Equipment');
    }

    public function test_editing_distribution_amount_updates_campaign_balance(): void
    {
        $distribution = FundDistribution::create([
            'title' => 'Initial Supply',
            'beneficiary_name' => 'Local Vendor',
            'amount_spent' => 5000.00,
            'distribution_date' => now()->format('Y-m-d'),
            'description' => 'Supplies purchase.',
            'is_public' => true,
            'campaign_id' => $this->campaign->id,
            'created_by' => $this->admin->id,
        ]);
        $this->campaign->update(['distributed_amount' => 5000.00]);

        Livewire::actingAs($this->admin)
            ->test(EditFundDistribution::class, ['record' => $distribution->id])
            ->fillForm([
                'amount_spent' => 7500.00,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEquals(7500.00, (float) $this->campaign->fresh()->distributed_amount);
    }
}
