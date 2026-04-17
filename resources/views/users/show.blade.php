<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FFFFF0] min-h-screen flex flex-col items-center py-10 px-4">

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

        {{-- Banner + Avatar --}}
        <div class="bg-[#800020] h-20 flex justify-center relative">
            <div class="absolute -bottom-9">
                @php
                    $avatarSrc = $user->photo ? asset($user->photo) : ($user->profile_image ?? null);
                @endphp
                @if($avatarSrc)
                    <img src="{{ $avatarSrc }}" class="w-[72px] h-[72px] rounded-full border-[3px] border-[#D4AF37] object-cover" />
                @else
                    <div class="w-[72px] h-[72px] rounded-full border-[3px] border-[#D4AF37] bg-[#D4AF37] flex items-center justify-center text-[#800020] text-2xl font-medium">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Body --}}
        <div class="px-7 pt-14 pb-7 text-center">
            <h2 class="text-xl font-medium text-[#800020]">{{ $user->name }}</h2>
            <span class="inline-block mt-2 mb-5 bg-[#fff0f3] border border-[#f5c4c4] text-[#800020] text-[11px] px-3 py-1 rounded-full">
                Joined {{ $user->created_at->format('F j, Y') }}
            </span>

            <hr class="border-[#f0e8d4] mb-5">

            <div class="grid grid-cols-2 gap-3 text-left mb-6">
                <div class="col-span-2 bg-[#fff8f0] border border-[#f0e8d4] rounded-xl p-3">
                    <p class="text-[11px] uppercase tracking-wide text-gray-400 mb-1">Email</p>
                    <p class="text-sm font-medium text-[#4B2E0A] break-all">{{ $user->email }}</p>
                </div>
                <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl p-3">
                    <p class="text-[11px] uppercase tracking-wide text-gray-400 mb-1">Phone</p>
                    <p class="text-sm font-medium text-[#4B2E0A]">{{ $user->phone ?? 'N/A' }}</p>
                </div>
                <div class="bg-[#fff8f0] border border-[#f0e8d4] rounded-xl p-3">
                    <p class="text-[11px] uppercase tracking-wide text-gray-400 mb-1">Gender</p>
                    <p class="text-sm font-medium text-[#4B2E0A]">{{ ucfirst($user->gender ?? 'N/A') }}</p>
                </div>
                <div class="col-span-2 bg-[#fff8f0] border border-[#f0e8d4] rounded-xl p-3">
                    <p class="text-[11px] uppercase tracking-wide text-gray-400 mb-1">Address</p>
                    <p class="text-sm font-medium text-[#4B2E0A]">{{ $user->address ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('users.index') }}"
                   class="flex-1 text-center text-sm font-medium py-2.5 rounded-xl border-[1.5px] border-[#D4AF37] bg-[#FFFFF0] text-[#800020] hover:bg-[#D4AF37] hover:text-[#4B2E0A] transition">
                    ← Back to list
                </a>
                <a href="{{ route('users.edit', $user->id) }}"
                   class="flex-1 text-center text-sm font-medium py-2.5 rounded-xl border-[1.5px] border-[#800020] bg-[#800020] text-[#FFFFF0] hover:bg-[#a8324a] transition">
                    Edit profile
                </a>
            </div>
        </div>
    </div>
</body>
</html>
