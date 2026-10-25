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

Technology stack not yet documented. Will populate after codebase mapping or first phase.
<!-- GSD:stack-end -->

<!-- GSD:conventions-start source:CONVENTIONS.md -->

## Conventions

Conventions not yet established. Will populate as patterns emerge during development.
<!-- GSD:conventions-end -->

<!-- GSD:architecture-start source:ARCHITECTURE.md -->

## Architecture

Architecture not yet mapped. Follow existing patterns found in the codebase.
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
