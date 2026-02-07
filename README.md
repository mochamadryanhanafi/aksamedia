# Aksamedia Full Stack Developer Intern Test

This repository contains the solution for the Aksamedia Full Stack Developer Intern Test. It features a robust **Laravel** backend (Clean Architecture) and a modern **Vue.js 3** frontend (Tailwind CSS), all fully Dockerized for easy deployment.

## 🚀 Tech Stack

### Frontend
-   **Framework**: Vue.js 3 (Composition API)
-   **State Management**: Pinia (Persistent Store)
-   **Routing**: Vue Router
-   **Styling**: Tailwind CSS (Dark Mode enabled)
-   **HTTP Client**: Axios
-   **Build Tool**: Vite

### Backend
-   **Framework**: Laravel 11
-   **Architecture**: Clean Architecture (Service/Repository Pattern)
-   **Database**: MySQL 8
-   **Caching/Session**: Redis (Configurable)
-   **Tools**: PHP 8.2, Composer

### DevOps
-   **Containerization**: Docker & Docker Compose
-   **Services**: Nginx, MySQL, Redis, BMP (PhpMyAdmin)

---

## ✨ Features

### 🎨 Frontend
-   **Authentication**: Secure Login/Logout with JWT (Sanctum) and persistent session.
-   **Dashboard with Glassmorphism UI**:
    -   **CRUD Operations**: Create, Read, Update, Delete employees effortlessly.
    -   **Real-time Search & Filtering**: Filter by name and division instantly.
    -   **State Persistence**: Search queries and filters sync with the URL for shareable links.
    -   **Responsive Design**: Optimized for Desktop (Table view) and Mobile (Card view).
    -   **Glassy Navbar**: Fixed, translucent navbar with blur effect.
    -   **Dark Mode**: Automatically respects system preferences, with a manual toggle.
-   **Advanced Reporting**:
    -   **Realizing Potential (RT)**: Grouped scoring analysis.
    -   **Smart Test (ST)**: Weighted score calculation with complex logic.
-   **User Experience**: Skeleton loading screens, smooth transitions, and toast notifications.

### ⚙️ Backend
-   **Clean Architecture**: Strict separation of concerns (Controller -> Service -> Repository).
-   **Restful API**: Standardized endpoints for Auth, Divisions, and Employees.
-   **Optimization**: 
    -   Database transactions for data integrity.
    -   Efficient image handling (auto-cleanup of old files).
-   **SQL Mastery**: Implementation of complex SQL queries including Window Functions (`SUM ... OVER PARTITION`).

---

## 🛠️ Installation & Setup

### Prerequisites
-   [Docker](https://www.docker.com/) & Docker Compose
-   [Node.js](https://nodejs.org/) (v16+)
-   [Composer](https://getcomposer.org/)

### 1. Start Infrastructure (Docker)
Start the database and cache services using Docker Compose.

```bash
docker-compose up -d
```
*Services started: `aksamedia_mysql`, `aksamedia_redis`, `aksamedia_pma`.*

### 2. Backend Setup
Configure and start the Laravel API.

```bash
cd backend

# Install PHP dependencies
composer install

# Configure Environment
cp .env.example .env
# Ensure DB_PORT=3306 and Redis settings match your docker-compose config.

# Generate App Key
php artisan key:generate

# Run Migrations & Seeders
php artisan migrate --seed

# Link Storage for Images
php artisan storage:link

# Start Server
php artisan serve --port=8002
```

### 3. Frontend Setup
Install and run the Vue.js application.

```bash
cd frontend

# Install Dependencies
npm install

# Start Development Server
npm run dev
```

### 4. Import Sample Data (Bonus)
To fully test the Reporting features (`/nilaiRT` & `/nilaiST`), import the provided SQL dump.

```bash
# Run from project root
cat nilai.sql | docker exec -i aksamedia_mysql mariadb -u root -proot aksamedia
```

---

## 🔗 Access Points

| Service | URL | Credentials |
|:---|:---|:---|
| **Frontend App** | [http://localhost:5173](http://localhost:5173) | Register/Login in app |
| **Backend API** | [http://localhost:8002](http://localhost:8002) | - |
| **PHPMyAdmin** | [http://localhost:8081](http://localhost:8081) | User: `root`, Pass: `root` |

---

## 📚 API Highlights

### Employee Management
-   `GET /api/employees`: List employees (supports `name` and `division_id` filters).
-   `POST /api/employees`: Create new employee (with image upload).
-   `PUT /api/employees/{id}`: Update employee.
-   `DELETE /api/employees/{id}`: Soft delete employee.

### Complex Reports
-   **GET /api/nilaiRT**: Returns student scores grouped by NISN with `materi_uji_id=7`.
-   **GET /api/nilaiST**: Returns calculated total scores using weighted averages for `materi_uji_id=4`.

---

Developed with ❤️ for Aksamedia.
