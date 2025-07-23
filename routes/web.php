<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductListController;

Route::get('/', function () {
    return view('welcome');
});

// Customer Routes
Route::prefix('customer')->group(function () {
    // Layout
    Route::get('layout', function(){
        return view('customer.layout.layout');
    });

    // Home
    Route::get('home', [HomeController::class, 'index'])->name('customer.home');

    // Product List
    Route::get('product_list', [ProductListController::class, 'index'])->name('customer.product_list');

    // Product Detail
    Route::get('product_detail/{id}', [ProductListController::class, 'productDetail'])->name('customer.product_detail');

    // Product Ajax Search
    Route::get('/products_list/search', [ProductListController::class, 'ajaxSearch'])->name('customer.products.ajaxSearch');

    // About
    Route::get('about', function () {
        return view('customer.about');
    })->name('customer.about');

    // Get Register Form
    Route::get('register', [CustomerController::class, 'registerForm'])->name('customer.registerForm');

    // Register Process
    Route::post('register/process', [CustomerController::class, 'registerProcess'])->name('customer.registerProcess');

    // Get Login Form
    Route::get('login', [CustomerController::class, 'loginForm'])->name('customer.loginForm');

    // Login Process
    Route::post('login/process', [CustomerController::class, 'loginProcess'])->name('customer.loginProcess');

    // Logout
    Route::get('logout', [CustomerController::class, 'logout'])->name('customer.logout');

    Route::middleware(CustomerMiddleware::class)->group(function () {
        // Cart
        Route::get('cart', [OrderController::class, 'cart'])->name('customer.cart');

        // Checkout
        Route::get('checkout', [OrderController::class, 'checkout'])->name('customer.checkout');

        // Reorder
        Route::post('/order/reorder/{orderId}', [OrderController::class, 'reorder'])->name('order.reorder');

        // Order History
        Route::get('order/history', [OrderController::class, 'orderHistory'])->name('order.history');

        // Cancel Order
        Route::patch('/order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

        // Payment
        Route::get('payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');

        // Payment Process
        Route::post('payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

        // Payment Success
        Route::get('payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    });
});

/*====================================================================================*/

// Admin Routes
Route::prefix('admin')->group(function () {
    // Login
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');

    // Login Process
    Route::post('/login', [AdminController::class, 'loginProcess'])->name('admin.loginProcess');

    Route::middleware(AdminMiddleware::class)->group(function () {
        // Logout
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Staff
        Route::get('/staff', [StaffController::class, 'index'])->name('admin.employee');

        // Employee Create
        Route::get('/employee/create', [StaffController::class, 'create'])->name('admin.staff.create');

        // Employee Store
        Route::post('/employee', [StaffController::class, 'store'])->name('admin.staff.store');

        // Employee Edit
        Route::get('/employee/{id}/edit', [StaffController::class, 'edit'])->name('admin.staff.edit');

        // Employee Update
        Route::put('/employee/{id}', [StaffController::class, 'update'])->name('admin.staff.update');

        // Employee Delete
        Route::delete('/employee/{id}', [StaffController::class, 'destroy'])->name('admin.staff.destroy');

        // Employee Search
        Route::get('/staff/search', [StaffController::class, 'ajaxSearch'])->name('admin.staff.ajaxSearch');

        // Customer routes
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer');

        // Customer create
        Route::get('/customer/create', [CustomerController::class, 'create'])->name('admin.customer.create');

        // Customer store
        Route::post('/customer', [CustomerController::class, 'store'])->name('admin.customer.store');

        // Customer edit
        Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('admin.customer.edit');

        // Customer update
        Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('admin.customer.update');

        // Customer delete
        Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('admin.customer.destroy');

        // Customer search
        Route::get('/customer/search', [CustomerController::class, 'ajaxSearch'])->name('admin.customer.ajaxSearch');

        // Category routes
        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');

        // Category create
        Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');

        // Category store
        Route::post('/category', [CategoryController::class, 'store'])->name('admin.category.store');

        // Category edit
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');

        // Category update
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');

        // Category delete
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

        // Category search
        Route::get('/category/search', [CategoryController::class, 'ajaxSearch'])->name('admin.category.ajaxSearch');

        // Product routes
        Route::get('/product', [ProductController::class, 'index'])->name('admin.product');

        // Product create
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');

        // Product store
        Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store');

        // Product edit
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');

        // Product update
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('admin.product.update');

        // Product delete
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');

        // Product search
        Route::get('/product/search', [ProductController::class, 'ajaxSearch'])->name('admin.product.ajaxSearch');

        // Order routes
        Route::get('/order', [OrderDetailController::class, 'index'])->name('admin.order');

        // Order create
        Route::get('/order/create', [OrderDetailController::class, 'create'])->name('admin.order.create');

        // Order store
        Route::post('/order', [OrderDetailController::class, 'store'])->name('admin.order.store');

        // Order edit
        Route::get('/order/{id}/edit', [OrderDetailController::class, 'edit'])->name('admin.order.edit');

        // Order update
        Route::put('/order/{id}', [OrderDetailController::class, 'update'])->name('admin.order.update');

        // Order delete
        Route::delete('/order/{id}', [OrderDetailController::class, 'destroy'])->name('admin.order.destroy');

        // Order search
        Route::get('/order/search', [OrderDetailController::class, 'ajaxSearch'])->name('admin.order.ajaxSearch');
    });
});
