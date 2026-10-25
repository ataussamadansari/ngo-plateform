# External Integrations & Service Architecture

## Payment Processing (Fee-Free Manual Flow)
- **Direct UPI & QR Codes**: Dynamic QR codes linked to registered NGO VPA (Virtual Payment Address) and bank accounts.
- **Bank Transfers**: Direct NEFT / RTGS / IMPS account details displayed dynamically from `payment_methods` table.
- **Decision Rationale**: Traditional payment gateways (Razorpay, Stripe, Cashfree) charge 2-3% transaction commissions and require extensive KYC delays. The platform utilizes donor UTR numbers (Unique Transaction Reference) and screenshot uploads for zero-fee, direct-to-bank donations.

## Verification & Audit Pipeline
- **Admin Verification Queue**: Manual verification workflow where administrators cross-reference donor UTR and payment proof screenshots against bank statements.
- **Duplicate Prevention**: Database-enforced unique index on `donations.utr_number`.
- **Status Machine**: Donations transition through `pending` -> `verified` (or `rejected`) with logged verification timestamps and admin ID.

## Filesystem & Asset Storage
- **Public Storage Symlink**: `public/storage` linked to `storage/app/public` via `php artisan storage:link`.
- **Stored Media**:
  - Payment proof screenshots (`donations/proofs/`)
  - Fund distribution expenditure bills and invoices (`fund_distributions/bills/`)
  - Campaign hero and gallery images (`campaigns/`)
  - NGO branding assets (`settings/logo.png`, `settings/signature.png`, `settings/favicon.ico`)
- **File Validation**: Strict server-side validation enforcing max 2MB file size and image mimes (`jpeg`, `png`, `webp`).

## Mail & Compliance Communications
- **Driver**: Laravel Mail (configured via `.env` for SMTP / Amazon SES / Log driver).
- **Automated Triggers**:
  - Immediate submission acknowledgement email to donors upon donation recording.
  - Verified receipt email with 80G tax exemption PDF attachment upon admin verification.
  - Volunteer application acknowledgement and credential dispatch.

## Document & PDF Generation
- **Tax Compliance Receipts**: Automated 80G / 12A compliant PDF receipt generation using donor PAN, serial receipt numbers, organization registration numbers, and digital signatures.
- **Renderer**: Spatie Laravel-PDF / Dompdf integration generating immutable, printable PDF receipts.
