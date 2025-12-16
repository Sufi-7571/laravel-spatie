<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Management Routes - Only for Admins
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// ALL Product Routes require
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');
    // Product category routes
    Route::resource('categories', CategoryController::class);

    // CREATE routes
    Route::middleware(['permission:create products'])->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');
    });

    // PDF Download route
    Route::middleware(['permission:download product pdf'])->group(function () {
        Route::get('/products/{product}/download-pdf', [ProductController::class, 'downloadPdf'])
            ->name('products.downloadPdf');
    });

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    Route::middleware(['permission:edit products'])->group(function () {
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');
    });
    Route::middleware(['permission:delete products'])->group(function () {
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');
    });
});


// Google OAuth Routes
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});

// Payment Routes
Route::get('/payment', [StripePaymentController::class, 'index'])
    ->name('payment.index');
Route::post('/payment/process', [StripePaymentController::class, 'process'])
    ->name('payment.process');
Route::get('/payment/success', [StripePaymentController::class, 'success'])
    ->name('payment.success');
Route::get('/payment/cancel', [StripePaymentController::class, 'cancel'])
    ->name('payment.cancel');


Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])
        ->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])
        ->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])
        ->name('cart.remove');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])
        ->name('cart.checkout');
});



require __DIR__ . '/auth.php';
