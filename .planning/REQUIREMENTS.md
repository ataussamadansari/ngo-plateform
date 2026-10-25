# Requirements: NGO Dynamic Website & Donation Management Platform

**Defined:** 2026-10-25  
**Core Value:** Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated compliance receipts.

## v1 Requirements

Requirements for initial release. Each maps to roadmap phases.

### Foundation & Schema Architecture (FND)

- [ ] **FND-01**: Database migrations for all 10 schema tables (users, cause_categories, campaigns, payment_methods, donations, fund_distributions, events, volunteers, event_registrations, site_settings) with foreign keys and indexes.
- [ ] **FND-02**: Eloquent models with typed relationships, casts, and helper scopes.
- [ ] **FND-03**: Global helper function `setting($key, $default)` backed by `Cache::rememberForever()` with automatic cache busting on settings update.
- [ ] **FND-04**: One-command client onboarding seeder (`NgoWhiteLabelSeeder`) generating default categories, white-label settings, and super admin account.

### White-Label Branding & Theming (WHT)

- [ ] **WHT-01**: Admin can configure NGO identity (name, tagline, logo, favicon, registration number, PAN number).
- [ ] **WHT-02**: Dynamic CSS variable theming (`--color-primary`, `--color-secondary`) applied across all public views based on saved settings.
- [ ] **WHT-03**: Compliance settings for 80G tax exemption (toggle, 80G registration number, digital signature image, authorized signatory name).
- [ ] **WHT-04**: Customizable receipt prefix (e.g. "KSF") and volunteer prefix (e.g. "KSF-VOL") dynamically used in code generation.

### Payment Methods & Manual Donations (DON)

- [ ] **DON-01**: Admin can manage multiple payment methods (active UPI QR code image, UPI ID, Bank name, account number, IFSC code, branch).
- [ ] **DON-02**: Donor can view active payment methods and copyable bank details on donation page.
- [ ] **DON-03**: Donor can submit manual donation proof (name, email, phone, optional PAN, amount, payment mode, UTR number, screenshot image, message, anonymous flag).
- [ ] **DON-04**: System enforces unique UTR numbers to prevent duplicate donation submissions.
- [ ] **DON-05**: Public donation submission endpoint is rate-limited (`throttle:5,1`) and screenshot uploads restricted to 2MB (jpg/png/webp).
- [ ] **DON-06**: Donor can look up verification status via UTR number or Phone + Receipt Number.

### Admin Verification & PDF Receipts (VER)

- [ ] **VER-01**: Admin can view pending donations queue with filters for status, payment mode, campaign, and date.
- [ ] **VER-02**: Admin can preview uploaded payment screenshot and donor UTR side-by-side in verification view.
- [ ] **VER-03**: Admin can approve donation in a `DB::transaction()` that updates status to verified, assigns unique receipt number, and increments campaign `raised_amount`.
- [ ] **VER-04**: Admin can reject donation with explanatory remarks.
- [ ] **VER-05**: Admin can record offline/cash donations directly marked as verified.
- [ ] **VER-06**: Verified donors can download an official PDF receipt featuring NGO logo, 80G details, donor details, and authorized digital signature stamp.

### Fund Distribution & Transparency (DIS)

- [ ] **DIS-01**: Admin can record fund distribution entries (linked campaign or general fund, beneficiary name, amount spent, date, category, invoice/bill image, impact photos, description, public toggle).
- [ ] **DIS-02**: Distribution creation runs inside a `DB::transaction()` that automatically updates the linked campaign's `distributed_amount`.
- [ ] **DIS-03**: Public can access transparency ledger page displaying financial summary and itemized verified distributions with bills and photos.
- [ ] **DIS-04**: Campaign detail page displays a dedicated fund utilization breakdown for that specific campaign.

### Causes & Campaigns Management (CMP)

- [ ] **CMP-01**: Admin can manage cause categories (Medical, Education, Disaster Relief, etc.).
- [ ] **CMP-02**: Admin can create and manage campaigns (title, slug, category, target amount, story, thumbnail, gallery, dates, urgent flag, status).
- [ ] **CMP-03**: Public can browse campaigns with category and status filters.
- [ ] **CMP-04**: Public can view detailed campaign story with live progress bar (target vs verified raised), recent verified donors, and fund utilization breakdown.

### Volunteers & Events System (VOL)

- [ ] **VOL-01**: Public can submit volunteer application (name, contact, city, skills, availability, profile photo, ID proof).
- [ ] **VOL-02**: Admin can review volunteer applications and approve/reject them.
- [ ] **VOL-03**: Approved volunteers receive a unique volunteer code (e.g. `KSF-VOL-2026-001`).
- [ ] **VOL-04**: Admin can manage events (title, date/time, venue, google map link, max participants, banner, status).
- [ ] **VOL-05**: Visitors and volunteers can register for upcoming events.
- [ ] **VOL-06**: Admin can track event participants and mark attendance.

### Public Website & Themed Frontend (PUB)

- [ ] **PUB-01**: Responsive Home page featuring dynamic hero banner, impact counter cards, featured urgent campaigns, recent transparency highlights, and upcoming events.
- [ ] **PUB-02**: About Us page featuring NGO mission/vision, founder/team info, and registration certificates preview (NGO Darpan, 80G, 12A).
- [ ] **PUB-03**: Global responsive navigation bar and dynamic footer with legal disclaimers, tax exemption notes, and social media links.
- [ ] **PUB-04**: Contact Us section with direct inquiry submission and office map.

### Back-Office Admin Dashboard (ADM)

- [ ] **ADM-01**: Financial overview dashboard cards (Total Verified Funds, Total Distributed Funds, Available Balance, Pending Verifications Count).
- [ ] **ADM-02**: Quick-action queue for pending donation proofs and volunteer applications directly on dashboard.
- [ ] **ADM-03**: FilamentPHP back-office integration with role-based access control (Super Admin, Manager).

## v2 Requirements

Deferred to future release. Tracked but not in current roadmap.

### Payment Gateways & Automated Webhooks

- **PAY-01**: Razorpay / Stripe automated payment gateway fallback for international donors.
- **PAY-02**: Bank webhook integration for automated UTR reconciliation.

### Automated Notifications

- **NTF-01**: Automated WhatsApp message with PDF receipt link sent upon donation verification.
- **NTF-02**: Automated SMS/Email alerts for event reminders and campaign milestones.

### Volunteer Portal Self-Service

- **VOL-V2-01**: Volunteer login portal to view assigned drives and download digital volunteer ID card.
- **VOL-V2-02**: Volunteer certificate generator upon completion of community hours.

## Out of Scope

Explicitly excluded. Documented to prevent scope creep.

| Feature | Reason |
|---------|--------|
| Payment Gateway Integration (Razorpay/Stripe) | Avoids transaction fees (2-3%) and regulatory KYC delays; manual QR verification provides full fee-free autonomy for NGOs. |
| Multi-tenant Single Database Architecture | Individual isolated deployments per client eliminate data co-mingling risks and simplify white-label resell packages. |
| Real-time Donor Chat | High operational overhead for small NGO volunteer teams; inquiry form and WhatsApp links suffice. |
| Native Mobile Apps (iOS/Android) | Responsive mobile-optimized web views cover 100% of donor and admin journeys without app store overhead. |

## Traceability

Which phases cover which requirements.

| Requirement | Phase | Status |
|-------------|-------|--------|
| FND-01 | Phase 1 | Pending |
| FND-02 | Phase 1 | Pending |
| FND-03 | Phase 1 | Pending |
| FND-04 | Phase 1 | Pending |
| WHT-01 | Phase 1 | Pending |
| WHT-02 | Phase 1 | Pending |
| WHT-03 | Phase 1 | Pending |
| WHT-04 | Phase 1 | Pending |
| DON-01 | Phase 2 | Pending |
| DON-02 | Phase 2 | Pending |
| DON-03 | Phase 2 | Pending |
| DON-04 | Phase 2 | Pending |
| DON-05 | Phase 2 | Pending |
| DON-06 | Phase 2 | Pending |
| VER-01 | Phase 3 | Pending |
| VER-02 | Phase 3 | Pending |
| VER-03 | Phase 3 | Pending |
| VER-04 | Phase 3 | Pending |
| VER-05 | Phase 3 | Pending |
| VER-06 | Phase 3 | Pending |
| DIS-01 | Phase 4 | Pending |
| DIS-02 | Phase 4 | Pending |
| DIS-03 | Phase 4 | Pending |
| DIS-04 | Phase 4 | Pending |
| CMP-01 | Phase 5 | Pending |
| CMP-02 | Phase 5 | Pending |
| CMP-03 | Phase 5 | Pending |
| CMP-04 | Phase 5 | Pending |
| VOL-01 | Phase 6 | Pending |
| VOL-02 | Phase 6 | Pending |
| VOL-03 | Phase 6 | Pending |
| VOL-04 | Phase 6 | Pending |
| VOL-05 | Phase 6 | Pending |
| VOL-06 | Phase 6 | Pending |
| PUB-01 | Phase 7 | Pending |
| PUB-02 | Phase 7 | Pending |
| PUB-03 | Phase 7 | Pending |
| PUB-04 | Phase 7 | Pending |
| ADM-01 | Phase 8 | Pending |
| ADM-02 | Phase 8 | Pending |
| ADM-03 | Phase 8 | Pending |

**Coverage:**
- v1 requirements: 41 total
- Mapped to phases: 41
- Unmapped: 0 ✓

---
*Requirements defined: 2026-10-25*  
*Last updated: 2026-10-25 after initial definition*
