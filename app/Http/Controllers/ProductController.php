<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Notifications\ProductUpdateNotification;
use App\Models\Product;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function index(){
        $products = Product::all();
        return view('product.index',compact(var_name: 'products'));



    }


    public function create()
    {
        $categories =Category::orderBy('priority')->get();
        return view('product.create',compact('categories'));

 }
   public function store(Request $request)
{
    // Validation rules:
    $data = $request->validate([
        'name' => ['required', 'regex:/^[A-Za-z\s\-]+$/'], // letters, spaces, hyphens only
        'category_id' => 'required|exists:categories,id',
        'description' => 'required',
        'price' => 'required|numeric|min:0',
        'discounted_price' => 'nullable|numeric|lt:price|min:0',
        'stock' => 'required|numeric|min:0',
        'status' => 'required',
        'photopath' => 'required|image',
    ]);

    // Store photo
    $photo = $request->file('photopath');
    $photoname = time() . '.' . $photo->extension();
    $photo->move(public_path('images/products'), $photoname);
    $data['photopath'] = $photoname;

    // Create product
    $product = Product::create($data);

    // Send notification to all users about new product
    $message = "New product added: {$product->name}! Check it out now.";
    User::chunk(100, function ($users) use ($product, $message) {
        foreach ($users as $user) {
            $user->notify(new ProductUpdateNotification($product, $message));
        }
    });

    return redirect()->route('product.index')->with('success', 'Product created successfully');
}

    public function edit($id){
        $product=Product::find($id);
        $categories=Category::orderBy('priority')->get();
        return view('product.edit',compact('product','categories'));





    }
   public function update(Request $request, $id)
{
    $data = $request->validate([
        'name' => ['required', 'regex:/^[A-Za-z\s\-]+$/'],
        'category_id' => 'required|exists:categories,id',
        'description' => 'required',
        'price' => 'required|numeric|min:0',
        'discounted_price' => 'nullable|numeric|lt:price|min:0',
        'stock' => 'required|numeric|min:0',
        'status' => 'required',
        'photopath' => 'nullable|image',
    ]);

    $product = Product::findOrFail($id);

    // Keep old discounted price to detect change
    $oldDiscountedPrice = $product->discounted_price;

    // Handle photo upload if exists
    if ($request->hasFile('photopath')) {
        $photo = $request->file('photopath');
        $photoname = time() . '.' . $photo->extension();
        $photo->move(public_path('images/products'), $photoname);

        // Delete old photo file if exists
        $oldphoto = public_path('images/products/' . $product->photopath);
        if (file_exists($oldphoto)) {
            unlink($oldphoto);
        }
        $data['photopath'] = $photoname;
    } else {
        // Keep old photo if no new photo uploaded
        $data['photopath'] = $product->photopath;
    }

    // Update product
    $product->update($data);

    // Notify users if discounted price changed
    if ($oldDiscountedPrice != $product->discounted_price) {
        $message = "Discount updated for {$product->name}! Grab it while it lasts.";
        User::chunk(100, function ($users) use ($product, $message) {
            foreach ($users as $user) {
                $user->notify(new ProductUpdateNotification($product, $message));
            }
        });
    }

    return redirect()->route('product.index')->with('success', 'Product updated successfully');
}
    public function destroy($id)
    {
        $product=Product::find($id);
        $photo=public_path('images/products/'.$product->photopath);
        if(file_exists($photo))
        {
            unlink($photo);
         }
            $product->delete();
            return redirect()->route('product.index')->with('success','Product deleted successfully');
     }



}
