# Inventory Management System (Laravel 10)

This starter project is a Laravel 10-oriented structure for a web-based inventory management system.

## Project structure

```text
inventory-management/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/AuthenticatedSessionController.php
│   │   ├── DashboardController.php
│   │   └── ProductController.php
│   ├── Models/Product.php
│   └── Services/Inventory/StockService.php
├── config/
├── database/migrations/2026_04_15_000001_create_products_table.php
├── public/
├── resources/views/
│   ├── auth/login.blade.php
│   ├── dashboard/index.blade.php
│   ├── layouts/app.blade.php
│   └── products/
├── routes/web.php
├── .env.example
└── composer.json
```

## Installation steps

1. Create project (Laravel 10):
   ```bash
   composer create-project laravel/laravel inventory-management "10.*"
   ```
2. Enter project directory:
   ```bash
   cd inventory-management
   ```
3. Install Breeze auth scaffolding:
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   npm install && npm run build
   ```
4. Prepare environment and app key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
5. Configure MySQL connection inside `.env`.
6. Run migrations:
   ```bash
   php artisan migrate
   ```
7. Start app:
   ```bash
   php artisan serve
   ```

## Initial `.env` example

```dotenv
APP_NAME="Inventory Management"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_db
DB_USERNAME=inventory_user
DB_PASSWORD=secret

QUEUE_CONNECTION=database
SESSION_DRIVER=file
CACHE_DRIVER=file
```

## Scalability notes

- Service layer (`app/Services`) is prepared for inventory domain logic expansion.
- Controllers remain thin and focused on request/response flow.
- Domain entities (`Product`) are isolated under `app/Models` for future modular growth.
- Queue/database session drivers are prepared in environment settings.

## Complete database schema

A full ERD explanation, normalization notes, stock tracking logic, and migration-based table design are documented in:

- `docs-database-schema.md`

## QA blackbox testing scenarios

Blackbox testing scenarios and SEQ usability question examples are documented in:

- `BLACKBOX_TESTING.md`
