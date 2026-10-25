# Roadmap: Milestone v1.1 — Native FilamentPHP Back-Office Migration & White-Label Administration

## Milestone Summary

- **Milestone**: v1.1
- **Focus**: Migrate from custom `/admin` Blade controllers to native FilamentPHP 5, build complete Admin UIs for `SiteSetting` and `PaymentMethod`, implement native Filament resources for all core operations, and cleanly deprecate legacy custom admin code.
- **Previous Milestone**: [Milestone v1.0 (Core MVP)](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/milestones/v1.0-ROADMAP.md) — Shipped 2026-10-25 (8 phases, 86 tests passed).

---

## Phase Summary

| Phase | Name | Goal | Requirements | Success Criteria |
|---|---|---|---|---|
| 9 | Native Filament Panel Setup, Auth & Route Release | Configure FilamentPHP 5 AdminPanelProvider at `/admin`, implement `FilamentUser` on `User`, release custom `/admin` routes from `web.php` | FIL-01, FIL-10 | 4 |
| 10 | White-Label Settings & Payment Methods Resources | Build Filament UI for `SiteSetting` (branding, color pickers, tax credentials, logo/signature) and `PaymentMethodResource` (UPI QR/bank accounts) | FIL-02, FIL-03 | 4 |
| 11 | Core Operations Migration (Donations, Ledger, Causes, Volunteers, Events) | Build native Filament resources for Donations (side-by-side verification, 80G receipt), Distributions, Campaigns, Volunteers, and Events | FIL-04, FIL-05, FIL-06, FIL-07, FIL-08 | 5 |
| 12 | Executive Dashboard Widgets, Legacy Deprecation & Verification | Build native Filament dashboard widgets, remove legacy `app/Http/Controllers/Admin` and Blade views, verify full test suite | FIL-09, FIL-10 | 4 |

---

## Phase Details

### Phase 9: Native Filament Panel Setup, Auth & Route Release
**Status:** Completed (2026-10-26)  
**Goal:** Initialize FilamentPHP 5 `AdminPanelProvider` mounted at `/admin`, implement `FilamentUser` on `App\Models\User` with role gating, and remove conflicting custom admin routes from `routes/web.php`.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** FIL-01, FIL-10  
**Success Criteria:**
1. `AdminPanelProvider` is registered and loads natively at `/admin/login` and `/admin`.
2. `App\Models\User` implements `FilamentUser`, allowing `super_admin` and `manager` access while denying inactive accounts.
3. Conflicting custom `/admin` routes (`login`, `logout`, custom middleware) in `routes/web.php` are cleanly removed or redirected so Filament natively owns `/admin`.
4. Global layout admin command bar reflects native Filament dashboard and logout routes.

---

### Phase 10: White-Label Settings & Payment Methods Resources
**Status:** Completed (2026-10-26)  
**Goal:** Create full administrative interfaces for `SiteSetting` (dynamic theme colors, branding, tax credentials, logo/signature uploads) and `PaymentMethodResource` (UPI QR codes, bank accounts).  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** FIL-02, FIL-03  
**Success Criteria:**
1. Dedicated Filament Settings page or resource allows modifying NGO legal name, contact details, PAN, 80G, 12A, and NGO Darpan registration.
2. Color picker inputs for primary (`--color-primary`) and secondary (`--color-secondary`) theme colors update live site theming.
3. Logo, favicon, and digital authorized signature can be uploaded via Filament FileUpload and save to public storage, invalidating settings cache automatically.
4. `PaymentMethodResource` provides full CRUD for dynamic UPI QR codes and bank account details with active status toggles.

---

### Phase 11: Core Operations Migration (Donations, Ledger, Causes, Volunteers, Events)
**Status:** Completed (2026-10-26)  
**Goal:** Implement native Filament resources for Donations, Fund Distributions, Causes/Campaigns, Volunteers, and Events with parity to v1.0 workflows.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** FIL-04, FIL-05, FIL-06, FIL-07, FIL-08  
**Success Criteria:**
1. `DonationResource` displays donor verification queue with status filters, side-by-side screenshot proof modal, atomic `DB::transaction()` approval with 80G receipt generation, and rejection remarks.
2. `FundDistributionResource` enables logging verified expenditures with invoice and impact photo uploads, atomically incrementing campaign distributed amount.
3. `CampaignResource` & `CauseCategoryResource` enable full campaign lifecycle management with thumbnail/gallery uploads and rich text story editing.
4. `VolunteerResource` provides screening table with sequential volunteer code generation (`VOL-YYYY-XXXX`) and applicant ID proof inspection.
5. `EventResource` enables event scheduling with banner upload and attendee RSVP RelationManager with 1-click attendance check-in.

---

### Phase 12: Executive Dashboard Widgets, Legacy Deprecation & Verification
**Goal:** Build native Filament executive summary widgets, delete legacy custom admin controllers and views, and achieve 100% test passing across the migrated platform.  
**Mode:** mvp  
**UI hint:** yes  
**Requirements:** FIL-09, FIL-10  
**Success Criteria:**
1. Filament Dashboard displays `FinancialOverviewWidget` with real-time stats: Total Raised, Total Distributed, Net Available Treasury, and Pending Verifications.
2. Quick-action widgets on the dashboard allow 1-click donation approval and volunteer screening.
3. Obsolete custom controllers (`app/Http/Controllers/Admin/*`) and obsolete custom Blade views (`resources/views/admin/*`) are completely deleted.
4. Automated feature test suite passes with full verification of Filament admin operations and public-facing features.

---
*Roadmap defined: 2026-10-26 for Milestone v1.1*
