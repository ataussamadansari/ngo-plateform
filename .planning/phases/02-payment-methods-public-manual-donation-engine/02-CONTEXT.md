# Phase 2: Payment Methods & Public Manual Donation Engine - Context

**Gathered:** 2026-10-25  
**Status:** Ready for planning  
**Mode:** MVP (Vertical Slice)

<domain>
## Phase Boundary

Phase 2 delivers the public-facing donor contribution workflow and verification status lookup:
1. Active UPI QR code and bank account information display with instant copy actions.
2. Preset and custom donation amount selection with 80G tax benefit guidance.
3. Manual donation proof submission form capturing donor details, optional campaign selection, UTR number, and screenshot upload.
4. Strict anti-abuse protections: UTR deduplication (unique database constraint and validation rule), rate limiting (`throttle:5,1`), and strict 2MB file validation (jpg, png, webp).
5. Public donation status tracking portal (`/donation-status`) allowing donors to track the verification of their contribution by UTR number or Phone.
</domain>

<decisions>
## Implementation Decisions

### Payment Methods Management & Display
- **D-01:** Populate default payment methods via seeder:
  - UPI QR Method: active UPI ID (`kashiseva@upi`), QR code asset (`storage/payment_methods/default_upi_qr.png`), label "UPI Payment (GPay, PhonePe, Paytm, BHIM)".
  - Bank Account Method: Account Name ("Kashi Seva Foundation"), Bank Name ("State Bank of India"), Account Number ("41238901234"), IFSC Code ("SBIN0001234"), Branch Name ("Assi Ghat Branch, Varanasi").
- **D-02:** Provide interactive copy-to-clipboard buttons on all bank fields and UPI ID with visual feedback ("Copied!").
- **D-03:** Provide tab switcher between UPI Payment (QR code + UPI apps) and Direct Bank Transfer.

### Donation Submission Form & Validation
- **D-04:** Dedicated Form Request `StoreDonationRequest`:
  - `donor_name`: string, required, max 255.
  - `donor_email`: email, required, max 255.
  - `donor_phone`: string, required, regex for valid 10-digit phone or international format.
  - `donor_pan`: string, nullable, uppercase alphanumeric regex (`^[A-Z]{5}[0-9]{4}[A-Z]{1}$`).
  - `donor_address`: string, nullable, max 500.
  - `amount`: numeric, required, min 1, max 10000000 (1 Crore).
  - `payment_mode`: required, in `upi_qr,bank_transfer`.
  - `utr_number`: required, string, min 6, max 30, unique:donations,utr_number.
  - `payment_screenshot`: required, file, image, mimes:jpeg,png,webp, max:2048 (2MB).
  - `campaign_id`: nullable, exists:campaigns,id.
  - `donor_message`: nullable, string, max 1000.
  - `is_anonymous`: boolean, default false.
- **D-05:** Rate limit donation submissions with `throttle:5,1` (5 submissions per minute per IP).
- **D-06:** Store uploaded screenshots in `storage/app/public/donations` with hashed names; store relative path in `donations.payment_screenshot`.
- **D-07:** Flash success feedback displaying submitted UTR number and a direct link to check status at `/donation-status?query={utr}`.

### Donation Status Portal
- **D-08:** Route `/donation-status` provides an instant lookup box accepting UTR number or Phone number.
- **D-09:** Search query automatically sanitizes whitespace and queries `Donation::where('utr_number', $query)->orWhere('donor_phone', $query)->latest()->get()`.
- **D-10:** Renders state cards corresponding to donation status:
  - `pending`: Amber alert explaining manual bank reconciliation is underway (typically 2-4 hours).
  - `verified`: Emerald success card displaying verified date, receipt number, and receipt download indicator.
  - `rejected`: Rose notice with admin remarks explaining why verification failed (e.g. incorrect UTR or missing credit).
- **D-11:** Include helpful "Need Help?" WhatsApp/support CTA and "Important Information" guidance based on client design mockups.
</decisions>

<canonical_refs>
## Canonical References
- UI Mockup: `docs/ui/Hope Foundation Donation UI Mockup.png`
- UI Mockup: `docs/ui/Hope Foundation Donation Status Portal.png`
- Requirements: DON-01, DON-02, DON-03, DON-04, DON-05, DON-06 in `.planning/REQUIREMENTS.md`
</canonical_refs>
