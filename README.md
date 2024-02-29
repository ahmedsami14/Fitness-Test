<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Fitness Test

Welcome to the Laravel Project Fitness Test! This document will guide you through the process of installing and running the project locally.

## Prerequisites

Before you begin, make sure you have the following installed on your machine:

- [PHP](https://www.php.net/) (>= 8.x)
- [Composer](https://getcomposer.org/)
- [laravel](= 10.x)

## Installation
1. Clone the repository:

   ```bash
   git clone https://github.com/ahmedsami14/Fitness-Test.git

2. Copy the .env.example file to .env

3. Generate an application key: php artisan key:generate

4. Install PHP dependencies: composer install

5. Update the .env file with your database configuration and other settings

6. Migrate the database: php artisan migrate

## Running the Application

To start the development server, run the following command: php artisan serve

## Explain Some Endpoint

1. register -> index (to open page register)

2. register -> store (to send otp and register account).
and same with login 
3. fitbit/auth -> to try make integration with fitbit
4. when update email we send otp for new email
5. resend otp -> it work in all function has send otp

## File Postman collection added in project 