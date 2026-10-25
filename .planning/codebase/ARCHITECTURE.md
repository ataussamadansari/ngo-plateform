# System Architecture

## Architectural Pattern
Monolithic Modular Web Application with strict Domain Separation between Public Donor/Visitor interactions and Back-Office Administrative Workflows.

```
                    ┌───────────────────────────────┐
                    │       HTTP Requests           │
                    └───────┬───────────────┬───────┘
                            │               │
                 Public Routes              Admin Routes
                            │               │
                    ┌───────▼───────┐ ┌─────▼───────────┐
                    │  Public Web   │ │  Filament Admin  │
                    │  Controllers  │ │ Panel / Resource│
                    └───────┬───────┘ └─────┬───────────┘
                            │               │
                            ▼               ▼
                    ┌───────────────────────────────┐
                    │      Eloquent Domain Layer     │
                    │ (Campaign, Donation, Setting) │
                    └───────────────┬───────────────┘
                                    │
                                    ▼
                    ┌───────────────────────────────┐
                    │  Database & Cache Subsystem   │
                    │ (DB::transaction & Cache Tag) │
                    └───────────────────────────────┘
```

## Presentation Layer
1. **Public Website**:
   - Blade templates combined with Tailwind CSS v4 for clean, server-rendered, SEO-optimized content.
   - Dynamic runtime CSS theming injected in `<head>` via CSS Custom Properties (`:root { --color-primary: ...; --color-secondary: ...; }`), bound dynamically from `setting('primary_color')` and `setting('secondary_color')`.
   - Alpine.js for lightweight modal behaviors, image lightbox previews, tab filtering, and copy-to-clipboard interactions.
2. **Back-Office Admin Panel**:
   - FilamentPHP resource architecture providing rapid data filtering, side-by-side donation verification modals, and fund distribution logging.

## White-Label Settings Engine
- **Persistence**: Key-value pairs stored in the `site_settings` table, categorized by group (`branding`, `receipt_legal`, `contact`, `hero_cms`, `social`).
- **Caching Layer**: Cached in memory via `Cache::rememberForever('site_settings', ...)` through global helper `setting($key, $default)`.
- **Cache Invalidation**: Automatic invalidation on `SiteSetting` model events (`saved`, `deleted`), ensuring zero stale settings without recurring database queries.

## Domain Model & Financial Integrity
- **Core Entities**:
  - `CauseCategory`: Taxonomic groupings (Medical Aid, Child Education, Winter Relief).
  - `Campaign`: Core cause entity tracking financial progress (`target_amount`, `raised_amount`, `distributed_amount`).
  - `PaymentMethod`: Active UPI VPAs, QR codes, and bank accounts.
  - `Donation`: Financial contribution records with donor details, UTR, proof screenshot, and status (`pending`, `verified`, `rejected`).
  - `FundDistribution`: Ground expenditure ledger linked to campaigns, with vendor bills and proof photos.
  - `Event` & `EventRegistration`: Community engagement drives and participant tracking.
  - `Volunteer`: Public volunteer applications and status review queue.
- **Transactional Consistency**:
  - All status transitions modifying balances (e.g. `Donation` approval incrementing `Campaign.raised_amount`, `FundDistribution` incrementing `Campaign.distributed_amount`) MUST be wrapped in `DB::transaction()`.
