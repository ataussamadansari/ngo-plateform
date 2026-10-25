# Coding Standards & Conventions

## Code Style & Formatting
- **PHP Standards**: PSR-12 and Laravel opinionated standards enforced via `laravel/pint`.
- **Strict Typing**: Use strict return types (`void`, `mixed`, `string`, `int`) on all new methods and functions.
- **Eloquent Casting**: Explicit attribute casting on models (`casts = ['amount' => 'decimal:2', 'is_active' => 'boolean']`).

## Naming Conventions
- **Models**: Singular PascalCase (`Campaign`, `FundDistribution`, `SiteSetting`).
- **Tables**: Plural snake_case (`campaigns`, `fund_distributions`, `site_settings`).
- **Migrations**: Laravel timestamped files (`2026_10_25_000004_create_donations_table.php`).
- **Foreign Keys**: Singular model name with `_id` (`campaign_id`, `category_id`, `verified_by`) with cascading delete constraints where appropriate.
- **Settings Keys**: Categorized snake_case (`primary_color`, `receipt_prefix`, `has_80g`, `ngo_name`).

## Financial & Data Integrity Rules
- **Decimal Precision**: All currency amounts use `decimal(12, 2)` or `decimal(14, 2)` in database columns and string/decimal casts in Eloquent. Float types are strictly prohibited for financial balances.
- **Atomic Operations**: Any multi-record update involving donation verification or fund disbursement MUST be enclosed in `DB::transaction()`.
- **Unique Indexes**: Strict unique index on `donations.utr_number` to prevent duplicate submissions or fraudulent replay attacks.

## Security Conventions
- **Rate Limiting**: Public submission routes (`/donate`, `/volunteer/register`) must use route throttling (e.g. `throttle:5,1`).
- **File Upload Protection**: Max 2MB file size, validated against strict MIME types (`jpeg,png,webp`). File names sanitized before writing to disk.
- **CSRF Protection**: All public POST forms must include `@csrf`.
