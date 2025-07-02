@extends('layouts.app')

@section('content')
<h1 class="text-4xl font-extrabold text-[#800020] mb-2">Edit Product</h1>
<hr class="h-1 bg-[#D4AF37] mb-6">

<form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
    class="space-y-6 text-[#4B2E0A]">
    @csrf


    <!-- Grid layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Category -->
        <div>
            <label class="block mb-1 font-medium">Category</label>
            <select name="category_id" class="w-full rounded-lg border border-[#800020] px-4 py-2">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Product Name -->
        <div>
            <label class="block mb-1 font-medium">Product Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                class="w-full rounded-lg border border-[#800020] px-4 py-2">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Description (Full width) -->
        <div class="md:col-span-2">
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" rows="4"
                class="w-full rounded-lg border border-[#800020] px-4 py-2">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Price -->
        <div>
            <label class="block mb-1 font-medium">Price</label>
            <input type="text" name="price" value="{{ old('price', $product->price) }}"
                class="w-full rounded-lg border border-[#800020] px-4 py-2">
            @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Discounted Price -->
        <div>
            <label class="block mb-1 font-medium">Discounted Price</label>
            <input type="text" name="discounted_price" value="{{ old('discounted_price', $product->discounted_price) }}"
                class="w-full rounded-lg border border-[#800020] px-4 py-2">
            @error('discounted_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Stock -->
        <div>
            <label class="block mb-1 font-medium">Stock</label>
            <input type="text" name="stock" value="{{ old('stock', $product->stock) }}"
                class="w-full rounded-lg border border-[#800020] px-4 py-2">
            @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="block mb-1 font-medium">Status</label>
            <select name="status" class="w-full rounded-lg border border-[#800020] px-4 py-2">
                <option value="Show" {{ old('status', $product->status) == 'Show' ? 'selected' : '' }}>Show</option>
                <option value="Hide" {{ old('status', $product->status) == 'Hide' ? 'selected' : '' }}>Hide</option>
            </select>
            @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Upload Photo -->
        <div class="md:col-span-2">
            <label class="block mb-1 font-medium">Change Photo</label>
            <input type="file" name="photopath"
                accept="image/*"
                class="w-full rounded-lg border border-[#800020] px-4 py-2 bg-white">
            @error('photopath') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror

            <!-- Current Photo Preview -->
            <p class="mt-4 text-sm">Current Picture:</p>
            <img src="{{ asset('images/products/' . $product->photopath) }}" alt="Product Image"
                class="w-44 mt-2 border border-[#800020] rounded-md">
        </div>

    </div>

    <!-- Buttons -->
    <div class="flex justify-center gap-4 mt-6">
        <button type="submit"
            class="bg-[#800020] hover:bg-[#9e2e36] text-[#FFFFF0] px-6 py-2 rounded-lg font-medium transition">
            Update Product
        </button>
        <a href="{{ route('product.index') }}"
            class="bg-[#D4AF37] hover:bg-[#c9a030] text-[#4B2E0A] px-6 py-2 rounded-lg font-medium transition">
            Cancel
        </a>
    </div>

</form>
@endsection
