<?php

namespace Voltic\ProductReviews\Http\Controllers;

use App\Http\Controllers\Controller;
use Voltic\ProductReviews\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display reviews for a product
     */
    public function index(Product $product)
    {
        $reviews = Review::where('product_id', $product->id)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('product-reviews::reviews.index', compact('product', 'reviews'));
    }

    /**
     * Show form to create a review
     */
    public function create(Product $product)
    {
        // Check if user already reviewed this product
        $existingReview = Review::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('reviews.index', $product)
                ->with('error', 'You have already reviewed this product.');
        }

        return view('product-reviews::reviews.create', compact('product'));
    }

    /**
     * Store a new review
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10',
        ]);

        // Check if user already reviewed
        $existingReview = Review::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('reviews.index', $product)
                ->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_approved' => false, // Requires admin approval
        ]);

        return redirect()->route('reviews.index', $product)
            ->with('status', 'Thank you! Your review has been submitted and is pending approval.');
    }

    /**
     * Admin: View all reviews
     */
    public function adminIndex()
    {
        $reviews = Review::with(['product', 'user'])
            ->latest()
            ->paginate(20);

        return view('product-reviews::admin.reviews', compact('reviews'));
    }

    /**
     * Admin: Approve a review
     */
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        return back()->with('status', 'Review approved successfully.');
    }

    /**
     * Admin: Reject/Delete a review
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('status', 'Review deleted successfully.');
    }
}
