# AGENTS.md — Loundry (PoS Laundry)

Laravel 12 / PHP 8.2+ project — a Point-of-Sale system for a laundry business. Indonesian language UI.

## Commands

```bash
composer setup         # full first-time setup
composer dev           # run all 4 services concurrently (serve, queue, pail logs, vite)
composer test          # config:clear then `php artisan test`
npm run build          # vite build
npm run dev            # vite dev server
```

- Tests use SQLite `:memory:`. Run focused: `php artisan test --filter=test_name` or `vendor/bin/phpunit tests/Unit/ExampleTest.php`.
- `composer test` is the canonical single-command runner. No separate lint/typecheck step exists.

## Architecture

- **Views**: `resources/views/*.php` — plain PHP files (NOT Blade). They use Tailwind via CDN + Material Symbols. Laravel Blade is *not* used.
- **View structure**:
  - `layouts/app.php` — master layout (head, tailwind config, body wrapper, bottom nav)
  - `partials/bottom-nav.php` — shared bottom nav, active tab via `$activeNav` variable
  - Each page sets `$title`, `$activeNav`, `$content` (ob_start buffer), `$header`, and `$extra`, then `require __DIR__ . '/layouts/app.php'`
  - Flexible layout options: `$bodyClass`, `$mainClass`, `$noWrapper` (skip padding wrapper), `$showBottomNav` (default true)
  - `transaksi.php` is standalone (unique flex-col body with collapsible bottom sheet)
- **Frontend build**: Vite 7 + `@tailwindcss/vite` configured, but views load Tailwind from `cdn.tailwindcss.com` directly. Vite currently only handles `resources/css/app.css` and `resources/js/app.js`.
- **Routes**: `routes/web.php` defines 5 named routes (`dashboard`, `transaksi`, `pelanggan`, `laporan`, `pengaturan`), each rendering a plain PHP view. Bottom nav links use `route()` named helpers.
- **Backend**: No custom controllers, models (only `User`), or service classes yet.
- **Database**: SQLite default (`DB_CONNECTION=sqlite`). Session, cache, and queue all use the `database` driver (SQLite).
- **Entrypoints**:
  - Web: `routes/web.php`
  - Console: `routes/console.php`
  - App bootstrap: `bootstrap/app.php` (standard Laravel)
- **No CI/CD** configured. No pre-commit hooks. No lint/typecheck scripts.

## Conventions

- Views are `.php` files, not `.blade.php`. If adding new views, extend `layouts/app.php`.
- DB migrations exist (users, cache, jobs). Add new migrations with `php artisan make:migration`.
- Tests extend `Tests\TestCase` (Feature) or `PHPUnit\Framework\TestCase` (Unit). Both suites exist in `tests/Feature` and `tests/Unit`.
- `.env` requires `APP_KEY`. Run `php artisan key:generate` if missing.
- This is early-stage code: all 5 custom views contain hardcoded example data, not bound to backend.
- PHP CS Fixer / Pint config not present — rely on `composer.json` `require-dev` having `laravel/pint` but no custom config file.
