# Handyman API

The API for handyman web app.

<br>

## Install

```
git clone https://github.com/miketorreno/handyman-api.git

cd handyman-api
```

```
composer install
```

```
cp .env.example .env

(add database credentials)
```

```
php artisan key:generate
```

```
php artisan filament:install --panels
```

```
php artisan migrate:fresh —seed
```

```
sail artisan scribe:generate
```

```
php artisan serve
```

<br>

## Usage

### API documentation

[http://localhost/docs](http://localhost/docs)

### Admin

[http://localhost/admin](http://localhost/admin)

```
email: admin@handyman.com
password: password


email: superadmin@handyman.com
password: password

```

### Auth

#### Headers

`Accept: application/json`

`Authorization: Bearer [token]`

#### Path Parameters

#### Register

**[POST]** [http://localhost/api/register](http://localhost/api/register)

```
name: 
email: 
password: 
password_confirmation: 
```

You'll get back user object & an api token. Use the api token in the headers for subsequent requests.

<hr>

#### Login

**[POST]** [http://localhost/api/login](http://localhost/api/login)

```
email: 
password: 
```

You'll get back user object & an api token. Use the api token in the headers for subsequent requests.

<hr>

#### Logout

**[POST]** [http://localhost/api/logout](http://localhost/api/logout)

Make sure to include the authorization token.

<br>

#### Send the authorization token with every POST, PUT & DELETE requests

<br>

## Tests

```
php artisan test
```
