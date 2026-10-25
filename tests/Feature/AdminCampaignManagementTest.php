<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCampaignManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected CauseCategory $category;

    protected Campaign $campaign;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->admin = User::where('role', 'super_admin')->first();
        $this->category = CauseCategory::first();

        $this->campaign = Campaign::create([
            'category_id' => $this->category->id,
            'title' => 'Emergency Oxygen Supply',
            'slug' => 'emergency-oxygen-supply',
            'short_description' => 'Providing oxygen cylinders to clinics',
            'full_story' => 'Full story of ground oxygen distribution...',
            'thumbnail_image' => 'campaigns/oxygen.jpg',
            'start_date' => now(),
            'goal_amount' => 150000.00,
            'raised_amount' => 50000.00,
            'distributed_amount' => 20000.00,
            'status' => 'active',
        ]);

        $this->actingAs($this->admin);
    }

    protected function createFakeImage(string $name = 'thumb.png', int $sizeKb = 50): UploadedFile
    {
        $pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $content = base64_decode($pngBase64);

        if ($sizeKb > 1) {
            $content .= str_repeat('0', ($sizeKb * 1024) - strlen($content));
        }

        return UploadedFile::fake()->createWithContent($name, $content);
    }

    public function test_admin_can_manage_cause_categories(): void
    {
        // 1. Create Category
        $response = $this->post('/admin/categories', [
            'name' => 'Animal Welfare',
            'slug' => 'animal-welfare',
            'icon' => 'heart',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('cause_categories', ['name' => 'Animal Welfare']);

        $category = CauseCategory::where('slug', 'animal-welfare')->first();

        // 2. Update Category
        $updateResponse = $this->put("/admin/categories/{$category->id}", [
            'name' => 'Wildlife & Animal Welfare',
            'slug' => 'animal-welfare',
            'is_active' => '1',
        ]);

        $updateResponse->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('cause_categories', ['name' => 'Wildlife & Animal Welfare']);

        // 3. Delete Category (empty)
        $deleteResponse = $this->delete("/admin/categories/{$category->id}");
        $deleteResponse->assertRedirect('/admin/categories');
        $this->assertDatabaseMissing('cause_categories', ['id' => $category->id]);

        // 4. Deleting Category with linked campaigns is blocked
        $blockedDelete = $this->delete("/admin/categories/{$this->category->id}");
        $blockedDelete->assertRedirect('/admin/categories');
        $blockedDelete->assertSessionHas('error');
        $this->assertDatabaseHas('cause_categories', ['id' => $this->category->id]);
    }

    public function test_admin_can_view_campaigns_list_and_metrics(): void
    {
        $response = $this->get('/admin/campaigns');

        $response->assertStatus(200);
        $response->assertSee('Campaigns Management');
        $response->assertSee('Emergency Oxygen Supply');
        $response->assertSee('150,000.00');
    }

    public function test_admin_can_create_campaign_with_thumbnail_and_gallery(): void
    {
        Storage::fake('public');

        $thumb = $this->createFakeImage('cover.png');
        $gallery1 = $this->createFakeImage('g1.png');
        $gallery2 = $this->createFakeImage('g2.png');

        $payload = [
            'title' => 'Mobile Health Clinic Van',
            'category_id' => $this->category->id,
            'goal_amount' => 500000.00,
            'short_description' => 'A fully equipped van for rural clinics.',
            'full_story' => 'Detailed narrative about rural primary healthcare vans...',
            'thumbnail_image' => $thumb,
            'gallery_images' => [$gallery1, $gallery2],
            'start_date' => now()->format('Y-m-d'),
            'is_urgent' => '1',
            'is_featured' => '1',
            'status' => 'active',
        ];

        $response = $this->post('/admin/campaigns', $payload);

        $response->assertRedirect('/admin/campaigns');
        $response->assertSessionHas('success');

        $campaign = Campaign::where('title', 'Mobile Health Clinic Van')->first();
        $this->assertNotNull($campaign);
        $this->assertEquals('mobile-health-clinic-van', $campaign->slug);
        $this->assertTrue($campaign->is_urgent);
        $this->assertTrue($campaign->is_featured);
        $this->assertCount(2, $campaign->gallery_images);

        Storage::disk('public')->assertExists($campaign->thumbnail_image);
        Storage::disk('public')->assertExists($campaign->gallery_images[0]);
    }

    public function test_admin_can_update_campaign_and_toggle_status(): void
    {
        $payload = [
            'title' => 'Emergency Oxygen Supply - Phase 2',
            'category_id' => $this->category->id,
            'goal_amount' => 200000.00,
            'short_description' => 'Updated short description.',
            'full_story' => 'Updated long narrative story.',
            'start_date' => now()->format('Y-m-d'),
            'status' => 'active',
        ];

        $response = $this->put("/admin/campaigns/{$this->campaign->id}", $payload);

        $response->assertRedirect('/admin/campaigns');
        $this->assertEquals('Emergency Oxygen Supply - Phase 2', $this->campaign->fresh()->title);

        // Toggle Status
        $toggleResponse = $this->patch("/admin/campaigns/{$this->campaign->id}/status", [
            'status' => 'completed',
        ]);

        $toggleResponse->assertRedirect();
        $this->assertEquals('completed', $this->campaign->fresh()->status);
    }
}
