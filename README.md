#  PHP_Laravel12_Phone

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![MySQL](https://img.shields.io/badge/Database-MySQL-orange)
![License](https://img.shields.io/badge/License-MIT-green)

---

##  Overview

**PHP_Laravel12_Phone** is a Laravel 12 project that demonstrates how to implement Indian phone number validation using the `propaganistas/laravel-phone` package.

The project includes a simple user registration system where phone numbers are:

* Validated using Google’s libphonenumber library
* Restricted to Indian numbers
* Stored in E.164 international format (+91XXXXXXXXXX)
* Displayed in a clean user listing interface

This project is useful for learning real-world phone validation and proper international number formatting in Laravel.

---

##  Features

*  Laravel 12 Setup
*  MySQL Database Integration
*  User Registration Form
*  Indian Phone Number Validation
*  E.164 International Format Storage
*  Unique Email & Phone Validation
*  Secure Password Hashing (bcrypt)
*  Clean Validation Error UI
*  Latest Users Displayed First

---

##  Folder Structure

```
PHP_Laravel12_Phone/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── UserController.php
│   └── Models/
│       └── User.php
│
├── database/
│   └── migrations/
│       └── xxxx_create_users_table.php
│
├── resources/
│   └── views/
│       └── users/
│           ├── create.blade.php
│           └── index.blade.php
│
├── routes/
│   └── web.php
│
├── .env
└── composer.json
```


## 1. Introduction

This project demonstrates how to:

* Install Laravel 12
* Configure database
* Create a user registration system
* Validate Indian phone numbers using propaganistas/laravel-phone
* Store phone numbers in E.164 international format
* Display formatted phone numbers
* Implement clean validation UI

---

## 2. System Requirements

Ensure your system has:

* PHP 8.2 or higher
* Composer
* MySQL
* XAMPP / Local server
* Web browser

Check installed versions:

```bash
php -v
composer -v
```

---

## 3. Project Installation

### Step 1: Create Laravel Project

Open terminal and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_Phone
```

Start development server:

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000
```

If Laravel welcome page appears, installation is successful.

---

## 4. Database Configuration

### Step 1: Create Database

Create a database in phpMyAdmin:

```
phone
```

### Step 2: Update .env File

Open .env file and update:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phone
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Modify Users Migration

Open:

database/migrations/xxxx_create_users_table.php

Update migration:

```php
public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone');
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}
```

Run migration:

```bash
php artisan migrate
```

---

## 6. Install Laravel Phone Package

Install the package:

```bash
composer require propaganistas/laravel-phone
```

This package uses Google’s libphonenumber library for real phone validation.

---

## 7. Configure Validation Language

Open:

lang/en/validation.php

Add this line at top-level (same level as required, email, regex):

```php
'regex' => 'The :attribute field format is invalid.',
'phone' => 'The :attribute must be a valid phone number.',
'required' => 'The :attribute field is required.',
```

Add Inside custom Section:

```php
'custom' => [
    'phone' => [
        'phone' => 'Please enter a valid phone number.',
    ],
],
```

Add Inside attributes Section:

```php
'attributes' => [
    'phone' => 'phone number',
    'email' => 'email address',
    'name' => 'full name',
],
```

Clear cache:

```bash
php artisan optimize:clear
```

---

## 8. Update User Model

Open:

app/Models/User.php

Update fillable:

```php
protected $fillable = [
    'name',
    'email',
    'phone',
    'password',
];
```

---

## 9. Create Controller

Generate controller:

```bash
php artisan make:controller UserController
```

Replace file:

app/Http/Controllers/UserController.php

With:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Propaganistas\LaravelPhone\Rules\Phone;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => ['required', 'unique:users,phone', new Phone('IN')],
            'password' => 'required|min:6',
        ], [
            'phone.phone' => 'Please enter a valid Indian phone number.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => phone($request->phone, 'IN')->formatE164(),
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')
                        ->with('success', 'User Created Successfully');
    }
}
```

---

## 10. Define Routes

Open:

routes/web.php

Add:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('users.index');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
```

---

## 11. Create Views

Create folder:

resources/views/users

Create:

### create.blade.php

```html
<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
        }

        input:focus {
            border-color: #4CAF50;
        }

        .error-border {
            border: 1px solid red !important;
        }

        .field-error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #4CAF50;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #45a049;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #333;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">

    <h2>Create User</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        {{-- Name --}}
        <input type="text"
               name="name"
               value="{{ old('name') }}"
               placeholder="Name"
               class="@error('name') error-border @enderror">

        @error('name')
            <div class="field-error">{{ $message }}</div>
        @enderror


        {{-- Email --}}
        <input type="email"
               name="email"
               value="{{ old('email') }}"
               placeholder="Email"
               class="@error('email') error-border @enderror">

        @error('email')
            <div class="field-error">{{ $message }}</div>
        @enderror


        {{-- Phone --}}
        <input type="text"
               name="phone"
               value="{{ old('phone') }}"
               placeholder="Phone (9876543210)"
               class="@error('phone') error-border @enderror">

        @error('phone')
            <div class="field-error">{{ $message }}</div>
        @enderror


        {{-- Password --}}
        <input type="password"
               name="password"
               placeholder="Password"
               class="@error('password') error-border @enderror">

        @error('password')
            <div class="field-error">{{ $message }}</div>
        @enderror


        <button type="submit">Submit</button>
    </form>

    <a href="{{ route('users.index') }}" class="back-link">← Back to List</a>

</div>

</body>
</html>

```

---

### index.blade.php

```html
<!DOCTYPE html>
<html>
<head>
    <title>User List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .success {
            background: #e6ffed;
            padding: 10px;
            border-radius: 6px;
            color: green;
            margin-bottom: 20px;
            text-align: center;
        }

        .create-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .create-btn:hover {
            background: #0069d9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #e9ecef;
        }
    </style>
</head>
<body>

<h2>User List</h2>

@if(session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('users.create') }}" class="create-btn">+ Create User</a>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone (E.164)</th>
        <th>Created At</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ $user->created_at }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>

```

---

## 12. How Phone Validation Works

Validation rule:

```php
new Phone('IN')
```

This ensures:

* Valid Indian phone number
* Real telecom validation
* Google libphonenumber verification

Storage format:

```php
formatE164()
```

Example stored value:

```
+917069688473
```

This is international standard format.

---

## OUTPUT

### Enter Invalid Number

<img width="491" height="464" alt="Screenshot 2026-02-10 164235" src="https://github.com/user-attachments/assets/90d66d15-c0b1-40d6-b47f-d5c39c416ee8" />


### Enter Valid Number

<img width="466" height="412" alt="Screenshot 2026-02-10 164401" src="https://github.com/user-attachments/assets/f95cb4f8-c099-42b7-8ffc-063ccfc5b7c0" />


### Valid Number Store

<img width="1884" height="283" alt="Screenshot 2026-02-10 164413" src="https://github.com/user-attachments/assets/136be0eb-204d-4403-8244-5839d383f245" />


