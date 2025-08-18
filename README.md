# Handyman API

A RESTful API for the Handyman web application, built with Laravel. Provides endpoints for user authentication, job management, and admin panel access.

---

## Features

-   User registration, login, and authentication (API tokens)
-   Admin panel (Filament)
-   Job/task management endpoints
-   API documentation (Scribe)
-   Database migrations and seeding
-   Ready-to-use test accounts
-   Comprehensive test suite

---

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/miketorreno/handyman-api.git
cd handyman-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

```bash
cp .env.example .env
# Edit .env to add your database credentials
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Install Filament Admin Panel

```bash
php artisan filament:install --panels
```

### 6. Run Migrations & Seed Database

```bash
php artisan migrate:fresh --seed
```

### 7. Generate API Documentation

```bash
sail artisan scribe:generate
```

### 8. Start the Development Server

```bash
php artisan serve
```

---

## Usage

### API Documentation

-   [http://localhost/docs](http://localhost/docs)

### Admin Panel

-   [http://localhost/admin](http://localhost/admin)

#### Test Admin Accounts

```
email: admin@handyman.com
password: password

email: superadmin@handyman.com
password: password
```

---

## Authentication

All API requests require the following header:

```
Accept: application/json
Authorization: Bearer [token]
```

### Register

**POST** `/api/register`

**Body:**

```
name: string
email: string
password: string
password_confirmation: string
```

Returns a user object and API token.

### Login

**POST** `/api/login`

**Body:**

```
email: string
password: string
```

Returns a user object and API token.

### Logout

**POST** `/api/logout`

Requires Authorization header.

---

## API Endpoints

-   `POST /api/register` — Register a new user
-   `POST /api/login` — Login and receive token
-   `POST /api/logout` — Logout (invalidate token)
-   Additional endpoints for jobs, tasks, etc. (see [API docs](http://localhost/docs))

---

## Testing

Run the test suite:

```bash
php artisan test
```

---

## Contributing

1. Fork the repository and create your branch.
2. Write clear, concise commits and add tests for new features.
3. Open a pull request with a description of your changes.

---

## License

See [LICENSE](LICENSE) for details.
