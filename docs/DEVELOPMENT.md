# Development Guide

This document describes the local development workflow for FantaMeister.

## Requirements

Recommended local environment:

* Windows with WSL2 Ubuntu
* Docker Desktop with WSL integration enabled
* VS Code with Remote WSL
* Git
* Docker Compose

The preferred workflow uses Docker containers for application commands.

## Working directory

Example project path in WSL:

```bash
cd /mnt/c/xampp/htdocs/FantaMeister-fantasy-football
```

## Start the local stack

```bash#
cp backend/.env.example backend/.env
docker compose up -d --build
```

Check services:

```bash
docker compose ps
```

Expected services:

* backend
* frontend
* postgres

## Stop the local stack

```bash
docker compose down
```

Reset local containers and volumes:

```bash
docker compose down -v
```

Use `down -v` only when you intentionally want to reset local PostgreSQL data and named volumes.

## Backend container workflow

Enter the backend container:

```bash
docker compose exec backend sh
```

The backend development service sets Docker PostgreSQL credentials explicitly, including `DB_PASSWORD=password`, and runs `composer install` before FrankenPHP starts so a fresh backend vendor volume is populated automatically.

Common backend commands:

```bash
php artisan test
php artisan migrate:fresh --seed
php artisan route:list --path=api/v1
php artisan optimize:clear
composer validate
```

From the host:

```bash
docker compose exec backend php artisan test
docker compose exec backend php artisan migrate:fresh --seed
docker compose exec backend composer validate
docker compose exec backend composer dump-autoload
```

## Frontend container workflow

Enter the frontend container:

```bash
docker compose exec frontend sh
```

Common frontend commands:

```bash
npm run dev
npm run build
```

From the host:

```bash
docker compose exec frontend npm run build
```

## Verification checklist

Before committing changes, run:

```bash
docker compose exec backend composer validate
docker compose exec backend php artisan migrate:fresh --seed
docker compose exec backend composer dump-autoload
docker compose exec backend php artisan test
docker compose exec frontend npm run build
curl http://127.0.0.1:8000/api/v1/health
```

## Backend code style

PHP code style should be handled with Laravel Pint.

Run Pint:

```bash
docker compose exec backend ./vendor/bin/pint
```

Check formatting without applying changes:

```bash
docker compose exec backend ./vendor/bin/pint --test
```

## Frontend code style

Frontend formatting should be handled with Prettier.

Run Prettier from the frontend container:

```bash
docker compose exec frontend npx prettier --write .
```

Check formatting without applying changes:

```bash
docker compose exec frontend npx prettier --check .
```

## Suggested VS Code setup

Recommended extensions:

* Remote - WSL
* Docker
* PHP Intelephense
* Laravel Pint formatter
* Prettier - Code formatter
* Tailwind CSS IntelliSense
* ESLint

Recommended editor behavior:

* format TypeScript, React, JSON, CSS and Markdown with Prettier
* format PHP with Laravel Pint
* keep `.env` files uncommitted
* run the full verification checklist before committing

If workspace VS Code settings are kept local, they should not be committed.

## Environment files

Backend:

```bash
cp backend/.env.example backend/.env
```

Frontend:

```bash
cp frontend/.env.example frontend/.env
```

Never commit real `.env` files.

## Local PostgreSQL

Inside Docker:

```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=fantasy_football
DB_USERNAME=fantasy
DB_PASSWORD=password
```

From the host machine:

```text
localhost:5433
```

## Multi-competition domain model

The application stores multiple real football competitions in one database. Seasons belong to real competitions, and fantasy leagues belong to seasons. Real clubs and players are global identities: `season_clubs` records club participation in a season, while `player_season_registrations` records a player's club, eligibility, quotation, and active status for a season.

Real matches reference season clubs, and player scores reference player season registrations. This keeps competition- and season-specific data separate from global club and player identity.

## Migrations

Use granular Laravel migrations. The domain schema follows this convention.

Preferred rule:

* one migration per table

Do not create milestone-sized migrations such as:

```text
create_milestone3_domain_tables
create_all_domain_tables
create_fantasy_schema
```

Migration order must respect foreign-key dependencies.

## Git workflow

Use `dev` for active development.

Use `main` as stable baseline.

Check current branch:

```bash
git branch
```

Commit manually:

```bash
git status
git add .
git commit -m "Your commit message"
git push
```

## Troubleshooting

If backend says `vendor/autoload.php` is missing, run:

```bash
docker compose exec backend composer install
```

If services are not running:

```bash
docker compose up -d --build
```

If PostgreSQL credentials mismatch after changing compose environment variables:

```bash
docker compose down -v
docker compose up -d --build
```

If frontend build fails after dependency changes:

```bash
docker compose exec frontend npm install
docker compose exec frontend npm run build
```

## Internal admin panel

The Filament internal admin panel is served at `http://127.0.0.1:8000/admin` and uses the existing user accounts.

- `super_admin` (level 100) manages all domain resources, users, and global roles.
- `global_admin` (level 80) manages domain resources but cannot manage users or global roles.
- `user` (level 10) is a normal platform user and cannot access the admin panel.
- League roles are league-scoped records in `league_roles` / `league_user` and are intentionally separate from global platform roles in `roles` / `role_user`.