@extends('layouts.master')

@section('content')

    {{-- Alerts --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto mt-4 px-6">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="px-6 md:px-16 py-10 min-h-screen bg-[#FFFFF0]">

        {{-- Search Header --}}
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-bold text-[#800020]">
                Search Results
                @if(request('search'))
                    <span class="text-[#4B2E0A] font-light italic">for "{{ request('search') }}"</span>
                @endif
            </h1>
            <p class="text-[#4B2E0A]/70 mt-2">Found {{ $products->total() }} matching items</p>
        </div>

        {{-- Filter Bar (Horizontal & Modern) --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-4 mb-10 shadow-sm">
            <form method="GET" action="{{ route('search') }}" class="flex flex-wrap items-end gap-4">
                {{-- Maintain search query --}}
                <input type="hidden" name="search" value="{{ request('search') }}">

                {{-- Category --}}
                <div class="flex flex-col flex-grow min-w-[150px]">
                    <label class="text-[10px] font-bold uppercase text-[#800020] mb-1 ml-1">Category</label>
                    <select name="category" class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#800020] focus:border-[#800020]">
                        <option value="">All Categories</option>
                        @foreach($allCategories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Price Range --}}
                <div class="flex flex-col w-full md:w-auto">
                    <label class="text-[10px] font-bold uppercase text-[#800020] mb-1 ml-1">Price Range (Rs.)</label>
                    <div class="flex items-center gap-2">
                        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Min" class="w-24 border-gray-200 rounded-lg text-sm focus:ring-[#800020]">
                        <span class="text-gray-400">-</span>
                        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Max" class="w-24 border-gray-200 rounded-lg text-sm focus:ring-[#800020]">
                    </div>
                </div>

                {{-- Sort --}}
                <div class="flex flex-col flex-grow min-w-[150px]">
                    <label class="text-[10px] font-bold uppercase text-[#800020] mb-1 ml-1">Sort By</label>
                    <select name="sort" class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#800020]">
                        <option value="">Newest</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-grow md:flex-none bg-[#800020] text-[#D4AF37] px-6 py-2 rounded-lg font-bold text-sm hover:bg-[#4B2E0A] transition shadow-md">
                        Filter
                    </button>
                    <a href="{{ route('search', ['search' => request('search')]) }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-200 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if($products->count() > 0)
            {{-- Products Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-10">
                @foreach ($products as $product)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100">
                        <a href="{{ route('viewproduct', $product->id) }}" class="block relative overflow-hidden">
                            <img src="{{ asset('images/products/' . ($product->photopath ?? 'default.jpg')) }}"
                                 alt="{{ $product->name }}"
                                 class="h-48 md:h-64 w-full object-cover transition-transform duration-700 group-hover:scale-110">

                            @if($product->discounted_price < $product->price)
                                <div class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded uppercase">
                                    Offer
                                </div>
                            @endif
                        </a>

                        <div class="p-4 md:p-6">
                            <p class="text-[10px] font-bold text-[#800020] uppercase tracking-widest mb-1">{{ $product->category->name }}</p>
                            <h3 class="text-sm md:text-lg font-bold text-[#4B2E0A] truncate mb-2">{{ $product->name }}</h3>

                            <div class="flex items-center gap-3">
                                <span class="text-lg font-bold text-[#800020]">Rs. {{ number_format($product->discounted_price ?? $product->price) }}</span>
                                @if($product->discounted_price)
                                    <span class="text-xs text-gray-400 line-through">Rs. {{ number_format($product->price) }}</span>
                                @endif
                            </div>

                            <a href="{{ route('viewproduct', $product->id) }}" class="mt-4 block text-center border-2 border-[#800020] text-[#800020] py-2 rounded-full text-xs font-bold uppercase hover:bg-[#800020] hover:text-[#D4AF37] transition-colors duration-300">
                                View Product
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-16">
                {{ $products->appends(request()->query())->links() }}
            </div>

        @else
            {{-- Modern Empty State --}}
            <div class="max-w-2xl mx-auto text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300 shadow-inner">
                <i class="ri-search-eye-line text-6xl text-gray-200 mb-4 block"></i>
                <h2 class="text-2xl font-bold text-[#4B2E0A] mb-2">No results found</h2>
                <p class="text-gray-500 mb-8 px-6">We couldn't find any products matching your criteria. Try adjusting your filters or searching for something else.</p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 px-6">
                    <a href="{{ route('home') }}" class="bg-[#800020] text-[#D4AF37] px-8 py-3 rounded-full font-bold shadow-lg hover:bg-[#4B2E0A] transition">
                        Browse All Products
                    </a>
                    <a href="tel:+9779815444184" class="bg-white border-2 border-gray-200 text-gray-600 px-8 py-3 rounded-full font-bold hover:bg-gray-50 transition">
                        Contact Support
                    </a>
                </div>
            </div>
        @endif

    </div>

@endsection
