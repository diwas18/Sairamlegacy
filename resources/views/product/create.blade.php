@extends('layouts.app')

@section('content')
<h1 class="text-4xl font-extrabold text-[#800020] mb-2">Create Product</h1>
<hr class="h-1 bg-[#D4AF37] mb-6">

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-[#4B2E0A]">
    @csrf

    <!-- Form Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Category -->
        <div>
            <label class="block mb-1 font-medium">Category</label>
            <select name="category_id" class="w-full rounded-lg border border-[#800020] px-4 py-2 focus:ring-2 focus:ring-[#D4AF37]">
                <option disabled selected>Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Product Name -->
        <div>
            <label class="block mb-1 font-medium">Product Name</label>
            <input type="text" name="name" placeholder="Enter Product Name"
                class="w-full rounded-lg border border-[#800020] px-4 py-2"
                value="{{ old('name') }}">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Description (full width) -->
        <div class="md:col-span-2">
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" rows="4" placeholder="Enter the description"
                class="w-full rounded-lg border border-[#800020] px-4 py-2">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Price -->
        <div>
            <label class="block mb-1 font-medium">Price</label>
            <input type="text" name="price" placeholder="Enter Price"
                class="w-full rounded-lg border border-[#800020] px-4 py-2"
                value="{{ old('price') }}">
            @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Discounted Price -->
        <div>
            <label class="block mb-1 font-medium">Discounted Price</label>
            <input type="text" name="discounted_price" placeholder="Enter Discounted Price"
                class="w-full rounded-lg border border-[#800020] px-4 py-2"
                value="{{ old('discounted_price') }}">
            @error('discounted_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Stock -->
        <div>
            <label class="block mb-1 font-medium">Stock</label>
            <input type="text" name="stock" placeholder="Enter Stock"
                class="w-full rounded-lg border border-[#800020] px-4 py-2"
                value="{{ old('stock') }}">
            @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="block mb-1 font-medium">Status</label>
            <select name="status"
                class="w-full rounded-lg border border-[#800020] px-4 py-2 focus:ring-2 focus:ring-[#D4AF37]">
                <option value="Show" {{ old('status') == 'Show' ? 'selected' : '' }}>Show</option>
                <option value="Hide" {{ old('status') == 'Hide' ? 'selected' : '' }}>Hide</option>
            </select>
            @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Photo Upload (full width) -->
        <div class="md:col-span-2">
            <label class="block mb-1 font-medium">Product Photo</label>
            <input type="file" name="photopath"
                class="w-full rounded-lg border border-[#800020] px-4 py-2 bg-white">
            @error('photopath') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

    </div>

    <!-- Buttons -->
    <div class="flex justify-center gap-4">
        <button type="submit"
            class="bg-[#800020] hover:bg-[#9e2e36] text-[#FFFFF0] px-6 py-2 rounded-lg font-medium transition">
            Create Product
        </button>
        <a href="{{ route('product.index') }}"
            class="bg-[#D4AF37] hover:bg-[#c9a030] text-[#4B2E0A] px-6 py-2 rounded-lg font-medium transition">
            Cancel
        </a>
    </div>
</form>
@endsection
