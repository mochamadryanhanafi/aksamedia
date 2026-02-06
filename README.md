# Aksamedia Full Stack Developer Intern Test

This repository contains the solution for the Aksamedia Full Stack Developer Intern Test, developed by [Your Name/Username].

It features a **Laravel** backend (Clean Architecture) and a **Vue.js 3** frontend (Tailwind CSS), running in a Dockerized environment.

## Tech Stack

-   **Frontend**: Vue.js 3, Pinia, Vue Router, Tailwind CSS, Axios.
-   **Backend**: Laravel 11, Sanctum (Auth), Clean Architecture (Service/Repository Pattern).
-   **Database**: MySQL 8 (Dockerized).
-   **Cache**: Redis (Dockerized).
-   **DevOps**: Docker Compose for orchestrating MySQL, Redis, and PHPMyAdmin.

## Features

### Frontend
-   **Authentication**: Login/Logout with persistent session management.
-   **Dashboard**:
    -   Employee Management (CRUD).
    -   Real-time search and filtering (by Division).
    -   **State Persistence**: Search terms, filters, and pagination sync with the URL query string.
    -   **Responsive Design**: Desktop table view and Mobile card view.
    -   **Glassmorphism UI**: Modern aesthetic with gradients and blur effects.
    -   **Dark Mode**: Automatically adapts to system preferences.
-   **Compliance Polish**: Custom built dropdown for Navbar logout (no external UI libraries).

### Backend
-   **Clean Architecture**: Separation of concerns using Controllers, Services, and Repositories.
-   **API Endpoints**: RESTful APIs for Auth, Divisions, and Employees.
-   **SQL Bonus Tasks**:
    -   `/api/nilaiRT`: Complex grouping of student scores.
    -   `/api/nilaiST`: Weighted score calculation using **SQL Window Functions** (`SUM ... OVER PARTITION`).

## Installation & Setup

### Prerequisites
-   Docker & Docker Compose
-   Node.js & NPM
-   PHP & Composer (Local) or use Docker container

### 1. Start Infrastructure (Docker)
Start MySQL, Redis, and PHPMyAdmin containers.

```bash
docker-compose up -d
```

### 2. Backend Setup
Navigate to the `backend` directory and set up Laravel.

```bash
cd backend

# Install dependencies
composer install

# Environment setup
cp .env.example .env
# Edit .env to match Docker ports (DB_PORT=3306, APP_URL=http://localhost:8002)

# Generate Key
php artisan key:generate

# Run Migrations & Seeders
php artisan migrate --seed

# Link Storage
php artisan storage:link

# Start Server
php artisan serve --port=8002
```

### 3. Frontend Setup
Navigate to the `frontend` directory.

```bash
cd frontend

# Install dependencies
npm install

# Start Dev Server
npm run dev
```

### 4. SQL Bonus Task Setup (Import Data)
To verify the `/nilaiRT` and `/nilaiST` endpoints, you must import the provided SQL data.

```bash
# From project root
cat nilai.sql | docker exec -i aksamedia_mysql mariadb -u root -proot aksamedia
```

## Access Points

-   **Frontend**: [http://localhost:5173](http://localhost:5173)
-   **Backend API**: [http://localhost:8002](http://localhost:8002)
-   **PHPMyAdmin**: [http://localhost:8081](http://localhost:8081)

## API Endpoints (Bonus)

-   **Realizing Potential Report**:
    `GET http://localhost:8002/api/nilaiRT`
    *Logic: Filters `materi_uji_id=7`, groups by NISN.*

-   **Weighted Score Report**:
    `GET http://localhost:8002/api/nilaiST`
    *Logic: Filters `materi_uji_id=4`, calculates total using SQL Window Functions with specific multipliers (Verbal: 41.67, etc.), sorts by Total Descending.*

---
Completed by [Your Name] for Aksamedia.
