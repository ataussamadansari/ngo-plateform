# Turnkey White-Label NGO Platform — Deployment & Handover Guide

> **Version:** 1.1.0  
> **Framework:** Laravel 12.0 (PHP 8.2+) with Native FilamentPHP 5 Administration  
> **Frontend:** Tailwind CSS v4, Blade, Alpine.js  
> **Database:** SQLite (development/local) / MySQL 8.0+ (production)  
> **Key Value Proposition:** Frictionless, fee-free manual donation verification paired with 100% transparent public fund distribution tracking, automated 80G tax receipts, and turnkey white-label management via native FilamentPHP 5.

---

## 1. Executive Architecture Overview

This platform is engineered as a white-label, single-tenant web application. Non-profit organizations (NGOs) and charitable trusts can deploy this system to completely eliminate third-party payment gateway transaction fees (which consume 2%–4% of donations) by accepting direct bank transfers and instant dynamic UPI QR codes.

### Core Subsystems:
1. **White-Label Administration (`/admin/settings`)**: Native Filament Settings interface for live branding updates, CSS custom properties (`--color-primary`, `--color-secondary`), logo/favicon/stamp uploads, and statutory credentials (80G, 12A, NGO Darpan, PAN).
2. **Direct Fee-Free Donations & Verification (`/admin/donations`)**: Dynamic UPI QR codes and NEFT/RTGS bank details with donor UTR reference submission. Back-office features side-by-side reconciliation of donor payment screenshots against bank credits, atomic balance increments inside `DB::transaction()`, and automated 80G PDF receipt generation (`KSF-YYYY-XXXX`).
3. **Ground Distribution Transparency Ledger (`/admin/fund-distributions`)**: Verified expense management with invoice and impact photo attachments, automatically synchronizing campaign distributed totals and feeding the public transparency portal.
4. **Campaigns & Causes Management (`/admin/campaigns` & `/admin/cause-categories`)**: Rich cause storytelling with photo galleries, goal amount tracking, status toggles, and live progress indicators.
5. **Volunteer Screening & Roster (`/admin/volunteers`)**: Applicant screening queue issuing sequential collision-resistant volunteer identification codes (`VOL-YYYY-XXXX`).
6. **Events & Attendance Management (`/admin/events`)**: Event scheduling with banner uploads and interactive attendance roster RelationManager for 1-click volunteer check-in.
7. **Contact Inquiries Portal (`/admin/contact-inquiries`)**: Triage visitor inquiries directly in Filament with status badges (pending, read, replied).
8. **Executive Command Dashboard (`/admin`)**: Real-time treasury cards (Verified Raised, Ground Distributed, Net Available Treasury, Pending Count) and 1-click triaging widgets.

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

All client-specific branding is stored in the `site_settings` table and cached in memory. Administrators can customize everything via the native Filament Admin UI at `/admin/settings` or programmatically:

### Customizing Organization Identity
Configure settings via the admin panel at `/admin/settings` or via `php artisan tinker`:
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

### Configuring Payment Methods & Dynamic UPI QR Codes
Manage banking methods at `/admin/payment-methods`:
- **UPI QR**: Set UPI ID (`ngo@bank`), account name, and upload dynamic QR code.
- **Bank Transfer**: Set Bank name, account number, IFSC code, and branch name.

---

## 4. Default Credentials & Access Portals

| Portal | URL | Default Username | Default Password | Role / Access |
|--------|-----|------------------|------------------|---------------|
| **Public Storefront** | `/` | *Public Access* | *Public Access* | Visitor / Donor |
| **Causes Directory** | `/campaigns` | *Public Access* | *Public Access* | Visitor / Donor |
| **Transparency Ledger**| `/transparency` | *Public Access* | *Public Access* | Public Audit |
| **Volunteer Application** | `/volunteer-join` | *Public Access* | *Public Access* | Applicant |
| **Track Donation Status** | `/donation-status` | *Public Access* | *Public Access* | Donor |
| **Back-Office Sign-In** | `/admin/login` | `admin@ksf.org` | `password123` | Super Admin / Staff |
| **Native Filament Dashboard**| `/admin` | *Session Guarded*| *Session Guarded*| Super Admin / Manager |

> [!IMPORTANT]
> Immediately change the default super admin password upon initial login in production!

---

## 5. Administrative Operational Workflows (FilamentPHP 5)

### 1. Reconciling Pending Donations
1. Navigate to `/admin` dashboard or `/admin/donations`.
2. Inspect the uploaded payment screenshot and donor UTR directly in the side-by-side modal.
3. Cross-reference the UTR number against official bank statements or UPI business notifications.
4. Click **Verify** — the system wraps the verification in `DB::transaction()`, increments the campaign balance, and produces an 80G PDF receipt (`KSF-YYYY-XXXX`).
5. Verified donors can immediately download their 80G tax receipt at `/donations/{id}/receipt` or via the public donation tracking portal.
6. If payment cannot be traced, click **Reject** and supply an audit explanation.

### 2. Disbursing Verified Funds & Publishing Proofs
1. Navigate to `/admin/fund-distributions/create`.
2. Select target campaign, beneficiary/vendor name, and expenditure amount.
3. Upload official vendor bill image and ground distribution photos.
4. Check **Make Public** to publish the entry to the public transparency ledger. The campaign's distributed balance updates atomically.

### 3. Screening Volunteer Candidates
1. Navigate to `/admin/volunteers` or dashboard screening widget.
2. Review applicant skills, city, and identity proof document.
3. Click **Approve** — the system auto-assigns a collision-resistant sequential volunteer code (e.g. `KSF-VOL-2026-0001`).

### 4. Event Scheduling & Live Attendance Roster
1. Navigate to `/admin/events`.
2. Schedule upcoming drives with location address, Google Maps link, and banner images.
3. During ground drives, open the event edit page and use the **Registrations** relation manager to toggle volunteer attendance (`attended` / `absent`) or add on-the-spot participants with 1 click.

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
