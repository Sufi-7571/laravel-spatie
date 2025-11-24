<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;

// Homepage redirects to products (which will redirect to login if not authenticated)
Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Management Routes - Only for Admins
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// ALL Product Routes require authentication and email verification
Route::middleware(['auth', 'verified'])->group(function () {
    // List all products
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    // Trash routes (for viewing deleted products)
    // Route::middleware(['permission:delete products'])->group(function () {
    //     Route::get('/products/trash', [ProductController::class, 'trash'])
    //         ->name('products.trash');
    //     Route::post('/products/{id}/restore', [ProductController::class, 'restore'])
    //         ->name('products.restore');
    //     Route::delete('/products/{id}/force-delete', [ProductController::class, 'forceDelete'])
    //         ->name('products.forceDelete');
    // });

    // CREATE routes
    Route::middleware(['permission:create products'])->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');
    });

    // PDF Download route (with permission check)
    Route::middleware(['permission:download product pdf'])->group(function () {
        Route::get('/products/{product}/download-pdf', [ProductController::class, 'downloadPdf'])
            ->name('products.downloadPdf');
    });

    // Show single product (AFTER create route)
    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    // EDIT routes (AFTER show route or use /products/{product}/edit pattern)
    Route::middleware(['permission:edit products'])->group(function () {
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');
    });

    // DELETE route (now soft delete)
    Route::middleware(['permission:delete products'])->group(function () {
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');
    });
});


// Google OAuth Routes (add these with other auth routes)
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');
});





require __DIR__ . '/auth.php';
