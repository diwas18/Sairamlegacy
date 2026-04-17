@extends('layouts.app')

@section('content')
<div class="bg-[#FFFFF0] min-h-screen flex flex-col items-center py-10 px-4">

    {{-- Back button --}}
    <div class="w-full max-w-lg mb-6">
        <a href="{{ route('users.index') }}"
           class="inline-flex items-center gap-2 text-[#800020] text-sm font-medium border-[1.5px] border-[#e8d9be] bg-white px-4 py-2 rounded-full hover:border-[#D4AF37] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to users
        </a>
    </div>

    <div class="w-full max-w-lg bg-white border-[1.5px] border-[#e8d9be] rounded-2xl overflow-hidden">

        {{-- Card Header --}}
        <div class="bg-[#800020] px-7 py-5 flex items-center gap-4">
            @php $avatarSrc = $user->photo ? asset($user->photo) : ($user->profile_image ?? null); @endphp
            @if($avatarSrc)
                <img src="{{ $avatarSrc }}" class="w-11 h-11 rounded-full border-2 border-[#D4AF37] object-cover flex-shrink-0" />
            @else
                <div class="w-11 h-11 rounded-full border-2 border-[#D4AF37] bg-[#D4AF37] flex items-center justify-center text-[#800020] font-medium text-sm flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            @endif
            <div>
                <h2 class="text-[#FFFFF0] font-medium text-base">Edit user</h2>
                <p class="text-white/60 text-xs mt-0.5">{{ $user->name }} · ID #{{ $user->id }}</p>
            </div>
        </div>

        {{-- Form Body --}}
        <div class="px-7 py-7">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Change Photo --}}
                <label class="flex items-center gap-3 bg-[#fff8f0] border-[1.5px] border-dashed border-[#D4AF37] rounded-xl p-3 mb-6 cursor-pointer hover:bg-[#fff3e0] transition">
                    <svg class="w-5 h-5 text-[#D4AF37] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <circle cx="12" cy="13" r="3"/>
                    </svg>
                    <div>
                        <span class="text-sm font-medium text-[#800020]">Change profile photo</span>
                        <span class="text-xs text-gray-400 block mt-0.5">JPG or PNG, max 2MB</span>
                    </div>
                    <input type="file" name="photo" accept="image/*" class="hidden" />
                </label>

                {{-- Basic Info --}}
                <p class="text-[11px] uppercase tracking-wide text-gray-400 mb-3 pb-2 border-b border-[#f0e8d4]">Basic info</p>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-[#800020] uppercase tracking-wide mb-1.5">Full name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border-[1.5px] border-[#e0cebc] rounded-xl px-4 py-2.5 text-sm text-[#4B2E0A] bg-[#fffdf8] focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition" />
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-medium text-[#800020] uppercase tracking-wide mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border-[1.5px] border-[#e0cebc] rounded-xl px-4 py-2.5 text-sm text-[#4B2E0A] bg-[#fffdf8] focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition" />
                </div>

                {{-- Contact --}}
                <p class="text-[11px] uppercase tracking-wide text-gray-400 mb-3 pb-2 border-b border-[#f0e8d4]">Contact</p>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-[#800020] uppercase tracking-wide mb-1.5">Phone number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full border-[1.5px] border-[#e0cebc] rounded-xl px-4 py-2.5 text-sm text-[#4B2E0A] bg-[#fffdf8] focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition" />
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-medium text-[#800020] uppercase tracking-wide mb-1.5">Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                           class="w-full border-[1.5px] border-[#e0cebc] rounded-xl px-4 py-2.5 text-sm text-[#4B2E0A] bg-[#fffdf8] focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition" />
                </div>

                <hr class="border-[#f0e8d4] mb-5">

                <div class="flex gap-3">
                    <a href="{{ route('users.index') }}"
                       class="flex-1 text-center text-sm font-medium py-2.5 rounded-xl border-[1.5px] border-[#e0cebc] bg-white text-[#800020] hover:border-[#800020] transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="flex-[2] text-sm font-medium py-2.5 rounded-xl border-[1.5px] border-[#800020] bg-[#800020] text-[#FFFFF0] hover:bg-[#a8324a] transition">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
