# NGO Dynamic Website & Donation Management Platform

## What This Is

A dynamic, white-label ready NGO web platform and donation management system built on Laravel 12. It enables non-profit organizations to showcase campaigns, accept manual donations via dynamic UPI QR codes and bank transfers without payment gateway fees, verify payments via UTR and screenshot proof, issue automated 80G compliant PDF receipts, and display a completely transparent fund utilization ledger with bills and impact photos.

## Core Value

Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated compliance receipts.

## Business Context

- **Customer**: Non-profits, charitable trusts, and grassroots NGOs needing a credible, high-trust digital presence.
- **Revenue model**: White-label turnkey software deployment and customization for NGO clients.
- **Success metric**: 100% verified donation-to-distribution reconciliation with sub-2 minute receipt generation and zero gateway commissions.
- **Strategy notes**: Fast-to-market monolithic architecture combining Laravel 12 Blade + Tailwind CSS for SEO-optimized public pages and FilamentPHP for rapid back-office administration.

## Requirements

### Validated

- ✓ Laravel 12 baseline application skeleton initialized — existing

### Active

- [ ] Dynamic white-label branding, theme colors, and site settings engine with cached global helper
- [ ] Dynamic QR code and bank account payment methods management
- [ ] Public manual donation submission flow with UTR deduplication and screenshot proof upload
- [ ] Admin donation verification queue with side-by-side proof check, 1-click approve/reject, and automated PDF receipt generation (80G/12A compliance)
- [ ] Public donation status and receipt lookup portal
- [ ] Fund distribution ledger with bill upload, impact photos, and public transparency breakdown
- [ ] Causes and campaigns engine with automated raised and distributed fund synchronization
- [ ] Volunteer registration, admin review queue, and volunteer ID code issuance
- [ ] Events management with volunteer and participant registration tracking
- [ ] Public frontend pages: Home with live impact counters, About Us with legal credentials, Campaigns listing/detail, Transparency ledger, Events, and Volunteer portal
- [ ] FilamentPHP back-office admin panel for centralized management

### Out of Scope

- Automated Payment Gateway integration (Razorpay/Stripe) — Excluded for v1 to avoid gateway transaction fees (2-3%) and complex KYC onboarding for non-profits; utilizes verified UPI/Bank transfers.
- Multi-tenant shared database architecture — Excluded to allow independent, isolated deployments per client with 1-command `.env` and database seeding.
- Live donor chat system — Excluded to minimize operational overhead for small NGO teams.
- Mobile application — Web-first responsive SSR design fulfills all mobile donor and admin requirements.

## Context

- Technical Stack: PHP 8.2+, Laravel 12, MySQL/SQLite, Tailwind CSS, Alpine.js, FilamentPHP, spatie/laravel-pdf or dompdf.
- Architecture: Monolithic modular design. Public views utilize Blade + Tailwind with CSS variables (`--color-primary`, `--color-secondary`) for dynamic runtime theming. Admin uses FilamentPHP for rapid table filters, modals, and actions.
- Operational Model: Solo developer execution optimized for rapid shipping, clean code separation (Public vs Admin controllers/resources), and zero-friction client onboarding.

## Constraints

- **Payment Verification**: Must rely on donor-submitted UTR numbers and payment screenshots verified manually by admins against bank statements.
- **Data Integrity**: All donation verifications and fund distributions must execute within `DB::transaction()` to ensure campaign balances stay strictly synchronized.
- **Security & Anti-Abuse**: Rate-limiting (`throttle:5,1`) on donation and volunteer forms; strict file validation (max 2MB, jpeg/png/webp); unique index on `utr_number`.
- **White-Label Modularity**: All client-specific branding, logos, signatures, prefixes, and tax details must be dynamic and stored in `site_settings`.

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Manual QR/Bank Payment over Gateway | Zero platform cuts, zero gateway setup delays, full trust in UPI/direct bank transfers | — Pending |
| FilamentPHP for Back-Office Admin | 70% faster development for verification queues, CRUD tables, modals, and filters | — Pending |
| `site_settings` Key-Value with Cached `setting()` Helper | Allows instant white-label client reselling without touching application code | — Pending |
| Blade + Tailwind + Alpine for Frontend | High SEO performance for causes/events, instant page loads, no SPA complexity | — Pending |

## Evolution

This document evolves at phase transitions and milestone boundaries.

**After each phase transition** (via `/gsd-transition`):
1. Requirements invalidated? → Move to Out of Scope with reason
2. Requirements validated? → Move to Validated with phase reference
3. New requirements emerged? → Add to Active
4. Decisions to log? → Add to Key Decisions
5. "What This Is" still accurate? → Update if drifted

**After each milestone** (via `/gsd-complete-milestone`):
1. Full review of all sections
2. Core Value check — still the right priority?
3. Audit Out of Scope — reasons still valid?
4. Update Context with current state

---
*Last updated: 2026-10-25 after initialization*
