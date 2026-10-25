# Project State

## Project Reference

See: [.planning/PROJECT.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/PROJECT.md) (updated 2026-10-25)

**Core value:** Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated compliance receipts.  
**Current focus:** Phase 1: Foundation, White-Label Engine & Database Schema

## Current Position

- **Phase**: 1 of 8 (Foundation, White-Label Engine & Database Schema)
- **Status**: Planned (2 plans ready: 01-01, 01-02)
- **Mode**: Vertical MVP (`PROJECT_MODE=mvp`)
- **Active Wave**: 1
- **Blockers**: None

## Phase 1 Plans

- [ ] [01-01-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/01-foundation-white-label-engine-database-schema/01-01-PLAN.md) — Wave 1: Database Schema Migrations & Eloquent Domain Models (FND-01, FND-02)
- [ ] [01-02-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/01-foundation-white-label-engine-database-schema/01-02-PLAN.md) — Wave 2: White-Label Settings Engine, Dynamic CSS Theming & Client Seeder (FND-03, FND-04, WHT-01, WHT-02, WHT-03, WHT-04)

## Milestones & History

- **v1.0 MVP Milestone**: Initialized 2026-10-25 (8 vertical MVP phases, 41 requirements mapped)
- **Phase 1 Planned**: 2026-10-25 (Walking skeleton, 2 execution plans)

## Accumulated Context

- **Tech Stack**: Laravel 12, PHP 8.2+, MySQL/SQLite, Blade, Tailwind CSS, Alpine.js, FilamentPHP v3/v5, spatie/laravel-pdf or dompdf.
- **Architecture**: Monolithic modular white-label system with cached `setting()` helper, CSS variable theming, and clean Public vs Admin controller segregation.
- **Execution Guardrails**:
  - `DB::transaction()` mandatory for all donation verifications and fund distributions.
  - Unique index and validation on `utr_number`.
  - Rate limiting (`throttle:5,1`) on public donation and volunteer endpoints.
  - File upload limits: max 2MB (jpg/png/webp) for payment proof and bills.
  - 1-command client onboarding via `NgoWhiteLabelSeeder`.
