<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=['name','description','price','discounted_price','stock','category_id','photopath','status'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
        /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Calculate the average rating for the product.
     * Returns null if there are no reviews.
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    /**
     * Get the total number of reviews for the product.
     */
    public function totalReviews()
    {
        return $this->reviews()->count();
    }

}
