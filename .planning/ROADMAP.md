# Roadmap: Milestone v1.1 — Native FilamentPHP Back-Office Migration & White-Label Administration

## Milestone Summary

- **Milestone**: v1.1
- **Focus**: Migrate from custom `/admin` Blade controllers to native FilamentPHP 5, build complete Admin UIs for `SiteSetting` and `PaymentMethod`, implement native Filament resources for all core operations, and cleanly deprecate legacy custom admin code.
- **Previous Milestone**: [Milestone v1.0 (Core MVP)](file:///d:/Devize%20Technologies%20Projects/ngo_website/.planning/milestones/v1.0-ROADMAP.md) — Shipped 2026-10-25 (8 phases, 86 tests passed).
- **Completed**: 2026-10-26 (4 phases, 8 plans, 125 tests passed).

---

## Phase Summary

| Phase | Name | Goal | Requirements | Success Criteria |
|---|---|---|---|---|
| 9 | Native Filament Panel Setup, Auth & Route Release | Configure FilamentPHP 5 AdminPanelProvider at `/admin`, implement `FilamentUser` on `User`, release custom `/admin` routes from `web.php` | FIL-01, FIL-10 | 4 |
| 10 | White-Label Settings & Payment Methods Resources | Build Filament UI for `SiteSetting` (branding, color pickers, tax credentials, logo/signature) and `PaymentMethodResource` (UPI QR/bank accounts) | FIL-02, FIL-03 | 4 |
| 11 | Core Operations Migration (Donations, Ledger, Causes, Volunteers, Events) | Build native Filament resources for Donations (side-by-side verification, 80G receipt), Distributions, Campaigns, Volunteers, and Events | FIL-04, FIL-05, FIL-06, FIL-07, FIL-08 | 5 |
| 12 | Executive Dashboard Widgets, Legacy Deprecation & Verification | Build native Filament dashboard widgets, remove legacy `app/Http/Controllers/Admin` and Blade views, verify full test suite | FIL-09, FIL-10 | 4 |

---

## Phase Details

### Phase 9: Native Filament Panel Setup, Auth & Route Release
**Status:** Completed (Shipped 2026-10-26)  
**Goal:** Configure FilamentPHP 5 AdminPanelProvider at `/admin`, implement `FilamentUser` on `User`, release custom `/admin` routes from `web.php`.  
**Mode:** mvp  
**Requirements:** FIL-01, FIL-10  

### Phase 10: White-Label Settings & Payment Methods Resources
**Status:** Completed (Shipped 2026-10-26)  
**Goal:** Build Filament UI for `SiteSetting` (branding, color pickers, tax credentials, logo/signature) and `PaymentMethodResource` (UPI QR/bank accounts).  
**Mode:** mvp  
**Requirements:** FIL-02, FIL-03  

### Phase 11: Core Operations Migration
**Status:** Completed (Shipped 2026-10-26)  
**Goal:** Build native Filament resources for Donations (side-by-side verification, 80G receipt), Distributions, Campaigns, Volunteers, and Events.  
**Mode:** mvp  
**Requirements:** FIL-04, FIL-05, FIL-06, FIL-07, FIL-08  

### Phase 12: Executive Dashboard Widgets, Legacy Deprecation & Verification
**Status:** Completed (Shipped 2026-10-26)  
**Goal:** Build native Filament dashboard widgets, remove legacy custom admin controllers, and verify full test suite.  
**Mode:** mvp  
**Requirements:** FIL-09, FIL-10  
