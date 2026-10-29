# NGO Dynamic Website & Donation Management Platform

## What This Is

A dynamic, white-label ready NGO web platform and donation management system built on Laravel 12 and FilamentPHP. It enables non-profit organizations to showcase campaigns, accept manual donations via dynamic UPI QR codes and bank transfers without payment gateway fees, verify payments via UTR and screenshot proof, issue automated 80G compliant PDF receipts, and display a completely transparent fund utilization ledger with bills and impact photos.

## Core Value

Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated compliance receipts.

## Business Context

- **Customer**: Non-profits, charitable trusts, and grassroots NGOs needing a credible, high-trust digital presence.
- **Revenue model**: White-label turnkey software deployment and customization for NGO clients.
- **Success metric**: 100% verified donation-to-distribution reconciliation with sub-2 minute receipt generation and zero gateway commissions.
- **Strategy notes**: Fast-to-market monolithic architecture combining Laravel 12 Blade + Tailwind CSS for SEO-optimized public pages and native FilamentPHP for back-office administration.

## Current State

- **Milestone v1.0 (Core MVP)**: Shipped 2026-10-25. 8 phases, 16 plans, 86 passing feature tests. All public donor, volunteer, event, and transparency interfaces operational.
- **Milestone v1.1 (FilamentPHP Back-Office)**: Shipped 2026-10-26. 4 phases, 8 plans, 125 passing tests. Native Filament 5 admin, white-label settings, and executive dashboard charts.
- **Status**: Milestone v1.1 Complete & Shipped. 135 passing tests. Ready for next milestone.

## Requirements

### Validated (v1.0 & v1.1 Milestones)

- ✓ Foundation & 10-table database schema with Eloquent models — Phase 1
- ✓ Dynamic white-label branding, theme colors, and site settings engine with cached global helper — Phase 1
- ✓ Active payment methods display, manual donation submission, UTR deduplication, and screenshot proof upload — Phase 2
- ✓ Public donation status and receipt lookup portal — Phase 2
- ✓ Admin donation verification queue with side-by-side proof check, 1-click approve/reject, and automated PDF receipt generation (80G/12A compliance) — Phase 3
- ✓ Fund distribution ledger with bill upload, impact photos, and public transparency breakdown — Phase 4
- ✓ Causes and campaigns engine with automated raised and distributed fund synchronization — Phase 5
- ✓ Volunteer registration, screening queue, and volunteer ID code issuance — Phase 6
- ✓ Events management with volunteer and participant registration tracking — Phase 6
- ✓ Public frontend pages: Home with live impact counters, About Us with legal credentials, Campaigns, Transparency, Events, and Volunteer join — Phase 7
- ✓ Executive financial overview metrics, quick-action queues, and turnkey client handover (`HANDOVER.md`) — Phase 8
- ✓ Native FilamentPHP 5 Panel Provider at `/admin` with `FilamentUser` access gating (`FIL-01`, `FIL-10`) — Phase 9
- ✓ Native Filament `SiteSetting` Management and `PaymentMethodResource` (`FIL-02`, `FIL-03`) — Phase 10
- ✓ Native Filament Resources for Donations, Distributions, Campaigns, Volunteers, and Events (`FIL-04` through `FIL-08`) — Phase 11
- ✓ Native Filament Executive Dashboard Widgets with responsive Chart.js line, doughnut, bar, and pie charts (`FIL-09`, `FIL-10`) — Phase 12

### Out of Scope

- Automated Payment Gateway integration (Razorpay/Stripe) — Excluded to avoid gateway transaction fees (2-3%) and complex KYC onboarding for non-profits; utilizes verified UPI/Bank transfers.
- Multi-tenant shared database architecture — Excluded to allow independent, isolated deployments per client with 1-command `.env` and database seeding.
- Live donor chat system — Excluded to minimize operational overhead for small NGO teams.
- Mobile application — Web-first responsive SSR design fulfills all mobile donor and admin requirements.

## Context

- Technical Stack: PHP 8.2+, Laravel 12, MySQL/SQLite, Tailwind CSS, Alpine.js, FilamentPHP 5, barryvdh/laravel-dompdf.
- Architecture: Monolithic modular design. Public views utilize Blade + Tailwind with CSS variables (`--color-primary`, `--color-secondary`) for dynamic runtime theming. Admin uses native FilamentPHP Panel Provider for back-office administration.
- Operational Model: Zero gateway commissions, high-trust ground proof verification, and 60-second turnkey client deployment.

## Constraints

- **Payment Verification**: Must rely on donor-submitted UTR numbers and payment screenshots verified manually by admins against bank statements.
- **Data Integrity**: All donation verifications and fund distributions must execute within `DB::transaction()` to ensure campaign balances stay strictly synchronized.
- **Security & Anti-Abuse**: Rate-limiting (`throttle:5,1`) on donation and volunteer forms; strict file validation (max 2MB, jpeg/png/webp); unique index on `utr_number`.
- **White-Label Modularity**: All client-specific branding, logos, signatures, prefixes, and tax details must be dynamic and stored in `site_settings`.

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Manual QR/Bank Payment over Gateway | Zero platform cuts, zero gateway setup delays, full trust in UPI/direct bank transfers | Validated (v1.0) |
| Native FilamentPHP 5 Panel for Back-Office | Modern, extensible administrative UX with native resources, forms, tables, and actions | Migrating in v1.1 |
| `site_settings` Key-Value with Cached `setting()` Helper | Allows instant white-label client reselling without touching application code | Validated (v1.0) |
| Blade + Tailwind + Alpine for Frontend | High SEO performance for causes/events, instant page loads, no SPA complexity | Validated (v1.0) |

---
*Last updated: 2026-10-26 for Milestone v1.1*
