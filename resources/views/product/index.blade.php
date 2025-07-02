@extends('layouts.app')

@section('content')
<h1 class="text-4xl font-extrabold text-[#800020] mb-2">Products</h1>
<hr class="h-1 bg-[#D4AF37] mb-6">

<div class="text-right mb-6 px-4 md:px-0 max-w-7xl mx-auto">
    <a href="{{ route('product.create') }}"
       class="bg-[#800020] hover:bg-[#9e2e36] text-[#FFFFF0] px-6 py-2 rounded-md transition font-semibold">
        + Add Product
    </a>
</div>

<div class="max-w-7xl mx-auto px-4 md:px-0 bg-[#FFFFF0] rounded-lg shadow border border-[#800020]/40">
    <table class="w-full table-fixed text-[#4B2E0A] text-sm md:text-base">
        <thead class="bg-[#800020] text-[#D4AF37] font-semibold select-none">
            <tr>
                <th class="px-2 py-2 w-[3%] text-left whitespace-nowrap">S.N</th>
                <th class="px-2 py-2 w-[8%] text-left whitespace-nowrap">Image</th>
                <th class="px-2 py-2 w-[12%] text-left whitespace-nowrap">Name</th>
                <th class="px-2 py-2 w-[30%] text-left max-w-xs truncate">Description</th>
                <th class="px-2 py-2 w-[8%] text-left whitespace-nowrap">Price</th>
                <th class="px-2 py-2 w-[10%] text-left whitespace-nowrap">Discount</th>
                <th class="px-2 py-2 w-[7%] text-left whitespace-nowrap">Stock</th>
                <th class="px-2 py-2 w-[7%] text-left whitespace-nowrap">Status</th>
                <th class="px-2 py-2 w-[10%] text-left whitespace-nowrap">Category</th>
                <th class="px-2 py-2 w-[10%] text-left whitespace-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#800020]/10">
            @foreach ($products as $product)
            <tr class="hover:bg-[#f9f3e8] transition">
                <td class="px-2 py-2 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                <td class="px-2 py-2 whitespace-nowrap">
                    <img src="{{ asset('images/products/' . $product->photopath) }}"
                         alt="Product Image" class="w-10 h-10 object-cover rounded-md shadow-sm mx-auto">
                </td>
                <td class="px-2 py-2 font-semibold whitespace-nowrap truncate">{{ $product->name }}</td>
                <td class="px-2 py-2 truncate text-gray-700" title="{{ $product->description }}">
                    {{ Str::limit($product->description, 70) }}
                </td>
                <td class="px-2 py-2 whitespace-nowrap">Rs. {{ $product->price }}</td>
                <td class="px-2 py-2 whitespace-nowrap text-green-700">Rs. {{ $product->discounted_price }}</td>
                <td class="px-2 py-2 whitespace-nowrap text-center">{{ $product->stock }}</td>
                <td class="px-2 py-2 whitespace-nowrap text-center">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                      {{ strtolower($product->status) == 'show' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $product->status }}
                    </span>
                </td>
                <td class="px-2 py-2 whitespace-nowrap truncate">{{ $product->category->name ?? '-' }}</td>
                <td class="px-2 py-2 whitespace-nowrap flex gap-1 justify-center">
                    <a href="{{ route('product.edit', $product->id) }}"
                       class="bg-[#800020] hover:bg-[#9e2e36] text-[#FFFFF0] px-2 py-1 text-xs rounded transition font-semibold whitespace-nowrap">
                        Edit
                    </a>

                    <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-700 hover:bg-red-800 text-white px-2 py-1 text-xs rounded transition font-semibold whitespace-nowrap">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
