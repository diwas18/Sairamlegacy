@extends('layouts.master')

@section('content')

<div class="px-6 md:px-16 py-8 bg-gray-50 min-h-screen">
<!-- 🟣 Hero Banner -->
<div class="relative h-[70vh] md:h-[85vh] w-full rounded-lg overflow-hidden shadow-lg mb-12 flex items-center justify-between bg-gray-200">

    <!-- 🧾 Left Text Content -->
    <div class="z-10 w-full md:w-1/2 px-6 md:px-16 space-y-6">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight tracking-wide">
            GIORDANO<br>GLASSES
        </h1>
        <p class="text-base md:text-lg text-gray-700 max-w-md">
            An original eyewear collection from the world-renowned American designer, featuring sun and optical styles for men and women.
        </p>
        <a href="#products"
           class="inline-block bg-black hover:bg-gray-800 text-white font-semibold text-sm md:text-base px-6 py-3 rounded-full shadow transition duration-300">
            Shop Now
        </a>
    </div>

    <!-- 🖼️ Image on Right -->
    <div class="hidden md:block w-1/2 h-full -ml-10 ">
        <img src="{{ asset('images/banner.png') }}" alt="Giordano Model"
             class="w-full h-full object-cover object-center rounded-l-lg">
    </div>

</div>



    <!-- 🟣 Section Title -->
    <div id="products" class="border-l-4 border-[#800020] pl-3 mb-6">
        <h1 class="text-3xl font-semibold text-[#4B2E0A] tracking-wide mb-1">Latest Products</h1>
        <p class="text-[#800020] text-sm font-medium">Discover our newest elegant collection</p>
    </div>

 <form method="GET" action="{{ route('home') }}" class="w-full bg-white border border-gray-100 rounded-lg p-6 shadow-sm mb-8 flex flex-wrap lg:flex-nowrap gap-4 lg:gap-6 items-end justify-between">

    <!-- 🔖 Category -->
    <div class="flex flex-col flex-grow lg:flex-grow-0">
        <label for="category" class="text-sm font-medium text-gray-700 mb-1">Category</label>
        <select id="category" name="category" class="w-full min-w-[150px] px-4 py-2 rounded-md border border-gray-300 text-sm focus:ring-2 focus:ring-[#800020] focus:border-[#800020]">
            <option value="">All</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- 💰 Min Price -->
    <div class="flex flex-col flex-grow lg:flex-grow-0">
        <label class="text-sm font-medium text-gray-700 mb-1">Min Price</label>
        <input
            type="number"
            name="price_min"
            value="{{ request('price_min') }}"
            placeholder="e.g. 500"
            class="w-full min-w-[100px] px-4 py-2 rounded-md border border-gray-300 text-sm focus:ring-2 focus:ring-[#800020] focus:border-[#800020]"
        />
    </div>

    <!-- 💰 Max Price -->
    <div class="flex flex-col flex-grow lg:flex-grow-0">
        <label class="text-sm font-medium text-gray-700 mb-1">Max Price</label>
        <input
            type="number"
            name="price_max"
            value="{{ request('price_max') }}"
            placeholder="e.g. 5000"
            class="w-full min-w-[100px] px-4 py-2 rounded-md border border-gray-300 text-sm focus:ring-2 focus:ring-[#800020] focus:border-[#800020]"
        />
    </div>

    <!-- 🔃 Sort Options -->
    <div class="flex flex-col flex-grow lg:flex-grow-0">
        <label for="sort" class="text-sm font-medium text-gray-700 mb-1">Sort By</label>
        <select id="sort" name="sort" class="w-full min-w-[150px] px-4 py-2 rounded-md border border-gray-300 text-sm focus:ring-2 focus:ring-[#800020] focus:border-[#800020]">
            <option value="">Default</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z–A</option>
        </select>
    </div>

    <!-- ✅ Buttons -->
    <div class="flex flex-row gap-3 flex-shrink-0">
        <button type="submit" class="bg-[#800020] text-white text-sm font-semibold px-5 py-2 rounded-md hover:bg-[#9d2f3f] shadow transition">
            Apply
        </button>
        <a href="{{ route('home') }}" class="text-sm font-semibold px-5 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition">
            Reset
        </a>
    </div>

</form>




    <!-- 🟣 Product Grid -->
    <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @include('partials.product_cards') {{-- partial with product cards only --}}
    </div>

    <!-- 🟣 Load More Button -->
    <div class="text-center mt-8">
        <button id="loadMoreBtn" class="bg-[#D4AF37] hover:bg-[#c39f2c] text-[#4B2E0A] px-6 py-2 rounded shadow">
            Load More
        </button>
    </div>

    <!-- 🟣 Pagination fallback (optional) -->
    <div class="mt-10 text-center">
        {{ $products->appends(request()->query())->links('pagination::tailwind') }}
    </div>

    <!-- 🟣 Featured Products Section -->
<div class="mb-12 mt-16">
    <h2 class="text-3xl font-semibold text-[#4B2E0A] mb-6 border-l-4 border-[#800020] pl-3">Featured Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($featured as $product)
        <a href="{{ route('viewproduct', $product->id) }}" class="group block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transform hover:scale-[1.03] transition-all duration-300">
            <div class="relative overflow-hidden rounded-t-lg">
                <img
                    src="{{ asset('images/products/'.$product->photopath) }}"
                    alt="{{ $product->name ?? 'Product Image' }}"
                    class="w-full h-52 object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                />
                @if($product->discounted_price)
                    @php
                        $discount = ceil((($product->price - $product->discounted_price) / $product->price) * 100);
                    @endphp
                    <div class="absolute top-2 left-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full font-semibold shadow">
                        {{ $discount }}% OFF
                    </div>
                @endif
            </div>
            <div class="p-4 text-center">
                <h3 class="text-lg font-semibold text-[#4B2E0A] truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                @if($product->discounted_price)
                    <p class="mt-2 text-md font-bold text-[#D4AF37]">
                        Rs. {{ number_format($product->discounted_price) }}
                        <span class="ml-2 text-gray-400 line-through text-sm font-normal">Rs. {{ number_format($product->price) }}</span>
                    </p>
                @else
                    <p class="mt-2 text-md font-bold text-[#4B2E0A]">Rs. {{ number_format($product->price) }}</p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</div>


    <!-- 🟣 Why Choose Us Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mt-16 text-center text-[#4B2E0A]">
        <div class="flex flex-col items-center space-y-3 hover:text-[#800020] transition duration-300 cursor-pointer">
            <img src="{{ asset('images/transport.png') }}" alt="Free Shipping" class="w-16 h-16 mx-auto" loading="lazy">
            <p class="text-sm font-semibold">Free Shipping</p>
        </div>
        <div class="flex flex-col items-center space-y-3 hover:text-[#800020] transition duration-300 cursor-pointer">
            <img src="{{ asset('images/easy-return.png') }}" alt="Easy 7-day Returns" class="w-16 h-16 mx-auto" loading="lazy">
            <p class="text-sm font-semibold">Easy 7-day Returns</p>
        </div>
        <div class="flex flex-col items-center space-y-3 hover:text-[#800020] transition duration-300 cursor-pointer">
            <img src="{{ asset('images/secure-payment.png') }}" alt="Secure Checkout" class="w-16 h-16 mx-auto" loading="lazy">
            <p class="text-sm font-semibold">Secure Checkout</p>
        </div>
        <div class="flex flex-col items-center space-y-3 hover:text-[#800020] transition duration-300 cursor-pointer">
            <img src="{{ asset('images/customer-care.png') }}" alt="24/7 Support" class="w-16 h-16 mx-auto" loading="lazy">
            <p class="text-sm font-semibold">24/7 Support</p>
        </div>
    </div>

    <!-- 🟣 Testimonial -->
    <div class="mt-16 bg-white p-8 rounded-lg shadow-lg text-center max-w-2xl mx-auto">
        <p class="text-lg italic text-gray-700 max-w-xl mx-auto leading-relaxed">"Absolutely love the quality! Stylish and affordable. Highly recommend!"</p>
        <p class="mt-4 text-sm text-[#800020] font-semibold tracking-wide">— Apsara Lamsal, Customer</p>
    </div>

</div>

@endsection


@push('scripts')
<script>
    let nextPage = 2;
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const lastPage = {{ $products->lastPage() }};

    loadMoreBtn.addEventListener('click', function() {
        let category = '{{ request("category") }}';
        let categoryParam = category ? '&category=' + category : '';
        fetch(window.location.pathname + `?page=${nextPage}${categoryParam}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            if (html.trim() === '') {
                loadMoreBtn.textContent = 'No more products';
                loadMoreBtn.disabled = true;
            } else {
                document.getElementById('product-list').insertAdjacentHTML('beforeend', html);
                nextPage++;
                if(nextPage > lastPage) {
                    loadMoreBtn.textContent = 'No more products';
                    loadMoreBtn.disabled = true;
                }
            }
        })
        .catch(() => {
            loadMoreBtn.textContent = 'Error loading products';
            loadMoreBtn.disabled = true;
        });
    });
</script>

<script>
$(document).ready(function(){
    $('.featured-carousel').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        dots: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        rtl: true,
        responsive: [
            { breakpoint: 1024, settings: { slidesToShow: 3 } },
            { breakpoint: 768, settings: { slidesToShow: 2 } },
            { breakpoint: 480, settings: { slidesToShow: 1 } }
        ]
    });
});
</script>
@endpush
