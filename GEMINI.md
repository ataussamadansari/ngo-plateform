<!-- GSD:project-start source:PROJECT.md -->

## Project

**NGO Dynamic Website & Donation Management Platform**

A dynamic, white-label ready NGO web platform and donation management system built on Laravel 12. It enables non-profit organizations to showcase campaigns, accept manual donations via dynamic UPI QR codes and bank transfers without payment gateway fees, verify payments via UTR and screenshot proof, issue automated 80G compliant PDF receipts, and display a completely transparent fund utilization ledger with bills and impact photos.

**Core Value:** Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated compliance receipts.

### Constraints

- **Payment Verification**: Must rely on donor-submitted UTR numbers and payment screenshots verified manually by admins against bank statements.
- **Data Integrity**: All donation verifications and fund distributions must execute within `DB::transaction()` to ensure campaign balances stay strictly synchronized.
- **Security & Anti-Abuse**: Rate-limiting (`throttle:5,1`) on donation and volunteer forms; strict file validation (max 2MB, jpeg/png/webp); unique index on `utr_number`.
- **White-Label Modularity**: All client-specific branding, logos, signatures, prefixes, and tax details must be dynamic and stored in `site_settings`.

<!-- GSD:project-end -->

<!-- GSD:stack-start source:STACK.md -->

## Technology Stack

- **Backend**: Laravel 12.0, PHP 8.2+, Eloquent ORM, Laravel Tinker
- **Database & Cache**: SQLite (dev) / MySQL (prod), Database cache driver (`cache` table), Database queues
- **Frontend & CSS**: Tailwind CSS v4 (`@tailwindcss/vite`), Vite 7.0, Axios, Blade Templates, CSS custom properties (`:root`)
- **Admin & Document Tools**: FilamentPHP (planned), Spatie Laravel-PDF / Dompdf (planned)
- **Code Quality & Testing**: PHPUnit 11, Laravel Pint, Mockery, Faker, Laravel Pail
<!-- GSD:stack-end -->

<!-- GSD:conventions-start source:CONVENTIONS.md -->

## Conventions

- **Code Style**: PSR-12 / Laravel opinionated conventions enforced via `laravel/pint`
- **Typing**: Strict return types on methods and attribute casting on all Eloquent models
- **Financial Precision**: All monetary values use `decimal(12, 2)` or `decimal(14, 2)` - never floats
- **Data Integrity**: Mandatory `DB::transaction()` on all donation approvals and fund disbursements
- **Security**: Route rate-limiting (`throttle:5,1`), max 2MB file uploads (jpeg/png/webp only), unique index on `utr_number`
<!-- GSD:conventions-end -->

<!-- GSD:architecture-start source:ARCHITECTURE.md -->

## Architecture

- **Pattern**: Monolithic modular architecture with domain separation (Public Donor Controllers vs Back-Office Filament Admin)
- **White-Label Engine**: Database-backed `site_settings` key-value store with cached `setting()` helper and model-event cache buster
- **Theming**: Dynamic CSS custom property injection in base layout (`--color-primary`, `--color-secondary`)
- **Verification Workflow**: Offline UPI QR & Bank transfer -> Donor UTR + proof submission -> Admin side-by-side verification -> Automated 80G PDF receipt
<!-- GSD:architecture-end -->

<!-- GSD:skills-start source:skills/ -->

## Project Skills

No project skills found. Add skills to any of: `.agents/skills/`, `.agents/skills/`, `.cursor/skills/`, `.github/skills/`, or `.codex/skills/` with a `SKILL.md` index file.
<!-- GSD:skills-end -->

<!-- GSD:workflow-start source:GSD defaults -->

## GSD Workflow Enforcement

Before using Edit, Write, or other file-changing tools, start work through a GSD command so planning artifacts and execution context stay in sync.

Use these entry points:
- `/gsd-fast` for a trivial task inline, with no subagents and no PLAN.md
- `/gsd-quick` for small fixes, doc updates, and ad-hoc tasks
- `/gsd-debug` for investigation and bug fixing
- `/gsd-execute-phase` for planned phase work

Do not make direct repo edits outside a GSD workflow unless the user explicitly asks to bypass it.
<!-- GSD:workflow-end -->

<!-- GSD:profile-start -->

## Developer Profile

> Profile not yet configured. Run `/gsd-profile-user` to generate your developer profile.
> This section is managed by `generate-claude-profile` -- do not edit manually.
<!-- GSD:profile-end -->
