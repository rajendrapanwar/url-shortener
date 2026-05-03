# Multi-Tenant URL Shortener (Laravel 12)

A multi-tenant URL shortener application, featuring role-based access control, company management, and invitation-based user onboarding.

---

## Project Overview

This application allows companies to manage their own users and generate short URLs in an isolated multi-tenant environment. Each company has its own users, and access is controlled via roles.

---

## Setup Instructions

Run the following commands to set up the project locally:

# 1. Clone the repository
git clone https://github.com/rajendrapanwar/url-shortener.git
cd url-shortener

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Setup environment file
cp .env.example .env

# 4. Configure database in .env
# Example:
DB_DATABASE=url_shortener

DB_USERNAME=root

DB_USERNAME=

# 5. Generate application key
php artisan key:generate

# 6. Run migrations and seeders
php artisan migrate --seed

# 7. Start development server
php artisan serve


# Features

Multi-tenant architecture (Company-based data isolation)
Role-based access control:
Super Admin, Admin, Member
Company management (create/manage companies)
User management within companies
Invitation-based user onboarding system
URL shortening with unique short codes
Redirect system for short URLs
Authentication & authorization using Laravel

# Default Credentials

Super Admin

Email: superadmin@example.com

Password: password

# AI Tools Used
ChatGPT

Helped in implementing:

Eloquent relationships (belongsTo, hasMany)

Role-based access control

Multi-tenant architecture approach


# Tech Stack
Laravel 12

PHP 8+

MySQL

Blade / Tailwind

Git & GitHub
