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

Route::prefix('customer')->group(function () {
    // Layout
    Route::get('layout', function(){
        return view('customer.layout.layout');
    });

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

    Route::get('home', [HomeController::class, 'index'])->name('customer.home');
    Route::get('product_list', [ProductListController::class, 'index'])->name('customer.product_list');
    Route::get('product_detail/{id}', [ProductListController::class, 'productDetail'])->name('customer.product_detail');
    Route::get('/products_list/search', [ProductListController::class, 'ajaxSearch'])->name('customer.products.ajaxSearch');

    Route::middleware(CustomerMiddleware::class)->group(function () {
        Route::get('cart', [OrderController::class, 'cart'])->name('customer.cart');

        Route::post('order/reorder/{productId}', [OrderController::class, 'reorder'])->name('order.reorder');

        Route::get('order/history', [OrderController::class, 'orderHistory'])->name('order.history');

        Route::get('payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');

        Route::post('payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

        Route::get('payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    });
});







Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'loginProcess'])->name('admin.loginProcess');

    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        // Route::get('/order', [AdminController::class, 'order'])->name('admin.order');
        // Route::get('/product', [AdminController::class, 'product'])->name('admin.product');
        // Route::get('/category', [AdminController::class, 'category'])->name('admin.category');
        // Route::get('/employee', [AdminController::class, 'employee'])->name('admin.employee');

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

        // Category routes
        Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
        Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/category', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        Route::get('/category/search', [CategoryController::class, 'ajaxSearch'])->name('admin.category.ajaxSearch');

        // Product routes
        Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
        Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
        Route::get('/product/search', [ProductController::class, 'ajaxSearch'])->name('admin.product.ajaxSearch');

        // Order routes
        Route::get('/order', [OrderDetailController::class, 'index'])->name('admin.order');
        Route::get('/order/create', [OrderDetailController::class, 'create'])->name('admin.order.create');
        Route::post('/order', [OrderDetailController::class, 'store'])->name('admin.order.store');
        Route::get('/order/{id}/edit', [OrderDetailController::class, 'edit'])->name('admin.order.edit');
        Route::put('/order/{id}', [OrderDetailController::class, 'update'])->name('admin.order.update');
        Route::delete('/order/{id}', [OrderDetailController::class, 'destroy'])->name('admin.order.destroy');
        Route::get('/order/search', [OrderDetailController::class, 'ajaxSearch'])->name('admin.order.ajaxSearch');
    });
});
