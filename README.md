# Task Management System (API Based)

A simple and scalable **Task Management System** built with **Laravel (API)**, **Sanctum Authentication**, **Spatie Role Permission**, and **React frontend**.

This system helps teams manage daily tasks, track progress, and maintain workflow transparency in a clean and structured way.

---

##  Features

-  User Authentication (Login/Register using Sanctum)
-  Role & Permission Management (Admin, Member) using Spatie
-  Task CRUD (Create, Read, Update, Delete)
-  Task Assignment to Users
-  Task Status Workflow  
  (Pending → In Progress → Review → Completed)
-  Activity Log (Track all task changes)
-  Role-based Access Control
-  Clean REST API for frontend integration (React)

---

##  Technology Stack

### Backend
- Laravel 12+
- PHP 8.2
- Laravel Sanctum (API Authentication)
- Spatie Laravel Permission
- MySQL

### Frontend
- React.js

---

##  Installation & Setup

### 1. Clone the project
```bash
git clone https://github.com/csesiddiqul/task-management
cd task-management
2. Install backend dependencies
composer install
3. Setup environment
cp .env.example .env
php artisan key:generate
4. Configure database

Update your .env file:

DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
5. Run migrations
php artisan migrate
6. Seed database
php artisan db:seed --class=RoleSeeder
7. Start development server
php artisan serve
API Base URL
http://localhost:8000/api
Notes
Ensure MySQL is running before migration
Sanctum token must be used for protected routes
Roles must be seeded before testing access control
