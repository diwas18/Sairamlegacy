<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
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
    {{-- Back Arrow to Users List --}}
    <a href="{{ route('users.index') }}" class="absolute top-6 left-6 text-[#800020] hover:text-[#6b001a] transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020] rounded-full p-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
    </a>

    <div class="max-w-2xl mx-auto p-8 bg-white shadow-2xl rounded-xl border border-gray-100 w-full">
        <h1 class="text-3xl font-extrabold text-[#800020] mb-8 text-center">User Details</h1>

        <div class="flex flex-col items-center mb-8">
            {{-- User Profile Picture --}}
            @php
                $userProfilePic = null;
                if ($user->photo) {
                    $userProfilePic = asset($user->photo);
                } elseif ($user->profile_image) {
                    $userProfilePic = $user->profile_image;
                }
            @endphp

            @if ($userProfilePic)
                <img src="{{ $userProfilePic }}"
                     alt="{{ $user->name }}'s Profile Photo"
                     class="w-32 h-32 object-cover rounded-full border-4 border-[#D4AF37] shadow-md mb-4">
            @else
                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-3xl font-bold border-4 border-gray-400 shadow-md mb-4">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            @endif

            <h2 class="text-2xl font-bold text-[#800020]">{{ $user->name }}</h2>
        </div>

        <div class="space-y-4 text-[#4B2E0A] text-base mb-8">
            <p><strong class="text-[#800020]">Email:</strong> {{ $user->email }}</p>
            <p><strong class="text-[#800020]">Address:</strong> {{ $user->address ?? 'N/A' }}</p>
            <p><strong class="text-[#800020]">Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
            <p><strong class="text-[#800020]">Gender:</strong> {{ ucfirst($user->gender ?? 'N/A') }}</p>
            <p><strong class="text-[#800020]">Joined:</strong> {{ $user->created_at->format('F j, Y - g:i A') }}</p>
        </div>

        <div class="flex justify-center mt-6">
            <a href="{{ route('users.index') }}"
               class="inline-block bg-[#D4AF37] hover:bg-[#c39f2c] text-[#4B2E0A] font-semibold px-6 py-2 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#D4AF37]">
                ← Back to Users List
            </a>
        </div>
    </div>
</body>
</html>
