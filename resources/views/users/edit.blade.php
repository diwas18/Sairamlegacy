@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-[#FFFFF0] p-8 rounded-lg shadow-lg border-t-4 border-[#800020]">
    <h2 class="text-3xl font-extrabold text-[#800020] mb-6 border-l-4 border-[#D4AF37] pl-4">Edit User</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block mb-1 text-sm font-semibold text-[#4B2E0A]">Name</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}"
                   class="w-full border border-[#800020] bg-white px-4 py-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37] transition">
        </div>

        <div>
            <label for="email" class="block mb-1 text-sm font-semibold text-[#4B2E0A]">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}"
                   class="w-full border border-[#800020] bg-white px-4 py-2 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37] transition">
        </div>
        <div class="text-right">
            <button type="submit"
                class="bg-[#800020] hover:bg-[#a8324a] text-[#FFFFF0] px-6 py-2 rounded-md font-semibold shadow transition">
            Update
            </button>
            <a href="{{ route('users.index') }}"
               class="bg-[#800020] hover:bg-[#a8324a] text-[#FFFFF0] px-6 py-2 rounded-md font-semibold shadow transition inline-block ml-2">
            Cancel
            </a>
        </div>
    </form>
</div>
@endsection
