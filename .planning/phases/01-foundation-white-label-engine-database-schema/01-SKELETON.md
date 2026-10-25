# Walking Skeleton — NGO Dynamic Website & Donation Management Platform

**Phase:** 1  
**Generated:** 2026-10-25

## Capability Proven End-to-End

A browser visitor requesting the application receives an SSR HTML page themed dynamically with CSS variables (`--color-primary`, `--color-secondary`) powered by the cached `setting()` engine backed by the database.

## Architectural Decisions

| Decision | Choice | Rationale |
|---|---|---|
| Framework | Laravel 12 (PHP 8.2+) | Modern, expressive full-stack framework with built-in queue, auth, DB migrations, and caching |
| Data Layer | MySQL / SQLite + Eloquent ORM | Strict typing, robust foreign key constraints, and clean transaction handling |
| White-Label Config | Key-Value `site_settings` + `Cache::rememberForever()` | Zero per-request database overhead for branding, legal, and payment configs |
| Dynamic Styling | Tailwind CSS + CSS Variables (`var(--color-primary)`) | Instant white-label theme customization without rebuilding assets |
| Seeding Strategy | Turnkey `NgoWhiteLabelSeeder` | New client onboarding in under 60 seconds via `migrate --seed` |

## Stack Touched in Phase 1

- [x] Project scaffold (Laravel 12, Composer, Vite, PHPUnit)
- [ ] Database — 10 complete relational tables with foreign keys and indexes
- [ ] Models & Relations — Eloquent models with typed relationships and scopes
- [ ] Global Helper & Cache — `setting($key, $default)` helper with automatic cache busting
- [ ] Base UI Layout — Blade master layout reading dynamic branding and CSS custom properties
- [ ] Storage — Linked public storage for uploads

## Out of Scope (Deferred to Later Slices)

- Public manual donation form and UTR upload (Phase 2)
- Admin verification queue and PDF receipts (Phase 3)
- Public fund distribution ledger (Phase 4)
- Campaign story and progress bars (Phase 5)
- Volunteer and event registration (Phase 6)
- Public homepage, about page, impact counters (Phase 7)
- Filament admin dashboard widgets (Phase 8)

## Subsequent Slice Plan

Each later phase adds one vertical capability on top of this skeleton:
- Phase 2: Payment Methods & Public Manual Donation Engine
- Phase 3: Admin Donation Verification & PDF Receipt Engine
- Phase 4: Fund Distribution & Public Transparency Ledger
- Phase 5: Causes & Campaigns Management Engine
- Phase 6: Volunteers Onboarding & Event Management
- Phase 7: Public Website Frontend & Dynamic Theming
- Phase 8: Back-Office Filament Admin Dashboard & Client Handover
