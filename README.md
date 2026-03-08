# Laravel Project

This project is built with **Laravel**, **Vue**, **Inertia**, and **Ziggy**, using **Laravel Sail** for the development environment.

---

# Requirements

You only need:

* **Docker**
* **Docker Compose**

Laravel Sail will handle PHP, database, Redis, and other services inside containers.

---

# Installation

Clone the repository:

```bash
git clone <repository-url>
cd <project-folder>
```

Install PHP dependencies:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install
```

Copy the environment file:

```bash
cp .env.example .env
```

Start Sail:

```bash
./vendor/bin/sail up -d
```

Generate the application key:

```bash
./vendor/bin/sail artisan key:generate
```

Install frontend dependencies:

```bash
./vendor/bin/sail npm install
```

---

# Database

Run migrations:

```bash
./vendor/bin/sail artisan migrate
```

Run seeders:

```bash
./vendor/bin/sail artisan db:seed
```

---

# Generate Ziggy Routes

If the project uses **Ziggy** for frontend routing:

```bash
./vendor/bin/sail artisan ziggy:generate
```

---

# Running the Project

Start Sail (if not already running):

```bash
./vendor/bin/sail up -d
```

Run the frontend dev server:

```bash
./vendor/bin/sail npm run dev
```

The application will be available at:

```
http://localhost
```

---

# Queue Worker (if needed)

```bash
./vendor/bin/sail artisan queue:work
```

---

# Useful Commands

Run tests:

```bash
./vendor/bin/sail artisan test
```
