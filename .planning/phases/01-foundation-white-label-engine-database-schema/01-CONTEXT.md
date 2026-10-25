# Phase 1: Foundation, White-Label Engine & Database Schema - Context

**Gathered:** 2026-10-25  
**Status:** Ready for planning

<domain>
## Phase Boundary

Phase 1 delivers the architectural bedrock of the NGO platform:
1. Complete database migrations for all 10 schema tables with foreign keys and indexes.
2. Eloquent models with typed relationships, attribute casting, mass-assignment protection, and helper scopes.
3. Global cached `setting($key, $default)` helper function in `app/helpers.php` with automatic cache busting on model save/delete.
4. Dynamic CSS variable theming foundation (`--color-primary`, `--color-secondary`) hooked into Tailwind/Blade base layout.
5. Turnkey client onboarding seeder (`NgoWhiteLabelSeeder`) with default categories, white-label settings keys, and super admin account.
</domain>

<decisions>
## Implementation Decisions

### Database Schema (10 Tables)
- **D-01:** Implement 10 relational tables:
  1. `users`: Admins & managers with `role` ENUM (`super_admin`, `manager`), `is_active`.
  2. `cause_categories`: Name, unique slug, optional icon, `is_active`.
  3. `campaigns`: Category FK, title, unique slug, short description, full story, thumbnail image, JSON gallery images, goal amount, cached `raised_amount` (default 0), cached `distributed_amount` (default 0), start/end dates, featured flag, urgent flag, status ENUM (`draft`, `active`, `completed`, `paused`).
  4. `payment_methods`: Type ENUM (`upi_qr`, `bank_account`), label, upi_id, qr_image_path, bank_name, account_holder_name, account_number, ifsc_code, branch_name, `is_active`, `display_order`.
  5. `donations`: Campaign FK (nullable for general fund), unique receipt_number (nullable until verified), donor_name, donor_email, donor_phone, donor_pan, donor_address, amount, payment_mode ENUM (`upi_qr`, `bank_transfer`, `cash`), unique indexed `utr_number`, payment_screenshot path, donor_message, `is_anonymous` boolean, status ENUM (`pending`, `verified`, `rejected`), admin_remarks, verified_by FK, verified_at timestamp.
  6. `fund_distributions`: Campaign FK (nullable for general expense), title, beneficiary_name, amount_spent, distribution_date, payment_reference, proof_bill_image, JSON impact_photos, description, `is_public` boolean, created_by FK.
  7. `events`: Title, unique slug, description, banner_image, location_name, address, google_map_link, event_date, start_time, end_time, max_participants, status ENUM (`upcoming`, `ongoing`, `completed`, `cancelled`).
  8. `volunteers`: Unique volunteer_code (nullable until approved), full_name, email, phone, city, address, occupation, JSON skills, availability ENUM (`weekdays`, `weekends`, `flexible`), profile_photo, id_proof_path, status ENUM (`pending`, `approved`, `rejected`, `inactive`), joined_at.
  9. `event_registrations`: Event FK, volunteer FK (nullable), participant_name, participant_phone, participant_email, role_assigned, attendance_status ENUM (`registered`, `attended`, `absent`).
  10. `site_settings`: Unique key, longtext value, group ('branding', 'receipt_legal', 'contact', 'hero_cms', 'social').

### Global White-Label Settings Engine
- **D-02:** Store configuration in `site_settings` table as key-value pairs.
- **D-03:** Provide global helper `setting($key, $default = null)` in `app/helpers.php` (registered via `composer.json` autoload `files` array).
- **D-04:** Cache all site settings forever using `Cache::rememberForever('site_settings', ...)` as a key-value associative array for zero database query overhead on web requests.
- **D-05:** Register `SiteSetting` Eloquent model observers/events (`saved`, `deleted`) to automatically execute `Cache::forget('site_settings')`.

### Dynamic Theming & Styling Engine
- **D-06:** Define CSS custom properties (`:root { --color-primary: ...; --color-secondary: ...; }`) in master layout `resources/views/layouts/base.blade.php` pulling values from `setting('primary_color', '#16a34a')` and `setting('secondary_color', '#0f172a')`.
- **D-07:** Configure Tailwind CSS in `resources/css/app.css` and `vite.config.js` to reference the dynamic CSS variables (`var(--color-primary)` and `var(--color-secondary)`).

### Turnkey Client Onboarding Seeder
- **D-08:** Create `NgoWhiteLabelSeeder` that seeds:
  - Super Admin (`admin@ksf.org` / `password123`).
  - Default cause categories: Medical Aid, Child Education, Winter Relief Drive, Food & Nutrition, Disaster Recovery.
  - Standard White-Label Keys:
    - Branding: `ngo_name`, `ngo_tagline`, `logo_path`, `primary_color` (`#16a34a`), `secondary_color` (`#0f172a`).
    - Receipt & Legal: `receipt_prefix` (`KSF`), `volunteer_prefix` (`KSF-VOL`), `ngo_reg_number`, `ngo_pan_number`, `has_80g` (`1`), `80g_reg_number`, `authorized_sign_image`, `authorized_sign_name`.
    - Contact: `contact_email`, `contact_phone`, `contact_address`, `office_city`.
    - Hero CMS: `hero_title`, `hero_subtitle`, `hero_cta_text`.
    - Social: `facebook_url`, `instagram_url`, `youtube_url`, `whatsapp_number`.
  - Storage link creation (`php artisan storage:link`).
</decisions>

<canonical_refs>
## Canonical References
- Schema blueprints and architectural rules from project definition.
- Laravel 12 documentation on migrations, Eloquent relationships, model events, and caching.
</canonical_refs>
