@extends('layouts.app')
@section('content')
<h1 class="text-4xl font-extrabold text-[#800020]">Categories</h1>
<hr class="h-1 bg-[#D4AF37] mb-6">

<div class="text-right my-5">
    <a href="{{ route('category.create') }}"
       class="bg-[#800020] text-[#FFFFF0] px-5 py-3 rounded-lg hover:bg-[#D4AF37] hover:text-[#800020] transition">
        Add Category
    </a>
</div>

<table class="w-full mt-5 text-[#4B2E0A] border-collapse">
    <thead>
        <tr class="bg-[#FFFFF0] text-left font-semibold border-b border-[#800020]/40">
            <th class="py-2 px-3">Order</th>
            <th class="py-2 px-3">Category Name</th>
            <th class="py-2 px-3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($categories as $category)
        <tr class="hover:bg-[#FFF8E1] border-b border-[#800020]/10">
            <td class="py-3 px-3">{{ $category->priority }}</td>
            <td class="py-3 px-3">{{ $category->name }}</td>
            <td class="py-3 px-3 space-x-2">
                <a href="{{ route('category.edit', $category->id) }}"
                   class="bg-[#4B2E0A] hover:bg-[#3a2207] text-[#FFFFF0] px-3 py-1 rounded transition inline-block">
                   Edit
                </a>
                <button
                    type="button"
                    class="bg-[#800020] hover:bg-[#D4AF37] hover:text-[#800020] text-[#FFFFF0] px-3 py-1 rounded cursor-pointer transition inline-block"
                    onclick="showpopup({{ $category->id }})"
                    aria-haspopup="dialog"
                >
                    Delete
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- Popup Modal --}}
<div
    class="fixed inset-0 bg-[#4B2E0A] bg-opacity-60 backdrop-blur-sm hidden items-center justify-center z-50"
    id="popup"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title"
    aria-describedby="modal-description"
>
    <form action="{{ route('category.destroy') }}" method="POST" class="bg-[#FFFFF0] px-10 py-8 rounded-lg text-center max-w-sm w-full shadow-lg">
        @csrf
        @method('DELETE')
        <h3 id="modal-title" class="font-bold mb-5 text-lg text-[#800020]">Are you sure you want to delete this category?</h3>
        <p id="modal-description" class="text-sm text-[#4B2E0A] mb-6">This action cannot be undone.</p>

        <input type="hidden" id="dataid" name="dataid" autocomplete="off">

        <div class="flex justify-center gap-6">
            <button type="submit"
                class="bg-[#800020] hover:bg-[#D4AF37] hover:text-[#800020] text-[#FFFFF0] px-6 py-2 rounded transition">
                Yes, Delete
            </button>
            <button
                type="button"
                class="bg-[#D4AF37] hover:bg-[#C3A42A] text-[#800020] px-6 py-2 rounded transition"
                onclick="hidepopup();"
            >
                Cancel
            </button>
        </div>
    </form>
</div>

{{-- Scripts --}}
<script>
    function showpopup(id) {
        const popup = document.getElementById('popup');
        popup.classList.remove('hidden');
        popup.classList.add('flex');
        document.getElementById('dataid').value = id;
    }

    function hidepopup() {
        const popup = document.getElementById('popup');
        popup.classList.remove('flex');
        popup.classList.add('hidden');
    }
</script>
@endsection
