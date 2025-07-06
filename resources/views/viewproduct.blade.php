@extends('layouts.master')
@section('content')

{{-- Success/Error Messages (for review submission) --}}
@if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 md:mx-20 mt-6 rounded shadow-sm" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif
@if (session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 md:mx-20 mt-6 rounded shadow-sm" role="alert">
        <p>{{ session('error') }}</p>
    </div>
@endif

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

        {{-- Average Ratings Display --}}
        <div class="flex items-center text-[#D4AF37] text-xl">
            @php
                $avgRating = $products->averageRating();
                $totalReviews = $products->totalReviews();
            @endphp
            @for($i = 1; $i <= 5; $i++)
                @if ($avgRating >= $i)
                    <i class="ri-star-fill"></i>
                @elseif ($avgRating > ($i - 1))
                    <i class="ri-star-half-fill"></i>
                @else
                    <i class="ri-star-line"></i>
                @endif
            @endfor
            @if ($avgRating)
                <span class="text-sm text-gray-500 ml-2">({{ number_format($avgRating, 1) }} average based on {{ $totalReviews }} reviews)</span>
            @else
                <span class="text-sm text-gray-500 ml-2">(No reviews yet)</span>
            @endif
        </div>

        {{-- Price --}}
        <div class="text-2xl font-semibold text-[#4B2E0A]">
            @if($products->discounted_price)
                Rs. {{ number_format($products->discounted_price, 0) }}
                <span class="text-base line-through text-red-400 ml-2">Rs. {{ number_format($products->price, 0) }}</span>
            @else
                Rs. {{ number_format($products->price, 0) }}
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

---

{{-- Tabs Section --}}
<div class="mt-16 px-6 md:px-20" x-data="{ tab: 'desc' }">
    <div class="flex space-x-6 border-b mb-4 text-[#4B2E0A] font-medium">
        <button @click="tab = 'desc'" :class="{ 'border-b-2 border-[#800020]': tab === 'desc' }" class="pb-2">Description</button>
        <button @click="tab = 'rev'" :class="{ 'border-b-2 border-[#800020]': tab === 'rev' }" class="pb-2">Reviews ({{ $products->totalReviews() }})</button>
        <button @click="tab = 'det'" :class="{ 'border-b-2 border-[#800020]': tab === 'det' }" class="pb-2">Details</button>
    </div>

    {{-- Description Tab Content --}}
    <div x-show="tab === 'desc'" x-transition>
        <p class="text-base text-gray-700 leading-relaxed">{{ $products->description }}</p>
    </div>

    {{-- Reviews Tab Content --}}
    <div x-show="tab === 'rev'" x-transition class="py-4">
        <h3 class="text-xl font-bold text-[#4B2E0A] mb-6">Customer Reviews</h3>

        {{-- Display existing reviews --}}
        {{-- Wrapper div to control the overall width of the review grid --}}
        <div class="max-w-4xl mx-auto lg:mx-0"> {{-- Added max-w-4xl for overall width, centered on small, left on large --}}
            @if($products->reviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($products->reviews->sortByDesc('created_at') as $review)
                        <div class="bg-gray-50 p-5 rounded-lg shadow-sm border border-gray-100 flex flex-col">
                            <div class="flex items-center mb-2">
                                <i class="ri-account-circle-fill text-gray-500 text-2xl mr-2"></i> {{-- User icon --}}
                                <p class="text-base font-semibold text-gray-800">{{ $review->user->name ?? 'Anonymous User' }}</p>
                                <span class="ml-auto text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex text-[#D4AF37] text-lg mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($review->rating >= $i)
                                        <i class="ri-star-fill"></i>
                                    @else
                                        <i class="ri-star-line"></i>
                                    @endif
                                @endfor
                            </div>
                            @if($review->feedback)
                                <p class="text-sm text-gray-700 mb-3 flex-grow">{{ $review->feedback }}</p>
                            @endif
                            @if($review->image_path)
                                <div class="mt-2">
                                    <img src="{{ asset($review->image_path) }}" alt="Review Image" class="w-24 h-24 object-cover rounded-md border border-gray-200 shadow-sm">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-base text-gray-600 mb-8">No reviews yet for this product. Be the first to share your experience!</p>
            @endif
        </div> {{-- End of new wrapper div --}}

        {{-- Review Submission Form --}}
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-xl font-bold text-[#4B2E0A] mb-6">Write Your Review</h3>

            @auth
                @php
                    $hasReviewed = false;
                    if (Auth::user()) {
                        $hasReviewed = Auth::user()->reviews->contains('product_id', $products->id);
                    }
                @endphp

                @if(!$hasReviewed)
                    <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 max-w-2xl mx-auto md:mx-0">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $products->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Star Rating Input (Column 1) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Your Rating:</label>
                                <div class="flex space-x-1 text-2xl text-gray-300">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label for="rating-{{ $products->id }}-{{ $i }}" class="cursor-pointer">
                                            <input type="radio" id="rating-{{ $products->id }}-{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required>
                                            <i class="ri-star-line peer-hover:text-[#D4AF37] peer-checked:text-[#D4AF37] transition-colors duration-200"></i>
                                        </label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Image Upload (Column 2) --}}
                            <div>
                                <label for="review_image-{{ $products->id }}" class="block text-sm font-medium text-gray-700 mb-1">Upload Image (Optional):</label>
                                <input
                                    type="file"
                                    id="review_image-{{ $products->id }}"
                                    name="review_image"
                                    class="w-full text-xs text-gray-500
                                           file:mr-2 file:py-1.5 file:px-3
                                           file:rounded-md file:border-0
                                           file:text-xs file:font-semibold
                                           file:bg-[#D4AF37] file:text-[#4B2E0A]
                                           hover:file:bg-[#800020] hover:file:text-white transition duration-300"
                                >
                                @error('review_image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Feedback Textarea (Full width below columns, but controlled by parent form's max-width) --}}
                        <div>
                            <label for="feedback-{{ $products->id }}" class="block text-sm font-medium text-gray-700 mb-1">Your Feedback (Optional):</label>
                            <textarea
                                id="feedback-{{ $products->id }}"
                                name="feedback"
                                rows="4"
                                class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#D4AF37] focus:border-[#D4AF37] text-sm"
                                placeholder="Share your detailed experience with this product..."
                            >{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Button (Full width below textarea, but controlled by parent form's max-width) --}}
                        <button type="submit" class="w-full bg-[#800020] text-white py-2.5 px-6 rounded-lg font-semibold text-base hover:bg-[#6b001a] transition duration-300 ease-in-out shadow-lg">
                            Submit Review
                        </button>
                    </form>
                @else
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-sm" role="alert">
                        <p class="font-semibold mb-2">You've already reviewed this product!</p>
                        <p>Thank you for sharing your valuable feedback. You can always edit your review from your profile if this feature is implemented later.</p>
                    </div>
                @endif
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-sm" role="alert">
                    <p class="text-lg">
                        Please <a href="{{ route('login') }}" class="font-bold text-[#800020] hover:underline">log in</a> to write a review for this product.
                    </p>
                </div>
            @endauth
        </div>
    </div>

    {{-- Details Tab Content --}}
    <div x-show="tab === 'det'" x-transition>
        <ul class="list-disc ml-5 text-gray-700 space-y-1">
            <li>Material: {{ $products->material ?? 'N/A' }}</li>
            <li>Category: {{ $products->category->name ?? 'N/A' }}</li>
            <li>Made in: {{ $products->made_in ?? 'N/A' }}</li>
        </ul>
    </div>
</div>

---

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
                        Rs. {{ number_format($rproducts->discounted_price, 0) }}
                        <span class="line-through text-xs text-red-500 ml-2">Rs. {{ number_format($rproducts->price, 0) }}</span>
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
