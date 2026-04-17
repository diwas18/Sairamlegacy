@extends('layouts.master')

@section('content')

{{-- Flash Messages --}}
@if (session('success'))
    <div class="flex items-center gap-3 bg-green-50 border-l-4 border-green-500 text-green-800 text-sm px-6 py-4 mx-6 md:mx-20 mt-6 rounded-r-xl shadow-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="flex items-center gap-3 bg-red-50 border-l-4 border-red-500 text-red-800 text-sm px-6 py-4 mx-6 md:mx-20 mt-6 rounded-r-xl shadow-sm">
        {{ session('error') }}
    </div>
@endif
@if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 text-sm px-6 py-4 mx-6 md:mx-20 mt-6 rounded-r-xl shadow-sm">
        <p class="font-medium mb-1">Please fix the following:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="max-w-7xl mx-auto px-6 md:px-16 py-8 bg-[#FFFFF0] min-h-screen">

    {{-- Breadcrumb --}}
    <p class="text-xs text-gray-400 mb-6">
        <a href="/" class="hover:text-[#800020]">Home</a> /
        <a href="#" class="hover:text-[#800020]">{{ $products->category->name ?? 'Eyewear' }}</a> /
        <span class="text-[#800020]">{{ $products->name }}</span>
    </p>

    {{-- ═══ PRODUCT TOP SECTION ═══ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

        {{-- 1. Gallery --}}
        <div class="flex flex-col gap-3">
            {{-- Main Image --}}
            <div class="relative bg-[#f5f0e8] border-[1.5px] border-[#e8d9be] rounded-2xl overflow-hidden group h-80">
                @if($products->is_new ?? false)
                    <span class="absolute top-3 left-3 z-10 bg-[#800020] text-[#FFFFF0] text-[11px] font-medium px-3 py-1 rounded-full">New arrival</span>
                @endif
                <img id="productImage"
                     src="{{ asset('images/products/' . ($products->photopath ?? 'default-product.webp')) }}"
                     alt="{{ $products->name }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 cursor-zoom-in"
                     onerror="this.onerror=null;this.src='{{ asset('images/products/default-product.webp') }}';" />
            </div>

            {{-- Thumbnails --}}
            <div class="flex gap-2">
                <button onclick="setMainImg(this, '{{ asset('images/products/' . ($products->photopath ?? 'default-product.webp')) }}')"
                        class="w-16 h-16 rounded-xl border-[1.5px] border-[#D4AF37] overflow-hidden flex-shrink-0">
                    <img src="{{ asset('images/products/' . ($products->photopath ?? 'default-product.webp')) }}" class="w-full h-full object-cover" />
                </button>
                {{-- Add more thumb images here as needed --}}
            </div>

            {{-- Virtual Try-On CTA --}}
            <button class="flex items-center justify-center gap-2 bg-[#fff8f0] border-[1.5px] border-[#D4AF37] text-[#800020] text-sm font-medium rounded-xl py-2.5 hover:bg-[#D4AF37] hover:text-[#4B2E0A] transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 10a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M21 12c-2.4 4-5.4 6-9 6s-6.6-2-9-6c2.4-4 5.4-6 9-6s6.6 2 9 6z"/></svg>
                Virtual try-on
            </button>
        </div>

        {{-- 2. Product Info --}}
        <div class="flex flex-col gap-4">

            <span class="inline-block self-start bg-[#fff0f3] border border-[#f5c4c4] text-[#800020] text-[11px] font-medium px-3 py-1 rounded-full">
                {{ $products->category->name ?? 'Eyewear' }}
                @if($products->material) · {{ $products->material }}@endif
            </span>

            <h1 class="text-2xl font-medium text-[#800020] leading-tight">{{ $products->name }}</h1>

            {{-- Stars --}}
            @php $avgRating = $products->averageRating(); $totalReviews = $products->totalReviews(); @endphp
            <div class="flex items-center gap-2">
                <div class="flex text-[#D4AF37] text-base">
                    @for($i = 1; $i <= 5; $i++)
                        @if($avgRating >= $i)<i class="ri-star-fill"></i>
                        @elseif($avgRating > ($i - 1))<i class="ri-star-half-fill"></i>
                        @else<i class="ri-star-line text-[#e0d0b8]"></i>
                        @endif
                    @endfor
                </div>
                <span class="text-xs text-gray-400">
                    @if($totalReviews > 0){{ number_format($avgRating, 1) }} · {{ $totalReviews }} reviews@else No reviews yet @endif
                </span>
            </div>

            {{-- Price --}}
            <div class="flex items-baseline gap-3">
                @if(isset($products->discounted_price) && $products->discounted_price < $products->price)
                    <span class="text-2xl font-medium text-[#800020]">Rs. {{ number_format($products->discounted_price, 0) }}</span>
                    <span class="text-sm text-gray-300 line-through">Rs. {{ number_format($products->price, 0) }}</span>
                    @php $pct = round((1 - $products->discounted_price / $products->price) * 100); @endphp
                    <span class="bg-[#fff0f3] border border-[#f5c4c4] text-[#800020] text-[11px] font-medium px-2 py-0.5 rounded-full">{{ $pct }}% off</span>
                @else
                    <span class="text-2xl font-medium text-[#800020]">Rs. {{ number_format($products->price, 0) }}</span>
                @endif
            </div>

            <hr class="border-[#f0e8d4]">

            {{-- Key specs strip --}}
            @if($products->weight || $products->dimensions || $products->material)
            <div class="flex gap-2 flex-wrap">
                @if($products->weight)
                    <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-3 py-2 text-center">
                        <div class="text-sm font-medium text-[#800020]">{{ $products->weight }}g</div>
                        <div class="text-[10px] text-gray-400">weight</div>
                    </div>
                @endif
                @if($products->dimensions)
                    <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-3 py-2 text-center">
                        <div class="text-sm font-medium text-[#800020]">{{ $products->dimensions }}</div>
                        <div class="text-[10px] text-gray-400">dimensions</div>
                    </div>
                @endif
                @if($products->material)
                    <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-3 py-2 text-center">
                        <div class="text-sm font-medium text-[#800020]">{{ $products->material }}</div>
                        <div class="text-[10px] text-gray-400">material</div>
                    </div>
                @endif
                <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-3 py-2 text-center">
                    <div class="text-sm font-medium text-[#800020]">Rx-ready</div>
                    <div class="text-[10px] text-gray-400">prescription</div>
                </div>
            </div>
            @endif

            {{-- Quantity + Stock --}}
            <div>
                <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-2">Quantity</p>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="dec()"
                            class="w-9 h-9 rounded-lg border-[1.5px] border-[#e0cebc] bg-white text-[#800020] text-lg flex items-center justify-center hover:border-[#800020] transition">–</button>
                    <input type="number" id="qty" name="qty" value="1" min="1" max="{{ $products->stock }}"
                           readonly class="w-12 text-center border-[1.5px] border-[#e0cebc] rounded-lg bg-[#fffdf8] text-[#4B2E0A] font-medium py-1.5 focus:outline-none appearance-none">
                    <button type="button" onclick="inc()"
                            class="w-9 h-9 rounded-lg border-[1.5px] border-[#e0cebc] bg-white text-[#800020] text-lg flex items-center justify-center hover:border-[#800020] transition">+</button>
                    @if($products->stock > 0)
                        <span class="flex items-center gap-1.5 text-xs text-green-700 bg-green-50 border border-green-200 px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            <span id="stockCount">{{ $products->stock }}</span> in stock
                        </span>
                    @else
                        <span class="flex items-center gap-1.5 text-xs text-red-700 bg-red-50 border border-red-200 px-3 py-1.5 rounded-full">Out of stock</span>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                @if($products->stock > 0)
                    <form action="{{ route('cart.store') }}" method="POST" class="flex-[2]">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $products->id }}">
                        <input type="hidden" name="qty" id="cartQty" value="1">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#800020] hover:bg-[#a8324a] text-[#FFFFF0] text-sm font-medium py-3 rounded-xl transition">
                            <i class="ri-shopping-cart-2-line"></i> Add to cart
                        </button>
                    </form>
                    <form action="" method="GET" class="flex-1">
                        <input type="hidden" name="product_id" value="{{ $products->id }}">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 border-[1.5px] border-[#D4AF37] bg-[#FFFFF0] hover:bg-[#D4AF37] text-[#800020] hover:text-[#4B2E0A] text-sm font-medium py-3 rounded-xl transition">
                            <i class="ri-wallet-line"></i> Buy now
                        </button>
                    </form>
                    <button type="button" class="w-12 h-12 flex-shrink-0 flex items-center justify-center border-[1.5px] border-[#e8d9be] bg-white rounded-xl hover:border-[#800020] transition">
                        <i class="ri-heart-line text-[#800020] text-lg"></i>
                    </button>
                @else
                    <button disabled class="flex-1 flex items-center justify-center gap-2 bg-gray-300 text-gray-500 text-sm font-medium py-3 rounded-xl cursor-not-allowed">
                        <i class="ri-shopping-cart-2-line"></i> Out of stock
                    </button>
                @endif
            </div>
        </div>

        {{-- 3. Delivery Card --}}
        <div class="bg-white border-[1.5px] border-[#e8d9be] rounded-2xl p-5 flex flex-col gap-4">
            <h4 class="text-sm font-medium text-[#800020]">Delivery &amp; Returns</h4>

            @foreach([
                ['icon' => 'ri-truck-line', 'title' => 'Delivery within 5 days', 'sub' => 'Free shipping over Rs. 2,000'],
                ['icon' => 'ri-arrow-go-back-line', 'title' => '7-day easy returns', 'sub' => 'No questions asked'],
                ['icon' => 'ri-hand-coin-line', 'title' => 'Cash on delivery', 'sub' => 'Pay when you receive'],
                ['icon' => 'ri-shield-check-line', 'title' => '1-year frame warranty', 'sub' => 'Manufacturer defects covered'],
            ] as $info)
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 flex-shrink-0 bg-[#fff8f0] border border-[#f0e8d4] rounded-xl flex items-center justify-center">
                    <i class="{{ $info['icon'] }} text-[#800020]"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-[#4B2E0A]">{{ $info['title'] }}</p>
                    <span class="text-xs text-gray-400">{{ $info['sub'] }}</span>
                </div>
            </div>
            @endforeach

            <div class="flex items-center gap-2 bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-3 py-2 text-xs text-[#800020] font-medium">
                <i class="ri-lock-line"></i> Secure checkout · SSL encrypted
            </div>
        </div>
    </div>

    {{-- ═══ TABS SECTION ═══ --}}
    <div class="mt-12" x-data="{ tab: 'desc' }">
        <div class="flex gap-1 border-b-[1.5px] border-[#f0e8d4] mb-6 overflow-x-auto">
            @foreach([
                ['key' => 'desc',  'label' => 'Description'],
                ['key' => 'specs', 'label' => 'Specifications'],
                ['key' => 'fit',   'label' => 'Face fit guide'],
                ['key' => 'rev',   'label' => 'Reviews (' . $products->totalReviews() . ')'],
                ['key' => 'write', 'label' => 'Write a review'],
            ] as $t)
            <button @click="tab = '{{ $t['key'] }}'"
                    :class="tab === '{{ $t['key'] }}' ? 'border-b-2 border-[#800020] text-[#800020]' : 'text-gray-400 hover:text-[#800020]'"
                    class="pb-2.5 px-4 text-sm font-medium whitespace-nowrap transition border-b-2 border-transparent -mb-[1.5px]">
                {{ $t['label'] }}
            </button>
            @endforeach
        </div>

        {{-- Description --}}
        <div x-show="tab === 'desc'" x-transition>
            <p class="text-sm text-[#5a4030] leading-relaxed max-w-2xl mb-4">{{ $products->description ?? 'No description available.' }}</p>
            @if($products->weight || $products->material)
            <div class="flex flex-wrap gap-3">
                @if($products->weight)
                <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-4 py-3 text-sm">
                    <strong class="text-[#800020] block">{{ $products->weight }}g</strong>Ultra lightweight
                </div>
                @endif
                <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-4 py-3 text-sm">
                    <strong class="text-[#800020] block">UV400</strong>Full protection
                </div>
                @if($products->material)
                <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-4 py-3 text-sm">
                    <strong class="text-[#800020] block">{{ $products->material }}</strong>Premium frame
                </div>
                @endif
                <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-4 py-3 text-sm">
                    <strong class="text-[#800020] block">Rx-ready</strong>Prescription lenses
                </div>
            </div>
            @endif
        </div>

        {{-- Specifications --}}
        <div x-show="tab === 'specs'" x-transition>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                @foreach([
                    ['label' => 'Material',   'value' => $products->material ?? 'N/A'],
                    ['label' => 'Category',   'value' => $products->category->name ?? 'N/A'],
                    ['label' => 'Made in',    'value' => $products->made_in ?? 'N/A'],
                    ['label' => 'Weight',     'value' => isset($products->weight) ? $products->weight . 'g' : 'N/A'],
                    ['label' => 'Dimensions', 'value' => $products->dimensions ?? 'N/A'],
                    ['label' => 'Lens type',  'value' => 'Polarised · UV400'],
                ] as $spec)
                <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl p-3">
                    <div class="text-[10px] text-gray-400 uppercase tracking-wide mb-1">{{ $spec['label'] }}</div>
                    <div class="text-sm font-medium text-[#4B2E0A]">{{ $spec['value'] }}</div>
                </div>
                @endforeach
            </div>
            @if($products->dimensions)
            <div class="bg-[#fff8f0] border border-dashed border-[#D4AF37] rounded-xl p-4 text-sm text-[#4B2E0A]">
                <strong class="text-[#800020]">Size guide: </strong>
                {{ $products->dimensions }} — numbers represent lens width · bridge width · temple length in mm.
            </div>
            @endif
        </div>

        {{-- Face Fit Guide --}}
        <div x-show="tab === 'fit'" x-transition>
            <p class="text-sm text-gray-400 mb-4">This frame style suits these face shapes best:</p>
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach(['Oval' => true, 'Heart' => true, 'Diamond' => true, 'Round' => false, 'Square' => false] as $shape => $match)
                <span class="px-4 py-2 rounded-full text-sm font-medium border-[1.5px] {{ $match ? 'border-[#D4AF37] bg-[#fff8f0] text-[#800020]' : 'border-[#e8d9be] text-[#4B2E0A] bg-white' }}">
                    {{ $shape }} @if($match) ✓ @endif
                </span>
                @endforeach
            </div>
            <p class="text-sm text-gray-500 leading-relaxed max-w-lg">
                Oval and heart-shaped faces have balanced proportions that complement this frame's teardrop silhouette. The wider top rim adds structure to narrower foreheads.
            </p>
        </div>

        {{-- Reviews --}}
        <div x-show="tab === 'rev'" x-transition>
            @if($totalReviews > 0)
            {{-- Rating summary bar --}}
            <div class="flex gap-6 items-center bg-[#fff8f0] border border-[#f0e8d4] rounded-2xl p-5 mb-6">
                <div class="text-center min-w-[80px]">
                    <div class="text-4xl font-medium text-[#800020]">{{ number_format($avgRating, 1) }}</div>
                    <div class="flex justify-center text-[#D4AF37] text-xs my-1">
                        @for($i=1;$i<=5;$i++)<i class="{{ $avgRating >= $i ? 'ri-star-fill' : ($avgRating > $i-1 ? 'ri-star-half-fill' : 'ri-star-line') }}"></i>@endfor
                    </div>
                    <div class="text-[11px] text-gray-400">{{ $totalReviews }} reviews</div>
                </div>
                <div class="flex-1 space-y-1.5">
                    @foreach([5,4,3,2,1] as $star)
                    @php $cnt = $products->reviews->where('rating', $star)->count(); $pct = $totalReviews > 0 ? round($cnt / $totalReviews * 100) : 0; @endphp
                    <div class="flex items-center gap-2 text-xs text-gray-400">
                        <span class="w-4">{{ $star }}</span>
                        <i class="ri-star-fill text-[#D4AF37] text-xs"></i>
                        <div class="flex-1 h-1.5 bg-[#f0e8d4] rounded-full overflow-hidden">
                            <div class="h-full bg-[#D4AF37] rounded-full" style="width:{{ $pct }}%"></div>
                        </div>
                        <span class="w-6 text-right">{{ $pct }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($products->reviews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                @foreach($products->reviews->sortByDesc('created_at') as $review)
                <div class="bg-white border-[1.5px] border-[#e8d9be] rounded-2xl p-4 hover:border-[#D4AF37] transition flex flex-col">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-full bg-[#D4AF37] flex items-center justify-center text-[#800020] text-xs font-medium flex-shrink-0">
                            {{ strtoupper(substr($review->user->name ?? 'A', 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-[#4B2E0A]">{{ $review->user->name ?? 'Anonymous' }}</p>
                            <p class="text-[11px] text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex text-[#D4AF37] text-xs mb-2">
                        @for($i=1;$i<=5;$i++)<i class="{{ $review->rating >= $i ? 'ri-star-fill' : 'ri-star-line text-[#e0d0b8]' }}"></i>@endfor
                    </div>
                    @if($review->feedback)
                        <p class="text-xs text-gray-600 leading-relaxed flex-1">{{ $review->feedback }}</p>
                    @endif
                    @if($review->image_path)
                        <img src="{{ asset(Storage::url($review->image_path)) }}" class="w-20 h-20 object-cover rounded-xl border border-[#e8d9be] mt-3">
                    @endif
                </div>
                @endforeach
            </div>
            @else
                <p class="text-sm text-gray-400 py-4">No reviews yet — be the first to share your experience!</p>
            @endif
        </div>

        {{-- Write Review --}}
        <div x-show="tab === 'write'" x-transition>
            @auth
                @php $hasReviewed = Auth::user()->reviews->where('product_id', $products->id)->isNotEmpty(); @endphp
                @if(!$hasReviewed)
                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="max-w-lg space-y-5">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $products->id }}">

                    <div>
                        <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-2">Your rating</p>
                        <div class="flex gap-2 text-2xl text-[#e0d0b8]">
                            @for($i=1;$i<=5;$i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ old('rating') == $i ? 'checked' : '' }} required>
                                <i class="ri-star-line peer-checked:text-[#D4AF37] hover:text-[#D4AF37] transition-colors"></i>
                            </label>
                            @endfor
                        </div>
                        @error('rating')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wide mb-2">Your feedback</p>
                        <textarea name="feedback" rows="4" placeholder="Share your experience — fit, quality, comfort..."
                                  class="w-full border-[1.5px] border-[#e0cebc] rounded-xl px-4 py-3 text-sm text-[#4B2E0A] bg-[#fffdf8] focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition resize-none">{{ old('feedback') }}</textarea>
                        @error('feedback')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3">
                        <label class="flex-1 flex items-center justify-center gap-2 border-[1.5px] border-dashed border-[#D4AF37] bg-[#fff8f0] rounded-xl py-2.5 text-sm text-[#800020] font-medium cursor-pointer hover:bg-[#fff0d0] transition">
                            <i class="ri-image-add-line"></i> Upload photo
                            <input type="file" name="review_image" accept="image/*" class="hidden">
                        </label>
                        <button type="submit" class="flex-[2] bg-[#800020] hover:bg-[#a8324a] text-[#FFFFF0] text-sm font-medium py-2.5 rounded-xl transition">
                            Submit review
                        </button>
                    </div>
                </form>
                @else
                <div class="flex items-start gap-3 bg-blue-50 border-l-4 border-blue-400 text-blue-800 text-sm px-5 py-4 rounded-r-xl max-w-lg">
                    <i class="ri-information-line text-lg flex-shrink-0"></i>
                    <div><p class="font-medium">You've already reviewed this product.</p><p class="text-xs text-blue-600 mt-0.5">Thank you for your feedback!</p></div>
                </div>
                @endif
            @else
                <div class="flex items-center gap-3 bg-[#fff8f0] border border-[#f0e8d4] text-[#4B2E0A] text-sm px-5 py-4 rounded-xl max-w-lg">
                    <i class="ri-lock-line text-[#800020]"></i>
                    Please <a href="{{ route('login') }}" class="font-medium text-[#800020] underline mx-1">log in</a> to write a review.
                </div>
            @endauth
        </div>
    </div>
    {{-- ═══ CUSTOMERS ALSO BOUGHT ═══ --}}
@if(isset($frequentlyBought) && $frequentlyBought->isNotEmpty())
<div class="mt-12">
    <h2 class="text-lg font-medium text-[#800020] mb-5 flex items-center gap-3">
        Customers Also Bought
        <span class="flex-1 h-px bg-[#f0e8d4]"></span>
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($frequentlyBought as $item)
        <a href="{{ route('viewproduct', $item->id) }}"
           class="group bg-white border-[1.5px] border-[#e8d9be] rounded-2xl overflow-hidden hover:border-[#D4AF37] transition block">

            <div class="h-36 bg-[#f5f0e8] overflow-hidden">
                <img src="{{ asset('images/products/' . ($item->photopath ?? 'default-product.webp')) }}"
                     alt="{{ $item->name }}"
                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                     onerror="this.onerror=null;this.src='{{ asset('images/products/default-product.webp') }}';">
            </div>

            <div class="p-3">
                <h3 class="text-sm font-medium text-[#4B2E0A] truncate mb-1">
                    {{ $item->name }}
                </h3>

                @if(isset($item->discounted_price) && $item->discounted_price < $item->price)
                    <p class="text-sm font-medium text-[#800020]">
                        Rs. {{ number_format($item->discounted_price, 0) }}
                        <span class="text-xs text-gray-300 line-through ml-1">
                            Rs. {{ number_format($item->price, 0) }}
                        </span>
                    </p>
                @else
                    <p class="text-sm font-medium text-[#800020]">
                        Rs. {{ number_format($item->price, 0) }}
                    </p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

    {{-- ═══ RELATED PRODUCTS ═══
    @if($relatedproducts->isNotEmpty())
    <div class="mt-12">
        <h2 class="text-lg font-medium text-[#800020] mb-5 flex items-center gap-3">
            You may also like
            <span class="flex-1 h-px bg-[#f0e8d4]"></span>
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($relatedproducts as $rp)
            <a href="{{ route('viewproduct', $rp->id) }}"
               class="group bg-white border-[1.5px] border-[#e8d9be] rounded-2xl overflow-hidden hover:border-[#D4AF37] transition block">
                <div class="h-36 bg-[#f5f0e8] overflow-hidden">
                    <img src="{{ asset('images/products/' . ($rp->photopath ?? 'default-product.webp')) }}"
                         alt="{{ $rp->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                         onerror="this.onerror=null;this.src='{{ asset('images/products/default-product.webp') }}';">
                </div>
                <div class="p-3">
                    <h3 class="text-sm font-medium text-[#4B2E0A] truncate mb-1">{{ $rp->name }}</h3>
                    @if(isset($rp->discounted_price) && $rp->discounted_price < $rp->price)
                        <p class="text-sm font-medium text-[#800020]">
                            Rs. {{ number_format($rp->discounted_price, 0) }}
                            <span class="text-xs text-gray-300 line-through ml-1">Rs. {{ number_format($rp->price, 0) }}</span>
                        </p>
                    @else
                        <p class="text-sm font-medium text-[#800020]">Rs. {{ number_format($rp->price, 0) }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif --}}

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const qtyInput = document.getElementById('qty');
    const cartQty = document.getElementById('cartQty');
    const stock = parseInt(document.querySelector('#stockCount')?.innerText || 99);

    window.inc = function() {
        let v = parseInt(qtyInput.value);
        if (v < stock) { qtyInput.value = v + 1; if(cartQty) cartQty.value = v + 1; }
    }
    window.dec = function() {
        let v = parseInt(qtyInput.value);
        if (v > 1) { qtyInput.value = v - 1; if(cartQty) cartQty.value = v - 1; }
    }
    window.setMainImg = function(btn, src) {
        document.getElementById('productImage').src = src;
        document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('border-[#D4AF37]'));
        btn.classList.add('border-[#D4AF37]');
    }
});
</script>

@endsection
