# Testing Architecture & Strategy

## Test Framework
- **Primary Framework**: PHPUnit 11 (`phpunit/phpunit: ^11.5.50`)
- **Assertions & Mocks**: PHPUnit native assertions + Mockery (`mockery/mockery: ^1.6`)
- **Data Generation**: Faker (`fakerphp/faker: ^1.23`)
- **Test Runner**:
  - `php artisan test`
  - `composer test` (clears configuration cache first then runs test runner)

## Test Structure
```
tests/
├── Feature/
│   └── ExampleTest.php
├── Unit/
│   └── ExampleTest.php
├── CreatesApplication.php (or standard TestCase setup)
└── TestCase.php
```

## Testing Guidelines & Coverage Requirements
1. **Model & Unit Tests**:
   - Dynamic computed properties (e.g. `Campaign::progress_percentage`, calculating percentage capped at 100 or actual).
   - Global helper functions (`setting('key', 'default')` behavior, fallback resolution, cache hit/miss).
   - Model lifecycle hooks (`SiteSetting` cache clearing on save/delete).
2. **Feature & Integration Tests**:
   - Public donation submission flow (UTR validation, required fields, file upload handling).
   - Duplicate UTR prevention (submitting same UTR returns 422 Unprocessable Entity).
   - Admin verification workflow (`DB::transaction` execution, campaign raised amount incrementing, status transitions).
   - Rate limiting enforcement on public submission routes.
3. **Database Environment**:
   - Tests execute against SQLite in-memory or a dedicated testing database using `Illuminate\Foundation\Testing\RefreshDatabase`.
