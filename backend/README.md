# FantaMeister Backend

Laravel API backend for **FantaMeister**, a multi-competition fantasy football platform.

The backend is designed to support multiple real football competitions, seasons, clubs and players within a single deployment, while keeping global administration separate from league-specific permissions.

## Tech stack

* PHP 8.5
* Laravel 13
* PostgreSQL
* Laravel Sanctum
* Filament 5
* FrankenPHP
* Docker Compose
* PHPUnit
* Laravel Pint

## Current features

* REST API versioned under `/api/v1`
* User registration and authentication with Laravel Sanctum
* Password reset flow
* Global role hierarchy:

  * `super_admin`
  * `global_admin`
  * `user`
* League-scoped roles:

  * `commissioner`
  * `co_commissioner`
  * `participant`
* Multi-competition real-football domain
* Filament administration panel
* English, German and Italian admin translations
* Session-based language switcher
* Database factories, seeders and automated tests

## Domain architecture

The real-football domain separates global entities from season-specific participation.

```text
RealCompetition
└── Season
    ├── SeasonClub
    │   └── RealClub
    ├── PlayerSeasonRegistration
    │   ├── Player
    │   ├── PlayerRole
    │   └── SeasonClub
    └── Matchday
        └── RealMatch
```

Key design decisions:

* real clubs and players are global identities
* clubs participate in competitions through `season_clubs`
* players are associated with clubs, roles and quotations through season registrations
* matchdays belong to seasons
* real matches reference the participating season clubs
* fantasy league permissions remain separate from global platform roles

## API

Implemented endpoints:

```text
GET  /api/v1/health

POST /api/v1/auth/register
POST /api/v1/auth/login
POST /api/v1/auth/logout
GET  /api/v1/auth/me

POST /api/v1/auth/forgot-password
POST /api/v1/auth/reset-password
```

List the registered routes:

```bash
docker compose exec backend php artisan route:list --path=api/v1
```

## Administration panel

The internal administration panel is available at:

```text
http://127.0.0.1:8000/admin
```

Access rules:

* `super_admin` can manage domain data, users and global roles
* `global_admin` can manage domain data
* regular users cannot access the panel

The panel supports English, German and Italian. The selected language is stored in the current browser session.

## Local development

From the repository root:

```bash
cp backend/.env.example backend/.env
docker compose up -d --build
```

Run migrations and seeders:

```bash
docker compose exec backend php artisan migrate:fresh --seed
```

Run the backend test suite:

```bash
docker compose exec backend php artisan test
```

Check code formatting:

```bash
docker compose exec backend ./vendor/bin/pint --test
```

Apply formatting:

```bash
docker compose exec backend ./vendor/bin/pint
```

Check Composer metadata and security advisories:

```bash
docker compose exec backend composer validate
docker compose exec backend composer audit --locked
docker compose exec backend composer dump-autoload -o
```

## Engineering conventions

The backend follows these conventions:

* thin controllers
* Form Requests for validation
* API Resources for response transformation
* Policies for authorization
* services or actions for non-trivial business logic
* granular database migrations
* explicit Eloquent relationships
* database constraints for domain integrity
* automated feature and domain tests
* PSR-4 compliant namespaces and file structure

## Project status

Completed foundations:

* development infrastructure
* authentication
* global role hierarchy
* multi-competition domain
* Filament administration
* backend internationalization

Next development area:

* fantasy league lifecycle
* league memberships
* commissioner and participant permissions
