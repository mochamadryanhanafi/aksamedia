# Aksamedia Backend API

This directory contains the Laravel-based backend API It implements a Clean Architecture pattern (Controller -> Service -> Repository) and uses Laravel Sanctum for authentication.

## 🛠️ Tech Stack

-   **Framework**: Laravel 11
-   **Language**: PHP 8.2+
-   **Database**: MySQL 8.0
-   **Cache/Queue**: Redis (Optional/Configurable)
-   **Authentication**: Laravel Sanctum (Bearer Token)
-   **Documentation**: Scribe (Optional) / Postman Collection

## 📂 Directory Structure

Key architectural components:

```
app/
├── Http/
│   ├── Controllers/       # Handles HTTP requests
│   ├── Requests/          # Form Validation
│   └── Resources/         # API Response Transformations
├── Services/              # Business Logic Layer
│   └── Interfaces/        # Service Contracts
├── Repositories/          # Data Access Layer
│   └── Interfaces/        # Repository Contracts
├── Models/                # Eloquent Models
└── Providers/             # Dependency Injection Binding
```

## 🚀 Setup & Installation

### Prerequisites
-   PHP 8.2+
-   Composer
-   MySQL

### Steps

1.  **Install Dependencies**
    ```bash
    composer install
    ```

2.  **Environment Configuration**
    ```bash
    cp .env.example .env
    ```
    Update `.env` with your database credentials:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=aksamedia
    DB_USERNAME=root
    DB_PASSWORD=root
    ```

3.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

4.  **Run Migrations & Seeders**
    ```bash
    php artisan migrate --seed
    ```

5.  **Serve Application**
    ```bash
    php artisan serve
    ```
    The API will be available at `http://localhost:8000` (or 8002 if using Docker mapping).

## 🔑 Key Commands

| Command | Description |
| :--- | :--- |
| `php artisan migrate:fresh --seed` | Reset DB and populate with sample data |
| `php artisan make:service MyService` | Create a new Service (if custom command exists) |
| `php artisan optimize:clear` | Clear all caches |
| `php artisan storage:link` | Link public storage for images |

## 🧪 Testing

Run PHPUnit tests:

```bash
php artisan test
```
