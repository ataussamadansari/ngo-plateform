# Phase 3: Admin Donation Verification & PDF Receipt Engine - Context

**Gathered:** 2026-10-25  
**Status:** Ready for planning  
**Mode:** MVP (Vertical Slice)

<domain>
## Phase Boundary

Phase 3 delivers the back-office donation verification workflow and official 80G compliance PDF receipt generator:
1. Administrative verification queue displaying pending donations with filters for status, payment mode, campaign, and date.
2. Side-by-side verification interface comparing donor-submitted UTR and transaction details against the uploaded bank payment screenshot.
3. Atomic donation approval inside `DB::transaction()`: status update to `verified`, sequential receipt number generation (`{PREFIX}-{YEAR}-{0001}`), and synchronized campaign `raised_amount` increment.
4. Administrative donation rejection with explanatory remarks.
5. Direct entry of verified offline/cash donations by administrators.
6. Automated 80G compliant PDF receipt generator featuring white-label NGO branding, 80G registration credentials, donor PAN, amount in words, and digital signature stamp, accessible by admins and verified donors.
</domain>

<decisions>
## Implementation Decisions

### Administrative Queue & Verification UX
- **D-01:** Admin routes under `/admin/donations`:
  - `GET /admin/donations` — Queue of donations with tab filters (`pending`, `verified`, `rejected`, `all`), search by UTR/name/phone, and campaign filter.
  - `GET /admin/donations/{donation}` — Detail & side-by-side comparison modal/view.
  - `POST /admin/donations/{donation}/approve` — Approval action.
  - `POST /admin/donations/{donation}/reject` — Rejection action with `admin_remarks`.
  - `GET /admin/donations/create` & `POST /admin/donations` — Record direct/offline verified donation.
- **D-02:** Provide side-by-side proof modal allowing zoom on screenshot image, copyable UTR for fast search in bank portal/statement, and quick-action Approve/Reject buttons.

### Financial Integrity & Atomic State Transitions
- **D-03:** Mandatory `DB::transaction()` with pessimistic row locking (`lockForUpdate()`) for all approvals:
  - Validates donation is currently in `pending` status.
  - Generates sequential unique `receipt_number`: `{PREFIX}-{YEAR}-{SEQUENTIAL_NUMBER}`, e.g. `KSF-2026-0001`.
  - Increments campaign `raised_amount` atomically if donation is assigned to a campaign.
  - Updates donation `status = 'verified'`, `verified_at = now()`, `verified_by = auth()->id()`.

### PDF Receipt Engine (80G Compliance)
- **D-04:** Use `barryvdh/laravel-dompdf` for pure-PHP server-side PDF generation without heavy external browser headless dependencies.
- **D-05:** Professional, white-label 80G receipt layout `resources/views/receipts/80g.blade.php`:
  - NGO header with logo, registration number, PAN, address.
  - 80G exemption notice: "Donations are exempt under Section 80G of Income Tax Act 1961, Reg No: ...".
  - Donor details: Full Name, PAN Number (if provided), Phone, Address.
  - Transaction table: Amount in figures, Amount in words (using NumberFormatter / helper), Payment mode, UTR number, Date of donation, Purpose/Campaign.
  - Digital signature seal & signature image from `setting('authorized_sign_image')`, with signatory name and title.
- **D-06:** Public receipt download route `GET /donations/{donation}/receipt` with signed/verified protection allowing donors who possess the donation's UTR or ID to download their official PDF receipt.
</decisions>

<canonical_refs>
## Canonical References
- Requirements: VER-01, VER-02, VER-03, VER-04, VER-05, VER-06 in `.planning/REQUIREMENTS.md`
- Project conventions: Financial precision, `DB::transaction()` mandatory requirement.
</canonical_refs>
