# Technical Concerns & Operational Constraints

## 1. Concurrent Donation Verification & Race Conditions
- **Issue**: If two administrators review the pending donation queue simultaneously, both might attempt to verify the same donation.
- **Mitigation**: Database transactions with optimistic locking or row locking (`lockForUpdate()`) during the verification action, preventing double-incrementing of `campaign.raised_amount`.

## 2. Public Proof Storage & Privacy Protection
- **Issue**: Donors upload payment proof screenshots that may contain sensitive personal banking details (account numbers, UPI IDs, balances).
- **Mitigation**: Ensure proof screenshots are not indexed by search engines. Restrict direct public directory traversal; provide obfuscated filenames and consider signed URLs or authenticated admin-only access for raw payment proofs.

## 3. UTR Fraud & Spurious Submission Flooding
- **Issue**: Malicious users might submit fake UTR numbers or spam high volumes of donations with random image files to exhaust disk space.
- **Mitigation**:
  - Enforce `throttle:5,1` on the donation submission endpoint.
  - Reject non-image MIME types and enforce max 2MB file limits.
  - Admin approval required before any donation counts toward campaign totals or appears on public donors wall.

## 4. Cache Coherency with White-Label Engine
- **Issue**: Long-lived caching of `site_settings` via `Cache::rememberForever()` could cause multi-server or multi-process environments to serve stale settings if cache invalidation fails.
- **Mitigation**: Model lifecycle events (`saved`, `deleted`) on `SiteSetting` trigger `Cache::forget('site_settings')`. For multi-server production deployments, configure Redis with shared cache tagging.

## 5. Tailwind CSS v4 Dynamic Color Theming
- **Issue**: Tailwind CSS v4 compiles utility classes ahead-of-time. Pre-compiled utility classes like `bg-emerald-600` cannot adapt to dynamic NGO client colors without rebuilding assets.
- **Mitigation**: Base layout injects CSS custom properties (`:root { --color-primary: ...; --color-secondary: ...; }`) from `setting()`. Utility classes `.bg-primary`, `.text-primary`, `.border-primary` reference these variables dynamically at runtime.
