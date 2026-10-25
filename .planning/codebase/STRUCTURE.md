# Directory Structure & File Organization

## Directory Layout

```
ngo_website/
├── app/
│   ├── helpers.php                 # Global helper functions (setting() engine)
│   ├── Http/
│   │   ├── Controllers/            # Public donor & web controllers
│   │   └── Requests/               # Form request validation classes
│   └── Models/                     # Eloquent domain models (10 core entities)
│       ├── Campaign.php            # Campaign entity with balance calculations
│       ├── CauseCategory.php       # Category grouping
│       ├── Donation.php            # Donation records & UTR verification
│       ├── Event.php               # Events & community drives
│       ├── EventRegistration.php   # Event attendees
│       ├── FundDistribution.php    # Transparent expenditure ledger
│       ├── PaymentMethod.php       # Bank & UPI account details
│       ├── SiteSetting.php         # White-label key-value store with cache hooks
│       ├── User.php                # Admin & staff accounts
│       └── Volunteer.php           # Volunteer applications & profiles
├── bootstrap/
│   └── app.php                     # Application routing & middleware configuration
├── config/                         # Standard Laravel framework configuration
├── database/
│   ├── factories/                  # Model testing factories
│   ├── migrations/                 # 12 database migrations (schema & framework)
│   └── seeders/                    # Seeders (NgoWhiteLabelSeeder, DatabaseSeeder)
├── docs/
│   └── ui/                         # High-fidelity UI mockups and design assets
├── public/
│   ├── storage -> ../storage/app/public  # Public storage symlink for uploaded proofs
│   └── index.php                   # Web entrypoint
├── resources/
│   ├── css/
│   │   └── app.css                 # Tailwind CSS v4 entrypoint with @theme rules
│   ├── js/
│   │   └── app.js                  # Frontend Javascript bootstrap
│   └── views/
│       ├── layouts/                # Master layouts (layouts/base.blade.php)
│       ├── components/             # Reusable Blade UI components
│       └── pages/                  # Public web pages (Home, Campaigns, About, Ledger)
├── routes/
│   ├── console.php                 # Artisan console commands
│   └── web.php                     # Public web route definitions
├── tests/
│   ├── Feature/                    # HTTP & feature integration tests
│   ├── Unit/                       # Model & logic unit tests
│   └── TestCase.php                # Base test case
└── .planning/                      # GSD planning directory (specs, roadmap, state, codebase)
    ├── codebase/                   # Codebase map documents (STACK, ARCHITECTURE, etc.)
    ├── phases/                     # Structured phase plans and walking skeleton
    ├── PROJECT.md                  # Project vision, core values, and requirements
    ├── REQUIREMENTS.md             # Formal requirement specifications
    ├── ROADMAP.md                  # Milestone and phase roadmap
    └── STATE.md                    # Project state and execution progress
```

## Component Placement Rules
- **Domain Logic**: Business rules and progress computations belong in Eloquent models or dedicated action services, never in Blade templates.
- **Form Validation**: Public donation and volunteer forms must use dedicated `FormRequest` classes with rate limiting (`throttle:5,1`).
- **Styling**: Use utility classes styled through CSS custom variables defined in `layouts/base.blade.php` to guarantee full white-label recoloring.
