<?php

namespace Voltic\ProductReviews;

use Illuminate\Support\ServiceProvider;

class ProductReviewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'product-reviews');

        // Publish migrations
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'product-reviews-migrations');

        // Publish views
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/product-reviews'),
        ], 'product-reviews-views');
    }
}