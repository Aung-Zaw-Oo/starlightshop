<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'loginProcess'])->name('admin.loginProcess');

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/order', [AdminController::class, 'order'])->name('admin.order');
        Route::get('/product', [AdminController::class, 'product'])->name('admin.product');
        Route::get('/category', [AdminController::class, 'category'])->name('admin.category');
        Route::get('/employee', [AdminController::class, 'employee'])->name('admin.employee');

        // Staff routes
        Route::get('/staff', [StaffController::class, 'index'])->name('admin.employee');
        Route::get('/employee/create', [StaffController::class, 'create'])->name('admin.staff.create');
        Route::post('/employee', [StaffController::class, 'store'])->name('admin.staff.store');
        Route::get('/employee/{id}/edit', [StaffController::class, 'edit'])->name('admin.staff.edit');
        Route::put('/employee/{id}', [StaffController::class, 'update'])->name('admin.staff.update');
        Route::delete('/employee/{id}', [StaffController::class, 'destroy'])->name('admin.staff.destroy');
        Route::get('/staff/search', [StaffController::class, 'ajaxSearch'])->name('admin.staff.ajaxSearch');

        // Customer routes
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer');
        Route::get('/customer/create', [CustomerController::class, 'create'])->name('admin.customer.create');
        Route::post('/customer', [CustomerController::class, 'store'])->name('admin.customer.store');
        Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('admin.customer.edit');
        Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('admin.customer.update');
        Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('admin.customer.destroy');
        Route::get('/customer/search', [CustomerController::class, 'ajaxSearch'])->name('admin.customer.ajaxSearch');
    });
});
