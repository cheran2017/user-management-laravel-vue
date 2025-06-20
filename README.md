# 🧑‍💼 Laravel User Management System

A complete User Management System built with Laravel and Vue 3 (Inertia + Breeze) that supports:

- ✅ Creating, Updating, and Deleting Users
- 🔍 Search by First/Last Name
- 📄 Pagination
- 📬 Client-side + Server-side Validation
- 🌍 Multi-address support (Home/Work)
- 🔥 Toast Notifications (Success/Error)
- 🧪 Unit Tests
- 📡 API endpoint to fetch user details

---

## 🚀 Technologies Used

- Laravel 12
- MySQL / SQLite (for testing)
- Vue 3 with Inertia.js
- Laravel Breeze (Inertia + Tailwind)
- PHPUnit

---
## 📸 Screenshots

### 🧾 User List Page
![User List](screenshots/user-list.png)

### ➕ Create User Form
![Create User](screenshots/create-user.png)

### ✏️ Edit User Page
![Edit User](screenshots/edit-user.png)

### ✅ Toast Notification
![Toast Message](screenshots/success-toast.png)

## 📦 Installation

```bash
git clone https://github.com/cheran2017/user-management-laravel-vue.git
cd user-management

# Install backend dependencies
composer install

# Install frontend dependencies
npm install && npm run dev

# Setup .env
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate

# Seed some test data (optional)
php artisan db:seed

