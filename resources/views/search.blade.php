@extends('layouts.master')

@section('content')

<div class="px-6 md:px-16 py-10 min-h-screen bg-[#FFFDF4]">

    {{-- Main Content Area --}}
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Left Sidebar (Can be repurposed or removed) --}}
        <aside class="w-full lg:w-1/4 bg-white border border-gray-100 rounded-xl p-6 shadow-sm sticky top-4 self-start hidden lg:block">
            <div class="mb-6 border-l-4 border-[#D4AF37] pl-4">
                <h2 class="text-2xl font-bold text-[#4B2E0A]">More Options</h2>
                <p class="text-sm text-[#800020]">Discover related content.</p>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md transition duration-200">
                            About Our Products
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md transition duration-200">
                            Customer Reviews
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Right Content Area for Filters and Products --}}
        <div class="flex-grow">

            {{-- Header and Filter Section --}}
            <div class="bg-white border border-gray-100 rounded-xl p-6 mb-8 shadow-sm">
                <div class="mb-6 border-l-4 border-[#800020] pl-4">
                    <h1 class="text-3xl font-bold text-[#4B2E0A]">
                        @if(request('search'))
                            Search Results for "<span class="italic">{{ request('search') }}</span>"
                        @else
                            Explore Our Collection
                        @endif
                    </h1>
                    <p class="text-sm text-[#800020]">Find your perfect pair of glasses or contact lenses.</p>
                </div>

                {{-- Filter Form --}}
                <form method="GET" action="{{ route('home') }}" class="w-full flex flex-wrap lg:flex-nowrap gap-4 lg:gap-6 items-end justify-between">
                    {{-- Hidden Search Input: To maintain the search query across filters --}}
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="flex flex-col flex-grow w-full md:w-auto">
                        <label class="text-sm font-medium text-gray-700 mb-1">Min Price (Rs.)</label>
                        <input
                            type="number"
                            name="price_min"
                            value="{{ request('price_min') }}"
                            placeholder="e.g. 500"
                            class="w-full min-w-[100px] px-4 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] transition duration-200 ease-in-out"
                        />
                    </div>

                    <div class="flex flex-col flex-grow w-full md:w-auto">
                        <label class="text-sm font-medium text-gray-700 mb-1">Max Price (Rs.)</label>
                        <input
                            type="number"
                            name="price_max"
                            value="{{ request('price_max') }}"
                            placeholder="e.g. 5000"
                            class="w-full min-w-[100px] px-4 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] transition duration-200 ease-in-out"
                        />
                    </div>

                    {{-- Category Filter Dropdown --}}
                    <div class="flex flex-col flex-grow w-full md:w-auto">
                        <label for="category" class="text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category" name="category" class="w-full min-w-[150px] px-4 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] transition duration-200 ease-in-out">
                            <option value="">All Categories</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col flex-grow w-full md:w-auto">
                        <label for="sort" class="text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select id="sort" name="sort" class="w-full min-w-[150px] px-4 py-2 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37] transition duration-200 ease-in-out">
                            <option value="">Default</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z–A</option>
                        </select>
                    </div>

                    <div class="flex flex-row gap-3 flex-shrink-0 w-full sm:w-auto mt-4 lg:mt-0">
                        <button type="submit" class="bg-[#800020] text-white text-sm font-semibold px-6 py-2 rounded-lg hover:bg-[#6b001a] shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                            Apply Filters
                        </button>
                        <a href="{{ route('home', ['search' => request('search')]) }}" class="text-sm font-semibold px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Product Count --}}
            <div class="mb-8 text-lg font-medium text-gray-700">
                Showing <span class="font-bold text-[#800020]">{{ $products->firstItem() }}</span> to <span class="font-bold text-[#800020]">{{ $products->lastItem() }}</span> of <span class="font-bold text-[#800020]">{{ $products->total() }}</span> results.
            </div>

            {{-- Products Grouped by Category --}}
            @if($products->count() > 0)
                @php
                    $categorizedProducts = [
                        'Men' => collect(),
                        'Women' => collect(),
                        'Kids' => collect(),
                        'Unisex' => collect(), // Added Unisex
                        'Other' => collect(), // For products that don't fit into the main four
                    ];

                    foreach ($products as $product) {
                        $categoryName = strtolower($product->category->name ?? '');
                        if (str_contains($categoryName, 'men') && !str_contains($categoryName, 'women') && !str_contains($categoryName, 'unisex')) {
                            $categorizedProducts['Men']->push($product);
                        } elseif (str_contains($categoryName, 'women') && !str_contains($categoryName, 'men') && !str_contains($categoryName, 'unisex')) {
                            $categorizedProducts['Women']->push($product);
                        } elseif (str_contains($categoryName, 'kid') || str_contains($categoryName, 'child')) {
                            $categorizedProducts['Kids']->push($product);
                        } elseif (str_contains($categoryName, 'unisex')) { // Check for unisex explicitly
                            $categorizedProducts['Unisex']->push($product);
                        }
                        else {
                            $categorizedProducts['Other']->push($product);
                        }
                    }
                @endphp

                @foreach (['Men', 'Women', 'Kids', 'Unisex', 'Other'] as $categoryKey) {{-- Control order of display --}}
                    @php
                        $categoryDisplayName = $categoryKey;
                        if ($categoryKey === 'Men') $categoryDisplayName = "Men's";
                        if ($categoryKey === 'Women') $categoryDisplayName = "Women's";
                        if ($categoryKey === 'Kids') $categoryDisplayName = "Kids'";
                        if ($categoryKey === 'Other') $categoryDisplayName = "General";
                    @endphp

                    @if ($categorizedProducts[$categoryKey]->count() > 0)
                        <div class="mb-12">
                            ---
                            <h2 class="text-3xl font-bold text-[#4B2E0A] mb-6 border-l-4 border-[#D4AF37] pl-4 py-1">{{ $categoryDisplayName }} Collection</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach ($categorizedProducts[$categoryKey] as $product)
                                    <a href="{{ route('viewproduct', $product->id) }}" class="block">
                                        <div class="bg-[#FFFFF0] rounded-lg overflow-hidden shadow hover:shadow-xl transition duration-300 transform hover:-translate-y-1 h-full flex flex-col group">
                                            <div class="relative overflow-hidden">
                                                <img src="{{ asset('images/products/' . $product->photopath) }}" alt="{{ $product->name }}" class="h-64 w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                @if ($product->discounted_price)
                                                    <span class="absolute top-3 left-3 bg-[#D4AF37] text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">SALE</span>
                                                @endif
                                            </div>
                                            <div class="p-5 flex flex-col flex-grow">
                                                <h3 class="text-xl font-bold text-[#4B2E0A] mb-2 truncate">{{ $product->name }}</h3>
                                                <p class="text-sm text-gray-600 mb-3">Category: {{ $product->category->name ?? 'N/A' }}</p>
                                                <div class="mt-auto flex items-baseline">
                                                    @if ($product->discounted_price)
                                                        <p class="text-[#800020] font-bold text-2xl mr-2">Rs. {{ number_format($product->discounted_price, 0) }}</p>
                                                        <span class="line-through text-md text-red-500">Rs. {{ number_format($product->price, 0) }}</span>
                                                    @else
                                                        <p class="text-[#800020] font-bold text-2xl">Rs. {{ number_format($product->price, 0) }}</p>
                                                    @endif
                                                </div>
                                                <button class="mt-4 w-full bg-[#800020] text-white py-3 rounded-lg font-semibold hover:bg-[#D4AF37] hover:text-[#800020] transition duration-300 ease-in-out shadow-md">View Details</button>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                {{-- Pagination --}}
                <div class="mt-10 text-center">
                    {{ $products->appends(request()->query())->links('pagination::tailwind') }}
                </div>

            @else
                {{-- No Results Message --}}
                <div class="text-center mt-20 p-8 bg-white rounded-xl shadow-md border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-700 mb-4">Oops! No products found.</h2>
                    @if(request('search'))
                        <p class="text-lg text-gray-600 mb-6">
                            It looks like there are no products matching your current filters for "<span class="font-bold italic">{{ request('search') }}</span>".
                        </p>
                    @else
                        <p class="text-lg text-gray-600 mb-6">
                            It looks like there are no products matching your current filter criteria.
                        </p>
                    @endif
                    <a href="{{ route('home', ['search' => request('search')]) }}" class="inline-block bg-[#800020] hover:bg-[#D4AF37] text-white hover:text-[#800020] px-8 py-4 rounded-full font-bold text-lg transition duration-300 transform hover:-translate-y-1 shadow-lg">
                        View All Products
                    </a>
                    <p class="mt-4 text-sm text-gray-500">Try adjusting your filters.</p>
                </div>
            @endif

        </div> {{-- End Right Content Area --}}
    </div> {{-- End Main Content Area --}}

</div>

@endsection
