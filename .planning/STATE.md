# Project State

## Project Reference

See: [.planning/PROJECT.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/PROJECT.md) (updated 2026-10-25)

**Core value:** Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated compliance receipts.  
**Current focus:** Phase 1: Foundation, White-Label Engine & Database Schema

## Current Position

- **Phase**: 1 of 8 (Foundation, White-Label Engine & Database Schema)
- **Status**: Ready to plan
- **Mode**: Vertical MVP (`PROJECT_MODE=mvp`)
- **Blockers**: None

## Milestones & History

- **v1.0 MVP Milestone**: Initialized 2026-10-25 (8 vertical MVP phases, 41 requirements mapped)

## Accumulated Context

- **Tech Stack**: Laravel 12, PHP 8.2+, MySQL/SQLite, Blade, Tailwind CSS, Alpine.js, FilamentPHP v3/v5, spatie/laravel-pdf or dompdf.
- **Architecture**: Monolithic modular white-label system with cached `setting()` helper, CSS variable theming, and clean Public vs Admin controller segregation.
- **Execution Guardrails**:
  - `DB::transaction()` mandatory for all donation verifications and fund distributions.
  - Unique index and validation on `utr_number`.
  - Rate limiting (`throttle:5,1`) on public donation and volunteer endpoints.
  - File upload limits: max 2MB (jpg/png/webp) for payment proof and bills.
  - 1-command client onboarding via `NgoWhiteLabelSeeder`.
