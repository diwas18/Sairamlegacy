<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Http\Request;

class PagesController extends Controller
{

public function index(Request $request)
{
    $categories = Category::orderBy('priority', 'desc')->latest()->limit(4)->get();

    $query = Product::where('status', 'Show');

    // 🔍 Filter by Category
    if ($request->has('category') && $request->category) {
        $query->where('category_id', $request->category);
    }

    // 💸 Filter by Price Range
    if ($request->filled('price_min')) {
        $query->where('price', '>=', $request->price_min);
    }

    if ($request->filled('price_max')) {
        $query->where('price', '<=', $request->price_max);
    }

    // ↕️ Sorting
    switch ($request->sort) {
        case 'price_asc':
            $query->orderBy('discounted_price' ?? 'price', 'asc');
            break;

        case 'price_desc':
            $query->orderBy('discounted_price' ?? 'price', 'desc');
            break;

        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;

        case 'name_desc':
            $query->orderBy('name', 'desc');
            break;

        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;

        default:
            $query->latest();
    }

    // 🧾 Paginated Product List (AJAX support)
    $products = $query->paginate(4);

    if ($request->ajax()) {
        return view('partials.product_cards', compact('products'))->render();
    }

    // ⭐ Featured Products (non-filtered)
    $featured = Product::where('status', 'Show')->inRandomOrder()->limit(4)->get();

    return view('welcome', compact('products', 'categories', 'featured'));
}


public function viewproduct($id)
    {
        // Find the product by ID, eager load its category, and all associated reviews along with the user for each review
        $product = Product::with('category', 'reviews.user')->findOrFail($id);

        // You might also fetch related products here
        $relatedproducts = Product::where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->inRandomOrder()
                                  ->limit(4) // Limit to 4 related products
                                  ->get();

        // Pass the product (as $products) and related products to the view
        return view('viewproduct', ['products' => $product, 'relatedproducts' => $relatedproducts]);
    }

public function categoryproduct($id)
{
    $category = Category::findOrFail($id);
    $products = Product::where('status', 'Show')->where('category_id', $id)->paginate(8);
    return view('categoryproduct', compact('products', 'category'));
}
public function checkout($cartid)
{
$cart = Cart:: find($cartid);
if($cart->product->discounted_price =='')
{
    $cart->total =$cart->product->price *$cart->qty;
}
else
{
    $cart->total =$cart->product->discounted_price *$cart->qty;
}
return view('checkout',compact('cart'));
}

    /**
     * Display the main product listing page with filtering, sorting, and text search capabilities.
     * This method serves as the 'home' or 'shop' page where users can browse and filter products.
     * It will be mapped to the 'home' route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request) // This method name will handle your main product listing/filters
    {
        // Start with all active products
        $query = Product::query()->where('status', 'Show');

        // 1. Text Search Filter (using 'search' input name as per your previous request and typical usage)
        if ($request->filled('search')) {
            $searchTerm = $request->search; // Using 'search' as the query parameter name
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
            // Optional: Add validation for the search term here
            // $request->validate(['search' => 'min:2|max:255']);
        } else {
            $searchTerm = null; // Set to null if no search term is present
        }


        // 2. Category Filter (from sidebar or main filter form)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 3. Price Range Filter
        if ($request->filled('price_min')) {
            if (is_numeric($request->price_min)) {
                $query->where(function ($q) use ($request) {
                    $q->where('price', '>=', $request->price_min)
                      ->orWhere('discounted_price', '>=', $request->price_min);
                });
            }
        }

        if ($request->filled('price_max')) {
            if (is_numeric($request->price_max)) {
                $query->where(function ($q) use ($request) {
                    $q->where('price', '<=', $request->price_max)
                      ->orWhere('discounted_price', '<=', $request->price_max);
                });
            }
        }

        // 4. Sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(discounted_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(discounted_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc'); // Default sort: newest first
        }

        // Execute the query and paginate results
        // Eager load category to avoid N+1 problem in Blade
        $products = $query->with('category')->paginate(12);

        // Fetch ALL categories for the sidebar (ordered by name for clean display)
        $allCategories = Category::orderBy('name', 'asc')->get();

        // Check if an AJAX request for partial loading (e.g., infinite scroll)
        if ($request->ajax()) {
            return view('partials.product_cards', compact('products'))->render();
        }

        // Return the main product listing view (which is 'home.blade.php' as per your Blade)
        // Pass the products, all categories, and the search term (if any)
        return view('search', compact('products', 'allCategories', 'searchTerm'));
    }
}
