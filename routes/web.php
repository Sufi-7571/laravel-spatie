<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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







// Temporary debug route - REMOVE IN PRODUCTION
Route::get('/test-recaptcha', function () {
    $siteKey = config('services.recaptcha.site_key');
    $secretKey = config('services.recaptcha.secret_key');
    
    echo "<h3>reCAPTCHA Debug</h3>";
    echo "<p><strong>Site Key:</strong> " . (empty($siteKey) ? 'NOT SET' : substr($siteKey, 0, 15) . '...') . "</p>";
    echo "<p><strong>Secret Key:</strong> " . (empty($secretKey) ? 'NOT SET' : substr($secretKey, 0, 15) . '...') . "</p>";
    echo "<hr>";
    
    // Test form
    echo '<form method="POST" action="/test-recaptcha-verify">';
    echo csrf_field();
    echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    echo '<div class="g-recaptcha" data-sitekey="' . $siteKey . '"></div>';
    echo '<br><button type="submit">Test Verify</button>';
    echo '</form>';
});

Route::post('/test-recaptcha-verify', function () {
    $secretKey = config('services.recaptcha.secret_key');
    $recaptchaResponse = request('g-recaptcha-response');
    
    echo "<h3>reCAPTCHA Verification Test</h3>";
    echo "<p><strong>g-recaptcha-response received:</strong> " . (empty($recaptchaResponse) ? 'EMPTY!' : substr($recaptchaResponse, 0, 50) . '...') . "</p>";
    echo "<hr>";
    
    if (empty($recaptchaResponse)) {
        echo "<p style='color: red;'>❌ No reCAPTCHA response received. Did you check the checkbox?</p>";
        return;
    }
    
    try {
        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => request()->ip(),
        ]);
        
        echo "<p><strong>Status Code:</strong> " . $response->status() . "</p>";
        echo "<p><strong>Response:</strong></p>";
        echo "<pre>" . json_encode($response->json(), JSON_PRETTY_PRINT) . "</pre>";
        
        $result = $response->json();
        if ($result['success'] ?? false) {
            echo "<p style='color: green;'>✅ reCAPTCHA verification PASSED!</p>";
        } else {
            echo "<p style='color: red;'>❌ reCAPTCHA verification FAILED!</p>";
            if (isset($result['error-codes'])) {
                echo "<p><strong>Error codes:</strong> " . implode(', ', $result['error-codes']) . "</p>";
            }
        }
        
    } catch (\Exception $e) {
        echo "<p style='color: red;'><strong>Error:</strong> " . $e->getMessage() . "</p>";
    }
});






require __DIR__ . '/auth.php';
