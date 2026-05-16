# FantaMeister Fantasy Football Monorepo

Milestone 1: working monorepo skeleton con backend Laravel e frontend React/Vite.

## Struttura
- `backend/` Laravel API
- `frontend/` React + TypeScript + Vite SPA
- `docker-compose.yml` stack locale con PostgreSQL, backend e frontend

## 1) Setup backend (locale)
```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```
Backend disponibile su `http://localhost:8000`.
Health endpoint: `http://localhost:8000/api/v1/health`.

## 2) Setup frontend (locale)
```bash
cd frontend
cp .env.example .env
npm install
npm run dev
```
Frontend disponibile su `http://localhost:5173`.

## 3) Test backend
```bash
cd backend
php artisan test
```

## 4) Build frontend
```bash
cd frontend
npm run build
```

## 5) Setup rapido con Docker Compose
```bash
docker compose up -d postgres
cd backend && cp .env.example .env && composer install && php artisan key:generate && php artisan migrate
cd ../frontend && cp .env.example .env && npm install
cd .. && docker compose up backend frontend
```

## Note
- Nessuna etichetta hardcoded di campionati reali: configurazione competizione in `backend/config/competition.php`.