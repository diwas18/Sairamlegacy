<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Sairam Chasma Pasal - Eyewear</title>
    <link rel="shortcut icon" href="{{ asset('images/Sairam.png') }}" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">

@include('layouts.alert')

<div class="flex min-h-screen">

    {{-- ── Sidebar ── --}}
    <aside class="w-64 bg-[#1a0a00] flex flex-col flex-shrink-0 shadow-xl">

        {{-- Brand --}}
        <div class="px-6 py-8 border-b border-[#D4AF37]/20">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-[#800020] flex items-center justify-center flex-shrink-0 border border-[#D4AF37]/30">
                    <img src="{{ asset('images/Sairam.png') }}" alt="Logo" class="w-6 h-6 object-contain" />
                </div>
                <div>
                    <p class="text-base font-bold text-[#D4AF37] tracking-tight">Sairam Chasma Pasal</p>
                    <p class="text-[11px] text-[#D4AF37]/80 uppercase tracking-widest font-medium">Admin Portal</p>
                </div>
            </a>
        </div>

        {{-- Nav links --}}
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            <div class="px-3 pt-2 pb-2">
                <span class="text-[11px] uppercase tracking-[0.15em] text-[#D4AF37]/50 font-bold">Main Navigation</span>
            </div>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200
                      {{ Route::is('dashboard') ? 'bg-[#800020] text-white shadow-lg' : 'text-gray-300 hover:bg-[#D4AF37]/10 hover:text-[#D4AF37]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('category.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200
                      {{ Route::is('category.*') ? 'bg-[#800020] text-white shadow-lg' : 'text-gray-300 hover:bg-[#D4AF37]/10 hover:text-[#D4AF37]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                <span class="font-medium">Categories</span>
            </a>

            <a href="{{ route('product.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200
                      {{ Route::is('product.*') ? 'bg-[#800020] text-white shadow-lg' : 'text-gray-300 hover:bg-[#D4AF37]/10 hover:text-[#D4AF37]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <span class="font-medium">Products</span>
            </a>

            <div class="px-3 pt-6 pb-2">
                <span class="text-[11px] uppercase tracking-[0.15em] text-[#D4AF37]/50 font-bold">Sales & Users</span>
            </div>

            <a href="{{ route('order.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200
                      {{ Route::is('order.*') ? 'bg-[#800020] text-white shadow-lg' : 'text-gray-300 hover:bg-[#D4AF37]/10 hover:text-[#D4AF37]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span class="font-medium">Orders</span>
            </a>

              <a href="{{ route('admin.booking.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200
                      {{ Route::is('booking.*') ? 'bg-[#800020] text-white shadow-lg' : 'text-gray-300 hover:bg-[#D4AF37]/10 hover:text-[#D4AF37]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M8 7V3m8 4V3m-9 8h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-medium">Bookings</span>
            </a>

            <a href="{{ route('admin.notify.form') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200
                      {{ Route::is('admin.notify.form') ? 'bg-[#800020] text-white shadow-lg' : 'text-gray-300 hover:bg-[#D4AF37]/10 hover:text-[#D4AF37]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="font-medium">Notify Users</span>
            </a>

            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-all duration-200
                      {{ Route::is('users.*') ? 'bg-[#800020] text-white shadow-lg' : 'text-gray-300 hover:bg-[#D4AF37]/10 hover:text-[#D4AF37]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="font-medium">User Management</span>
            </a>

        </nav>

        {{-- Logout --}}
        <div class="px-4 py-6 border-t border-[#D4AF37]/10">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-sm font-medium text-gray-400 hover:bg-red-500/10 hover:text-red-400 transition-all duration-200">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- ── Main content ── --}}
    <main class="flex-1 h-screen overflow-y-auto p-8 lg:p-12">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

</div>

</body>
</html>
