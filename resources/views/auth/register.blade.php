<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F8F8; /* Light background for contrast */
        }
        /* Custom styles for file input to ensure consistency */
        input[type="file"]::-webkit-file-upload-button {
            cursor: pointer;
        }
        input[type="file"]::file-selector-button {
            cursor: pointer;
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

    {{-- Registration Form Container --}}
    <div class="w-full sm:max-w-xl md:max-w-2xl lg:max-w-3xl bg-white shadow-2xl rounded-xl border border-gray-100 p-8">
        {{-- Logo --}}
        <div class="flex justify-center mb-8">
            <img src="{{ asset('images/sairam.png') }}" alt="Sairam Chasma Pasal Logo" class="h-24">
        </div>

        <h1 class="text-3xl font-extrabold text-[#800020] mb-8 text-center">Create Your Account</h1>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            {{-- Partition 1: Personal Information --}}
            <h3 class="text-xl font-semibold text-[#800020] mb-6 border-b pb-3 border-gray-200">Personal Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-8">
                {{-- Name Field --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input id="name" class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out"
                                    type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Field --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out"
                                    type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Address Field --}}
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input id="address" class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out"
                                    type="text" name="address" value="{{ old('address') }}" required
                                    placeholder="e.g. Geetanagar, Bharatpur" />
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone Field --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input id="phone" class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out"
                                    type="text" name="phone" value="{{ old('phone') }}" required />
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender Field --}}
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select id="gender" name="gender" class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Photo Field (span full width) --}}
                <div class="md:col-span-2">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                    <input id="photo" type="file" name="photo"
                           class="block w-full text-sm text-gray-700
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-full file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-[#800020] file:text-white
                                   hover:file:bg-[#6b001a]
                                   focus:outline-none focus:ring-2 focus:ring-[#800020] focus:ring-offset-2 rounded-lg cursor-pointer" />
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Partition 2: Account Security --}}
            <h3 class="text-xl font-semibold text-[#800020] mt-8 mb-6 border-b pb-3 border-gray-200">Account Security</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-8">
                {{-- Password Field --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out"
                                    type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password Field --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="password_confirmation" class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out"
                                    type="password" name="password_confirmation" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Already Registered & Register Button --}}
            <div class="flex flex-col sm:flex-row items-center justify-between mt-8 gap-4">
                <a class="text-sm text-[#800020] hover:underline font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020] transition duration-200 ease-in-out"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="w-full sm:w-auto bg-[#800020] hover:bg-[#6b001a] text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020]">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</body>
</html>
