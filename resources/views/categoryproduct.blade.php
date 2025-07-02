@extends('layouts.master')
@section('content')

<div class="px-6 md:px-16 mt-8">
    <h1 class="text-3xl font-bold text-[#4B2E0A] mb-2">{{ $category->name }} Collection</h1>
    <p class="text-sm text-[#800020] mb-6">Curated selection of our stylish {{ $category->name }} frames.</p>

    {{-- Masonry Layout --}}
    <div class="columns-1 sm:columns-2 md:columns-3 gap-6 space-y-6">
        @foreach ($products as $product)
            <a href="{{ route('viewproduct', $product->id) }}" class="block break-inside-avoid">
                <div class="rounded-lg overflow-hidden shadow hover:shadow-lg bg-[#FFFFF0] transition hover:-translate-y-1 duration-300">
                    <img src="{{ asset('images/products/' . $product->photopath) }}" alt="{{ $product->name }}" class="w-full object-cover">
                    <div class="p-4">
                        <h2 class="text-lg font-bold text-[#4B2E0A]">{{ $product->name }}</h2>
                        @if ($product->discounted_price)
                            <p class="text-[#800020] font-semibold">Rs. {{ $product->discounted_price }}
                                <span class="line-through text-sm text-red-600">Rs. {{ $product->price }}</span>
                            </p>
                        @else
                            <p class="text-[#800020] font-semibold">Rs. {{ $product->price }}</p>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $products->links() }}
    </div>
</div>

@endsection
