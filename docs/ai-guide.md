# AI Guide for This Repository

Purpose: Give AI assistants a fast, accurate mental model of this Laravel app so they can navigate, modify, and extend it with minimal context switching.

Scope: Backend (Laravel 12, PHP 8.2), Blade views, a simple bilingual CMS layer with cached helpers, Vite/Tailwind front-end, and basic admin routes for content editing.

---

## Quick Facts

- Framework: Laravel 12 (PHP 8.2)
- Front-end: Vite, TailwindCSS, Alpine.js
- DB: Configured for MySQL by default in `.env`; app supports SQLite/MySQL/Postgres/SQL Server in `config/database.php`
- Auth: Laravel Breeze (views present), session-based locale switching
- Content system: `contents` table, translatable JSON for text, JSON with `path` for media
- Image storage: `public/content-images/` (directly web-served)
- Caching: `rememberForever` with explicit invalidation per key

---

## Key Commands

- Install & build once:
  - `composer install`
  - `cp .env.example .env && php artisan key:generate` (if needed)
  - `php artisan migrate --force`
  - `npm install`
  - `npm run build`

- Dev mode (concurrently runs server, queue, logs, Vite):
  - `composer run dev`

- Serve app only:
  - `php artisan serve` (default url `http://localhost:8000`)

- Tests:
  - `composer run test`

- Seed content:
  - `php artisan db:seed --class=Database\Seeders\ContentStarterSeeder`
  - `php artisan db:seed --class=Database\Seeders\ContentAdditionsSeeder`

- Sync media filenames to key convention and clear caches:
  - Dry run: `php artisan content:sync-images --dry-run`
  - Apply: `php artisan content:sync-images` (use `--force` to overwrite)

---

## Directory Structure (key paths)

```
app/
  Console/Commands/SyncContentImages.php   # Tool to align media filenames to keys
  Http/
    Controllers/
      Admin/ContentController.php          # Admin endpoints for content CRUD (text/image/video)
    Middleware/SetLocale.php               # Reads locale from session; registered in bootstrap/app.php
  Models/Content.php                       # Eloquent model with Spatie Translatable
  Support/
    ContentRepository.php                  # Cached content lookup + invalidation helpers
    helpers.php                            # Global helpers: content(), content_media()

bootstrap/
  app.php                                  # Registers routes and web middleware (SetLocale)

config/
  app.php, database.php, ...               # Locale defaults, DB connections

database/
  migrations/2025_10_13_205827_create_contents_table.php
  seeders/ContentStarterSeeder.php         # Minimal seed content
  seeders/ContentAdditionsSeeder.php       # Seeds from docs/content-registry.json

docs/
  cms-conventions.md                       # CMS rules and naming conventions
  content-registry.json                    # Source of truth for content keys/meta

public/
  content-images/                          # All uploaded content media (shared across locales)
  index.php, css/, js/, img/, fonts/       # Public assets and entry

resources/
  views/
    layouts/app.blade.php                  # lang/dir reflect current locale; footer uses content helpers
    site/*.blade.php                       # Pages using content()/content_media()
    admin/skeletons/*.blade.php            # Skeleton editors for specific groups

routes/
  web.php                                  # Public pages + /lang/{locale} + admin CMS routes
  auth.php                                 # Breeze auth routes

tests/
  Pest.php, TestCase.php                   # Pest + RefreshDatabase in Feature tests

package.json, vite.config.js               # Vite/Tailwind/Alpine setup
composer.json                              # Laravel 12 + spatie/laravel-translatable
```

---

## Environment & Config

- `.env` highlights:
  - `APP_LOCALE=en`, `APP_FALLBACK_LOCALE=en`
  - `DB_CONNECTION=mysql` (switchable; `config/database.php` default is `sqlite` if env missing)
  - `SESSION_DRIVER=database`, `CACHE_STORE=database`
- Locale selection: session key `locale`; route `GET /lang/{locale}` whitelists `en|ar`.
- Middleware registration: `bootstrap/app.php` appends `App\Http\Middleware\SetLocale` to `web` group.

---

## Content System Cheat Sheet

- Table: `contents`
  - Columns: `id`, `key` (unique), `group`, `type` (`text|image|video`), `value` (JSON), timestamps
  - Migration adds a MySQL check constraint for `type` when supported

- Text values: JSON with translations, e.g. `{ "en": "...", "ar": "..." }`
- Media values: JSON with `{ "path": "<key>.<ext>", "mime": "...", "size": <bytes> }`
- Storage: `public/content-images/<key>.<ext>` (no per-locale media)

- Global helpers (autoloaded via `composer.json`):
  - `content($key, $default = null): string` → uses `ContentRepository::text()`
  - `content_media($key, $default = null): string` → `ContentRepository::image()` returning absolute URL with cache-busting `?v=filemtime`

- Caching keys:
  - Text: `cms:content:{key}:{locale}`
  - Media: `cms:content-media:{key}`
  - Bust via `ContentRepository::forgetText($key, $locales)` / `forgetMedia($key)` or run `content:sync-images`

- Fallback chain for `content()`:
  - Current session locale → English (`en`) → provided `$default` → empty string

- Conventions (see `docs/cms-conventions.md`):
  - Key format: `page.section.item` (lowercase, dot-separated)
  - Keys are stable identifiers; do not rename on copy changes
  - Image filename must equal key + extension → `<key>.<ext>`

- Registry: `docs/content-registry.json`
  - Authoritative list of content keys per group with metadata and constraints
  - `ContentAdditionsSeeder` can upsert keys from registry into DB with defaults

---

## Routes Snapshot (essentials)

- Public pages: `/`, `/about`, `/services`, `/partners`, `/tournaments`, `/team`, etc. → Blade views in `resources/views/site`
- Locale switching: `GET /lang/{locale}` → sets session `locale` and redirects back
- Admin CMS (behind `web,auth`):
  - `GET /admin` → dashboard
  - `GET /admin/contents` → list/filter
  - `GET /admin/contents/page/{group}` → list by page/group
  - `GET /admin/contents/skeleton/{group}` → skeleton editor (if view exists)
  - `GET /admin/contents/{key}` → edit single
  - `POST /admin/contents/{key}` → update
  - `POST /admin/contents/{key}/ajax` → update via AJAX (text or media)
  - `POST /admin/content/update-ajax` → generic single update
  - `POST /admin/content/batch-update` → batch updates for skeleton editors

---

## Front-end Notes

- Vite inputs: `resources/css/app.css`, `resources/js/app.js` (see `vite.config.js`)
- Tailwind content scan: `resources/views/**/*.blade.php`, Laravel vendor pagination, and compiled views
- Layout sets `<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">`

---

## Common Tasks for AI

- Add a new content key:
  1) Add to `docs/content-registry.json` with `key`, `group`, `type`, and meta.
  2) Run `php artisan db:seed --class=Database\Seeders\ContentAdditionsSeeder`.
  3) Reference via `content('page.section.item')` or `content_media('page.section.image')` in Blade.

- Update media and ensure URL cache-busts:
  - Upload through admin route or place file at `public/content-images/<key>.<ext>` and run `php artisan content:sync-images`.

- Ensure correct locale behavior in Blade:
  - Use `content()` for text; do not hardcode strings where translatable content exists.

- Bust caches after programmatic updates:
  - Call `ContentRepository::forgetText($key, $locales)` or `forgetMedia($key)` as appropriate.

---

## Pitfalls & Notes

- Media paths must live under `public/content-images/` to match helpers and docs.
- `content_media()` returns absolute URL and appends `?v=filemtime` if the file exists; missing files return provided default or empty string.
- If `.env` sets `DB_CONNECTION=mysql`, ensure the database exists and credentials are valid before running migrations/seeders.
- Admin routes currently gate by `auth`; a future phase may add abilities like `can:manage-content`.

---

## Where Things Live (references)

- Helpers: app/Support/helpers.php
- Repository: app/Support/ContentRepository.php
- Model: app/Models/Content.php
- Admin controller: app/Http/Controllers/Admin/ContentController.php
- Locale middleware: app/Http/Middleware/SetLocale.php
- Web routes: routes/web.php
- Registry: docs/content-registry.json
- Conventions/spec: docs/cms-conventions.md
- Public media: public/content-images/

---

## Versioning & Tooling

- PHP >= 8.2; Composer required
- Node 18+ recommended for Vite 7; npm available
- Tests use Pest; `tests/Pest.php` enables `RefreshDatabase` for Feature tests

---

If you need more context, search examples of `content(` or `content_media(` usage in `resources/views/**` to find live keys and patterns.

