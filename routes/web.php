<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;

// User Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Protected Routes
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
}); 