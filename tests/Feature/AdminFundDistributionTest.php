<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\FundDistribution;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminFundDistributionTest extends TestCase
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

    public function test_admin_can_view_distributions_queue_and_metrics(): void
    {
        FundDistribution::create([
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

        $response = $this->get(route('admin.distributions.index'));

        $response->assertStatus(200);
        $response->assertSee('Fund Distribution Ledger');
        $response->assertSee('Purchase of 100 Thermal Blankets');
        $response->assertSee('12,500.00');
        $response->assertSee('Assi Ghat Night Shelter');
    }

    public function test_admin_can_record_fund_distribution_with_bill_and_impact_photos(): void
    {
        Storage::fake('public');

        $bill = $this->createFakeImage('vendor_bill.png');
        $photo1 = $this->createFakeImage('impact_1.png');
        $photo2 = $this->createFakeImage('impact_2.png');

        $payload = [
            'title' => 'Dry Ration Kits Distribution',
            'beneficiary_name' => '150 Daily Wage Worker Families',
            'amount_spent' => 18000.00,
            'distribution_date' => now()->format('Y-m-d'),
            'campaign_id' => $this->campaign->id,
            'payment_reference' => 'NEFT-88392019',
            'proof_bill_image' => $bill,
            'impact_photos' => [$photo1, $photo2],
            'description' => 'Distributed 5kg rice, 2kg dal, oil and spices to 150 families.',
            'is_public' => '1',
        ];

        $response = $this->post(route('admin.distributions.store'), $payload);

        $response->assertRedirect(route('admin.distributions.index'));
        $response->assertSessionHas('success');

        $distribution = FundDistribution::where('title', 'Dry Ration Kits Distribution')->first();
        $this->assertNotNull($distribution);
        $this->assertEquals(18000.00, (float) $distribution->amount_spent);
        $this->assertTrue($distribution->is_public);
        $this->assertNotNull($distribution->proof_bill_image);
        $this->assertCount(2, $distribution->impact_photos);

        // Check storage
        Storage::disk('public')->assertExists($distribution->proof_bill_image);
        Storage::disk('public')->assertExists($distribution->impact_photos[0]);
    }

    public function test_distribution_atomically_increments_campaign_distributed_amount(): void
    {
        Storage::fake('public');

        $this->assertEquals(0.00, (float) $this->campaign->distributed_amount);

        $payload = [
            'title' => 'Emergency Medical Procurement',
            'beneficiary_name' => 'District Children Ward',
            'amount_spent' => 15000.00,
            'distribution_date' => now()->format('Y-m-d'),
            'campaign_id' => $this->campaign->id,
            'description' => 'Medicines and surgical supplies procured for pediatric care.',
            'is_public' => '1',
        ];

        $response = $this->post(route('admin.distributions.store'), $payload);

        $response->assertRedirect(route('admin.distributions.index'));

        $this->campaign->refresh();
        $this->assertEquals(15000.00, (float) $this->campaign->distributed_amount);
    }

    public function test_validation_enforces_required_fields_and_positive_amounts(): void
    {
        $response = $this->post(route('admin.distributions.store'), []);

        $response->assertSessionHasErrors([
            'title',
            'beneficiary_name',
            'amount_spent',
            'distribution_date',
            'description',
        ]);

        $invalidResponse = $this->post(route('admin.distributions.store'), [
            'amount_spent' => -500,
            'distribution_date' => now()->addDays(5)->format('Y-m-d'),
        ]);

        $invalidResponse->assertSessionHasErrors([
            'amount_spent',
            'distribution_date',
        ]);
    }
}
