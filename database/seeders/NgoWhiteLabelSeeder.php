<?php

namespace Database\Seeders;

use App\Models\CauseCategory;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NgoWhiteLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Default Super Admin User
        User::updateOrCreate(
            ['email' => 'admin@ksf.org'],
            [
                'name' => 'KSF Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'phone' => '+91 9876543210',
                'is_active' => true,
            ]
        );

        // 2. Default Cause Categories
        $categories = [
            [
                'name' => 'Medical Aid',
                'slug' => 'medical-aid',
                'icon' => 'heroicon-o-heart',
                'is_active' => true,
            ],
            [
                'name' => 'Child Education',
                'slug' => 'child-education',
                'icon' => 'heroicon-o-academic-cap',
                'is_active' => true,
            ],
            [
                'name' => 'Winter Relief Drive',
                'slug' => 'winter-relief-drive',
                'icon' => 'heroicon-o-sparkles',
                'is_active' => true,
            ],
            [
                'name' => 'Food & Nutrition',
                'slug' => 'food-and-nutrition',
                'icon' => 'heroicon-o-cake',
                'is_active' => true,
            ],
            [
                'name' => 'Disaster Recovery',
                'slug' => 'disaster-recovery',
                'icon' => 'heroicon-o-shield-check',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            CauseCategory::updateOrCreate(['slug' => $category['slug']], $category);
        }

        // 3. Standard White-Label Keys in site_settings
        $settings = [
            // Group: branding
            [
                'key' => 'ngo_name',
                'value' => 'Kashi Seva Foundation',
                'group' => 'branding',
            ],
            [
                'key' => 'ngo_tagline',
                'value' => 'Serving Humanity with Complete Transparency',
                'group' => 'branding',
            ],
            [
                'key' => 'logo_path',
                'value' => 'settings/logo.png',
                'group' => 'branding',
            ],
            [
                'key' => 'favicon_path',
                'value' => 'settings/favicon.ico',
                'group' => 'branding',
            ],
            [
                'key' => 'primary_color',
                'value' => '#16a34a',
                'group' => 'branding',
            ],
            [
                'key' => 'secondary_color',
                'value' => '#0f172a',
                'group' => 'branding',
            ],
            [
                'key' => 'total_lives_impacted',
                'value' => '12,500+',
                'group' => 'branding',
            ],
            [
                'key' => 'total_projects_completed',
                'value' => '150+',
                'group' => 'branding',
            ],

            // Group: receipt_legal
            [
                'key' => 'receipt_prefix',
                'value' => 'KSF',
                'group' => 'receipt_legal',
            ],
            [
                'key' => 'volunteer_prefix',
                'value' => 'KSF-VOL',
                'group' => 'receipt_legal',
            ],
            [
                'key' => 'ngo_reg_number',
                'value' => 'UP/2024/0045891',
                'group' => 'receipt_legal',
            ],
            [
                'key' => 'ngo_pan_number',
                'value' => 'AABTK1234F',
                'group' => 'receipt_legal',
            ],
            [
                'key' => 'has_80g',
                'value' => '1',
                'group' => 'receipt_legal',
            ],
            [
                'key' => '80g_reg_number',
                'value' => 'AABTK1234FF20241',
                'group' => 'receipt_legal',
            ],
            [
                'key' => 'fcra_number',
                'value' => '123456789',
                'group' => 'receipt_legal',
            ],
            [
                'key' => 'authorized_sign_image',
                'value' => 'settings/signature.png',
                'group' => 'receipt_legal',
            ],
            [
                'key' => 'authorized_sign_name',
                'value' => 'R. K. Sharma (President)',
                'group' => 'receipt_legal',
            ],

            // Group: contact
            [
                'key' => 'contact_email',
                'value' => 'contact@kashiseva.org',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+91 9876543210',
                'group' => 'contact',
            ],
            [
                'key' => 'contact_address',
                'value' => 'B-12, Assi Ghat Road, Varanasi, Uttar Pradesh - 221005',
                'group' => 'contact',
            ],
            [
                'key' => 'office_city',
                'value' => 'Varanasi',
                'group' => 'contact',
            ],
            [
                'key' => 'working_hours',
                'value' => 'Mon - Sat: 9:00 AM - 6:00 PM',
                'group' => 'contact',
            ],
            [
                'key' => 'google_map_embed_url',
                'value' => 'https://maps.google.com/maps?q=Assi+Ghat+Varanasi&t=&z=14&ie=UTF8&iwloc=&output=embed',
                'group' => 'contact',
            ],

            // Group: hero_cms
            [
                'key' => 'hero_title',
                'value' => 'Direct Impact, Zero Deductions, 100% Transparency',
                'group' => 'hero_cms',
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Every rupee you donate is verified against bank records and tracked directly to ground relief with proof bills.',
                'group' => 'hero_cms',
            ],
            [
                'key' => 'hero_cta_text',
                'value' => 'Donate Now',
                'group' => 'hero_cms',
            ],

            // Group: social
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com',
                'group' => 'social',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com',
                'group' => 'social',
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://youtube.com',
                'group' => 'social',
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com',
                'group' => 'social',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '919876543210',
                'group' => 'social',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                ]
            );
        }

        // 4. Default Payment Methods
        (new PaymentMethodSeeder)->run();
    }
}
