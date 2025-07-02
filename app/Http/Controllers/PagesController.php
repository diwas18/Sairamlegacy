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
    $products= Product::where('status','Show')->find($id);
    $relatedproducts = Product::where('status','Show')->where('category_id', $products->category_id)->where('id', '!=', $id)->limit(4)->get();
        return view('viewproduct',compact('products','relatedproducts'));
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
public function search(Request $request)
{
    $qry=$request->search;
    $products=Product::where('name','like','%'.$qry.'%')-> orWhere ('description','like','%'.$qry.'%')->get();
    return view('search',compact('products'));
}
}
