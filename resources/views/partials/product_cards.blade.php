@foreach($products as $product)
<a href="{{ route('viewproduct', $product->id) }}" class="group block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transform hover:scale-[1.03] transition-all duration-300">
    <div class="relative overflow-hidden rounded-t-lg">
        <img
            src="{{ asset('images/products/'.$product->photopath) }}"
            alt="{{ $product->name ?? 'Product Image' }}"
            class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105"
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
    <div class="p-5 text-center">
        <h2 class="text-xl font-semibold text-[#4B2E0A] truncate" title="{{ $product->name }}">{{ $product->name }}</h2>

        @if($product->discounted_price)
        <p class="mt-3 text-lg font-bold text-[#D4AF37]">
            Rs. {{ number_format($product->discounted_price) }}
            <span class="ml-3 text-gray-400 line-through text-sm font-normal">Rs. {{ number_format($product->price) }}</span>
        </p>
        @else
        <p class="mt-3 text-lg font-bold text-[#4B2E0A]">Rs. {{ number_format($product->price) }}</p>
        @endif
    </div>
</a>
@endforeach
