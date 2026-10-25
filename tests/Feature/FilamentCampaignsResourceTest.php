<?php

namespace Tests\Feature;

use App\Filament\Resources\Campaigns\Pages\CreateCampaign;
use App\Filament\Resources\Campaigns\Pages\EditCampaign;
use App\Filament\Resources\CauseCategories\Pages\CreateCauseCategory;
use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\User;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentCampaignsResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected CauseCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);

        $this->admin = User::where('role', 'super_admin')->first();
        $this->category = CauseCategory::first();
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

    public function test_unauthenticated_user_cannot_access_campaigns_or_categories(): void
    {
        $response1 = $this->get('/admin/campaigns');
        $response1->assertRedirect('/admin/login');

        $response2 = $this->get('/admin/cause-categories');
        $response2->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_view_campaigns_and_categories_tables(): void
    {
        $this->actingAs($this->admin);

        $response1 = $this->get('/admin/campaigns');
        $response1->assertOk();
        $response1->assertSee('Causes & Campaigns');

        $response2 = $this->get('/admin/cause-categories');
        $response2->assertOk();
        $response2->assertSee('Cause Categories');
    }

    public function test_admin_can_create_category_via_filament(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateCauseCategory::class)
            ->fillForm([
                'name' => 'Disaster Relief Fund',
                'slug' => 'disaster-relief-fund',
                'icon' => 'heroicon-o-shield-exclamation',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('cause_categories', [
            'name' => 'Disaster Relief Fund',
            'slug' => 'disaster-relief-fund',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_create_campaign_via_filament(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin);

        $fakeThumb = $this->createFakeImage('thumb.png');

        Livewire::test(CreateCampaign::class)
            ->fillForm([
                'title' => 'Clean Drinking Water Plant',
                'slug' => 'clean-drinking-water-plant',
                'category_id' => $this->category->id,
                'goal_amount' => 250000.00,
                'status' => 'active',
                'start_date' => now()->format('Y-m-d'),
                'is_urgent' => true,
                'is_featured' => true,
                'short_description' => 'Solar-powered RO water filtration for rural families.',
                'full_story' => 'Full detailed story of ground water contamination and the solar filtration initiative.',
                'thumbnail_image' => $fakeThumb,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('campaigns', [
            'title' => 'Clean Drinking Water Plant',
            'slug' => 'clean-drinking-water-plant',
            'category_id' => $this->category->id,
            'goal_amount' => 250000.00,
            'status' => 'active',
            'is_urgent' => true,
            'is_featured' => true,
        ]);
    }

    public function test_admin_can_edit_campaign_via_filament(): void
    {
        $this->actingAs($this->admin);

        $campaign = Campaign::create([
            'category_id' => $this->category->id,
            'title' => 'Emergency Blanket Drive',
            'slug' => 'emergency-blanket-drive',
            'short_description' => 'Winter blankets for homeless families',
            'full_story' => 'Detailed winter narrative...',
            'thumbnail_image' => 'campaigns/blanket.jpg',
            'start_date' => now()->format('Y-m-d'),
            'goal_amount' => 100000.00,
            'status' => 'active',
        ]);

        Livewire::test(EditCampaign::class, ['record' => $campaign->id])
            ->fillForm([
                'goal_amount' => 120000.00,
                'is_urgent' => true,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('campaigns', [
            'id' => $campaign->id,
            'goal_amount' => 120000.00,
            'is_urgent' => true,
        ]);
    }

    public function test_public_campaigns_directory_reflects_active_filament_campaign(): void
    {
        $campaign = Campaign::create([
            'category_id' => $this->category->id,
            'title' => 'Ghat Cleanliness Drive Varanasi',
            'slug' => 'ghat-cleanliness-drive-varanasi',
            'short_description' => 'Daily sanitation and waste collection on Assi Ghat.',
            'full_story' => 'Volunteers work daily to clean waste and install bins on the ghats.',
            'thumbnail_image' => 'campaigns/ghat.jpg',
            'start_date' => now()->format('Y-m-d'),
            'goal_amount' => 80000.00,
            'status' => 'active',
        ]);

        $response = $this->get('/campaigns');
        $response->assertOk();
        $response->assertSee('Ghat Cleanliness Drive Varanasi');
        $response->assertSee('Daily sanitation and waste collection on Assi Ghat.');

        $detailResponse = $this->get("/campaigns/{$campaign->slug}");
        $detailResponse->assertOk();
        $detailResponse->assertSee('Ghat Cleanliness Drive Varanasi');
        $detailResponse->assertSee('Volunteers work daily to clean waste and install bins on the ghats.');
    }

    public function test_draft_campaign_is_hidden_from_public_directory(): void
    {
        $draftCampaign = Campaign::create([
            'category_id' => $this->category->id,
            'title' => 'Secret Unpublished Campaign',
            'slug' => 'secret-unpublished-campaign',
            'short_description' => 'This campaign is still in draft state.',
            'full_story' => 'Draft story...',
            'thumbnail_image' => 'campaigns/draft.jpg',
            'start_date' => now()->format('Y-m-d'),
            'goal_amount' => 50000.00,
            'status' => 'draft',
        ]);

        $response = $this->get('/campaigns');
        $response->assertDontSee('Secret Unpublished Campaign');

        $detailResponse = $this->get("/campaigns/{$draftCampaign->slug}");
        $detailResponse->assertNotFound();
    }
}
