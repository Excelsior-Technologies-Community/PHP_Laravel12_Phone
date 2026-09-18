<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('users.dashboard');
});

// Phone Management Dashboard
Route::get('/dashboard', [UserController::class, 'dashboard'])
    ->name('users.dashboard');

// User List with Search & Filtering
Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

// Create User
Route::get('/users/create', [UserController::class, 'create'])
    ->name('users.create');

// Store User
Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');