<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventManagementAndRegistrationTest extends TestCase
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

    protected function createFakeImage(string $name = 'banner.png'): UploadedFile
    {
        $onePixelPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

        return UploadedFile::fake()->createWithContent($name, $onePixelPng);
    }

    public function test_admin_can_create_and_update_event_with_banner(): void
    {
        Storage::fake('public');

        $banner = $this->createFakeImage('health_camp.png');

        $createData = [
            'title' => 'Mega Health & Dental Checkup Camp',
            'description' => 'Free complete medical checkup, medicines distribution, and eye screening for elderly citizens.',
            'banner_image' => $banner,
            'location_name' => 'Community Center Hall, Ward 12',
            'address' => 'Near Old Shiva Temple, Assi Ghat Road, Varanasi, UP - 221005',
            'google_map_link' => 'https://maps.google.com/?q=25.2819,82.9995',
            'event_date' => now()->addDays(14)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '17:00',
            'max_participants' => 100,
            'status' => 'upcoming',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), $createData);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', [
            'title' => 'Mega Health & Dental Checkup Camp',
            'slug' => 'mega-health-dental-checkup-camp',
            'location_name' => 'Community Center Hall, Ward 12',
            'max_participants' => 100,
            'status' => 'upcoming',
        ]);

        $event = Event::where('slug', 'mega-health-dental-checkup-camp')->first();
        $this->assertNotNull($event);
        Storage::disk('public')->assertExists($event->banner_image);

        // Update event details
        $updateData = [
            'title' => 'Mega Health Camp & Dental Checkup',
            'slug' => 'mega-health-camp-updated',
            'description' => 'Updated medical camp description with doctor schedule.',
            'location_name' => 'Main Community Auditorium',
            'address' => 'Varanasi Central Auditorium, UP',
            'event_date' => now()->addDays(20)->toDateString(),
            'start_time' => '10:00',
            'end_time' => '18:00',
            'max_participants' => 150,
            'status' => 'ongoing',
        ];

        $updateResponse = $this->actingAs($this->admin)->put(route('admin.events.update', $event->id), $updateData);
        $updateResponse->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Mega Health Camp & Dental Checkup',
            'slug' => 'mega-health-camp-updated',
            'max_participants' => 150,
            'status' => 'ongoing',
        ]);
    }

    public function test_public_can_browse_events_directory(): void
    {
        $upcomingEvent = Event::create([
            'title' => 'Upcoming River Cleanliness Drive',
            'slug' => 'upcoming-river-cleanliness-drive',
            'description' => 'Ghat cleaning and waste segregation volunteer drive.',
            'banner_image' => 'events/banners/river.jpg',
            'location_name' => 'Assi Ghat Steps',
            'address' => 'Assi Ghat, Varanasi',
            'event_date' => now()->addDays(5)->toDateString(),
            'start_time' => '07:00:00',
            'end_time' => '11:00:00',
            'status' => 'upcoming',
        ]);

        $pastEvent = Event::create([
            'title' => 'Completed Winter Warmth Blanket Drive',
            'slug' => 'completed-winter-blanket-drive',
            'description' => 'Distributed 500 blankets to homeless families.',
            'banner_image' => 'events/banners/blanket.jpg',
            'location_name' => 'Cantonment Station Area',
            'address' => 'Near Platform 1, Varanasi Station',
            'event_date' => now()->subDays(10)->toDateString(),
            'start_time' => '18:00:00',
            'end_time' => '22:00:00',
            'status' => 'completed',
        ]);

        // Default tab: upcoming
        $response = $this->get(route('events.index'));
        $response->assertOk();
        $response->assertSee('Upcoming River Cleanliness Drive');
        $response->assertDontSee('Completed Winter Warmth Blanket Drive');

        // Past tab: past events
        $pastResponse = $this->get(route('events.index', ['type' => 'past']));
        $pastResponse->assertOk();
        $pastResponse->assertSee('Completed Winter Warmth Blanket Drive');
    }

    public function test_public_can_register_for_upcoming_event(): void
    {
        $event = Event::create([
            'title' => 'Tree Plantation Marathon',
            'slug' => 'tree-plantation-marathon',
            'description' => 'Planting 1000 saplings in city parks.',
            'banner_image' => 'events/banners/tree.jpg',
            'location_name' => 'Benia Bagh Park',
            'address' => 'Benia Bagh, Varanasi',
            'event_date' => now()->addDays(7)->toDateString(),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'max_participants' => 50,
            'status' => 'upcoming',
        ]);

        // Detail page renders form
        $showResponse = $this->get(route('events.show', $event->slug));
        $showResponse->assertOk();
        $showResponse->assertSee('RSVP to Attend or Volunteer');

        // Submit RSVP
        $rsvpData = [
            'participant_name' => 'Rohan Sharma',
            'participant_phone' => '9876543210',
            'participant_email' => 'rohan@example.com',
        ];

        $rsvpResponse = $this->post(route('events.register', $event->slug), $rsvpData);
        $rsvpResponse->assertRedirect();
        $rsvpResponse->assertSessionHas('success');

        $this->assertDatabaseHas('event_registrations', [
            'event_id' => $event->id,
            'participant_name' => 'Rohan Sharma',
            'participant_phone' => '9876543210',
            'participant_email' => 'rohan@example.com',
            'role_assigned' => 'Participant',
            'attendance_status' => 'registered',
        ]);
    }

    public function test_event_registration_enforces_capacity_limit(): void
    {
        $event = Event::create([
            'title' => 'Exclusive CPR Training Workshop',
            'slug' => 'exclusive-cpr-workshop',
            'description' => 'Hands-on emergency medical response training.',
            'banner_image' => 'events/banners/cpr.jpg',
            'location_name' => 'Rotary Hall',
            'address' => 'Sigra, Varanasi',
            'event_date' => now()->addDays(3)->toDateString(),
            'start_time' => '14:00:00',
            'end_time' => '17:00:00',
            'max_participants' => 1,
            'status' => 'upcoming',
        ]);

        // Register 1st participant (should succeed)
        $firstRsvp = $this->post(route('events.register', $event->slug), [
            'participant_name' => 'Participant One',
            'participant_phone' => '9111111111',
            'participant_email' => 'p1@example.com',
        ]);
        $firstRsvp->assertSessionHas('success');
        $this->assertEquals(1, $event->registrations()->count());

        // Register 2nd participant (should fail because capacity is full)
        $secondRsvp = $this->post(route('events.register', $event->slug), [
            'participant_name' => 'Participant Two',
            'participant_phone' => '9222222222',
            'participant_email' => 'p2@example.com',
        ]);
        $secondRsvp->assertSessionHas('error');
        $this->assertEquals(1, $event->registrations()->count());
    }

    public function test_duplicate_registration_by_same_phone_is_prevented(): void
    {
        $event = Event::create([
            'title' => 'Blood Donation Camp',
            'slug' => 'blood-donation-camp',
            'description' => 'Voluntary blood donation drive.',
            'banner_image' => 'events/banners/blood.jpg',
            'location_name' => 'District Hospital',
            'address' => 'Kabir Chaura, Varanasi',
            'event_date' => now()->addDays(4)->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '16:00:00',
            'max_participants' => 50,
            'status' => 'upcoming',
        ]);

        $payload = [
            'participant_name' => 'Same Donor',
            'participant_phone' => '9333333333',
            'participant_email' => 'same@example.com',
        ];

        $first = $this->post(route('events.register', $event->slug), $payload);
        $first->assertSessionHas('success');

        $duplicate = $this->post(route('events.register', $event->slug), $payload);
        $duplicate->assertSessionHas('error');
        $this->assertEquals(1, $event->registrations()->count());
    }

    public function test_registration_auto_links_approved_volunteer(): void
    {
        $volunteer = Volunteer::create([
            'full_name' => 'Meera Patel',
            'email' => 'meera.volunteer@example.com',
            'phone' => '9888877777',
            'city' => 'Varanasi',
            'status' => 'approved',
            'volunteer_code' => 'KSF-VOL-2026-0099',
            'skills' => ['medical', 'first_aid'],
            'availability' => 'weekends',
            'address' => 'Varanasi',
        ]);

        $event = Event::create([
            'title' => 'Mobile Health Van Drive',
            'slug' => 'mobile-health-van-drive',
            'description' => 'Providing free consultations in rural areas.',
            'banner_image' => 'events/banners/health_van.jpg',
            'location_name' => 'Chiraigaon Block',
            'address' => 'Chiraigaon, Varanasi District',
            'event_date' => now()->addDays(10)->toDateString(),
            'start_time' => '09:00:00',
            'end_time' => '15:00:00',
            'status' => 'upcoming',
        ]);

        $response = $this->post(route('events.register', $event->slug), [
            'participant_name' => 'Meera Patel',
            'participant_phone' => '9888877777',
            'participant_email' => 'meera.volunteer@example.com',
        ]);

        $response->assertSessionHas('success');

        $registration = EventRegistration::where('event_id', $event->id)->first();
        $this->assertNotNull($registration);
        $this->assertEquals($volunteer->id, $registration->volunteer_id);
        $this->assertEquals('Volunteer', $registration->role_assigned);
    }

    public function test_admin_can_view_participants_and_toggle_attendance(): void
    {
        $event = Event::create([
            'title' => 'Winter Relief Kit Distribution',
            'slug' => 'winter-relief-kit-distribution',
            'description' => 'Distributing warm clothes and blankets.',
            'banner_image' => 'events/banners/winter.jpg',
            'location_name' => 'Ghat Shelter',
            'address' => 'Dashashwamedh Ghat, Varanasi',
            'event_date' => now()->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '14:00:00',
            'status' => 'ongoing',
        ]);

        $registration = $event->registrations()->create([
            'participant_name' => 'Amit Kumar',
            'participant_phone' => '9444444444',
            'participant_email' => 'amit@example.com',
            'role_assigned' => 'Volunteer',
            'attendance_status' => 'registered',
        ]);

        // Admin views roster
        $rosterResponse = $this->actingAs($this->admin)->get(route('admin.events.participants', $event->id));
        $rosterResponse->assertOk();
        $rosterResponse->assertSee('Amit Kumar');
        $rosterResponse->assertSee('9444444444');

        // Mark attended
        $patchResponse = $this->actingAs($this->admin)->patch(
            route('admin.events.attendance', [$event->id, $registration->id]),
            ['attendance_status' => 'attended']
        );

        $patchResponse->assertRedirect();
        $patchResponse->assertSessionHas('success');

        $this->assertDatabaseHas('event_registrations', [
            'id' => $registration->id,
            'attendance_status' => 'attended',
        ]);
    }

    public function test_admin_can_manually_add_on_spot_participant(): void
    {
        $event = Event::create([
            'title' => 'Flood Relief Food Distribution',
            'slug' => 'flood-relief-food-distribution',
            'description' => 'Distributing dry ration packets.',
            'banner_image' => 'events/banners/flood.jpg',
            'location_name' => 'Relief Camp 4',
            'address' => 'Rajghat, Varanasi',
            'event_date' => now()->toDateString(),
            'start_time' => '08:00:00',
            'status' => 'ongoing',
        ]);

        $manualData = [
            'participant_name' => 'Suresh Yadav',
            'participant_phone' => '9555555555',
            'participant_email' => 'suresh@example.com',
            'role_assigned' => 'Logistics Volunteer',
            'attendance_status' => 'attended',
        ];

        $response = $this->actingAs($this->admin)->post(
            route('admin.events.addParticipant', $event->id),
            $manualData
        );

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('event_registrations', [
            'event_id' => $event->id,
            'participant_name' => 'Suresh Yadav',
            'participant_phone' => '9555555555',
            'role_assigned' => 'Logistics Volunteer',
            'attendance_status' => 'attended',
        ]);
    }
}
