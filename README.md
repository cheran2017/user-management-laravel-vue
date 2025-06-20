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

# To Run Unit test
php artisan test tests/Feature/UserTest.php

## 📡 API: Get User Details

### Endpoint:
`GET /api/users/{user_id}`

### ✅ Success Response:

```json
{
  "status_code": 200,
  "message": "User details",
  "data": {
    "user_name": "John Doe",
    "mobile": "9345345352",
    "dob": "14/01/1990",
    "gender": "Male",
    "Address": [
      {
        "address_type": "home",
        "address1": {
          "door/street": "1st Main Rd, Rajiv Nagar",
          "landmark": "Zxy building",
          "city": "Chennai",
          "state": "Tamilnadu",
          "country": "India"
        },
        "primary": "No"
      }
    ]
  }
}
### ❌ Error Response (User Not Found)

```json
{
  "status_code": 404,
  "message": "User not found",
  "data": null
}
