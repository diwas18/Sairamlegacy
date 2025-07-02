<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Sairam Chasma Pasal - Eyewear</title>

    <link rel="shortcut icon" href="{{ asset('images/Sairam.png') }}" type="image/x-icon" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#FFFFF0] text-[#4B2E0A]">

@include('layouts.alert')

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <nav class="w-56 bg-[#FFF8E7] border-r border-[#D4AF37] shadow-md flex flex-col">
       <div class="pt-6 pb-8 text-center">
    <a href="{{ route('dashboard') }}" class="inline-block">
        <img src="{{ asset('images/Sairam.png') }}" alt="Logo" class="w-28 mx-auto mb-2" />
        <h2 class="text-xl font-extrabold text-[#800020] tracking-wide">Sairam Eyewear</h2>
    </a>
</div>

        <ul class="flex-1 px-5 space-y-2">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-3 rounded-md text-lg font-semibold transition
                          {{ Route::is('dashboard') ? 'bg-[#800020] text-[#D4AF37]' : 'text-[#4B2E0A] hover:bg-[#D4AF37] hover:text-[#800020]' }}">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('category.index') }}"
                   class="block px-4 py-3 rounded-md text-lg font-semibold transition
                          {{ Route::is('category.*') ? 'bg-[#800020] text-[#D4AF37]' : 'text-[#4B2E0A] hover:bg-[#D4AF37] hover:text-[#800020]' }}">
                    Categories
                </a>
            </li>

            <li>
                <a href="{{ route('product.index') }}"
                   class="block px-4 py-3 rounded-md text-lg font-semibold transition
                          {{ Route::is('product.*') ? 'bg-[#800020] text-[#D4AF37]' : 'text-[#4B2E0A] hover:bg-[#D4AF37] hover:text-[#800020]' }}">
                    Products
                </a>
            </li>

            <li>
                <a href="{{ route('order.index') }}"
                   class="block px-4 py-3 rounded-md text-lg font-semibold transition
                          {{ Route::is('order.*') ? 'bg-[#800020] text-[#D4AF37]' : 'text-[#4B2E0A] hover:bg-[#D4AF37] hover:text-[#800020]' }}">
                    Orders
                </a>
            </li>

            <li>
                <a href="{{ route('admin.notify.form') }}"
                   class="block px-4 py-3 rounded-md text-lg font-semibold transition
                          {{ Route::is('admin.notify.form') ? 'bg-[#800020] text-[#D4AF37]' : 'text-[#4B2E0A] hover:bg-[#D4AF37] hover:text-[#800020]' }}">
                    Notify Users
                </a>

            <li>
                <a href="{{ route('users.index') }}"
                   class="block px-4 py-3 rounded-md text-lg font-semibold transition
                          text-[#4B2E0A] hover:bg-[#D4AF37] hover:text-[#800020]">
                    Users
                </a>
            </li>
        </ul>

        <form action="{{ route('logout') }}" method="POST" class="p-5 border-t border-[#D4AF37]">
            @csrf
            <button type="submit"
                    class="w-full text-left px-4 py-3 rounded-md text-lg font-semibold text-[#800020] hover:bg-[#D4AF37] hover:text-[#800020] transition">
                Log Out
            </button>
        </form>
    </nav>

    <!-- Main content -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

</body>
</html>
