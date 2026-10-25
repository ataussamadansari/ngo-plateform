# Codebase Onboarding Summary

**Onboarding Status**: Complete  
**Date**: 2026-10-25  
**Platform**: NGO Dynamic Website & Donation Management Platform  

---

## 1. Codebase Baseline & Intel

The repository is an active **Laravel 12.0** application running on **PHP 8.2+** with **Tailwind CSS v4** and **Vite 7.0**.

Structured codebase documentation has been mapped and recorded in [`.planning/codebase/`](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/codebase/):

| Document | Focus | Core Highlights |
|---|---|---|
| [STACK.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/codebase/STACK.md) | Technologies & Tooling | Laravel 12, SQLite/MySQL, Tailwind v4, Vite 7, PHPUnit 11, Pint |
| [INTEGRATIONS.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/codebase/INTEGRATIONS.md) | External Services | Fee-free manual UPI/Bank transfer, UTR verification, Public storage |
| [ARCHITECTURE.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/codebase/ARCHITECTURE.md) | System Pattern | Monolithic modular design, dynamic `:root` CSS variables, cached settings |
| [STRUCTURE.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/codebase/STRUCTURE.md) | File Placement | App models, Blade layouts, routes, seeders, planning directory |
| [CONVENTIONS.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/codebase/CONVENTIONS.md) | Code Standards | Strict typing, `DB::transaction()` on financial mutations, rate limiting |
| [TESTING.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/codebase/TESTING.md) | Testing Strategy | PHPUnit Feature/Unit tests, RefreshDatabase, UTR uniqueness test |
| [CONCERNS.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/codebase/CONCERNS.md) | Risk Radar | Concurrent verification race conditions, proof privacy, fake UTR spam |

---

## 2. Planning Artifacts State

Planning artifacts in [`.planning/`](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/) are verified:

- [PROJECT.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/PROJECT.md): Core value, scope boundaries, and key architectural decisions.
- [REQUIREMENTS.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/REQUIREMENTS.md): 41 functional and compliance requirements across 8 phases.
- [ROADMAP.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/ROADMAP.md): 8 sequential vertical MVP phases mapped.
- [STATE.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/STATE.md): Currently positioned at **Phase 1** (Foundation, White-Label Engine & Database Schema).

---

## 3. Current Phase Execution Status

- **Phase 1**: Foundation, White-Label Engine & Database Schema
  - **Plan 01-01** ([01-01-SUMMARY.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/01-foundation-white-label-engine-database-schema/01-01-SUMMARY.md)): **COMPLETE** (10-table database schema migrations and Eloquent domain models implemented and verified).
  - **Plan 01-02** ([01-02-PLAN.md](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/phases/01-foundation-white-label-engine-database-schema/01-02-PLAN.md)): **READY FOR EXECUTION** (Cached `setting()` helper, `NgoWhiteLabelSeeder`, base Blade dynamic `:root` theming).

---

## 4. Next Step

To continue Phase 1 implementation:
- Run `/gsd-execute-phase 1` (or use `/gsd-progress` to resume Plan 01-02 execution).
