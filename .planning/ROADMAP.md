# Roadmap: NGO Dynamic Website & Donation Management Platform

## Overview

A modular, vertical MVP roadmap organized into 8 focused phases. Each phase delivers a complete, testable capability for rapid execution and white-label client deployment.

## Phase Summary

| Phase | Name | Goal | Requirements | Success Criteria |
|---|---|---|---|---|
| 1 | Foundation, White-Label Engine & Database Schema | 10-table schema, Eloquent models, cached `setting()` helper, dynamic CSS variable system, and client onboarding seeder | FND-01..04, WHT-01..04 | 4 |
| 2 | Payment Methods & Public Manual Donation Engine | Active UPI QR & bank transfer display, manual proof submission, UTR deduplication, and status lookup | DON-01..06 | 4 |
| 3 | Admin Donation Verification & PDF Receipt Engine | Verification queue, side-by-side proof check, atomic `DB::transaction()` approval, and 80G compliance PDF receipts | VER-01..06 | 4 |
| 4 | Fund Distribution & Public Transparency Ledger | Expense ledger, bill/proof uploads, atomic campaign distribution balance sync, and public transparency page | DIS-01..04 | 4 |
| 5 | Causes & Campaigns Management Engine | Categories CRUD, rich campaign stories, live raised/distributed progress bars, and recent donors list | CMP-01..04 | 4 |
| 6 | Volunteers Onboarding & Event Management | Volunteer registration form, admin review queue, volunteer code generation, and event participant tracking | VOL-01..06 | 4 |
| 7 | Public Website Frontend & Dynamic Theming | High-conversion Home page, Impact counters, About Us with legal credentials, dynamic navigation and footer | PUB-01..04 | 4 |
| 8 | Back-Office Filament Admin Dashboard & Client Handover | Filament admin integration, financial analytics cards, quick-action queues, and turnkey client seeding verification | ADM-01..03 | 3 |

---

## Phase Details

### Phase 1: Foundation, White-Label Engine & Database Schema
**Goal:** Establish complete 10-table database schema, Eloquent models, global cached `setting()` helper, dynamic CSS variable system, and client onboarding seeder.  
**Mode:** mvp  
**UI hint:** no  
**Requirements:** FND-01, FND-02, FND-03, FND-04, WHT-01, WHT-02, WHT-03, WHT-04  
**Success Criteria:**
1. All 10 database migrations (users, cause_categories, campaigns, payment_methods, donations, fund_distributions, events, volunteers, event_registrations, site_settings) run cleanly with proper foreign keys and indexes.
2. Eloquent models are configured with strict casts, mass-assignment guards, and typed relationships.
3. Global helper `setting($key, $default)` retrieves cached values via `Cache::rememberForever()` and clears instantly upon settings mutation.
4. `php artisan db:seed --class=NgoWhiteLabelSeeder` sets up working default white-label keys, default cause categories, and super admin account.

---

### Phase 2: Payment Methods & Public Manual Donation Engine
**Goal:** Enable donor manual payment proof submission with UPI QR display, bank details, UTR deduplication, screenshot upload, and status lookup.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** DON-01, DON-02, DON-03, DON-04, DON-05, DON-06  
**Success Criteria:**
1. `/donate` route renders active UPI QR code image and copyable bank account fields (Account Number, IFSC, Bank Name).
2. Public submission form accepts donor details, validates unique UTR number, and enforces rate-limiting (`throttle:5,1`).
3. Payment screenshots are securely stored in `storage/app/public/donations` with max 2MB validation.
4. Donors can verify status (Pending / Verified / Rejected) at `/donation-status` using their UTR number or Phone.

---

### Phase 3: Admin Donation Verification & PDF Receipt Engine
**Goal:** Provide administrative verification queue with side-by-side proof preview, atomic approval, campaign balance increment, and 80G compliant PDF receipt download.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** VER-01, VER-02, VER-03, VER-04, VER-05, VER-06  
**Success Criteria:**
1. Admin view lists pending donations with filters by status, payment mode, campaign, and date.
2. Verification interface displays donor UTR number alongside the uploaded payment screenshot for quick bank statement matching.
3. Approving a donation executes in `DB::transaction()`, setting status to `verified`, generating a unique sequential receipt number (e.g. `KSF-2026-0001`), and incrementing campaign `raised_amount`.
4. Verified donors and admins can generate/download an official PDF receipt with NGO logo, donor PAN, 80G registration number, and digital signature stamp.

---

### Phase 4: Fund Distribution & Public Transparency Ledger
**Goal:** Enable recording of verified fund expenditures with invoice/bill uploads and provide a public transparency page with real-time utilization breakdown.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** DIS-01, DIS-02, DIS-03, DIS-04  
**Success Criteria:**
1. Admin can log fund distribution entries with beneficiary details, amount, category, invoice image, and impact photos.
2. Saving distribution automatically updates linked campaign's `distributed_amount` inside `DB::transaction()`.
3. Public `/transparency` page presents verified financial totals (Total Raised vs Distributed) and itemized public distribution cards.
4. Campaign detail page displays dedicated fund utilization breakdown for that specific cause.

---

### Phase 5: Causes & Campaigns Management Engine
**Goal:** Build end-to-end campaign creation, category management, urgent cause highlights, and live financial progress synchronization.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** CMP-01, CMP-02, CMP-03, CMP-04  
**Success Criteria:**
1. Admin can create, edit, and toggle status (draft, active, completed, paused) for donation campaigns.
2. Public `/campaigns` lists active and completed campaigns with category filtering.
3. Campaign detail view renders full rich story, photo gallery, target vs raised progress bar, and recent verified donors list.
4. Campaign financial fields (`raised_amount`, `distributed_amount`) stay perfectly synchronized with verified transactions.

---

### Phase 6: Volunteers Onboarding & Event Management
**Goal:** Facilitate volunteer registration, application screening, volunteer code generation, and event registration with attendance tracking.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** VOL-01, VOL-02, VOL-03, VOL-04, VOL-05, VOL-06  
**Success Criteria:**
1. Public `/volunteer-join` captures volunteer applications with city, skills, availability, and ID proof upload.
2. Admin review queue allows 1-click Approval/Rejection with automatic generation of formatted volunteer code (e.g. `KSF-VOL-2026-001`).
3. Admin can publish events with date, time, venue, and Google Map location.
4. Event registration form captures attendee details and allows admin to mark attendance (attended/absent).

---

### Phase 7: Public Website Frontend & Dynamic Theming
**Goal:** Build a high-trust, responsive public website with Home, About Us, Impact Counters, Navigation, and Footer styled with dynamic NGO branding.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** PUB-01, PUB-02, PUB-03, PUB-04  
**Success Criteria:**
1. Home page renders dynamic hero banner, live impact counter cards (Total Raised, Distributed, Volunteers, Causes), featured urgent causes, and upcoming events.
2. About Us page highlights NGO mission, vision, founder story, core team, and accreditation documents preview (NGO Darpan, 80G, 12A).
3. Global layout adopts dynamic CSS variables (`--color-primary`, `--color-secondary`) and renders responsive navigation and legal footer.
4. Mobile donor experience is fully responsive with frictionless navigation and sub-second SSR performance.

---

### Phase 8: Back-Office Filament Admin Dashboard & Client Handover
**Goal:** Integrate FilamentPHP admin panel with financial overview metrics, quick-action queues, and complete turnkey client setup validation.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** ADM-01, ADM-02, ADM-03  
**Success Criteria:**
1. Filament admin dashboard displays live metric cards: Total Verified Funds, Total Distributed Funds, Available Balance, and Pending Verifications Count.
2. Quick-action widgets allow verifying pending donations and reviewing volunteer applications directly from the dashboard.
3. White-label client handover verified: changing `.env` database and executing `php artisan migrate --seed` produces a ready-to-use NGO portal for a new client in under 60 seconds.

---
*Roadmap defined: 2026-10-25*
