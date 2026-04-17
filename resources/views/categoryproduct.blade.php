@extends('layouts.master')

@section('content')

<div class="px-6 md:px-16 py-10 bg-[#FFFFF0] min-h-screen">

    {{-- Page Title & Context --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#800020] uppercase tracking-tight">{{ $category->name }}</h1>
            <p class="text-gray-600 text-sm mt-1">
                Displaying {{ $products->total() }} {{ Str::plural('style', $products->total()) }} from our collection
            </p>
        </div>

        {{-- Compact Sort Bar --}}
        <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-100">
            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                <select id="sort" name="sort" onchange="this.form.submit()" class="bg-transparent border-none text-sm font-bold text-[#4B2E0A] focus:ring-0 cursor-pointer">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                </select>

                @if(request('sort'))
                    <a href="{{ url()->current() }}" class="text-[#800020] hover:text-red-700 p-1" title="Clear Sort">
                        <i class="ri-close-circle-fill text-lg"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Products Grid --}}
    @if ($products->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
            <i class="ri-eye-off-line text-5xl text-gray-300 mb-4 block"></i>
            <h2 class="text-2xl font-bold text-[#4B2E0A]">No products found</h2>
            <p class="text-gray-500 mb-6">We are currently updating our {{ $category->name }} collection.</p>
            <a href="{{ route('home') }}" class="inline-block bg-[#800020] text-[#D4AF37] px-8 py-3 rounded-full font-bold hover:bg-[#4B2E0A] transition shadow-lg">
                Explore Other Categories
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-10">
            @foreach ($products as $product)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col h-full">
                    <a href="{{ route('viewproduct', $product->id) }}" class="block relative overflow-hidden">
                        <img src="{{ asset('images/products/' . ($product->photopath ?? 'default.jpg')) }}"
                             alt="{{ $product->name }}"
                             class="h-48 md:h-64 w-full object-cover transition-transform duration-700 group-hover:scale-110">

                        {{-- Discount badge (top-left) --}}
                        @if($product->discounted_price && $product->discounted_price < $product->price)
                            <div class="absolute top-3 left-3 bg-[#800020] text-[#D4AF37] text-[10px] font-bold px-2 py-1 rounded uppercase tracking-tighter">
                                Special Offer
                            </div>
                        @endif

                        {{-- Stock badge (top-right) — only when low or out --}}
                        @if($product->stock <= 0)
                            <div class="absolute top-3 right-3 bg-red-100 text-red-800 text-[10px] font-bold px-2 py-1 rounded-full shadow">
                                Out of stock
                            </div>
                        @elseif($product->stock <= 5)
                            <div class="absolute top-3 right-3 bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-1 rounded-full shadow animate-pulse">
                                Only {{ $product->stock }} left!
                            </div>
                        @endif
                    </a>

                    <div class="p-4 md:p-6 flex flex-col flex-grow">
                        <h3 class="text-sm md:text-lg font-bold text-[#4B2E0A] truncate mb-2">{{ $product->name }}</h3>

                        {{-- Price --}}
                        <div class="mt-auto flex items-center gap-3">
                            <span class="text-lg font-bold text-[#800020]">Rs. {{ number_format($product->discounted_price ?? $product->price) }}</span>
                            @if($product->discounted_price && $product->discounted_price < $product->price)
                                <span class="text-xs text-gray-400 line-through">Rs. {{ number_format($product->price) }}</span>
                            @endif
                        </div>

                        {{-- Stock status text --}}
                        <div class="mt-2">
                            @if($product->stock <= 0)
                                <span class="text-xs text-red-600 font-medium">● Out of stock</span>
                            @elseif($product->stock <= 5)
                                <span class="text-xs text-amber-600 font-medium animate-pulse">● Only {{ $product->stock }} left — hurry!</span>
                            @elseif($product->stock <= 15)
                                <span class="text-xs text-green-700 font-medium">● {{ $product->stock }} in stock</span>
                            @else
                                <span class="text-xs text-green-600 font-medium">● In stock</span>
                            @endif
                        </div>

                        <a href="{{ route('viewproduct', $product->id) }}" class="mt-4 block text-center border-2 border-[#800020] text-[#800020] py-2 rounded-full text-xs font-bold uppercase hover:bg-[#800020] hover:text-[#D4AF37] transition-all duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-16 flex justify-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif

</div>

@endsection
