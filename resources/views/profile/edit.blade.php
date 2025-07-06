<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
<body class="flex items-center justify-center min-h-screen py-10 relative">
    {{-- Back Arrow to Home --}}
    <a href="/" class="absolute top-6 left-6 text-[#800020] hover:text-[#6b001a] transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020] rounded-full p-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
    </a>

    <div class="max-w-4xl mx-auto p-8 bg-white shadow-2xl rounded-xl border border-gray-100 w-full">
        <h1 class="text-3xl font-extrabold text-[#800020] mb-8 text-center">Edit Your Profile</h1>

        @if (session('status') == 'profile-updated')
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md relative mb-6" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">Profile successfully updated!</span>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Profile Picture Section -->
            <div class="mb-8 pb-6 border-b border-gray-200">
                <label for="photo" class="block text-lg font-semibold text-[#800020] mb-4">Profile Picture</label>
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                    {{-- Display current profile picture or placeholder --}}
                    @php
                        $currentProfilePic = null;
                        if ($user->photo) {
                            $currentProfilePic = asset($user->photo); // Using asset() directly as per your previous request
                        } elseif ($user->profile_image) {
                            $currentProfilePic = $user->profile_image; // For social login images
                        }
                    @endphp

                    @if ($currentProfilePic)
                        <img src="{{ $currentProfilePic }}"
                             alt="Current Profile Picture"
                             class="w-32 h-32 object-cover rounded-full border-4 border-[#D4AF37] shadow-md"
                             id="current-profile-pic">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-3xl font-bold border-4 border-gray-400 shadow-md">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif

                    {{-- Image preview for new upload --}}
                    <div id="image-preview-container" class="hidden">
                        <img src="" alt="New Profile Picture Preview" class="w-32 h-32 object-cover rounded-full border-4 border-[#800020] shadow-md" id="image-preview">
                    </div>

                    <div class="flex-1 w-full md:w-auto">
                        <input type="file" name="photo" id="photo"
                               class="block w-full text-sm text-gray-700
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-full file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-[#800020] file:text-white
                                       hover:file:bg-[#6b001a]
                                       focus:outline-none focus:ring-2 focus:ring-[#800020] focus:ring-offset-2 rounded-lg cursor-pointer"
                               onchange="previewImage(event)">
                        @error('photo')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <h3 class="text-xl font-semibold text-[#800020] mb-6 border-b pb-3 border-gray-200">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-8">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           class="mt-1 block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                           class="mt-1 block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                           class="mt-1 block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out"
                           placeholder="e.g. Geetanagar, Bharatpur">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                           class="mt-1 block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender" id="gender"
                            class="mt-1 block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Account Security Section -->
            <h3 class="text-xl font-semibold text-[#800020] mb-6 border-b pb-3 border-gray-200">Account Security</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-8">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password (Optional)</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-[#800020] focus:border-[#800020] transition duration-200 ease-in-out">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-[#800020] hover:bg-[#6b001a] text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#800020]">
                Update Profile
            </button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            const previewContainer = document.getElementById('image-preview-container');
            const previewImage = document.getElementById('image-preview');
            const currentProfilePic = document.getElementById('current-profile-pic'); // Get the current image element

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
                if (currentProfilePic) {
                    currentProfilePic.style.display = 'none'; // Hide the current image if a new one is selected
                }
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                if (currentProfilePic) {
                    currentProfilePic.style.display = 'block'; // Show the current image if no new file is selected
                }
            }
        }
    </script>
</body>
</html>
