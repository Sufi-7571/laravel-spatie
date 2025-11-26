<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Voltic\ProductReviews\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalReviews = Review::count();
        $pendingReviews = Review::where('is_approved', false)->count();

        // Calculate total revenue (sum of all product prices * stock)
        $totalRevenue = Product::sum(DB::raw('price * stock'));

        // Low stock products (stock < 10)
        $lowStockCount = Product::where('stock', '<', 10)->count();

        // Recent Products (last 5)
        $recentProducts = Product::latest()->take(5)->get();

        // Recent Reviews (last 5)
        $recentReviews = Review::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Users (last 5)
        $recentUsers = User::latest()->take(5)->get();

        // Products by Stock Status
        $inStock = Product::where('stock', '>', 10)->count();
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $outOfStock = Product::where('stock', '<=', 0)->count();

        // Top Rated Products (by average rating)
        $topProducts = Product::withAvg('approvedReviews', 'rating')
            ->having('approved_reviews_avg_rating', '>', 0)
            ->orderByDesc('approved_reviews_avg_rating')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalReviews',
            'pendingReviews',
            'totalRevenue',
            'lowStockCount',
            'recentProducts',
            'recentReviews',
            'recentUsers',
            'inStock',
            'lowStock',
            'outOfStock',
            'topProducts'
        ));
    }
}
