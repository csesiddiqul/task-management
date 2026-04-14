# Task Management System (API Based)

A modern Task Management System built with Laravel (API) and React.js to help teams manage daily tasks, track progress, and stay organized efficiently.

---

## Features

- User Authentication using Laravel Sanctum  
- Role and Permission Management (Spatie)  
- Task CRUD (Create, Read, Update, Delete)  
- Assign Tasks to Users  
- Task Workflow:
  - Pending
  - In Progress
  - Review
  - Completed  
- Activity Tracking  
- Role-Based Access Control (RBAC)  
- REST API for Frontend Integration  

---

## Technology Stack

### Backend
- Laravel 12+
- PHP 8.2+
- Laravel Sanctum
- Spatie Laravel Permission
- MySQL

### Frontend
- React.js
- Axios

---

## Project Structure (Backend)

```
app/
 ├── Http/
 │   ├── Controllers/
 │   ├── Requests/
 │   └── Resources/
 ├── Models/
 ├── Services/
 ├── Repositories/
 ├── Policies/
 └── Traits/
```

---

## Installation Guide

### Clone Repository
```bash
git clone https://github.com/csesiddiqul/task-management
cd task-management
```

### Install Dependencies
```bash
composer install
```

### Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Configure Database (.env)
```
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

### Run Migrations & Seeders
```bash
php artisan migrate --seed
php artisan db:seed --class=RoleSeeder
```

### Start Server
```bash
php artisan serve
```

---

## API Base URL

```
http://localhost:8000/api
```

---

## API Testing

Run:
```bash
php artisan test
```

### If Tests Fail 

Enable these in `php.ini`:
Remove This ;
```
extension=pdo_sqlite
extension=sqlite3
```

---

## Notes

- Ensure MySQL is running before migrations  
- Sanctum Token required for protected routes  
- Roles must be seeded before permission testing  

---

## Author

Md Siddiqul Islam Labib  
Full Stack Laravel Developer  
