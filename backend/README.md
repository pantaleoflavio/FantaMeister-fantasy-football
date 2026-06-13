# Backend — Laravel API

This folder contains the Laravel API backend for FantaMeister.

## Stack

* PHP 8.5
* Laravel
* PostgreSQL
* Laravel Sanctum
* FrankenPHP
* Docker Compose

## API prefix

All API routes should be versioned under:

```text
/api/v1
```

Current implemented routes:

```text
GET       /api/v1/health
POST      /api/v1/auth/register
POST      /api/v1/auth/login
POST      /api/v1/auth/logout
GET       /api/v1/auth/me
POST      /api/v1/auth/forgot-password
POST      /api/v1/auth/reset-password
```

Check routes:

```bash
php artisan route:list --path=api/v1
```

From the host:

```bash
docker compose exec backend php artisan route:list --path=api/v1
```

## Domain status

Milestone 3.5 extends the stabilized core fantasy football domain with multi-competition support in one database. The real-football model follows these boundaries:

* real competitions have many seasons
* leagues and matchdays belong to seasons
* real clubs are global identities connected to seasons through `season_clubs`
* players are global identities connected to clubs and seasons through `player_season_registrations`
* real matches reference the participating season clubs
* player scores reference season-specific player registrations

The backend includes granular migrations, Eloquent models and relationships, lookup seeders, high-priority factories, and focused domain tests for relationships, JSON casting, lookup seeders, and constraints.

## Architecture conventions

Use:

* thin controllers
* Form Requests for validation
* API Resources for JSON output
* Policies for authorization
* service classes for business logic
* Events, Listeners and Jobs only when they simplify the design

Avoid:

* business logic inside controllers
* manually editing `composer.json` without updating `composer.lock`
* hardcoded competition labels
* large all-in-one migrations

## Authentication

Authentication uses Laravel Sanctum.

Implemented auth scope:

* register
* login
* logout
* authenticated user endpoint
* forgot password
* reset password
* global roles
* default user role
* global admin seeder

Registered users must receive the default `user` role.

The global admin user is created by `GlobalAdminSeeder` using environment-driven values:

```env
GLOBAL_ADMIN_NAME="Global Admin"
GLOBAL_ADMIN_EMAIL=admin@example.com
GLOBAL_ADMIN_PASSWORD=password
```

## Configuration

Main deployment branding configuration:

```text
config/competition.php
```

Deployment-specific values should come from environment variables.

Do not use deployment branding configuration as the source of real-competition domain data.

## Docker development

Start the full stack from the repository root after preparing the backend environment file:

```bash
cp backend/.env.example backend/.env
docker compose up -d --build
```

Enter the backend container:

```bash
docker compose exec backend sh
```

The backend development container runs `composer install` before starting FrankenPHP. This keeps a fresh `/app/vendor` named volume compatible with first-time `docker compose up -d --build` and after intentional volume resets.

Run backend tests:

```bash
php artisan test
```

Run migrations and seeders:

```bash
php artisan migrate:fresh --seed
```

Clear Laravel caches:

```bash
php artisan optimize:clear
```

If the `vendor` directory is missing inside an already-running backend container, run `composer install` inside that container or recreate the backend service so the startup command repopulates the named volume. This can happen after intentionally removing volumes with `docker compose down -v`.

## Database

Inside Docker, Laravel connects to PostgreSQL using:

```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=fantasy_football
DB_USERNAME=fantasy
DB_PASSWORD=password
```

The host-side PostgreSQL port is mapped to:

```text
localhost:5433
```

Do not use `5433` inside the backend container.

## Testing

Run all backend tests:

```bash
php artisan test
```

From the host:

```bash
docker compose exec backend php artisan test
```

Run migration/seed verification:

```bash
docker compose exec backend php artisan migrate:fresh --seed
```

Validate Composer metadata:

```bash
docker compose exec backend composer validate
docker compose exec backend composer dump-autoload
```

## Code style

Laravel Pint is used for PHP code style.

Run Pint inside the backend container:

```bash
docker compose exec backend ./vendor/bin/pint
```

Check formatting without changing files:

```bash
docker compose exec backend ./vendor/bin/pint --test
```

## Production-style backend

The production-style backend Dockerfile is:

```text
backend/Dockerfile.prod
```

Build it from the repository root:

```bash
docker build -f backend/Dockerfile.prod -t fantameister-backend-prod ./backend
```

Run it locally:

```bash
docker run --rm -p 8080:8000 \
  --env-file backend/.env \
  -e PORT=8000 \
  -e DB_HOST=host.docker.internal \
  fantameister-backend-prod
```

Check health:

```bash
curl http://127.0.0.1:8080/api/v1/health
```

## Migration conventions

Use granular migrations.

Preferred rule:

* one migration per table

Do not create one large migration for an entire milestone.

Bad migration names:

```text
create_milestone3_domain_tables
create_all_domain_tables
create_fantasy_schema
create_core_tables
```

Good migration names:

```text
create_seasons_table
create_real_clubs_table
create_players_table
create_leagues_table
create_fantasy_teams_table
create_formations_table
```

Migration order must respect foreign-key dependencies.

Existing auth migrations should not be modified unless explicitly requested.

## Domain model milestone

Milestone 3 and the Milestone 3.5 multi-competition refactor are implemented and stabilized with:

* core domain migrations
* Eloquent models
* relationships
* lookup seeders
* high-priority factories
* focused relationship and constraint tests

Milestone 3 does not include:

* gameplay API routes
* Filament resources
* frontend domain pages
* scoring calculation logic

## Internal administration

The internal Filament panel is available at `/admin`. Global platform roles control panel access: `super_admin` can manage all domain data, users, and global roles; `global_admin` can manage domain data but cannot manage users or global roles; `user` cannot access the panel. League-specific roles (`commissioner`, `co_commissioner`, and `participant`) remain separate and only apply within a league.

Global platform roles are stored in `roles` and `role_user`. League-scoped roles are stored separately in `league_roles` and `league_user`; league roles never grant access to the global admin panel.

Optional super-admin seeding uses `SUPER_ADMIN_NAME`, `SUPER_ADMIN_EMAIL`, and `SUPER_ADMIN_PASSWORD`. Set `SUPER_ADMIN_EMAIL` to enable it. Global-admin seeding continues to use the corresponding `GLOBAL_ADMIN_*` variables.