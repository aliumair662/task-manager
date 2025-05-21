# Laravel Task Manager

A simple task management web app built with Laravel. Features:

- Create/edit/delete tasks
- Reorder tasks by drag and drop (priority updates automatically)
- Assign tasks to projects
- View tasks per project

---

## 🛠 Setup Instructions

### 1. Clone the Project

```bash
git clone https://github.com/aliumair662/task-manager
cd task-manager

### 2. Install Dependencies
composer install

### 3. Configure Environment
cp .env.example .env

update Database setting

DB_DATABASE=task_manager
DB_USERNAME=your_username
DB_PASSWORD=your_password

###4. php artisan key:generate

php artisan key:generate

###5.Run Migrations and Seeders

php artisan migrate --seed

###6.Start Development Server

php artisan serve

or 

setup virtual host 

Features:

Task creation under specific projects

Reordering tasks with SortableJS

Fully Eloquent relationships

Minimal and clean UI using Blade


Tech Stack:

Laravel 12

MySQL

Blade templating

SortableJS (drag & drop)