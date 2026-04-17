@extends('layouts.app')

@section('content')
<div class="px-6 md:px-16 py-10 bg-[#FFFFF0] min-h-screen">

    {{-- Header + Search --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-medium text-[#800020]">Users</h1>
            <div class="h-[3px] w-12 bg-[#D4AF37] mt-2 rounded-full"></div>
        </div>

        <form action="{{ route('users.index') }}" method="GET">
            <div class="flex items-center border-[1.5px] border-[#800020] rounded-full overflow-hidden bg-white focus-within:ring-2 focus-within:ring-[#D4AF37] transition">
                <input type="text" name="search" placeholder="Search by name or email..."
                       value="{{ request('search') }}"
                       class="w-56 px-4 py-2 text-sm bg-transparent text-[#4B2E0A] placeholder-[#b05070] focus:outline-none" />
                <button type="submit" class="bg-[#800020] hover:bg-[#a8324a] text-[#FFFFF0] px-4 py-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    {{-- Stats pills --}}
    <div class="flex flex-wrap gap-3 mb-6">
        <span class="bg-[#fff8f0] border border-[#D4AF37] text-[#800020] text-xs font-medium px-4 py-1.5 rounded-full">
            Total: {{ $users->total() }} users
        </span>
        <span class="bg-[#fff8f0] border border-[#D4AF37] text-[#800020] text-xs font-medium px-4 py-1.5 rounded-full">
            Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
        </span>
    </div>

    {{-- Cards Grid --}}
    @if($users->isEmpty())
        <div class="text-center py-20 text-gray-400 italic">No users found.</div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach($users as $user)
        @php
            $avatarSrc = $user->photo ? asset($user->photo) : ($user->profile_image ?? null);
        @endphp
        <div class="bg-white border-[1.5px] border-[#e8d9be] rounded-2xl overflow-hidden hover:border-[#D4AF37] transition">

            {{-- Card Top --}}
            <div class="bg-gradient-to-br from-[#800020] to-[#a0243c] px-5 pt-5 pb-8 relative">
                <span class="absolute top-3 right-4 bg-[#D4AF37]/20 border border-[#D4AF37] text-[#D4AF37] text-[11px] font-medium px-3 py-0.5 rounded-full">
                    #{{ $user->id }}
                </span>
                @if($avatarSrc)
                    <img src="{{ $avatarSrc }}" class="w-14 h-14 rounded-full border-[3px] border-[#D4AF37] object-cover" />
                @else
                    <div class="w-14 h-14 rounded-full border-[3px] border-[#D4AF37] bg-[#D4AF37] flex items-center justify-center text-[#800020] font-medium text-lg">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>

            {{-- Card Body --}}
            <div class="px-5 pt-0 pb-4 -mt-4 bg-white rounded-t-2xl relative z-10">
                <p class="text-[#800020] font-medium text-base">{{ $user->name }}</p>
                <p class="text-gray-400 text-xs truncate mb-3">{{ $user->email }}</p>

                <div class="flex items-center gap-2 text-xs text-[#5a4030] mb-2">
                    <svg class="w-4 h-4 text-[#D4AF37] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $user->address ?? 'N/A' }}
                </div>
                <div class="flex items-center gap-2 text-xs text-[#5a4030]">
                    <svg class="w-4 h-4 text-[#D4AF37] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 8V5z"/>
                    </svg>
                    {{ $user->phone ?? 'N/A' }}
                </div>
                <p class="text-[11px] text-gray-400 mt-2">Registered: {{ $user->created_at->format('Y-m-d H:i') }}</p>
            </div>

            {{-- Card Footer --}}
            <div class="flex gap-2 px-5 pb-4 border-t border-[#f0e8d4] pt-3">
                <a href="{{ route('users.show', $user->id) }}"
                   class="flex-1 text-center text-xs font-medium py-1.5 rounded-lg border-[1.5px] border-[#D4AF37] bg-[#FFFFF0] text-[#800020] hover:bg-[#D4AF37] hover:text-[#4B2E0A] transition">
                    View
                </a>
                <a href="{{ route('users.edit', $user->id) }}"
                   class="flex-1 text-center text-xs font-medium py-1.5 rounded-lg border-[1.5px] border-[#800020] bg-[#800020] text-[#FFFFF0] hover:bg-[#a8324a] transition">
                    Edit
                </a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 rounded-lg border-[1.5px] border-red-600 text-red-600 text-xs font-medium hover:bg-red-600 hover:text-white transition">
                        ✕
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $users->appends(request()->query())->links('pagination::tailwind') }}
    </div>

</div>
@endsection
