<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('priority', 'desc')->latest()->limit(4)->get();

        $query = Product::where('status', 'Show');

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('price_min')) {
            $query->whereRaw('COALESCE(discounted_price, price) >= ?', [$request->price_min]);
        }

        if ($request->filled('price_max')) {
            $query->whereRaw('COALESCE(discounted_price, price) <= ?', [$request->price_max]);
        }

        // Sorting — use COALESCE so discounted_price is respected
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
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(4);

        if ($request->ajax()) {
            return view('partials.product_cards', compact('products'))->render();
        }

        $featured = Product::where('status', 'Show')->inRandomOrder()->limit(4)->get();

        return view('welcome', compact('products', 'categories', 'featured'));
    }


    public function viewproduct($id)
{
    $product = Product::with('category', 'reviews.user')->findOrFail($id);

    // Step 1: Get users who bought this product
    $userIds = Order::where('product_id', $id)
                    ->pluck('user_id');

    // Step 2: Find other products bought by those users
    $frequentProductIds = Order::select('product_id', \DB::raw('COUNT(*) as frequency'))
                                ->whereIn('user_id', $userIds)
                                ->where('product_id', '!=', $id)
                                ->groupBy('product_id')
                                ->orderByDesc('frequency')
                                ->limit(4)
                                ->pluck('product_id');

    // Step 3: Get product details
    $frequentlyBought = Product::whereIn('id', $frequentProductIds)->get();

    // Fallback (if no history exists)
    if ($frequentlyBought->isEmpty()) {
        $frequentlyBought = Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $product->id)
                                    ->inRandomOrder()
                                    ->limit(4)
                                    ->get();
    }

    return view('viewproduct', [
        'products' => $product,
        'frequentlyBought' => $frequentlyBought
    ]);
}


    public function categoryproduct(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $query = Product::where('status', 'Show')->where('category_id', $id);

        if ($request->filled('price_min') && is_numeric($request->price_min)) {
            $query->whereRaw('COALESCE(discounted_price, price) >= ?', [$request->price_min]);
        }

        if ($request->filled('price_max') && is_numeric($request->price_max)) {
            $query->whereRaw('COALESCE(discounted_price, price) <= ?', [$request->price_max]);
        }

        if ($request->filled('category_id')) {
            $selectedCategoryId = $request->category_id;
            $query->where('category_id', $selectedCategoryId);

            if ($selectedCategoryId != $id) {
                $category = Category::find($selectedCategoryId) ?? $category;
            }
        }

        switch ($request->query('sort')) {
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
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(8)->withQueryString();
        $allCategories = Category::orderBy('name')->get();

        return view('categoryproduct', compact('products', 'category', 'allCategories'));
    }


    public function checkout($cartid)
    {
        $cart = Cart::findOrFail($cartid);

        // Use discounted_price if set and non-zero, otherwise fall back to price
        $effectivePrice = !empty($cart->product->discounted_price)
            ? $cart->product->discounted_price
            : $cart->product->price;

        $cart->total = $effectivePrice * $cart->qty;

        return view('checkout', compact('cart'));
    }


    public function search(Request $request)
    {
        $query = Product::where('status', 'Show');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('price_min')) {
            $query->whereRaw('COALESCE(discounted_price, price) >= ?', [$request->price_min]);
        }

        if ($request->filled('price_max')) {
            $query->whereRaw('COALESCE(discounted_price, price) <= ?', [$request->price_max]);
        }

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
            default:
                $query->latest();
                break;
        }

        $products = $query->with('category')->paginate(12)->withQueryString();
        $allCategories = Category::orderBy('name', 'asc')->get();

        if ($request->ajax()) {
            return view('partials.product_cards', compact('products'))->render();
        }

        return view('search', compact('products', 'allCategories'));
    }


    public function vieworder()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $orders = $user->orders()->with('product')->get();

        return view('vieworder', compact('orders'));
    }
}
