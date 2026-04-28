# 🏥 Cabinet Médical - Laravel Application

A web application for managing a medical cabinet, built with **Laravel**.  
It allows doctors/secretaries to manage patients, appointments, and related medical data efficiently.

---

##  Features

- User authentication (Login/Register)
-  Patient management (CRUD)
-  Appointment scheduling system
-  Search and filter appointments/patients
-  Email notifications (e.g. appointment confirmation)
-  Multi-language support (optional)
-  Dashboard with overview statistics

---

##  Tech Stack

- **Backend:** Laravel 10+
- **Frontend:** Blade, Tailwind CSS / Bootstrap
- **Database:** MySQL
- **Tools:** Composer, NPM, Vite

---

##  Installation

### 1. Clone the repository
```bash
git clone https://github.com/Mariamm112/cabinet-medical
cd cabinet-medical
composer create-project laravel/laravel cabinet-medical

npm install && npm run dev
Then update database settings
Generate application key : php artisan key:generate
run migrations: php artisan migrate
Patients
Add, edit, delete patients
View medical history
Appointments
Create appointments
Assign to users/patients
Search & filter
 Known Issues
Appointment creation may fail if user_id is missing
Language switch button may not update UI correctly (needs fix)
 Author
Mariam Hilmi

language switching:
English (en/messages.php)
return [
    'welcome' => 'Welcome',
    'login' => 'Login',
];
French (fr/messages.php)
return [
    'welcome' => 'Bienvenue',
    'login' => 'Connexion',
];
Authentication (Login API)
Used for:
Logging users in
Logging users out
Getting current user info
## 👥 Role System

The application uses a **role-based access control (RBAC)** system to manage permissions and restrict access to specific features depending on the user type.

---

### 🧑‍💼 Available Roles

| Role       | Description |
|------------|------------|
| 👑 Admin    | Full access to the system (users, patients, appointments, settings) |
| 🧑‍⚕️ Doctor  | Can manage patients and appointments related to medical care |
| 🗂️ Secretary | Can create and manage appointments and assist with scheduling |

---

### 🔐 Role Permissions

Each role has different levels of access:

#### 👑 Admin
- Manage all users
- Full CRUD on patients and appointments
- Access system settings

#### 🧑‍⚕️ Doctor
- View assigned patients
- Create and manage appointments
- Access medical information

#### 🗂️ Secretary
- Create and update appointments
- Manage scheduling
- Limited access to patient data

---

### ⚙️ Implementation

Roles are handled using:
- Laravel authentication system
- Middleware for route protection
- (Optional) Policies or Gates for fine-grained control

Example middleware usage:
```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
});