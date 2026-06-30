# AGENTS.md — Sekolah CMS

## Project Identity

- **Sekolah CMS** — website profil sekolah untuk **PKBM Al Falah Sumur Batu**.
- **Laravel 12** (`^12.0`), PHP `^8.2`, SQLite (dev), Bootstrap 5.3 (public via CDN), Tailwind CSS 4 (via Vite, unused in views), Vite 7.
- Monorepo, single Laravel app — no packages, no monorepo tooling.

## Setup & Dev Commands

| Action | Command |
|---|---|
| Full first-time setup | `composer run setup` (copies `.env`, generates key, migrates, builds assets) |
| Dev server (all services) | `composer run dev` — runs `php artisan serve`, `queue:listen`, `pail`, `vite` concurrently |
| Run tests | `composer run test` (clears config then runs `php artisan test`) |
| Standalone test | `php artisan test --filter=TestName` |
| Migrate + seed | `php artisan migrate --seed` |
| Create storage link | `php artisan storage:link` |
| Clear config | `php artisan config:clear` |
| Lint | `./vendor/bin/pint` (Laravel Pint) |

## Database

- **SQLite** default (`DB_CONNECTION=sqlite`). File: `database/database.sqlite`.
- Session, queue, cache all default to `database` driver.
- Testing uses `:memory:` SQLite (see `phpunit.xml`).

## Architecture

### Routes (`routes/web.php`)

| Path | Auth | Role | Controller |
|---|---|---|---|
| `/` | public | — | `Public\HomeController@index` |
| `/guru/{slug}` | public | — | `Public\TeacherController@show` |
| `/login` | guest | — | `Auth\AuthenticatedSessionController` |
| `/admin/*` | auth | `admin` | `Admin\*` |
| `/portal-guru` | auth | `teacher` | static view only |

### Roles (Enum: `App\Enums\UserRole`)
- `admin`, `teacher` — checked by `App\Http\Middleware\EnsureUserHasRole` registered as `role` alias in `bootstrap/app.php`.

### Models (all in `app/Models/`)
- `SchoolProfile` — single row singleton via `SchoolProfile::query()->first()` pattern.
- `ContentSection` — keyed by `section_key` (`profil`, `visi`, `misi`, `sejarah`), fetched via `whereIn()` + `keyBy('section_key')`.
- `Program` — programs with `slug`, `sort_order`, `is_active`.
- `Teacher` — has `user_id` (nullable) linking to `User`, `slug`, `is_active`.
- `Subject` — standalone name.
- `TeacherAssignment` — pivot: `teacher_id`, `subject_id`, `program_id`, `note`.

### Admin CRUD Status (per `TASKS.md`)
- **Done**: Teachers (full CRUD + teacher account mgmt + assignment mgmt).
- **Not done yet**: SchoolProfile, ContentSection, Program, Subject — data only via seeder.
- Admin auth is custom (no Breeze), login view at `resources/views/auth/login.blade.php`.

### Auth Guard
- Custom login (not Breeze). Session-based. Redirect: admin → `admin.index`, teacher → `teacher-portal.index`.

## Default Admin Credentials (Seeder)

- Email: `admin@pkbmalfalah.test`
- Password: `password`

## Frontend

- **Public** (`resources/views/public/`): Uses Bootstrap 5.3 CDN + Poppins Google Font (`public/layouts/app.blade.php`). No Vite CSS used on public pages.
- **Admin** (`resources/views/admin/`): Custom CSS at `public/css/admin.css`. Same theme variables.
- **Theme**: CSS variables in `public/css/theme.css`. Colors: green primary (`#2E7D32`), yellow accent (`#F2C94C`).
- **Vite**: Entry points `resources/css/app.css` (Tailwind 4) and `resources/js/app.js`. Not integrated into public/admin Blade layouts.
- **Images**: Stored in `storage/app/public/`, served via `public/storage/` symlink. In views: `asset('storage/'.ltrim($path, '/'))`.

## Key Conventions

- Data must come from database, never hardcoded in views (per PROJECT_BRIEF.md).
- Controllers use `View`/`RedirectResponse` return type hints.
- No `@vite` directive in views yet — asset serving is CDN + `asset()`.
- Requests: `StoreTeacherRequest`, `UpdateTeacherRequest`, `LoginRequest` in `app/Http/Requests/`.
- No tests written (empty `tests/Feature/`, `tests/Unit/`).

## Gotchas

- `db:seed` must be run after `migrate` — seeder expects all tables to exist.
- Seeder creates sample teachers **without** `user_id` (accounts must be created via admin panel).
- Teacher `show` route uses route-model binding by slug, not ID.
- Image upload not yet implemented (no media handling in controllers).
- Public home loads only 6 teachers (`limit(6)`).
