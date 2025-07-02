@extends('layouts.master')
@section('content')

<div class="px-6 md:px-16 py-10 min-h-screen bg-[#FFFDF4]">

    {{-- Header --}}
    <div class="mb-6 border-l-4 border-[#800020] pl-4">
        <h1 class="text-3xl font-bold text-[#4B2E0A]">Search Results</h1>
        <p class="text-sm text-[#800020]">Found {{ $products->count() }} product(s) matching your search.</p>
    </div>

    {{-- Products --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-6">
            @foreach ($products as $product)
                <a href="{{ route('viewproduct', $product->id) }}">
                    <div class="bg-[#FFFFF0] rounded-lg overflow-hidden shadow hover:shadow-lg transition hover:-translate-y-1">
                        <img src="{{ asset('images/products/' . $product->photopath) }}" alt="{{ $product->name }}" class="h-64 w-full object-cover">
                        <div class="p-4">
                            <h2 class="text-lg font-bold text-[#4B2E0A]">{{ $product->name }}</h2>
                            @if ($product->discounted_price)
                                <p class="text-[#800020] font-semibold text-base">
                                    Rs. {{ $product->discounted_price }}
                                    <span class="line-through text-sm text-red-500 ml-1">Rs. {{ $product->price }}</span>
                                </p>
                            @else
                                <p class="text-[#800020] font-semibold text-base">Rs. {{ $product->price }}</p>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        {{-- No Results --}}
        <div class="text-center mt-20">
            <h2 class="text-xl text-gray-500 mb-2">No products found for your search.</h2>
            <a href="{{ route('home') }}" class="inline-block bg-[#800020] hover:bg-[#D4AF37] text-white hover:text-[#800020] px-6 py-3 rounded-full font-medium transition">
                Go Back to Shop
            </a>
        </div>
    @endif

</div>

@endsection
