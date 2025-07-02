<?php

namespace App\Http\Controllers;

use App\Models\Cart;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\support\Facades\Auth;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function store(Request $request)
    {
        $data =$request->validate([
            'product_id' => 'required',
            'qty'=>'required'
        ]);
        $data['user_id'] =Auth::id();

        $cart = Cart::where('user_id',Auth::id())->where ('product_id',$data['product_id'])->first();
        if($cart){
            $cart->qty=$data['qty'];
            $cart->save();
            return back()->with('success','Cart Updated  Successfully');}

        Cart::create($data);
        return back()->with('success','product added to cart successfully');

    }


    public function mycart()
    {
        $carts = Cart::where('user_id',Auth::id())->get();
        foreach($carts as $cart)
        {
            if($cart->product->discounted_price==''){
                $cart->total =$cart->product->price * $cart->qty;
            }
            else
            {
                $cart->total =$cart->product->discounted_price * $cart->qty;
            }
        }
        return view('mycart',compact('carts'));

    }
    public function destroy($id) {
        Cart::find($id)->delete();
        return back()->with('success','product removed from cart successfully');

    }
}


