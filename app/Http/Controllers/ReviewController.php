<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class ReviewController extends Controller
{

    public function __construct()
    {
        // Only authenticated users can submit reviews
        $this->middleware('auth');
    }

    /**
     * Store a newly created review in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'review_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $user = Auth::user();

        // Check if the user has already reviewed this product
        if (Review::where('product_id', $request->product_id)->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You have already submitted a review for this product.');
        }

        $imagePath = null;
        if ($request->hasFile('review_image')) {
            $image = $request->file('review_image');
            $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension(); // Generate a unique filename
            $destinationPath = public_path('images/reviews'); // Your desired public path

            // Create the directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $fileName); // Move the uploaded file
            $imagePath = 'images/reviews/' . $fileName; // Store path relative to public directory
        }

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => $user->id,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'image_path' => $imagePath, // Save the public path
        ]);

        return back()->with('success', 'Your review has been submitted successfully!');
    }
}

