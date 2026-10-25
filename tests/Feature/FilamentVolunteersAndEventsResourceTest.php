<?php

namespace Tests\Feature;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\RelationManagers\RegistrationsRelationManager;
use App\Filament\Resources\Volunteers\Pages\ListVolunteers;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentVolunteersAndEventsResourceTest extends TestCase
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

    protected function createFakeImage(string $name = 'image.png', int $sizeKb = 50): UploadedFile
    {
        $pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $content = base64_decode($pngBase64);

        if ($sizeKb > 1) {
            $content .= str_repeat('0', ($sizeKb * 1024) - strlen($content));
        }

        return UploadedFile::fake()->createWithContent($name, $content);
    }

    public function test_unauthenticated_user_cannot_access_volunteers_or_events(): void
    {
        $this->get('/admin/volunteers')->assertRedirect('/admin/login');
        $this->get('/admin/events')->assertRedirect('/admin/login');
    }

    public function test_authenticated_admin_can_view_volunteers_and_events_lists(): void
    {
        $this->actingAs($this->admin);

        $this->get('/admin/volunteers')->assertSuccessful();
        $this->get('/admin/events')->assertSuccessful();
    }

    public function test_volunteers_table_renders_and_filters_applicants(): void
    {
        $pending = Volunteer::create([
            'full_name' => 'Aarav Patel',
            'email' => 'aarav@example.com',
            'phone' => '9876543201',
            'city' => 'Varanasi',
            'skills' => ['Community Care'],
            'status' => 'pending',
        ]);

        $approved = Volunteer::create([
            'full_name' => 'Neha Gupta',
            'volunteer_code' => 'KSF-VOL-2026-0001',
            'email' => 'neha@example.com',
            'phone' => '9876543202',
            'city' => 'Prayagraj',
            'skills' => ['Media & Documentation'],
            'status' => 'approved',
            'joined_at' => now(),
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListVolunteers::class)
            ->assertCanSeeTableRecords([$pending, $approved]);
    }

    public function test_admin_can_approve_volunteer_and_assign_sequential_code(): void
    {
        $volunteer = Volunteer::create([
            'full_name' => 'Kavita Sharma',
            'email' => 'kavita@example.com',
            'phone' => '9876543203',
            'city' => 'Varanasi',
            'skills' => ['Education & Tutoring'],
            'status' => 'pending',
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListVolunteers::class)
            ->callTableAction('approve', $volunteer)
            ->assertHasNoTableActionErrors();

        $volunteer->refresh();
        $this->assertEquals('approved', $volunteer->status);
        $this->assertNotNull($volunteer->volunteer_code);
        $this->assertStringStartsWith('KSF-VOL-2026-', $volunteer->volunteer_code);
        $this->assertNotNull($volunteer->joined_at);
    }

    public function test_admin_can_reject_volunteer_application(): void
    {
        $volunteer = Volunteer::create([
            'full_name' => 'Ineligible Applicant',
            'email' => 'ineligible@example.com',
            'phone' => '9876543204',
            'city' => 'Lucknow',
            'skills' => ['Ground Relief'],
            'status' => 'pending',
        ]);

        Livewire::actingAs($this->admin)
            ->test(ListVolunteers::class)
            ->callTableAction('reject', $volunteer)
            ->assertHasNoTableActionErrors();

        $volunteer->refresh();
        $this->assertEquals('rejected', $volunteer->status);
        $this->assertNull($volunteer->volunteer_code);
    }

    public function test_admin_can_create_event_with_banner(): void
    {
        Storage::fake('public');
        $banner = $this->createFakeImage('event_banner.png');

        Livewire::actingAs($this->admin)
            ->test(CreateEvent::class)
            ->fillForm([
                'title' => 'Ghat Cleanliness Awareness Rally',
                'slug' => 'ghat-cleanliness-awareness-rally',
                'event_date' => now()->addDays(7)->toDateString(),
                'start_time' => '07:30',
                'end_time' => '11:00',
                'max_participants' => 75,
                'status' => 'upcoming',
                'location_name' => 'Assi Ghat Steps',
                'address' => 'Assi Ghat, Varanasi, UP',
                'google_map_link' => 'https://maps.google.com/?q=25.2819,82.9995',
                'description' => 'Comprehensive volunteer drive for riverbank cleanup and awareness.',
                'banner_image' => $banner,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $event = Event::where('slug', 'ghat-cleanliness-awareness-rally')->first();
        $this->assertNotNull($event);
        $this->assertEquals('Assi Ghat Steps', $event->location_name);
        $this->assertNotNull($event->banner_image);
        Storage::disk('public')->assertExists($event->banner_image);
    }

    public function test_event_registrations_relation_manager_renders_attendees_and_toggles_attendance(): void
    {
        $event = Event::create([
            'title' => 'Tree Plantation Drive',
            'slug' => 'tree-plantation-drive',
            'banner_image' => 'events/banners/trees.png',
            'event_date' => now()->addDays(3)->toDateString(),
            'start_time' => '08:00',
            'end_time' => '12:00',
            'max_participants' => 50,
            'status' => 'upcoming',
            'location_name' => 'BHU Campus Grounds',
            'address' => 'Banaras Hindu University, Varanasi',
            'description' => 'Planting 500 saplings.',
        ]);

        $attendee = EventRegistration::create([
            'event_id' => $event->id,
            'participant_name' => 'Rahul Verma',
            'participant_phone' => '9876543205',
            'participant_email' => 'rahul@example.com',
            'role_assigned' => 'Logistics & Saplings',
            'attendance_status' => 'registered',
        ]);

        Livewire::actingAs($this->admin)
            ->test(RegistrationsRelationManager::class, [
                'ownerRecord' => $event,
                'pageClass' => EditEvent::class,
            ])
            ->assertCanSeeTableRecords([$attendee])
            ->callTableAction('mark_attended', $attendee)
            ->assertHasNoTableActionErrors();

        $attendee->refresh();
        $this->assertEquals('attended', $attendee->attendance_status);

        // Can mark absent
        Livewire::actingAs($this->admin)
            ->test(RegistrationsRelationManager::class, [
                'ownerRecord' => $event,
                'pageClass' => EditEvent::class,
            ])
            ->callTableAction('mark_absent', $attendee)
            ->assertHasNoTableActionErrors();

        $attendee->refresh();
        $this->assertEquals('absent', $attendee->attendance_status);
    }

    public function test_admin_can_add_on_spot_participant_via_relation_manager(): void
    {
        $event = Event::create([
            'title' => 'Blood Donation Camp',
            'slug' => 'blood-donation-camp',
            'banner_image' => 'events/banners/blood.png',
            'event_date' => now()->addDays(5)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '15:00',
            'max_participants' => 100,
            'status' => 'upcoming',
            'location_name' => 'District Red Cross Society',
            'address' => 'Lahurabir, Varanasi',
            'description' => 'Voluntary blood donation drive.',
        ]);

        Livewire::actingAs($this->admin)
            ->test(RegistrationsRelationManager::class, [
                'ownerRecord' => $event,
                'pageClass' => EditEvent::class,
            ])
            ->callTableAction('create', data: [
                'participant_name' => 'Manish Tiwari',
                'participant_phone' => '9876543206',
                'participant_email' => 'manish@example.com',
                'role_assigned' => 'Donor / Participant',
                'attendance_status' => 'attended',
            ])
            ->assertHasNoTableActionErrors();

        $registration = EventRegistration::where('participant_name', 'Manish Tiwari')
            ->where('event_id', $event->id)
            ->first();

        $this->assertNotNull($registration);
        $this->assertEquals('attended', $registration->attendance_status);
        $this->assertEquals('9876543206', $registration->participant_phone);
    }
}
