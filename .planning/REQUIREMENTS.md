# Requirements: Milestone v1.1 — Native FilamentPHP Back-Office Migration & White-Label Administration

Milestone: `v1.1`
Target: Native FilamentPHP 5 Panel Integration, Full White-Label Admin UI, and Custom Admin Deprecation
Status: **Completed (2026-10-26)**

---

## 1. Filament Panel Foundation & Access Control

- [x] **FIL-01**: Native FilamentPHP 5 Panel Provider (`AdminPanelProvider`) mounted at `/admin` with custom branding, login, password reset, and `App\Models\User` implementing `FilamentUser` with `canAccessPanel()` gating (`super_admin` and `manager` roles allowed, inactive accounts denied).

---

## 2. White-Label & Payment Methods Administration (New Admin UIs)

- [x] **FIL-02**: Native Filament `SiteSetting` Management (Settings Page or Resource) providing full UI for:
  - NGO details: Legal name, tagline, email, phone, address.
  - Theming: Primary color picker (`--color-primary`), Secondary color picker (`--color-secondary`), logo upload, favicon upload, digital stamp/signature upload.
  - Compliance: PAN, 80G registration number & approval date, 12A registration number, NGO Darpan ID.
  - Automatic cache clearing on save to ensure `setting()` reflects changes instantly across public pages.
- [x] **FIL-03**: Native Filament `PaymentMethodResource` providing full CRUD for:
  - Payment method name, type (`upi_qr`, `bank_transfer`).
  - Dynamic UPI QR code image upload, UPI ID.
  - Bank account name, account number, IFSC code, branch.
  - Active toggle and display priority order.

---

## 3. Core Operational Filament Resources

- [x] **FIL-04**: Native Filament `DonationResource`:
  - Data table with status badges (pending, verified, rejected), payment mode, campaign, date, and UTR search.
  - Side-by-side proof check modal displaying donor UTR number directly alongside uploaded payment screenshot.
  - Atomic verification action running in `DB::transaction()` to set status to `verified`, issue sequential receipt number (`KSF-YYYY-XXXX`), and increment campaign `raised_amount`.
  - Rejection action modal with mandatory rejection remarks.
  - Direct 80G PDF receipt stream/download action for verified donations.
  - Direct manual cash donation creation by administrators.
- [x] **FIL-05**: Native Filament `FundDistributionResource`:
  - Ledger data table with beneficiary name, amount, date, and linked campaign.
  - Creation/edit form with invoice/bill upload, impact photos upload, beneficiary notes, and atomic campaign `distributed_amount` increment inside `DB::transaction()`.
- [x] **FIL-06**: Native Filament `CampaignResource` & `CauseCategoryResource`:
  - Category CRUD with automatic slug generation.
  - Campaign CRUD with goal amount, cover thumbnail upload, photo gallery upload, rich story editor, status toggle (draft, active, completed, paused), and live raised/distributed indicators.
- [x] **FIL-07**: Native Filament `VolunteerResource`:
  - Screening queue table with filters for status (pending, approved, rejected), skills, and availability.
  - Approval action issuing sequential volunteer ID code (`VOL-YYYY-XXXX`).
  - Rejection action with remarks.
  - Downloadable/viewable applicant government ID proof.
- [x] **FIL-08**: Native Filament `EventResource`:
  - Event CRUD with date, time, venue, Google Maps link, and banner image.
  - Event registrations RelationManager displaying attendee details and 1-click attendance check-in toggle (`attended`/`absent`).

---

## 4. Executive Dashboard & Legacy Admin Deprecation

- [x] **FIL-09**: Native Filament Dashboard Widgets:
  - `FinancialOverviewWidget`: Live stat cards for Total Verified Raised, Total Distributed on Ground, Net Available Treasury, and Pending Verifications count.
  - `PendingDonationsQuickActionWidget`: Table widget of pending donations directly on dashboard with 1-click verify action.
  - Responsive charts: `MonthlyDonationTrendWidget` (interactive line chart), `DonationsByModeWidget` (doughnut chart), `TopCampaignsRaisedWidget` (bar chart), and `FundsUtilizationSplitWidget` (pie chart).
- [x] **FIL-10**: Full deprecation and removal of legacy `/admin` custom Blade views and controllers, route release from `web.php`, and zero regressions verified across test suite.
