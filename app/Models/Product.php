<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Voltic\ProductReviews\Models\Review;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image_url',
        'image_public_id',
        'category_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get all reviews for the product
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get approved reviews only
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    /**
     * Get average rating
     */
    public function averageRating()
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    /**
     * Get total reviews count
     */
    public function reviewsCount()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Check if product has an image
     */
    public function hasImage(): bool
    {
        return !empty($this->image_url);
    }

    /**
     * Get image URL or default placeholder
     */
    public function getImageUrl(): string
    {
        return $this->image_url ?? 'https://via.placeholder.com/500x500?text=No+Image';
    }

    /**
     * Relationship with Category model
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
