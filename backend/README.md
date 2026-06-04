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

Main competition configuration:

```text
config/competition.php
```

Deployment-specific values should come from environment variables.

Do not hardcode real competition names inside code.

## Docker development

Start the full stack from the repository root:

```bash
docker compose up -d --build
```

Enter the backend container:

```bash
docker compose exec backend sh
```

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

If the `vendor` directory is missing inside the backend container, run:

```bash
composer install
```

This can happen after:

```bash
docker compose down -v
```

because named Docker volumes are removed.

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

The current domain model work should add:

* core domain migrations
* Eloquent models
* relationships
* lookup seeders
* factories
* relationship tests

It should not add:

* gameplay API routes
* Filament resources
* frontend domain pages
* scoring calculation logic
