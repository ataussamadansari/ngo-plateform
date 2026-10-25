---
phase: 02-payment-methods-public-manual-donation-engine
plan: 02
status: complete
requirements:
  - DON-06
files_created:
  - app/Http/Controllers/DonationStatusController.php
  - resources/views/donate/status.blade.php
  - tests/Feature/DonationStatusTest.php
files_modified:
  - routes/web.php
  - resources/views/layouts/base.blade.php
---

# Plan 02-02: Public Donation Status Lookup Portal & UTR Tracking — Summary

## Execution Overview

Successfully built and verified the public donation status tracking portal (`/donation-status`) matching the design mockup (`Hope Foundation Donation Status Portal.png`).

## Tasks Completed

1. **DonationStatusController & Query Engine**:
   - Built `DonationStatusController` handling `GET /donation-status`.
   - Supports searching by UTR number, Receipt number, or registered phone number (matching exact string or last 10 digits for flexible formatting).
   - Pre-loads associated campaign data and orders by latest submission.

2. **Donation Status Blade View (`/donation-status`)**:
   - Built `resources/views/donate/status.blade.php` matching the design mockup.
   - Distinct, context-rich status cards:
     - **Verified**: Emerald card with verified badge, details grid, and official 80G receipt indicator.
     - **Pending**: Amber card with animated reconciliation clock and transparent 2-4 hour turnaround notice.
     - **Rejected**: Rose card showing admin remarks and donor care support instructions.
     - **Empty state**: Guidance on verifying UTR or contacting support.
   - Sidebars for "Your Direct Impact", "Need Assistance?" (direct WhatsApp/Email links), and "Important Information" rules.

3. **Global Layout Navigation Integration**:
   - Updated `resources/views/layouts/base.blade.php` with direct navigation links to "Donate" and "Track Donation" in the header and footer, plus a prominent "Donate Now" CTA button.

4. **Automated Feature Testing**:
   - `tests/Feature/DonationStatusTest.php` validates status page rendering, lookups by UTR, lookups by phone, state card rendering for all 3 states (verified, pending, rejected), and empty state handling.
