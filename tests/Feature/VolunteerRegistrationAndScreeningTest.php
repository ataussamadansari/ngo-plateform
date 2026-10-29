<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Volunteer;
use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VolunteerRegistrationAndScreeningTest extends TestCase
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

    protected function createFakeImage(string $name = 'photo.png'): UploadedFile
    {
        $onePixelPng = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

        return UploadedFile::fake()->createWithContent($name, $onePixelPng);
    }

    protected function createFakePdf(string $name = 'id_proof.pdf'): UploadedFile
    {
        return UploadedFile::fake()->create($name, 150, 'application/pdf');
    }

    public function test_public_can_view_volunteer_join_form(): void
    {
        $response = $this->get('/volunteer-join');

        $response->assertOk();
        $response->assertSee('Join Our Volunteer Community');
        $response->assertSee('Healthcare & Medical Aid');
        $response->assertSee('Full Name');
    }

    public function test_public_can_submit_volunteer_application_with_files(): void
    {
        Storage::fake('public');

        $photo = $this->createFakeImage('avatar.png');
        $idProof = $this->createFakePdf('aadhaar.pdf');

        $payload = [
            'full_name' => 'Aditya Verma',
            'email' => 'aditya@example.com',
            'phone' => '9876543210',
            'city' => 'Varanasi',
            'address' => 'Ghat Road, Varanasi',
            'occupation' => 'Software Engineer',
            'skills' => ['Healthcare & Medical Aid', 'Event Coordination & Logistics'],
            'availability' => 'weekends',
            'profile_photo' => $photo,
            'id_proof' => $idProof,
        ];

        $response = $this->post('/volunteer-join', $payload);

        $response->assertRedirect(route('volunteers.success'));
        $this->assertDatabaseHas('volunteers', [
            'full_name' => 'Aditya Verma',
            'email' => 'aditya@example.com',
            'phone' => '9876543210',
            'city' => 'Varanasi',
            'status' => 'pending',
        ]);

        $volunteer = Volunteer::where('email', 'aditya@example.com')->first();
        $this->assertNotNull($volunteer);
        $this->assertNotNull($volunteer->profile_photo);
        $this->assertNotNull($volunteer->id_proof_path);

        Storage::disk('public')->assertExists($volunteer->profile_photo);
        Storage::disk('public')->assertExists($volunteer->id_proof_path);

        // Success page check
        $successResponse = $this->get('/volunteer-join/success');
        $successResponse->assertOk();
        $successResponse->assertSee('Thank You for Stepping Up!');
    }

    public function test_duplicate_phone_or_email_is_rejected(): void
    {
        Volunteer::create([
            'full_name' => 'Existing Volunteer',
            'email' => 'duplicate@example.com',
            'phone' => '9876543211',
            'city' => 'Varanasi',
            'skills' => ['Child Education & Tutoring'],
            'availability' => 'weekends',
            'status' => 'approved',
        ]);

        $payload = [
            'full_name' => 'Second Volunteer',
            'email' => 'duplicate@example.com',
            'phone' => '9876543211',
            'city' => 'Lucknow',
            'skills' => ['Disaster Relief & Ground Operations'],
            'availability' => 'flexible',
        ];

        $response = $this->post('/volunteer-join', $payload);

        $response->assertSessionHasErrors(['email', 'phone']);
    }

    public function test_volunteer_submissions_are_rate_limited(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $this->post('/volunteer-join', [
                'full_name' => "Throttle User {$i}",
                'email' => "throttle{$i}@example.com",
                'phone' => "987000000{$i}",
                'city' => 'Varanasi',
                'skills' => ['Healthcare & Medical Aid'],
                'availability' => 'weekends',
            ]);
        }

        // 6th request within the same minute should be throttled
        $response = $this->post('/volunteer-join', [
            'full_name' => 'Throttle User 6',
            'email' => 'throttle6@example.com',
            'phone' => '9870000006',
            'city' => 'Varanasi',
            'skills' => ['Healthcare & Medical Aid'],
            'availability' => 'weekends',
        ]);

        $response->assertStatus(429);
    }

    public function test_volunteer_screen_matches_new_ui_ux_specification(): void
    {
        $response = $this->get('/volunteer-join');

        $response->assertOk();

        // 1. Hero Section
        $response->assertSee('BE A VOLUNTEER');
        $response->assertSee('Give Your Time');
        $response->assertSee('Create Real Change');
        $response->assertSee('Join as a Volunteer');
        $response->assertSee('People');
        $response->assertSee('Brighter');
        $response->assertSee('Tomorrows');

        // 2. 4 Value Proposition Pillars
        $response->assertSee('Make an Impact');
        $response->assertSee('Support real causes');
        $response->assertSee('Build Communities');
        $response->assertSee('Create lasting change');
        $response->assertSee('Gain Experience');
        $response->assertSee('Develop new skills');
        $response->assertSee('Be Part of a Family');
        $response->assertSee('Work with like-minded people');

        // 3. Volunteering Opportunities
        $response->assertSee('Volunteering Opportunities');
        $response->assertSee('Education Support');
        $response->assertSee('Health Camp Support');
        $response->assertSee('Food Distribution');
        $response->assertSee('Environment Initiatives');
        $response->assertSee('Community Outreach');
        $response->assertSee('Event Support');

        // 4. Stats Strip
        $response->assertSee('Active Volunteers');
        $response->assertSee('Community Programs');
        $response->assertSee('Cities Covered');
        $response->assertSee('Lives Impacted');

        // 5. Volunteer Stories
        $response->assertSee('Volunteer Stories');
        $response->assertSee('Real people. Real stories. Real impact.');
        $response->assertSee('Sara Khan');
        $response->assertSee('Amit Verma');
        $response->assertSee('Riya Sharma');

        // 6. Registration Form Card
        $response->assertSee('Volunteer Registration');
        $response->assertSee('Fill out the form below to join our volunteer community.');
        $response->assertSee('Full Name');
        $response->assertSee('Email Address');
        $response->assertSee('Mobile Number');
        $response->assertSee('Date of Birth');
        $response->assertSee('Area of Interest');
        $response->assertSee('Availability');
        $response->assertSee('Tell Us About Yourself');
        $response->assertSee('Submit Application');
        $response->assertSee('Your information is safe and will only be used for volunteering purposes.');

        // 7. Frequently Asked Questions
        $response->assertSee('Frequently Asked Questions');
        $response->assertSee('Who can become a volunteer?');
        $response->assertSee('Do I need any prior experience?');
        $response->assertSee('How much time do I need to commit?');
        $response->assertSee('Will I receive a certificate?');
    }

    public function test_applicant_can_submit_via_new_form_fields(): void
    {
        $payload = [
            'full_name' => 'Pooja Kashyap',
            'email' => 'pooja.kashyap@example.com',
            'phone' => '9871122334',
            'date_of_birth' => '1998-05-14',
            'area_of_interest' => 'Education Support',
            'availability' => 'weekends',
            'about_yourself' => 'I want to teach underprivileged kids during my free weekend hours.',
        ];

        $response = $this->post('/volunteer-join', $payload);

        $response->assertRedirect(route('volunteers.success'));
        $this->assertDatabaseHas('volunteers', [
            'full_name' => 'Pooja Kashyap',
            'email' => 'pooja.kashyap@example.com',
            'phone' => '9871122334',
            'area_of_interest' => 'Education Support',
            'availability' => 'weekends',
            'status' => 'pending',
        ]);
    }
}
