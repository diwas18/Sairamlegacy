<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // These fields can be mass-assigned
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'feedback',
        'image_path',
    ];

    /**
     * Get the product that this review belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who wrote this review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
