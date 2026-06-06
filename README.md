# FantaMeister Fantasy Football

FantaMeister is a fantasy football web application inspired by the Italian Fantacalcio model.

The application is designed for one real football competition per deployment. It is not a multi-championship SaaS platform. The same codebase can be reused for different competitions by changing environment variables, configuration files, translations, branding and imported data.

## Current project status

Completed:

* Laravel API backend
* React + TypeScript + Vite frontend
* Docker Compose local stack
* PostgreSQL local database
* FrankenPHP backend runtime
* backend health endpoint
* frontend health check
* Laravel Sanctum authentication
* register, login, logout
* authenticated user endpoint
* forgot/reset password
* global roles
* default user role
* global admin seeder
* auth service layer
* frontend auth pages
* protected frontend routes
* frontend i18n structure for auth/navigation
* core fantasy football domain model (Milestone 3)
* granular database migrations
* Eloquent domain models and relationships
* lookup seeders
* high-priority domain factories
* focused domain relationship and constraint tests

In progress:

* Milestone 4 planning

## Repository structure

* `backend/`: Laravel API backend
* `frontend/`: React + TypeScript + Vite frontend
* `docs/`: project documentation
* `.github/workflows/`: CI workflows
* `docker-compose.yml`: local development stack

## Main stack

Backend:

* PHP 8.5
* Laravel
* PostgreSQL
* Laravel Sanctum
* FrankenPHP
* Docker Compose

Frontend:

* React
* TypeScript
* Vite
* React Router
* TanStack Query
* React Hook Form
* Zod
* Tailwind CSS
* lightweight i18n structure

Planned infrastructure:

* Frontend: Cloudflare Pages
* Backend: Render initially
* Database: Supabase PostgreSQL
* Storage: Cloudflare R2
* CI/CD: GitHub Actions

## Local development with Docker Compose

Prepare the backend environment file, then start the full stack:

```bash
cp backend/.env.example backend/.env
docker compose up -d --build
```

The Docker backend service explicitly connects to PostgreSQL with `DB_PASSWORD=password`, matching the `POSTGRES_PASSWORD=password` value used by the PostgreSQL service. The backend development container runs `composer install` before starting FrankenPHP, so a fresh `backend_vendor` named volume is populated automatically.

Check running services:

```bash
docker compose ps
```

Stop the stack:

```bash
docker compose down
```

Stop the stack and remove local volumes:

```bash
docker compose down -v
```

Use `docker compose down -v` only when you intentionally want to reset local PostgreSQL data and named volumes.

## Local URLs

Backend:

```text
http://127.0.0.1:8000
```

Frontend:

```text
http://localhost:5173
```

Backend health endpoint:

```bash
curl http://127.0.0.1:8000/api/v1/health
```

## Backend commands

Run backend commands inside the backend container:

```bash
docker compose exec backend sh
```

Inside the backend container:

```bash
php artisan test
php artisan migrate:fresh --seed
php artisan route:list --path=api/v1
composer validate
composer dump-autoload
```

From the host:

```bash
docker compose exec backend php artisan test
docker compose exec backend php artisan migrate:fresh --seed
docker compose exec backend php artisan route:list --path=api/v1
docker compose exec backend composer validate
```

## Frontend commands

Run frontend commands inside the frontend container:

```bash
docker compose exec frontend sh
```

Inside the frontend container:

```bash
npm run dev
npm run build
```

From the host:

```bash
docker compose exec frontend npm run build
```

## Verification checklist

Before committing backend/frontend changes, run:

```bash
docker compose exec backend composer validate
docker compose exec backend composer dump-autoload
docker compose exec backend php artisan migrate:fresh --seed
docker compose exec backend php artisan test
docker compose exec frontend npm run build
curl http://127.0.0.1:8000/api/v1/health
```

## Auth API

Current API routes:

```text
GET       /api/v1/health
POST      /api/v1/auth/register
POST      /api/v1/auth/login
POST      /api/v1/auth/logout
GET       /api/v1/auth/me
POST      /api/v1/auth/forgot-password
POST      /api/v1/auth/reset-password
```

Check API routes:

```bash
docker compose exec backend php artisan route:list --path=api/v1
```

## Local database

The PostgreSQL service is exposed to the host on:

```text
localhost:5433
```

Inside Docker, the backend connects to PostgreSQL using:

```text
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=fantasy_football
DB_USERNAME=fantasy
DB_PASSWORD=password
```

Do not use `5433` inside the backend container. `5433` is only the host-side mapped port.

## Environment files

Backend:

```bash
cp backend/.env.example backend/.env
```

Frontend:

```bash
cp frontend/.env.example frontend/.env
```

Real `.env` files must not be committed.

## Production-style backend container

Build the production-style backend image:

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

Check it:

```bash
curl http://127.0.0.1:8080/api/v1/health
```
