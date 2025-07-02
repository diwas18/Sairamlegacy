@extends('layouts.master')
@section('content')

<div class="px-6 md:px-16 py-10 bg-[#FFFDF4] min-h-screen">

    {{-- Header --}}
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-extrabold text-[#800020] tracking-wide">My Cart</h1>
        <p class="text-sm text-[#4B2E0A]">You have {{ count($carts) }} item{{ count($carts) > 1 ? 's' : '' }} in your cart.</p>
    </div>

    @if(count($carts) > 0)
        {{-- Cart List --}}
        <div class="space-y-6">
            @foreach ($carts as $cart)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                    {{-- Product Info --}}
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/products/' . $cart->product->photopath) }}" alt="{{ $cart->product->name }}" class="h-20 w-20 object-cover rounded-md border border-gray-200">
                        <div>
                            <h2 class="text-lg font-semibold text-[#4B2E0A]">{{ $cart->product->name }}</h2>
                            <p class="text-sm text-gray-500">Quantity: {{ $cart->qty }}</p>
                        </div>
                    </div>

                    {{-- Price Info --}}
                    <div class="text-center md:text-left">
                        @if ($cart->product->discounted_price)
                            <p class="text-lg font-semibold text-[#800020]">Rs. {{ $cart->product->discounted_price }}</p>
                            <span class="text-sm text-red-500 line-through">Rs. {{ $cart->product->price }}</span>
                        @else
                            <p class="text-lg font-semibold text-[#800020]">Rs. {{ $cart->product->price }}</p>
                        @endif
                        <p class="text-sm text-gray-500 mt-1">Total: <span class="text-[#4B2E0A] font-medium">Rs. {{ $cart->total }}</span></p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 justify-center md:justify-end">
                        <a href="{{ route('checkout', $cart->id) }}" class="bg-[#800020] hover:bg-[#D4AF37] text-white hover:text-[#800020] px-4 py-2 rounded-full transition font-medium">Checkout</a>
                        <a href="{{ route('cart.destroy', $cart->id) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full transition font-medium">Remove</a>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Checkout All Option (optional) --}}
        <div class="text-center mt-10">
            <a href="" class="inline-block bg-[#D4AF37] hover:bg-[#800020] text-[#800020] hover:text-white px-6 py-3 rounded-full font-semibold transition">
                Proceed to Checkout All
            </a>
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center mt-20">
            <h2 class="text-xl text-gray-600 mb-4">Your cart is empty.</h2>
            <a href="{{ route('home') }}" class="inline-block bg-[#800020] hover:bg-[#D4AF37] text-white hover:text-[#800020] px-6 py-3 rounded-full font-medium transition">
                Continue Shopping
            </a>
        </div>
    @endif

</div>

@endsection
