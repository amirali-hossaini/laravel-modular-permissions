
# Laravel Modular Permissions API

A modular Laravel API project implementing **Role-Based Access Control (RBAC)** with the following features:

- **Direct user permissions**
- **Role-based permissions**
- **Organizational chart permissions**
- **User management**
- **Blog module** (as an example)

The project is fully **Dockerized using Laravel Sail** for consistent, easy, and reproducible local development.

---

## Features

- Modular structure (`app/Modules`)
- Advanced permission system (user, role, and organizational chart)
- User permission caching for high performance
- **API-only** (no views)
- **Sanctum authentication**
- Comprehensive **Postman collection** included
- Ready for **testing** and **production**

---

## Prerequisites

- **Docker & Docker Compose**
- **Git**
- **Composer** (only for initial setup)

> All required services (PHP, MySQL, Redis, etc.) are provided by Sail containers.

---

## Installation & Setup

Follow the steps below to set up the project:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/amirali-hossaini/laravel-modular-permissions.git
    cd laravel-modular-permissions
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Copy the environment file:**

    ```bash
    cp .env.example .env
    ```

4. **Generate the application key:**

    ```bash
    php artisan key:generate
    ```

5. **Start Sail containers** (with build for first-time setup):

    ```bash
    ./vendor/bin/sail up -d --build
    ```

6. **Run database migrations and seed initial data:**

    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

7. **(Optional) Run tests:**

    ```bash
    ./vendor/bin/sail artisan test
    ```

---

## API Endpoints

Your application will be accessible at:

- **Application URL:** [http://localhost:8088](http://localhost:8088)
- **API Base URL:** [http://localhost:8088/api/v1](http://localhost:8088/api/v1)

---

## Postman Collection

A comprehensive **Postman collection** is included in the project. You can use it to test all available API endpoints efficiently.