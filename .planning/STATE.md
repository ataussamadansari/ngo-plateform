# Project State

## Project Reference

See: [.planning/PROJECT.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/PROJECT.md) (updated 2026-10-26)

**Core value:** Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated compliance receipts.  
**Current focus:** Milestone v1.1 — Native FilamentPHP Back-Office Migration & White-Label Administration  
**Next action:** `/gsd-plan-phase 9` to plan Phase 9: Native Filament Panel Setup, Auth & Route Release

## Current Position

- **Milestone**: v1.1
- **Phase**: 9 of 12 (Native Filament Panel Setup, Auth & Route Release)
- **Status**: Planned (1 plan ready: 09-01)
- **Mode**: Vertical MVP (`PROJECT_MODE=mvp`)
- **Active Wave**: 1
- **Blockers**: None

## Phase 9 Plans

- [ ] [09-01-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/09-native-filament-panel-setup-auth-route-release/09-01-PLAN.md) — Wave 1: Native Filament Panel Provider Setup, FilamentUser Auth & Route Release (FIL-01, FIL-10)

## Milestone v1.1 Phases

- [ ] **Phase 9**: Native Filament Panel Setup, Auth & Route Release (FIL-01, FIL-10)
- [ ] **Phase 10**: White-Label Settings & Payment Methods Resources (FIL-02, FIL-03)
- [ ] **Phase 11**: Core Operations Migration (Donations, Ledger, Causes, Volunteers, Events) (FIL-04, FIL-05, FIL-06, FIL-07, FIL-08)
- [ ] **Phase 12**: Executive Dashboard Widgets, Legacy Deprecation & Verification (FIL-09, FIL-10)

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
