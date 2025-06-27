<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use function PHPUnit\Framework\returnArgument;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login/submit', [AdminController::class, 'login'])->name('admin.login.submit');


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Route::get('/order', function(){ 
    //     return view('admin.order');
    // })->name('Order');

    Route::get('/customer', function () {
        return view('admin.customer');
    })->name('admin.customer');

    Route::get('/product', function () {
        return view('admin.product');
    })->name('admin.product');

    Route::get('/category', function () {
        return view('admin.category');
    })->name('admin.category');

    Route::get('/employee', function(){
        return view('admin.employee');
    })->name('admin.employee');
});

Route::get('/order',[AdminController::class, 'list'])->name('Order');