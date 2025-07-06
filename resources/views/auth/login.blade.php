<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F8F8; /* Light background for contrast */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-10 px-4 sm:px-6 relative">
    {{-- Back Arrow to Home --}}
    <a href="/" class="absolute top-6 left-6 text-[#800020] hover:text-[#6b001a] transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020] rounded-full p-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
    </a>

    <div class="w-full max-w-md bg-white shadow-2xl rounded-xl border border-gray-100 p-8">
        {{-- Logo --}}
        <div class="flex justify-center mb-8">
            <img src="{{ asset('images/sairam.png') }}" alt="Sairam Chasma Pasal Logo" class="h-24">
        </div>

        <h1 class="text-3xl font-extrabold text-[#800020] mb-8 text-center">Login to Your Account</h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out">
                @error('email')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required autocomplete="current-password"
                       class="w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out">
                @error('password')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Forgot Password --}}
            <div class="text-right mb-6">
                <a href="{{ route('password.request') }}"
                   class="text-sm text-[#800020] hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020] transition duration-200 ease-in-out">Forgot Password?</a>
            </div>

            {{-- Login Button --}}
            <button type="submit"
                    class="w-full bg-[#800020] text-white font-bold py-3 rounded-lg hover:bg-[#6b001a] shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020]">
                Login
            </button>
        </form>

        {{-- OR Divider --}}
        <div class="mt-8">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or continue with</span>
                </div>
            </div>

            {{-- Social Logins --}}
            <div class="mt-6 grid grid-cols-1 gap-3">
                <a href="{{ url('auth/google') }}"
                   class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition duration-200 ease-in-out">
                    <img class="h-5 w-5 mr-2" src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google logo">
                    Sign in with Google
                </a>
                <a href="{{ url('auth/facebook') }}"
                   class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50
                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition duration-200 ease-in-out">
                    <img class="h-5 w-5 mr-2" src="https://www.svgrepo.com/show/448224/facebook.svg" alt="Facebook logo">
                    Sign in with Facebook
                </a>
            </div>
        </div>

        {{-- Don't have an account? --}}
        <div class="mt-8 text-center">
            <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}"
                    class="text-[#800020] hover:underline font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020] transition duration-200 ease-in-out">Register</a></p>
        </div>
    </div>
</body>
</html>
