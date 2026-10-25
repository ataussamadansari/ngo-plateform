# Phase 7: Public Website Frontend & Dynamic Theming - Context

**Gathered:** 2026-10-25  
**Status:** Ready for planning  
**Mode:** MVP (Vertical Slice)

<domain>
## Phase Boundary

Phase 7 delivers the flagship public website experience, connecting all underlying functional modules (Campaigns, Donations, Transparency Ledger, Events, Volunteers) into a unified, high-trust, responsive digital presence:
1. **Dynamic Home Page (`/`)**:
   - Dynamic hero banner with customizable heading, subtitle, and primary call-to-action powered by `site_settings`.
   - Real-time live Impact Counter cards calculated directly from verified database records:
     - Total Verified Funds Raised (sum of verified donations)
     - Total Distributed on Ground (sum of fund distributions)
     - Mobilized Volunteers (count of approved active volunteers)
     - Active Causes & Initiatives Supported (count of active campaigns)
   - Featured Urgent Causes section showcasing high-priority campaigns with dynamic target vs. raised progress bars and 1-click donate triggers.
   - Ground Transparency Highlights displaying recent bill-backed distributions with direct link to the Transparency Ledger.
   - Upcoming Community Drives showcasing scheduled events with RSVP links.
   - Trust Pillars explaining zero platform fees, manual bank reconciliation, and 80G tax benefits.
2. **Global Navigation & Dynamic Theming (`layouts/base.blade.php`)**:
   - CSS custom property variables (`--color-primary`, `--color-secondary`) driving buttons, accents, badges, and focus rings.
   - Responsive top header with dynamic logo, title, and tagline.
   - Full desktop & mobile navigation bar with mobile hamburger drawer.
   - Dynamic footer displaying NGO registration credentials (Reg No, 80G Reg, 12A Reg, NGO Darpan ID), contact info, office address, social links, and legal tax exemption disclaimer.
3. **About Us Credibility Page (`/about`)**:
   - Mission, Vision, and Core Operating Principles.
   - Founder's Story and grassroots community background.
   - Accreditation & Compliance credentials showcase (NGO Darpan ID, 80G Certificate, 12A Registration, PAN).
   - Core leadership team structure and volunteer network profile.
4. **Contact Us & Inquiry Engine (`/contact`)**:
   - Office address, contact phone, contact email, and opening hours.
   - Direct Google Map integration link / embedded location card.
   - Visitor inquiry submission form protected by rate limiting (`throttle:5,1`).
   - Database storage in `contact_inquiries` table and administrative review queue (`/admin/inquiries`).
</domain>

<decisions>
## Implementation Decisions

### Home Page & Real-Time Aggregations (PUB-01, PUB-03)
- **D-01:** Implement `HomeController` (`app/Http/Controllers/HomeController.php`) managing the root route `GET /`:
  - Dynamically calculates verified financial metrics using Eloquent aggregations:
    - `$totalRaised = Donation::where('status', 'verified')->sum('amount');`
    - `$totalDistributed = FundDistribution::sum('amount');`
    - `$volunteerCount = Volunteer::where('status', 'approved')->count();`
    - `$activeCausesCount = Campaign::where('status', 'active')->count();`
  - Retrieves top urgent active campaigns (`is_urgent = true`, falling back to latest active if none flagged urgent) with category and verified donation sums.
  - Retrieves latest 3 verified distributions with photos and bills for ground impact proof.
  - Retrieves upcoming events (`Event::upcoming()->take(3)->get()`).
  - Passes aggregated data to `resources/views/welcome.blade.php`.
- **D-02:** Global Layout & Mobile Navigation Drawer:
  - Enhance `resources/views/layouts/base.blade.php` with an Alpine.js or vanilla JS responsive mobile menu drawer.
  - Add active link indicators for all primary routes (`Home`, `Causes`, `Events`, `Transparency`, `About Us`, `Contact Us`, `Volunteer`, `Donate`).
  - Expand footer with dynamic links (`facebook_url`, `instagram_url`, `youtube_url`, `whatsapp_number`) and legal tax exemption notices.

### About Us & Compliance Transparency (PUB-02)
- **D-03:** Dedicated About Us Route & View (`GET /about` -> `PageController@about`):
  - High-trust story layout highlighting organization history, vision, and operational principles.
  - Compliance accreditation showcase highlighting NGO Darpan ID (`setting('ngo_darpan_id')`), 80G tax exemption (`setting('80g_reg_number')`), 12A registration (`setting('12a_reg_number')`), and PAN.
  - Leadership and team spotlight cards.

### Contact Us & Inquiry Management (PUB-04)
- **D-04:** Dedicated Contact Page & Persistence:
  - Database table `contact_inquiries` with migration: `id`, `name`, `email`, `phone`, `subject`, `message`, `status` (`pending`, `read`, `replied`), `timestamps`.
  - Eloquent model `App\Models\ContactInquiry`.
  - Form request `App\Http\Requests\StoreContactInquiryRequest` with strict validation.
  - Public routes: `GET /contact` (`ContactController@index`) and `POST /contact` (`ContactController@store`, rate-limited `throttle:5,1`).
  - Admin management: `GET /admin/inquiries` and `PATCH /admin/inquiries/{inquiry}` for reviewing visitor inquiries and marking them as read or replied.
</decisions>

<canonical_refs>
## Canonical References
- Requirements: PUB-01, PUB-02, PUB-03, PUB-04 in `.planning/REQUIREMENTS.md`
- Site Settings: `branding`, `contact`, `receipt_legal`, `hero_cms`, `social` groups in `site_settings`
- Base Layout: `resources/views/layouts/base.blade.php`
</canonical_refs>
