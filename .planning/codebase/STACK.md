# Technology Stack

## Core Runtime & Framework
- **PHP**: ^8.2 (Running on Windows local environment with PHP 8.2+)
- **Framework**: Laravel 12.0 (`laravel/framework: ^12.0`)
- **Interactive Shell / REPL**: Laravel Tinker (`laravel/tinker: ^2.10.1`)
- **Application Architecture**: Monolithic Server-Side Rendered (SSR) web application with Blade templates and back-office admin panel.

## Database & Data Persistence
- **Database Engine**: SQLite (default local development via `database/database.sqlite`), MySQL 8.0+ production ready.
- **ORM**: Eloquent ORM with strict typing, attribute casting, and relationships.
- **Cache Driver**: Database cache (`cache` and `cache_locks` tables) / Redis ready.
- **Queue Driver**: Database queues (`jobs`, `job_batches`, `failed_jobs` tables).

## Frontend & Tooling
- **Build Tool / Bundler**: Vite 7.0 (`vite: ^7.0.7`) via `laravel-vite-plugin: ^2.0.0`
- **CSS Framework**: Tailwind CSS v4 (`tailwindcss: ^4.0.0`, `@tailwindcss/vite: ^4.0.0`)
- **HTTP Client**: Axios (`axios: ^1.11.0`)
- **Task Runner / Process Manager**: Concurrently (`concurrently: ^9.0.1`) for unified dev execution (`php artisan serve`, queue worker, pail logs, vite dev)
- **Planned Additions**: Alpine.js for lightweight UI micro-interactions, FilamentPHP for back-office admin, and Spatie Laravel-PDF / Dompdf for 80G compliant PDF receipt generation.

## Development & Code Quality Tools
- **Linter / Formatter**: Laravel Pint (`laravel/pint: ^1.24`)
- **Error Handling & Logging**: Laravel Pail (`laravel/pail: ^1.2.2`), Nunomaduro Collision (`nunomaduro/collision: ^8.6`)
- **Test Framework**: PHPUnit 11 (`phpunit/phpunit: ^11.5.50`), Mockery (`mockery/mockery: ^1.6`), Faker (`fakerphp/faker: ^1.23`)
- **Local Containerization**: Laravel Sail (`laravel/sail: ^1.41`)

## Key Commands
- Development server: `npm run dev` (runs Vite + Artisan serve + Queue worker + Pail concurrently)
- Database migration: `php artisan migrate`
- Database seeder: `php artisan db:seed`
- Tests: `php artisan test`
