<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
{
    $categories = Category::count();
    $products = Product::count();
    $pending = Order::where('status','Pending')->count();
    $processing = Order::where('status','Processing')->count();
    $shipping = Order::where('status','Shipping')->count();
    $delivered = Order::where('status','Delivered')->count();

    $allcat = Category::all();
    $productcount = [];
    foreach($allcat as $cat){
        $productcount[] = Product::where('category_id',$cat->id)->count();
    }
    $allcatNames = $allcat->pluck('name')->toArray(); // array of names

    return view('dashboard', compact(
        'categories', 'products', 'pending', 'processing', 'shipping', 'delivered',
        'allcatNames', 'productcount'
    ));
}

}
