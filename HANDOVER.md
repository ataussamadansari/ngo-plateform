# Turnkey White-Label NGO Platform — Deployment & Handover Guide

> **Version:** 1.0.0  
> **Framework:** Laravel 12.0 (PHP 8.2+)  
> **Frontend:** Tailwind CSS v4, Blade, Alpine.js  
> **Database:** SQLite (development/local) / MySQL 8.0+ (production)  
> **Key Value Proposition:** Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking and automated 80G tax receipts.

---

## 1. Executive Architecture Overview

This platform is engineered as a white-label, single-tenant web application. Non-profit organizations (NGOs) and charitable trusts can deploy this system to completely eliminate third-party payment gateway transaction fees (which consume 2%–4% of donations) by accepting direct bank transfers and instant dynamic UPI QR codes.

### Core Subsystems:
1. **White-Label Engine (`site_settings`)**: Dynamic runtime theming with CSS variables (`--color-primary`, `--color-secondary`) and cached organization credentials.
2. **Direct Fee-Free Donations**: Dynamic UPI QR codes and NEFT/RTGS bank details with donor UTR reference submission.
3. **Admin Verification Queue**: Side-by-side reconciliation of donor payment screenshots and UTR numbers against official bank statements with atomic balance updates.
4. **80G PDF Receipt Engine**: Sequentially numbered, audited PDF receipts automatically downloadable by verified donors.
5. **Ground Distribution Transparency Ledger**: Immutable public ledger detailing every rupee spent with vendor bills and ground impact proof.
6. **Volunteer & Event Management**: Volunteer onboarding with sequential identification codes and community drive attendance tracking.
7. **Executive Command Dashboard**: Real-time treasury cards (Verified Raised, Ground Distributed, Net Available Treasury) and 1-click triage queues.

---

## 2. 60-Second Rapid Turnkey Provisioning

Deploying a clean, production-ready portal for a new NGO client takes under 60 seconds:

### Step 1: Environment Setup
```bash
# Clone the repository and enter directory
cd ngo_website

# Create environment configuration
copy .env.example .env

# Install backend dependencies
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate
```

### Step 2: Database Initialization & Seeding
```bash
# Execute migrations and populate baseline white-label configurations
php artisan migrate:fresh --seed
```
*This automatically provisions:*
- Default Super Admin account (`admin@ksf.org` / `password123`).
- 5 Core Cause Categories (Medical Aid, Child Education, Winter Relief Drive, Food & Nutrition, Disaster Recovery).
- Default UPI QR and Bank Transfer payment configurations.
- Default statutory settings (80G, 12A, NGO Darpan, PAN, contact address).

### Step 3: Storage Link & Permissions
```bash
# Ensure public storage symlink exists for bills, proofs, and receipts
php artisan storage:link
```

---

## 3. Client Customization & White-Label Theming

All client-specific branding is stored in the `site_settings` table and cached in memory.

### Customizing Organization Identity
Configure settings via `php artisan tinker` or direct database record updates:
```php
setting(['ngo_name' => 'Adarsh Sewa Sansthan']);
setting(['ngo_tagline' => 'Empowering Lives with Complete Transparency']);
setting(['contact_address' => '45, Civil Lines, Prayagraj, UP - 211001']);
setting(['contact_phone' => '+91 9876543210']);
setting(['contact_email' => 'support@adarshsewa.org']);
setting(['primary_color' => '#059669']);   // Emerald green
setting(['secondary_color' => '#1e293b']); // Slate dark
```

### Configuring Official Tax & Statutory Credentials
```php
setting(['80g_reg_number' => 'AADTA9876DF20251']);
setting(['12a_reg_number' => 'AADTA9876DE20241']);
setting(['ngo_darpan_id' => 'UP/2026/0098765']);
setting(['ngo_pan_number' => 'AADTA9876D']);
```

### Configuring Payment Methods & UPI VPA
Update `payment_methods` table to specify the NGO's official banking details:
- **UPI QR**: `upi_id = "adarshsewa@sbi"`, `account_name = "Adarsh Sewa Sansthan"`
- **Bank Transfer**: `bank_name = "State Bank of India"`, `account_number = "30987654321"`, `ifsc_code = "SBIN0001234"`

---

## 4. Default Credentials & Access Portals

| Portal | URL | Default Username | Default Password | Role |
|--------|-----|------------------|------------------|------|
| **Public Storefront** | `/` | *Public Access* | *Public Access* | Visitor / Donor |
| **Causes Directory** | `/campaigns` | *Public Access* | *Public Access* | Visitor / Donor |
| **Transparency Ledger**| `/transparency` | *Public Access* | *Public Access* | Public Audit |
| **Volunteer Application** | `/volunteer-join` | *Public Access* | *Public Access* | Applicant |
| **Track Donation Status** | `/donation-status` | *Public Access* | *Public Access* | Donor |
| **Back-Office Sign-In** | `/admin/login` | `admin@ksf.org` | `password123` | Super Admin |
| **Admin Command Center**| `/admin` | *Session Guarded*| *Session Guarded*| Super Admin / Manager |

> [!IMPORTANT]
> Immediately change the default super admin password upon initial login in production!

---

## 5. Administrative Operational Workflows

### 1. Reconciling Pending Donations
1. Navigate to `/admin/donations` or the dashboard quick-action triage widget.
2. Click on the pending donation thumbnail to inspect the donor-uploaded payment screenshot.
3. Cross-reference the UTR number against official bank statements or UPI business notifications.
4. Click **Approve** — the system wraps the verification in `DB::transaction()`, increments the campaign balance, and produces an 80G PDF receipt.
5. If payment cannot be traced, click **Reject** and supply an audit remark.

### 2. Disbursing Verified Funds
1. Navigate to `/admin/distributions/create`.
2. Select target campaign, beneficiary/vendor name, and expenditure amount.
3. Upload official vendor bill image and ground distribution photos.
4. Check **Make Public** to publish the entry to the public transparency ledger.

### 3. Screening Volunteer Candidates
1. Navigate to `/admin/volunteers` or dashboard screening widget.
2. Review applicant skills, city, and identity proof.
3. Click **Approve** — the system auto-assigns a formatted volunteer code (e.g. `KSF-VOL-2026-001`).

---

## 6. Production Hardening Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
- [ ] Enforce SSL/HTTPS by configuring Nginx / Apache reverse proxy.
- [ ] Cache Laravel configurations and routes:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```
- [ ] Ensure background queue workers are managed via Supervisor (`php artisan queue:work --tries=3`).
- [ ] Set up automated database backups.
- [ ] Run test suite to guarantee 100% integrity:
  ```bash
  php artisan test
  ```

---
*Client handover documentation finalized 2026-10-26.*
