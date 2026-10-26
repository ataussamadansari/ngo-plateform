# Project State

## Project Reference

See: [.planning/PROJECT.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/PROJECT.md) (updated 2026-10-26)

**Core value:** Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated compliance receipts.  
**Current focus:** Milestone v1.1 Complete — Native FilamentPHP Back-Office Migration & White-Label Administration  
**Next action:** Milestone complete! All 12 phases executed and verified. Ready for next milestone or production deployment.

## Current Position

- **Milestone**: v1.1
- **Phase**: 12 of 12 (Executive Dashboard Widgets, Legacy Deprecation & Verification)
- **Status**: Completed (All 2 plans executed and verified: 12-01, 12-02)
- **Mode**: Vertical MVP (`PROJECT_MODE=mvp`)
- **Blockers**: None

## Phase 12 Plans (Completed)

- [x] [12-01-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/12-executive-dashboard-widgets-legacy-deprecation-verification/12-01-PLAN.md) — Wave 1: Native Filament Executive Dashboard Widgets & Contact Inquiries Resource (FIL-09)
- [x] [12-02-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/12-executive-dashboard-widgets-legacy-deprecation-verification/12-02-PLAN.md) — Wave 2: Complete Legacy Admin Deprecation, Route Cleanup & System Verification (FIL-10)

## Phase 11 Plans (Completed)

- [x] [11-01-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/11-core-operations-migration/11-01-PLAN.md) — Wave 1: Native Filament `CampaignResource` & `CauseCategoryResource` (FIL-06)
- [x] [11-02-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/11-core-operations-migration/11-02-PLAN.md) — Wave 2: Native Filament `DonationResource` with Side-by-Side Proof & 80G Receipt (FIL-04)
- [x] [11-03-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/11-core-operations-migration/11-03-PLAN.md) — Wave 2: Native Filament `FundDistributionResource` with Ledger & Proof Uploads (FIL-05)
- [x] [11-04-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/11-core-operations-migration/11-04-PLAN.md) — Wave 3: Native Filament `VolunteerResource` & `EventResource` with Attendance Roster (FIL-07, FIL-08)

## Phase 10 Plans (Completed)

- [x] [10-01-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/10-white-label-settings-payment-methods-resources/10-01-PLAN.md) — Wave 1: Native Filament `SiteSetting` White-Label Administration Engine (FIL-02)
- [x] [10-02-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/10-white-label-settings-payment-methods-resources/10-02-PLAN.md) — Wave 2: Native Filament `PaymentMethodResource` (UPI QR & Bank Accounts) (FIL-03)

## Phase 9 Plans (Completed)

- [x] [09-01-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/09-native-filament-panel-setup-auth-route-release/09-01-PLAN.md) — Wave 1: Native Filament Panel Provider Setup, FilamentUser Auth & Route Release (FIL-01, FIL-10)

## Milestone v1.1 Phases

- [x] **Phase 9**: Native Filament Panel Setup, Auth & Route Release (FIL-01, FIL-10)
- [x] **Phase 10**: White-Label Settings & Payment Methods Resources (FIL-02, FIL-03)
- [x] **Phase 11**: Core Operations Migration (Donations, Ledger, Causes, Volunteers, Events) (FIL-04, FIL-05, FIL-06, FIL-07, FIL-08)
- [x] **Phase 12**: Executive Dashboard Widgets, Legacy Deprecation & Verification (FIL-09, FIL-10)

## Completed Milestones

- **v1.0 (Core MVP)**: Shipped 2026-10-25 (8 phases, 16 plans, 86 feature tests passed).
  - Archived Roadmap: [.planning/milestones/v1.0-ROADMAP.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/milestones/v1.0-ROADMAP.md)
  - Archived Requirements: [.planning/milestones/v1.0-REQUIREMENTS.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/milestones/v1.0-REQUIREMENTS.md)

## Accumulated Context

- **Tech Stack**: Laravel 12, PHP 8.2+, MySQL/SQLite, Blade, Tailwind CSS, Alpine.js, FilamentPHP 5, barryvdh/laravel-dompdf.
- **Architecture**: Monolithic modular white-label system with cached `setting()` helper, CSS variable theming (`--color-primary`, `--color-secondary`), public Blade views, and native FilamentPHP panel for back-office administration.
- **Execution Guardrails**:
  - `DB::transaction()` mandatory for all donation verifications and fund distributions.
  - Unique index and validation on `utr_number`.
  - Rate limiting (`throttle:5,1`) on public donation and volunteer endpoints.
  - File upload limits: max 2MB (jpg/png/webp) for payment proof and bills.
  - 1-command client onboarding via `NgoWhiteLabelSeeder`.
