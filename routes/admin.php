<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\BlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
*/

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/{id}', [UserManagementController::class, 'show'])->name('show');
            Route::post('/', [UserManagementController::class, 'store'])->name('store');
            Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
        });

        // Blog Management
        Route::prefix('blogs')->name('blogs.')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('index');
            Route::get('/create', [BlogController::class, 'create'])->name('create');
            Route::post('/', [BlogController::class, 'store'])->name('store');
            Route::get('/{blog}/edit', [BlogController::class, 'edit'])->name('edit');
            Route::put('/{blog}', [BlogController::class, 'update'])->name('update');
            Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('destroy');
            Route::get('/sync', [BlogController::class, 'sync'])->name('sync');
        });

        // Admin Management (placeholder)
        Route::prefix('admins')->name('admins.')->group(function () {
            Route::get('/', function () {
                return view('admin.admins.index');
            })->name('index');
        });

        // Logout
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Profile & Settings (placeholder routes)
        Route::get('/profile', function () {
            return view('admin.profile');
        })->name('profile');

        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');
    });
});
