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

    public function test_admin_can_view_volunteers_queue_and_filter_by_status(): void
    {
        Volunteer::create([
            'full_name' => 'Pending Applicant',
            'email' => 'pending@example.com',
            'phone' => '9876543220',
            'city' => 'Varanasi',
            'skills' => ['Food Preparation & Ration Distribution'],
            'availability' => 'weekends',
            'status' => 'pending',
        ]);

        Volunteer::create([
            'full_name' => 'Approved Member',
            'volunteer_code' => 'KSF-VOL-2026-0001',
            'email' => 'approved@example.com',
            'phone' => '9876543221',
            'city' => 'Prayagraj',
            'skills' => ['Media, Photography & Storytelling'],
            'availability' => 'flexible',
            'status' => 'approved',
            'joined_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.volunteers.index'));

        $response->assertOk();
        $response->assertSee('Volunteer Screening & Roster');
        $response->assertSee('Pending Applicant');
        $response->assertSee('Approved Member');
        $response->assertSee('KSF-VOL-2026-0001');

        // Status filter
        $pendingFilter = $this->get(route('admin.volunteers.index', ['status' => 'pending']));
        $pendingFilter->assertOk();
        $pendingFilter->assertSee('Pending Applicant');
        $pendingFilter->assertDontSee('Approved Member');
    }

    public function test_admin_can_approve_volunteer_and_assign_sequential_code(): void
    {
        $volunteer = Volunteer::create([
            'full_name' => 'Pooja Kashyap',
            'email' => 'pooja@example.com',
            'phone' => '9876543230',
            'city' => 'Varanasi',
            'skills' => ['Child Education & Tutoring'],
            'availability' => 'weekends',
            'status' => 'pending',
        ]);

        $year = date('Y');
        $expectedCode = "KSF-VOL-{$year}-0001";

        $response = $this->actingAs($this->admin)->post(route('admin.volunteers.approve', $volunteer));

        $response->assertSessionHas('success');

        $volunteer->refresh();
        $this->assertEquals('approved', $volunteer->status);
        $this->assertEquals($expectedCode, $volunteer->volunteer_code);
        $this->assertNotNull($volunteer->joined_at);

        // Approve second volunteer to verify sequential increment
        $secondVolunteer = Volunteer::create([
            'full_name' => 'Rohan Singh',
            'email' => 'rohan@example.com',
            'phone' => '9876543231',
            'city' => 'Varanasi',
            'skills' => ['Disaster Relief & Ground Operations'],
            'availability' => 'flexible',
            'status' => 'pending',
        ]);

        $this->post(route('admin.volunteers.approve', $secondVolunteer));

        $secondVolunteer->refresh();
        $expectedSecondCode = "KSF-VOL-{$year}-0002";
        $this->assertEquals($expectedSecondCode, $secondVolunteer->volunteer_code);
    }

    public function test_admin_can_reject_volunteer_application(): void
    {
        $volunteer = Volunteer::create([
            'full_name' => 'Reject Test Applicant',
            'email' => 'reject@example.com',
            'phone' => '9876543240',
            'city' => 'Kanpur',
            'skills' => ['Fundraising & Campaign Advocacy'],
            'availability' => 'weekdays',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.volunteers.reject', $volunteer));

        $response->assertSessionHas('info');

        $volunteer->refresh();
        $this->assertEquals('rejected', $volunteer->status);
        $this->assertNull($volunteer->volunteer_code);
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
}
