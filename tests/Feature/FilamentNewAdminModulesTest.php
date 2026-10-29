<?php

namespace Tests\Feature;

use App\Filament\Resources\Campaigns\CampaignResource;
use App\Filament\Resources\ContactInquiries\ContactInquiryResource;
use App\Filament\Resources\Donations\DonationResource;
use App\Filament\Resources\Donations\Pages\ListDonations;
use App\Filament\Resources\EventRegistrations\EventRegistrationResource;
use App\Filament\Resources\EventRegistrations\Pages\ListEventRegistrations;
use App\Filament\Resources\FundDistributions\Pages\ListFundDistributions;
use App\Filament\Resources\TeamMembers\Pages\ListTeamMembers;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Filament\Resources\Volunteers\Pages\ListVolunteers;
use App\Filament\Resources\Volunteers\VolunteerResource;
use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\ContactInquiry;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\FundDistribution;
use App\Models\PaymentMethod;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentNewAdminModulesTest extends TestCase
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

    public function test_unauthenticated_user_cannot_access_new_admin_modules(): void
    {
        $this->get('/admin/testimonials')->assertRedirect('/admin/login');
        $this->get('/admin/team-members')->assertRedirect('/admin/login');
        $this->get('/admin/event-registrations')->assertRedirect('/admin/login');
    }

    public function test_admin_can_view_and_manage_testimonials(): void
    {
        $testimonial = Testimonial::create([
            'name' => 'Dr. Vikram Malhotra',
            'role' => 'Healthcare Patron & Donor',
            'quote' => 'The complete transparency of the medical equipment bills makes KSF unique.',
            'rating' => 5,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/testimonials');
        $response->assertOk();

        Livewire::actingAs($this->admin)
            ->test(ListTestimonials::class)
            ->assertCanSeeTableRecords([$testimonial])
            ->assertSee('Dr. Vikram Malhotra')
            ->assertSee('Healthcare Patron & Donor');
    }

    public function test_admin_can_view_and_manage_team_members(): void
    {
        $member = TeamMember::create([
            'name' => 'Meera Krishnan',
            'role' => 'Director of Community Programs',
            'bio' => 'Oversees grassroots outreach, education centers, and winter relief distribution.',
            'email' => 'meera@kashiseva.org',
            'phone' => '+91 98888 77777',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/team-members');
        $response->assertOk();

        Livewire::actingAs($this->admin)
            ->test(ListTeamMembers::class)
            ->assertCanSeeTableRecords([$member])
            ->assertSee('Meera Krishnan')
            ->assertSee('Director of Community Programs');
    }

    public function test_admin_can_view_and_check_in_event_registrations(): void
    {
        $event = Event::create([
            'title' => 'Ganga Ghat Sanitation & Medical Drive',
            'slug' => 'ganga-ghat-sanitation-medical-drive',
            'description' => 'Riverbank sanitation and free basic medical health check-up camp.',
            'banner_image' => 'events/banners/ganga.jpg',
            'location_name' => 'Dashashwamedh Ghat',
            'address' => 'Varanasi, UP',
            'event_date' => now()->addDays(2)->toDateString(),
            'start_time' => '07:30:00',
            'end_time' => '11:30:00',
            'status' => 'upcoming',
        ]);

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'participant_name' => 'Anurag Sharma',
            'participant_email' => 'anurag@example.com',
            'participant_phone' => '9876543210',
            'attendance_status' => 'registered',
            'role_assigned' => 'Volunteer Doctor',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/event-registrations');
        $response->assertOk();

        // 1. Verify list renders registration
        Livewire::actingAs($this->admin)
            ->test(ListEventRegistrations::class)
            ->assertCanSeeTableRecords([$registration])
            ->assertSee('Anurag Sharma')
            ->assertSee('Ganga Ghat Sanitation & Medical Drive');

        // 2. Perform attendee Check-In
        Livewire::actingAs($this->admin)
            ->test(ListEventRegistrations::class)
            ->callTableAction('mark_attended', $registration)
            ->assertHasNoTableActionErrors();

        $this->assertEquals('attended', $registration->fresh()->attendance_status);

        // 3. Mark Absent
        Livewire::actingAs($this->admin)
            ->test(ListEventRegistrations::class)
            ->callTableAction('mark_absent', $registration)
            ->assertHasNoTableActionErrors();

        $this->assertEquals('absent', $registration->fresh()->attendance_status);
    }

    public function test_admin_navigation_badges_reflect_real_time_counts(): void
    {
        $category = CauseCategory::first();
        $paymentMethod = PaymentMethod::first();

        // 1. Pending Donation
        $campaign = Campaign::create([
            'category_id' => $category->id,
            'title' => 'Clean Water Well Drilling',
            'slug' => 'clean-water-well-drilling',
            'short_description' => 'Drilling borewells for safe drinking water.',
            'full_story' => 'Full story about clean water wells.',
            'thumbnail_image' => 'campaigns/thumbnails/well.jpg',
            'goal_amount' => 100000.00,
            'raised_amount' => 0.00,
            'start_date' => now()->toDateString(),
            'status' => 'active',
        ]);

        Donation::create([
            'campaign_id' => $campaign->id,
            'payment_method_id' => $paymentMethod->id,
            'donor_name' => 'Sunil Gupta',
            'donor_email' => 'sunil@example.com',
            'donor_phone' => '9876543210',
            'amount' => 5000.00,
            'payment_mode' => 'upi_qr',
            'utr_number' => 'UTR998877665544',
            'status' => 'pending',
        ]);

        // 2. Pending Volunteer
        Volunteer::create([
            'full_name' => 'Geeta Rani',
            'email' => 'geeta@example.com',
            'phone' => '9811122233',
            'city' => 'Varanasi',
            'status' => 'pending',
            'skills' => ['first_aid'],
        ]);

        // 3. Unread Contact Inquiry
        ContactInquiry::create([
            'name' => 'Karan Kapoor',
            'email' => 'karan@example.com',
            'subject' => 'Corporate CSR Inquiry',
            'message' => 'Query about corporate CSR program.',
            'status' => 'pending',
        ]);

        // 4. Event Registration
        $event = Event::create([
            'title' => 'Tree Plantation Drive',
            'slug' => 'tree-plantation-drive',
            'description' => 'Planting saplings along the ring road.',
            'banner_image' => 'events/banners/trees.jpg',
            'location_name' => 'Sarnath Road',
            'address' => 'Varanasi',
            'event_date' => now()->addDays(5)->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '11:00:00',
            'status' => 'upcoming',
        ]);

        EventRegistration::create([
            'event_id' => $event->id,
            'participant_name' => 'Rohit Roy',
            'participant_email' => 'rohit@example.com',
            'participant_phone' => '9988776655',
            'attendance_status' => 'registered',
        ]);

        // Assert Navigation Badge values
        $this->assertEquals(1, DonationResource::getNavigationBadge());
        $this->assertEquals(1, VolunteerResource::getNavigationBadge());
        $this->assertEquals(1, ContactInquiryResource::getNavigationBadge());
        $this->assertEquals(1, EventRegistrationResource::getNavigationBadge());
        $this->assertGreaterThanOrEqual(1, CampaignResource::getNavigationBadge());
    }

    public function test_csv_export_header_actions_return_streamed_downloads(): void
    {
        $category = CauseCategory::first();
        $campaign = Campaign::create([
            'category_id' => $category->id,
            'title' => 'School Kits Support',
            'slug' => 'school-kits-support',
            'short_description' => 'Providing school bags and books.',
            'full_story' => 'Full story.',
            'thumbnail_image' => 'campaigns/thumbnails/kits.jpg',
            'goal_amount' => 20000.00,
            'raised_amount' => 5000.00,
            'start_date' => now()->toDateString(),
            'status' => 'active',
        ]);

        $paymentMethod = PaymentMethod::first();
        Donation::create([
            'campaign_id' => $campaign->id,
            'payment_method_id' => $paymentMethod->id,
            'donor_name' => 'Alok Nath',
            'donor_email' => 'alok@example.com',
            'donor_phone' => '9876543210',
            'amount' => 5000.00,
            'payment_mode' => 'bank_transfer',
            'utr_number' => 'UTR112233445566',
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        FundDistribution::create([
            'campaign_id' => $campaign->id,
            'title' => 'Stationery Bags Purchase',
            'beneficiary_name' => 'Varanasi Stationery Mart',
            'description' => 'Bags and notebooks procurement.',
            'amount_spent' => 4500.00,
            'distribution_date' => now()->toDateString(),
            'is_public' => true,
            'created_by' => $this->admin->id,
        ]);

        // 1. Export Donations CSV
        Livewire::actingAs($this->admin)
            ->test(ListDonations::class)
            ->callAction('export_csv')
            ->assertHasNoActionErrors();

        // 2. Export Volunteers CSV
        Livewire::actingAs($this->admin)
            ->test(ListVolunteers::class)
            ->callAction('export_csv')
            ->assertHasNoActionErrors();

        // 3. Export Fund Distributions CSV
        Livewire::actingAs($this->admin)
            ->test(ListFundDistributions::class)
            ->callAction('export_csv')
            ->assertHasNoActionErrors();

        // 4. Export Event Registrations CSV
        Livewire::actingAs($this->admin)
            ->test(ListEventRegistrations::class)
            ->callAction('export_csv')
            ->assertHasNoActionErrors();
    }
}
