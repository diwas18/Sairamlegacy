@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-[#FFFFF0] p-8 rounded-lg shadow-lg border-t-4 border-[#800020]">
    <h2 class="text-3xl font-extrabold text-[#800020] mb-6 border-l-4 border-[#D4AF37] pl-4">
        User Details
    </h2>

    <div class="space-y-4 text-[#4B2E0A] text-sm md:text-base">
        <p><strong class="text-[#800020]">Name:</strong> {{ $user->name }}</p>
        <p><strong class="text-[#800020]">Email:</strong> {{ $user->email }}</p>
        <p><strong class="text-[#800020]">Joined:</strong> {{ $user->created_at->format('F j, Y - g:i A') }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('users.index') }}"
           class="inline-block text-sm bg-[#D4AF37] hover:bg-[#c39f2c] text-[#4B2E0A] font-semibold px-5 py-2 rounded shadow transition">
            ← Back to Users
        </a>
    </div>
</div>
@endsection
