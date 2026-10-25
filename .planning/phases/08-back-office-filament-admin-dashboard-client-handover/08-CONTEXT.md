# Phase 8: Back-Office Admin Dashboard, RBAC & Client Handover - Context

**Gathered:** 2026-10-25  
**Status:** Ready for planning  
**Mode:** MVP (Vertical Slice)

<domain>
## Phase Boundary

Phase 8 completes the MVP milestone by unifying all back-office administrative workflows into a centralized command dashboard, establishing administrative authentication and role-based access control (RBAC), and validating a frictionless, turnkey white-label client handover:

1. **Central Financial Overview & Operational Dashboard (`/admin`, `/admin/dashboard`)**:
   - Executive financial metrics computed in real-time with decimal precision:
     - Total Verified Funds Received (sum of verified donations)
     - Total Funds Distributed to Ground (sum of public fund distributions)
     - Net Available Treasury Balance (`Total Verified - Total Distributed`)
     - Pending Verification Count (unverified UTRs awaiting bank statement matching)
     - Pending Volunteer Applications Count (unscreened volunteer candidates)
     - Pending Visitor Inquiries Count (unaddressed contact queries)
     - Active Relief Campaigns Count & Overall Goal Progress Percentage
   - Quick-Action Interactive Triage Queues directly on the dashboard:
     - Pending Donation Verification Queue with donor details, UTR, payment mode, proof thumbnail, and 1-click verification/rejection triggers.
     - Volunteer Screening Queue with applicant location, skills, and 1-click approval (auto-generating sequential volunteer code).
     - Active Campaign Funding Progress Bars showing goal fulfillment.
     - Recent Ground Distribution Activity feed with bill proof status.

2. **Administrative Authentication & Role-Based Access Control (RBAC)**:
   - Dedicated branded administrative login interface (`/admin/login`) with CSRF protection, rate limiting (`throttle:5,1`), and credential validation.
   - Administrative session management and secure logout endpoint (`/admin/logout`).
   - Role-Based Access Control middleware (`EnsureAdminRole`) guarding all `/admin/*` routes:
     - Super Admin: Full administrative privileges including platform settings, user management, and destructive operations.
     - Manager: Operational privileges for verifying donations, recording distributions, managing campaigns, screening volunteers, and organizing events.
     - Unauthenticated visitors automatically redirected to `/admin/login`.

3. **Turnkey White-Label Client Handover**:
   - Seamless installation engine verified: executing `php artisan migrate:fresh --seed` creates an entire production-ready NGO platform for a new client with default super admin, sample cause categories, default site settings, and payment methods in under 60 seconds.
   - Deployment & Handover Guide (`HANDOVER.md`) detailing environment configuration, branding customization, and operational maintenance.
</domain>

<decisions>
## Implementation Decisions

### Financial Dashboard & Quick Actions (ADM-01, ADM-02)
- **D-01:** Dedicated `AdminDashboardController` (`app/Http/Controllers/Admin/AdminDashboardController.php`) serving `GET /admin` and `GET /admin/dashboard`:
  - Financial calculations executed via Eloquent aggregations:
    - `totalVerifiedFunds = Donation::where('status', 'verified')->sum('amount');`
    - `totalDistributedFunds = FundDistribution::sum('amount_spent');`
    - `availableBalance = max(0, totalVerifiedFunds - totalDistributedFunds);`
  - Actionable queues:
    - `pendingDonations = Donation::where('status', 'pending')->with('campaign', 'paymentMethod')->latest()->take(5)->get();`
    - `pendingVolunteers = Volunteer::where('status', 'pending')->latest()->take(5)->get();`
    - `activeCampaigns = Campaign::where('status', 'active')->with('category')->latest()->take(5)->get();`
    - `recentDistributions = FundDistribution::with('campaign')->latest('distribution_date')->take(5)->get();`
- **D-02:** Rich Dashboard View (`resources/views/admin/dashboard.blade.php`):
  - Metric summary cards with visual trend indicators and status badges.
  - Embedded quick-action tables with modal triggers for reviewing payment screenshots and applicant IDs without navigating away.
  - Global admin navigation bar linking all administrative sub-modules (Verification, Ledger, Campaigns, Categories, Volunteers, Events, Inquiries, Settings).

### Admin Authentication & RBAC (ADM-03)
- **D-03:** Authentication Gateway:
  - `AdminAuthController` (`app/Http/Controllers/Admin/AdminAuthController.php`):
    - `showLoginForm()` renders `resources/views/admin/auth/login.blade.php`.
    - `login()` validates credentials, enforces rate limiting (`throttle:5,1`), verifies `is_active`, and creates session.
    - `logout()` terminates session and redirects to login with flash notice.
- **D-04:** Role-Based Access Middleware:
  - `EnsureAdminRole` (`app/Http/Middleware/EnsureAdminRole.php`):
    - Protects `/admin` routes.
    - Checks that user is logged in and possesses `super_admin` or `manager` role.
    - Prevents unauthorized access with 403 Forbidden or redirect to `/admin/login`.
    - Registered as `'admin.role'` in Laravel application middleware stack (`bootstrap/app.php`).

### Turnkey Client Handover Verification
- **D-05:** Automated Handover Validation:
  - `tests/Feature/AdminAuthAndHandoverTest.php` asserts that database seeding initializes super admin, site settings, payment methods, and categories.
  - Comprehensive `HANDOVER.md` guide for client deployment.
</decisions>

<canonical_refs>
## Canonical References
- Requirements: ADM-01, ADM-02, ADM-03 in `.planning/REQUIREMENTS.md`
- Roadmap: Phase 8 in `.planning/ROADMAP.md`
- User Roles: `App\Models\User` with `role` attribute (`super_admin`, `manager`)
- Seeder: `Database\Seeders\NgoWhiteLabelSeeder`
</canonical_refs>
