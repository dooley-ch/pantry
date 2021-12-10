# Configuration

| Area              | Location                                           | Comment                                      |
|-------------------|----------------------------------------------------|----------------------------------------------|
| Log File Names    | /vendor/laravel/lumen-framework/config/logging.php | Search for the name lumen.log and replace it |

## Install Session Management 

### Step 1

Install illuminate/session using: `composer require illuminate/session` 

### Step 2

Add middleware to bootstrap/app.php:

`
$app->middleware([\Illuminate\Session\Middleware\StartSession::class,]);
`
### Step 3

Now add config/session.php to the application.  The contents can be found in the 
[Laravel official repo](https://github.com/laravel/laravel/blob/master/config/session.php). 

### Step 4

Create session storage directory by:

`
mkdir -p storage/framework/sessions
`

### Step 5

In bootstrap/app.php add bindings for \Illuminate\Session\SessionManager:

`
$app->singleton(Illuminate\Session\SessionManager::class, function () use ($app) {
return $app->loadComponent('session', Illuminate\Session\SessionServiceProvider::class, 'session');
});
$app->singleton('session.store', function () use ($app) {
return $app->loadComponent('session', Illuminate\Session\SessionServiceProvider::class, 'session.store');
});
`





# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
