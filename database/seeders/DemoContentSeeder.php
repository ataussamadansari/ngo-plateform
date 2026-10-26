<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\CauseCategory;
use App\Models\ContactInquiry;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\FundDistribution;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DemoContentSeeder extends Seeder
{
    /**
     * Run the demo content seeders for realistic UI/UX development and testing.
     */
    public function run(): void
    {
        // 0. Ensure Public Storage Directories Exist
        $directories = [
            storage_path('app/public/campaigns/thumbnails'),
            storage_path('app/public/campaigns/galleries'),
            storage_path('app/public/events/banners'),
            storage_path('app/public/distributions/bills'),
            storage_path('app/public/distributions/impact'),
            storage_path('app/public/volunteers/photos'),
            storage_path('app/public/volunteers/id_proofs'),
        ];

        foreach ($directories as $dir) {
            if (! File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true, true);
            }
        }

        // Create a 1x1 dummy PNG if needed so file_exists checks succeed
        $dummyPngData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $defaultThumbnail = 'campaigns/thumbnails/demo_thumbnail.png';
        if (! File::exists(storage_path('app/public/'.$defaultThumbnail))) {
            File::put(storage_path('app/public/'.$defaultThumbnail), $dummyPngData);
        }

        $defaultEventBanner = 'events/banners/demo_event_banner.png';
        if (! File::exists(storage_path('app/public/'.$defaultEventBanner))) {
            File::put(storage_path('app/public/'.$defaultEventBanner), $dummyPngData);
        }

        $defaultBill = 'distributions/bills/demo_bill.png';
        if (! File::exists(storage_path('app/public/'.$defaultBill))) {
            File::put(storage_path('app/public/'.$defaultBill), $dummyPngData);
        }

        $defaultImpact = 'distributions/impact/demo_impact.png';
        if (! File::exists(storage_path('app/public/'.$defaultImpact))) {
            File::put(storage_path('app/public/'.$defaultImpact), $dummyPngData);
        }

        // 1. Get or Create Admin User
        $admin = User::first() ?? User::create([
            'name' => 'KSF Super Admin',
            'email' => 'admin@ksf.org',
            'password' => bcrypt('password123'),
            'role' => 'super_admin',
            'phone' => '+91 9876543210',
            'is_active' => true,
        ]);

        // 2. Fetch Categories
        $medicalCategory = CauseCategory::where('slug', 'medical-aid')->first() ?? CauseCategory::first();
        $educationCategory = CauseCategory::where('slug', 'child-education')->first() ?? CauseCategory::first();
        $winterCategory = CauseCategory::where('slug', 'winter-relief-drive')->first() ?? CauseCategory::first();
        $foodCategory = CauseCategory::where('slug', 'food-and-nutrition')->first() ?? CauseCategory::first();
        $disasterCategory = CauseCategory::where('slug', 'disaster-recovery')->first() ?? CauseCategory::first();

        // 3. Seed Realistic Campaigns
        $campaignsData = [
            [
                'category_id' => $medicalCategory->id,
                'title' => 'Emergency Oxygen Supplies & Concentrators Drive',
                'slug' => 'emergency-oxygen-supplies-drive',
                'short_description' => 'Procuring high-flow oxygen concentrators and cylinders for district health centers in rural Varanasi.',
                'full_story' => "Rural district hospitals often face sudden shortages of life-saving oxygen during seasonal surges. Hope Foundation is deploying 10L medical concentrators with complete maintenance backup directly to grassroots medical clinics.\n\nEvery rupee contributed is verified against bank statements and tracked through public GST tax invoices and geotagged serial numbers.",
                'thumbnail_image' => $defaultThumbnail,
                'goal_amount' => 150000.00,
                'raised_amount' => 95000.00,
                'distributed_amount' => 60000.00,
                'start_date' => now()->subDays(30)->toDateString(),
                'end_date' => now()->addDays(60)->toDateString(),
                'is_featured' => true,
                'is_urgent' => true,
                'status' => 'active',
            ],
            [
                'category_id' => $educationCategory->id,
                'title' => 'Rural Girl Child Education & Digital Literacy Kits',
                'slug' => 'rural-girl-child-education',
                'short_description' => 'Empowering 120 underprivileged rural schoolgirls with annual stationery, books, school bags, and digital tablets.',
                'full_story' => "Education is the greatest tool for societal transformation. Our digital literacy drive equips rural primary school students with curated learning kits, notebooks, school bags, and shared tablet computers.\n\nWe coordinate directly with village school principals to ensure 100% attendance and zero dropouts among young girl students.",
                'thumbnail_image' => $defaultThumbnail,
                'goal_amount' => 200000.00,
                'raised_amount' => 140000.00,
                'distributed_amount' => 80000.00,
                'start_date' => now()->subDays(45)->toDateString(),
                'end_date' => now()->addDays(45)->toDateString(),
                'is_featured' => true,
                'is_urgent' => false,
                'status' => 'active',
            ],
            [
                'category_id' => $winterCategory->id,
                'title' => 'Winter Blanket & Warm Clothes Distribution in Varanasi Ghats',
                'slug' => 'winter-blanket-relief-ghats',
                'short_description' => 'Providing heavy double-layer wool blankets and thermal wear to homeless families and sadhus along Ganga ghats.',
                'full_story' => "Winter along the river ghats can drop to harsh single digits. Hope Foundation's ground volunteer force conducts nightly drives across Assi Ghat, Dashashwamedh, and Rajghat to distribute heavy thermal blankets and jackets.\n\nEach blanket is hand-delivered with dignity, verified, and mapped on our transparent fund distribution ledger.",
                'thumbnail_image' => $defaultThumbnail,
                'goal_amount' => 80000.00,
                'raised_amount' => 52000.00,
                'distributed_amount' => 35000.00,
                'start_date' => now()->subDays(15)->toDateString(),
                'end_date' => now()->addDays(25)->toDateString(),
                'is_featured' => true,
                'is_urgent' => true,
                'status' => 'active',
            ],
            [
                'category_id' => $foodCategory->id,
                'title' => 'Daily Nutritious Meals for Underprivileged Children',
                'slug' => 'daily-nutritious-meals-program',
                'short_description' => 'Serving hot, wholesome, freshly cooked mid-day meals to slum children and community shelter centers.',
                'full_story' => 'Malnutrition hinders child cognitive growth and immune defenses. Our community kitchen prepares balanced meals consisting of lentils, seasonal vegetables, fortified rice, and fresh fruit for 250+ kids daily.',
                'thumbnail_image' => $defaultThumbnail,
                'goal_amount' => 120000.00,
                'raised_amount' => 78000.00,
                'distributed_amount' => 50000.00,
                'start_date' => now()->subDays(60)->toDateString(),
                'end_date' => now()->addDays(90)->toDateString(),
                'is_featured' => false,
                'is_urgent' => false,
                'status' => 'active',
            ],
            [
                'category_id' => $disasterCategory->id,
                'title' => 'Clean Drinking Water Community RO Plant Setup',
                'slug' => 'clean-drinking-water-ro-plant',
                'short_description' => 'Installing a 500 LPH solar-powered community reverse-osmosis filtration plant for 400 rural households.',
                'full_story' => 'Contaminated groundwater leads to endemic waterborne illnesses in flood-prone districts. This initiative constructs a decentralized, solar-powered reverse osmosis water purification station supplying tested, WHO-standard drinking water.',
                'thumbnail_image' => $defaultThumbnail,
                'goal_amount' => 300000.00,
                'raised_amount' => 185000.00,
                'distributed_amount' => 110000.00,
                'start_date' => now()->subDays(20)->toDateString(),
                'end_date' => now()->addDays(70)->toDateString(),
                'is_featured' => true,
                'is_urgent' => false,
                'status' => 'active',
            ],
        ];

        $createdCampaigns = [];
        foreach ($campaignsData as $data) {
            $createdCampaigns[] = Campaign::updateOrCreate(['slug' => $data['slug']], $data);
        }

        // 4. Fetch Payment Methods
        $upiMethod = PaymentMethod::where('type', 'upi_qr')->first() ?? PaymentMethod::first();
        $bankMethod = PaymentMethod::where('type', 'bank_transfer')->first() ?? PaymentMethod::first();

        // 5. Seed Verified & Pending Donations
        $donationsData = [
            [
                'campaign_id' => $createdCampaigns[0]->id,
                'receipt_number' => 'KSF-2026-0101',
                'donor_name' => 'Dr. Anand Verma',
                'donor_email' => 'anand.verma@example.com',
                'donor_phone' => '9876543210',
                'donor_pan' => 'ABCDE1234F',
                'donor_address' => 'A-44, Kailash Colony, New Delhi',
                'amount' => 15000.00,
                'payment_mode' => 'upi_qr',
                'utr_number' => 'UTR202601150012',
                'donor_message' => 'Happy to sponsor oxygen flowmeters for the emergency ward.',
                'is_anonymous' => false,
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDays(25),
            ],
            [
                'campaign_id' => $createdCampaigns[1]->id,
                'receipt_number' => 'KSF-2026-0102',
                'donor_name' => 'Priya Sharma',
                'donor_email' => 'priya.sharma@example.com',
                'donor_phone' => '9812345678',
                'donor_pan' => 'BKDPS5678M',
                'donor_address' => 'Flat 302, Green Valley Apartments, Pune',
                'amount' => 5000.00,
                'payment_mode' => 'upi_qr',
                'utr_number' => 'UTR202601180045',
                'donor_message' => 'For girls education kits. Keep up the transparent work!',
                'is_anonymous' => false,
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDays(20),
            ],
            [
                'campaign_id' => $createdCampaigns[4]->id,
                'receipt_number' => 'KSF-2026-0103',
                'donor_name' => 'Rajesh K. Mehta',
                'donor_email' => 'rajesh.mehta@example.com',
                'donor_phone' => '9920112233',
                'donor_pan' => 'AAAPM9988K',
                'donor_address' => 'B-1204, Oberoi Springs, Andheri West, Mumbai',
                'amount' => 25000.00,
                'payment_mode' => 'bank_transfer',
                'utr_number' => 'UTR202601200089',
                'donor_message' => 'Clean water for rural households. Zero gateway fee model is exemplary.',
                'is_anonymous' => false,
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDays(15),
            ],
            [
                'campaign_id' => $createdCampaigns[2]->id,
                'receipt_number' => 'KSF-2026-0104',
                'donor_name' => 'Sunita Gupta',
                'donor_email' => 'sunita.gupta@example.com',
                'donor_phone' => '9765432109',
                'donor_pan' => 'CLPKG3322R',
                'donor_address' => 'Civil Lines, Prayagraj',
                'amount' => 2500.00,
                'payment_mode' => 'upi_qr',
                'utr_number' => 'UTR202601220033',
                'donor_message' => 'Warm blankets for ghat night shelters.',
                'is_anonymous' => false,
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDays(10),
            ],
            [
                'campaign_id' => $createdCampaigns[0]->id,
                'receipt_number' => 'KSF-2026-0105',
                'donor_name' => 'Vikram Rao',
                'donor_email' => 'vikram.rao@example.com',
                'donor_phone' => '9845012345',
                'donor_pan' => 'AALPR4411Q',
                'donor_address' => 'Indiranagar, Bengaluru',
                'amount' => 10000.00,
                'payment_mode' => 'upi_qr',
                'utr_number' => 'UTR202601250077',
                'donor_message' => 'In memory of my late mother Smt. Kamala Rao.',
                'is_anonymous' => false,
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDays(5),
            ],
            [
                'campaign_id' => $createdCampaigns[3]->id,
                'receipt_number' => null,
                'donor_name' => 'Amit Patel',
                'donor_email' => 'amit.patel@example.com',
                'donor_phone' => '9825098765',
                'donor_pan' => null,
                'donor_address' => 'Navrangpura, Ahmedabad',
                'amount' => 1500.00,
                'payment_mode' => 'upi_qr',
                'utr_number' => 'UTR202601260011',
                'donor_message' => 'Meal sponsorship.',
                'is_anonymous' => false,
                'status' => 'pending',
                'verified_by' => null,
                'verified_at' => null,
            ],
            [
                'campaign_id' => $createdCampaigns[1]->id,
                'receipt_number' => 'KSF-2026-0106',
                'donor_name' => 'Anonymous Donor',
                'donor_email' => 'donor.anon@example.com',
                'donor_phone' => '9111223344',
                'donor_pan' => null,
                'donor_address' => null,
                'amount' => 7500.00,
                'payment_mode' => 'upi_qr',
                'utr_number' => 'UTR202601270094',
                'donor_message' => 'May every child receive quality education.',
                'is_anonymous' => true,
                'status' => 'verified',
                'verified_by' => $admin->id,
                'verified_at' => now()->subDays(2),
            ],
        ];

        foreach ($donationsData as $don) {
            Donation::updateOrCreate(
                ['utr_number' => $don['utr_number']],
                $don
            );
        }

        // 6. Seed Fund Distributions (Ground Proofs & Audit Ledger)
        $distributionsData = [
            [
                'campaign_id' => $createdCampaigns[0]->id,
                'title' => 'Oxygen Concentrators & Flowmeters Procurement',
                'beneficiary_name' => 'Kashi Medical Gases & Equipments Ltd',
                'amount_spent' => 60000.00,
                'distribution_date' => now()->subDays(12)->toDateString(),
                'payment_reference' => 'NEFT-KMG-2026-0441',
                'proof_bill_image' => $defaultBill,
                'impact_photos' => [$defaultImpact],
                'description' => 'Procured 6 certified 10-liter medical oxygen concentrators and 12 dual-stage flowmeters for rural district clinics.',
                'is_public' => true,
                'created_by' => $admin->id,
            ],
            [
                'campaign_id' => $createdCampaigns[2]->id,
                'title' => '150 Heavy Woolen Blankets Procurement',
                'beneficiary_name' => 'Varanasi Handloom Textile Cooperative',
                'amount_spent' => 35000.00,
                'distribution_date' => now()->subDays(8)->toDateString(),
                'payment_reference' => 'UPI-VTC-9921',
                'proof_bill_image' => $defaultBill,
                'impact_photos' => [$defaultImpact],
                'description' => 'Procured 150 heavy double-layer wool blankets distributed across Assi Ghat and Dashashwamedh Ghat night shelters.',
                'is_public' => true,
                'created_by' => $admin->id,
            ],
            [
                'campaign_id' => $createdCampaigns[1]->id,
                'title' => 'Stationery, Notebooks & Digital Tablets Distribution',
                'beneficiary_name' => 'Sarvodaya Vidyalaya Rural Trust',
                'amount_spent' => 80000.00,
                'distribution_date' => now()->subDays(5)->toDateString(),
                'payment_reference' => 'IMPS-SVT-8812',
                'proof_bill_image' => $defaultBill,
                'impact_photos' => [$defaultImpact],
                'description' => 'Equipped 120 rural schoolgirls with annual textbook sets, geometry boxes, and 5 shared digital learning tablets.',
                'is_public' => true,
                'created_by' => $admin->id,
            ],
            [
                'campaign_id' => $createdCampaigns[4]->id,
                'title' => 'High-Capacity RO Water Purification System Installation',
                'beneficiary_name' => 'AquaPure Engineering Solutions',
                'amount_spent' => 110000.00,
                'distribution_date' => now()->subDays(2)->toDateString(),
                'payment_reference' => 'RTGS-APES-3312',
                'proof_bill_image' => $defaultBill,
                'impact_photos' => [$defaultImpact],
                'description' => 'Completed civil foundation and membrane filtration fitting of 500 LPH community drinking water plant.',
                'is_public' => true,
                'created_by' => $admin->id,
            ],
        ];

        foreach ($distributionsData as $dist) {
            FundDistribution::updateOrCreate(
                ['title' => $dist['title'], 'distribution_date' => $dist['distribution_date']],
                $dist
            );
        }

        // 7. Seed Upcoming Community Events
        $eventsData = [
            [
                'title' => 'Ganga Riverbank Cleanliness & Eco-Conservation Drive',
                'slug' => 'ganga-riverbank-cleanliness-drive',
                'description' => 'Join over 50 dedicated volunteers in cleaning ghat steps, removing floating non-biodegradable waste, and planting indigenous riverbank saplings along Assi Ghat.',
                'banner_image' => $defaultEventBanner,
                'location_name' => 'Assi Ghat Steps',
                'address' => 'Assi Ghat, Shivala, Varanasi, Uttar Pradesh - 221005',
                'google_map_link' => 'https://maps.google.com/?q=Assi+Ghat+Varanasi',
                'event_date' => now()->addDays(5)->toDateString(),
                'start_time' => '06:30:00',
                'end_time' => '09:30:00',
                'max_participants' => 75,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Free Community Eye Screening & Cataract Health Camp',
                'slug' => 'community-eye-screening-camp',
                'description' => 'Professional ophthalmologists and optometrists providing free comprehensive vision tests, subsidized eyeglasses, and fully sponsored cataract surgical consultations for elderly citizens.',
                'banner_image' => $defaultEventBanner,
                'location_name' => 'Community Health Center, Kabir Nagar',
                'address' => 'Kabir Nagar Health Post, Bhelupur, Varanasi, Uttar Pradesh - 221004',
                'google_map_link' => 'https://maps.google.com/?q=Bhelupur+Varanasi',
                'event_date' => now()->addDays(12)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '16:00:00',
                'max_participants' => 150,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Winter Warm Clothing & Nutritious Ration Camp',
                'slug' => 'winter-warm-clothing-camp',
                'description' => 'Direct volunteer distribution of warm wool sweaters, thermal caps, and 10kg essential foodgrain dry ration kits to flood-affected families.',
                'banner_image' => $defaultEventBanner,
                'location_name' => 'Rajghat Primary School Grounds',
                'address' => 'Near Malviya Bridge, Rajghat, Varanasi - 221001',
                'google_map_link' => 'https://maps.google.com/?q=Rajghat+Varanasi',
                'event_date' => now()->addDays(20)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '14:00:00',
                'max_participants' => 100,
                'status' => 'upcoming',
            ],
        ];

        $createdEvents = [];
        foreach ($eventsData as $event) {
            $createdEvents[] = Event::updateOrCreate(['slug' => $event['slug']], $event);
        }

        // 8. Seed Screened Volunteers
        $volunteersData = [
            [
                'volunteer_code' => 'KSF-VOL-2026-0101',
                'full_name' => 'Pooja Tiwari',
                'email' => 'pooja.tiwari@example.com',
                'phone' => '9111122222',
                'city' => 'Varanasi',
                'address' => 'Lane 4, Assi, Varanasi, UP',
                'occupation' => 'College Lecturer',
                'skills' => ['first_aid', 'event_management'],
                'availability' => 'weekends',
                'profile_photo' => null,
                'id_proof_path' => null,
                'status' => 'approved',
                'joined_at' => now()->subDays(60)->toDateString(),
            ],
            [
                'volunteer_code' => 'KSF-VOL-2026-0102',
                'full_name' => 'Rohan Verma',
                'email' => 'rohan.verma@example.com',
                'phone' => '9222233333',
                'city' => 'Lucknow',
                'address' => 'Gomti Nagar, Lucknow, UP',
                'occupation' => 'Software Engineer',
                'skills' => ['teaching', 'digital_marketing'],
                'availability' => 'flexible',
                'profile_photo' => null,
                'id_proof_path' => null,
                'status' => 'approved',
                'joined_at' => now()->subDays(45)->toDateString(),
            ],
            [
                'volunteer_code' => 'KSF-VOL-2026-0103',
                'full_name' => 'Meera Sen',
                'email' => 'meera.sen@example.com',
                'phone' => '9333344444',
                'city' => 'Varanasi',
                'address' => 'Sigra, Varanasi, UP',
                'occupation' => 'Social Worker',
                'skills' => ['photography', 'counseling'],
                'availability' => 'weekdays',
                'profile_photo' => null,
                'id_proof_path' => null,
                'status' => 'approved',
                'joined_at' => now()->subDays(30)->toDateString(),
            ],
            [
                'volunteer_code' => 'KSF-VOL-2026-0104',
                'full_name' => 'Kavita Reddy',
                'email' => 'kavita.reddy@example.com',
                'phone' => '9444455555',
                'city' => 'Kanpur',
                'address' => 'Swaroop Nagar, Kanpur, UP',
                'occupation' => 'Doctor (MBBS)',
                'skills' => ['logistics', 'first_aid'],
                'availability' => 'weekends',
                'profile_photo' => null,
                'id_proof_path' => null,
                'status' => 'approved',
                'joined_at' => now()->subDays(15)->toDateString(),
            ],
            [
                'volunteer_code' => null,
                'full_name' => 'Arun Joshi',
                'email' => 'arun.joshi@example.com',
                'phone' => '9555566666',
                'city' => 'Varanasi',
                'address' => 'Lanka, Varanasi, UP',
                'occupation' => 'Student',
                'skills' => ['teaching', 'community_outreach'],
                'availability' => 'weekends',
                'profile_photo' => null,
                'id_proof_path' => null,
                'status' => 'pending',
                'joined_at' => null,
            ],
        ];

        $createdVolunteers = [];
        foreach ($volunteersData as $vol) {
            $createdVolunteers[] = Volunteer::updateOrCreate(['email' => $vol['email']], $vol);
        }

        // 9. Seed Event Registrations
        if (! empty($createdEvents) && ! empty($createdVolunteers)) {
            EventRegistration::updateOrCreate(
                ['event_id' => $createdEvents[0]->id, 'participant_email' => 'pooja.tiwari@example.com'],
                [
                    'participant_name' => 'Pooja Tiwari',
                    'participant_phone' => '9111122222',
                    'volunteer_id' => $createdVolunteers[0]->id,
                    'role_assigned' => 'Logistics Team Lead',
                    'attendance_status' => 'registered',
                ]
            );

            EventRegistration::updateOrCreate(
                ['event_id' => $createdEvents[0]->id, 'participant_email' => 'kavita.reddy@example.com'],
                [
                    'participant_name' => 'Dr. Kavita Reddy',
                    'participant_phone' => '9444455555',
                    'volunteer_id' => $createdVolunteers[3]->id,
                    'role_assigned' => 'First Aid Coordinator',
                    'attendance_status' => 'registered',
                ]
            );
        }

        // 10. Seed Realistic Contact Inquiries
        $inquiriesData = [
            [
                'name' => 'Harish Chandra',
                'email' => 'harish@example.com',
                'phone' => '+91 9888877771',
                'subject' => 'Corporate CSR Partnership Inquiry',
                'message' => 'Our technology firm wants to sponsor 2 community drinking water RO plants under our annual CSR initiative. Please share the formal proposal and 80G tax exemption documents.',
                'status' => 'read',
            ],
            [
                'name' => 'Dr. Shalini Singh',
                'email' => 'shalini@example.com',
                'phone' => '+91 9888877772',
                'subject' => 'Volunteering for Medical Camps',
                'message' => 'I am a practicing pediatrician in Varanasi. Would love to volunteer my free time during weekend health camps.',
                'status' => 'replied',
            ],
            [
                'name' => 'Manish Aggarwal',
                'email' => 'manish@example.com',
                'phone' => '+91 9888877773',
                'subject' => 'Donation Verification Query',
                'message' => 'Transferred ₹10,000 via NEFT yesterday morning. Submitted UTR number. Kindly confirm receipt issuance.',
                'status' => 'pending',
            ],
        ];

        foreach ($inquiriesData as $inq) {
            ContactInquiry::updateOrCreate(
                ['email' => $inq['email'], 'subject' => $inq['subject']],
                $inq
            );
        }
    }
}
