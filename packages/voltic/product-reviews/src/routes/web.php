<?php


use Illuminate\Support\Facades\Route;
use Voltic\ProductReviews\Http\Controllers\ReviewController;

// Product Reviews Routes
Route::middleware(['web', 'auth', 'verified'])->group(function () {
    // User routes - View and create reviews
    Route::get('/products/{product}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/products/{product}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Admin routes - Manage reviews
Route::middleware(['web', 'auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/reviews', [ReviewController::class, 'adminIndex'])->name('admin.reviews.index');
    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
});