@extends('layouts.master')
@section('content')

{{-- Product Section --}}
<div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-10 px-6 md:px-20 items-start">

    {{-- Product Image --}}
    <div class="col-span-1 relative">
        <div class="overflow-hidden rounded-xl border bg-white shadow-md group">
            <img id="productImage" src="{{ asset('images/products/' . $products->photopath) }}"
                 alt="Product Image"
                 class="w-full h-96 object-cover transform transition-transform duration-300 group-hover:scale-105 cursor-zoom-in" />
        </div>
    </div>

    {{-- Product Details --}}
    <div class="col-span-1 space-y-6">
        <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-[#800020]">{{ $products->name }}</h1>

        {{-- Ratings --}}
        <div class="flex items-center text-yellow-500 text-xl">
            @for($i = 1; $i <= 5; $i++)
                <i class="{{ $i <= 4 ? 'ri-star-fill' : 'ri-star-line' }}"></i>
            @endfor
            <span class="text-sm text-gray-500 ml-2">(120 reviews)</span>
        </div>

        {{-- Price --}}
        <div class="text-2xl font-semibold text-[#4B2E0A]">
            @if($products->discounted_price)
                Rs. {{ $products->discounted_price }}
                <span class="text-base line-through text-red-400 ml-2">Rs. {{ $products->price }}</span>
            @else
                Rs. {{ $products->price }}
            @endif
        </div>

        {{-- Add to Cart Form --}}
        <form action="{{ route('cart.store') }}" method="POST" class="space-y-6 mt-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $products->id }}">

            {{-- Quantity Selector --}}
            <div class="flex items-center gap-4">
                <button type="button" onclick="dec()" class="w-10 h-10 flex items-center justify-center border border-[#800020] text-[#800020] rounded-lg text-xl hover:bg-[#800020] hover:text-[#FFFFF0] transition shadow-sm">
                    –
                </button>
                <input type="text" id="qty" name="qty" value="1" readonly class="w-12 text-center border border-gray-300 rounded-lg bg-[#FFFFF0] shadow-inner text-[#4B2E0A] font-semibold tracking-wide">
                <button type="button" onclick="inc()" class="w-10 h-10 flex items-center justify-center border border-[#800020] text-[#800020] rounded-lg text-xl hover:bg-[#800020] hover:text-[#FFFFF0] transition shadow-sm">
                    +
                </button>
            </div>

            <p class="text-sm text-gray-500 tracking-wide">In Stock: {{ $products->stock }}</p>

            {{-- Add to Cart Button --}}
            <button type="submit" class="flex items-center justify-center gap-2 bg-[#800020] hover:bg-[#D4AF37] text-[#FFFFF0] hover:text-[#800020] font-semibold px-6 py-3 rounded-full shadow-md transition duration-300 tracking-wide">
                <i class="ri-shopping-cart-2-line text-lg"></i> Add to Cart
            </button>
        </form>
    </div>

    {{-- Delivery Info --}}
    <div class="col-span-1 flex justify-center items-center">
        <div class="space-y-4 w-full max-w-sm text-sm text-gray-600 bg-[#FFFDF5] border rounded-xl p-6 shadow">
            <div class="flex items-center gap-2">
                <i class="ri-truck-fill text-[#800020] text-xl"></i>
                <span>Delivery within 5 days</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="ri-government-fill text-[#800020] text-xl"></i>
                <span>7-day return policy</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="ri-hand-coin-fill text-[#800020] text-xl"></i>
                <span>Cash on delivery available</span>
            </div>
        </div>
    </div>
</div>

{{-- Tabs Section --}}
<div class="mt-16 px-6 md:px-20" x-data="{ tab: 'desc' }">
    <div class="flex space-x-6 border-b mb-4 text-[#4B2E0A] font-medium">
        <button @click="tab = 'desc'" :class="{ 'border-b-2 border-[#800020]': tab === 'desc' }" class="pb-2">Description</button>
        <button @click="tab = 'rev'" :class="{ 'border-b-2 border-[#800020]': tab === 'rev' }" class="pb-2">Reviews</button>
        <button @click="tab = 'det'" :class="{ 'border-b-2 border-[#800020]': tab === 'det' }" class="pb-2">Details</button>
    </div>

    <div x-show="tab === 'desc'" x-transition>
        <p class="text-base text-gray-700">{{ $products->description }}</p>
    </div>

    <div x-show="tab === 'rev'" x-transition class="space-y-4 text-gray-700">
        <p class="text-sm text-gray-500">⭐ 4.5 Average based on 120 reviews</p>
        <p>"Great quality, loved it!" – <strong>Ravi</strong></p>
        <p>"Fast delivery and looks amazing." – <strong>Sita</strong></p>
    </div>

    <div x-show="tab === 'det'" x-transition>
        <ul class="list-disc ml-5 text-gray-700 space-y-1">
            <li>Material: Cotton Blend</li>
            <li>Category: Unisex</li>
            <li>Made in: Nepal</li>
        </ul>
    </div>
</div>

{{-- Related Products --}}
<div class="mt-16 px-6 md:px-20">
    <h2 class="text-xl font-bold text-[#800020] mb-6">You May Also Like</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        @foreach($relatedproducts as $rproducts)
        <a href="{{ route('viewproduct', $rproducts->id) }}" class="group block rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-lg transition duration-300 bg-white">
            <div class="relative w-full h-52 overflow-hidden">
                <img src="{{ asset('images/products/' . $rproducts->photopath) }}" alt="{{ $rproducts->name }}"
                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
            </div>
            <div class="p-4">
                <h3 class="text-md font-semibold text-[#4B2E0A] truncate mb-1">{{ $rproducts->name }}</h3>
                @if($rproducts->discounted_price)
                    <p class="text-sm font-bold text-[#800020]">
                        Rs. {{ $rproducts->discounted_price }}
                        <span class="line-through text-xs text-red-500 ml-2">Rs. {{ $rproducts->price }}</span>
                    </p>
                @else
                    <p class="text-sm font-bold text-[#800020]">Rs. {{ $rproducts->price }}</p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</div>


{{-- Quantity Control Script --}}
<script>
    function inc() {
        let qty = document.getElementById('qty');
        if (parseInt(qty.value) < {{ $products->stock }}) {
            qty.value = parseInt(qty.value) + 1;
        }
    }

    function dec() {
        let qty = document.getElementById('qty');
        if (parseInt(qty.value) > 1) {
            qty.value = parseInt(qty.value) - 1;
        }
    }
</script>

{{-- Alpine.js for tabs --}}
<script src="//unpkg.com/alpinejs" defer></script>

@endsection
