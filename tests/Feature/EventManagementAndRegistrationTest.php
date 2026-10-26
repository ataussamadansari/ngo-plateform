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
}
