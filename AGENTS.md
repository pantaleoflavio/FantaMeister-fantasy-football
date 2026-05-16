# AGENTS.md

## Project overview

This repository contains a fantasy football web application inspired by the Italian Fantacalcio model.

The application manages one real football competition per deployment. It is not a multi-championship SaaS platform. The same repository should be reusable for different competitions by changing environment variables, configuration files, translations, branding and imported data.

Do not hardcode competition-specific labels such as Serie A, Bundesliga or Premier League. Use configuration values and translation keys.

## Repository layout

- backend/: Laravel API backend
- frontend/: React + TypeScript + Vite frontend
- docs/: project documentation
- .github/workflows/: CI workflows
- docker-compose.yml: local development stack

## Backend stack

- Laravel API
- PHP target: 8.5
- PostgreSQL
- Laravel Sanctum for authentication
- Filament for global admin
- API routes under /api/v1
- Supabase will be used only as managed PostgreSQL
- Cloudflare R2 will be used as S3-compatible object storage
- Redis is not required for the MVP
- Laravel database queues may be used later

## Backend conventions

- Keep controllers thin.
- Use Form Requests for validation.
- Use API Resources for JSON responses.
- Use Policies for authorization.
- Use service classes for business and domain logic.
- Use Events, Listeners and Jobs only when they simplify the design.
- Do not put business logic directly inside controllers.
- Do not manually edit composer.json to add dependencies. Use Composer commands and keep composer.lock synchronized.

## Frontend stack

- React
- TypeScript
- Vite
- React Router
- TanStack Query
- React Hook Form
- Zod
- Tailwind CSS
- shadcn/ui where useful
- i18n translation files

## Frontend conventions

- Use feature-based folders.
- Use typed API clients and hooks.
- Use loading, empty and error states for API-driven pages.
- Do not hardcode user-facing labels directly in components if they should be translatable.
- Do not manually edit package.json to add dependencies. Use npm commands and keep package-lock.json synchronized.

## Docker strategy

Local development uses Docker Compose.

Backend Docker strategy:

- backend/Dockerfile.dev is for local development.
- backend/Dockerfile.prod is for production-style deployment.
- FrankenPHP is the preferred backend server path.
- Do not use php artisan serve as the final production server.
- Production deployments should bind to 0.0.0.0:${PORT} where required by the platform.
- Render deployment should use backend/Dockerfile.prod.

Frontend Docker strategy:

- The frontend can run in Docker for local development.
- Production frontend deployment should be a static build on Cloudflare Pages.

## Infrastructure targets

MVP infrastructure target:

- Frontend: Cloudflare Pages
- Backend: Render Free Web Service initially
- Database: Supabase PostgreSQL
- Storage: Cloudflare R2
- CI/CD: GitHub Actions
- Monthly cost target: 0 EUR

Do not use Supabase Auth or Supabase-generated APIs as the main application layer. Authentication must be handled by Laravel Sanctum.

## Core product scope

Initial league types:

- classic: standings based on total fantasy points
- formula_one: points assigned by matchday placement
- head_to_head: direct matches with fantasy points converted into goals

Core fantasy concepts:

- users
- global roles
- league roles
- seasons
- real clubs
- players
- player roles
- matchdays
- real matches
- player scores
- leagues
- invitations
- fantasy teams
- rosters
- formations
- substitutions
- team matchday scores
- standings
- trades
- notifications
- imports

Excluded from MVP:

- multi-championship in the same deployment
- SaaS billing or subscriptions
- live auction
- real-time or websockets
- chat
- push notifications
- mobile app
- external sports API integration
- scraping
- cup or knockout competitions

## Commands

Run backend tests locally:

- cd backend
- php artisan test

Run backend tests in Docker:

- docker compose exec backend php artisan test

Run frontend build locally:

- cd frontend
- npm run build

Run frontend build in Docker:

- docker compose exec frontend npm run build

Start local Docker stack:

- docker compose up -d --build

Stop local Docker stack:

- docker compose down

Check backend health in local Docker:

- curl http://127.0.0.1:8000/api/v1/health

Build production-style backend container:

- docker build -f backend/Dockerfile.prod -t fantameister-backend-prod ./backend

Run production-style backend container locally:

- docker run --rm -p 8080:8000 --env-file backend/.env -e PORT=8000 -e DB_HOST=host.docker.internal fantameister-backend-prod

Check production-style backend container:

- curl http://127.0.0.1:8080/api/v1/health

## Workflow rules for Codex

Before making changes:

1. Inspect the repository.
2. Read this file.
3. Check existing patterns before adding new ones.
4. Keep the requested milestone scope narrow.
5. Do not start the next milestone unless explicitly asked.

After making changes:

1. List changed files.
2. List commands to verify.
3. Mention any commands that could not be run.
4. Do not claim tests passed unless they were actually run.

## Dependency rules

Composer:

- Use composer require or composer require --dev for new PHP dependencies.
- Keep composer.json and composer.lock synchronized.
- Do not manually add packages to composer.json.

npm:

- Use npm install for new frontend dependencies.
- Keep package.json and package-lock.json synchronized.
- Do not manually add packages to package.json.

## Current milestone status

Milestone 1 is the base setup:

- Laravel backend
- React frontend
- Docker Compose
- FrankenPHP backend Dockerfiles
- health endpoint
- frontend health check
- README/setup documentation

Milestone 2 should implement:

- authentication
- Sanctum endpoints
- global roles
- default user role
- global admin seed
- frontend auth pages
- protected routes