@extends('layouts.app')

@section('content')
<div class="px-6 md:px-16 py-10 bg-[#FFFFF0] min-h-screen">
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
    <div>
        <h1 class="text-4xl font-extrabold text-[#800020] mb-2 md:mb-0">
            Users List
        </h1>
        <hr class="h-1 bg-[#D4AF37] mt-2 md:mt-3 w-24">
    </div>
    <!-- 🔍 Search Form -->
    <form action="{{ route('users.index') }}" method="GET" class="max-w-xs w-full">
        <div class="flex items-center border-2 border-[#800020] rounded-full overflow-hidden shadow focus-within:ring-2 focus-within:ring-[#D4AF37] transition">
            <input type="text" name="search" placeholder="Search by name or email..."
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 text-sm bg-white text-[#4B2E0A] placeholder-[#800020] focus:outline-none" />
            <button type="submit" class="bg-[#800020] hover:bg-[#a8324a] text-[#FFFFF0] px-5 py-2 text-sm font-semibold transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </button>
        </div>
    </form>
</div>

    <!-- 📋 Users Table -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg border-2 border-[#800020]">
        <table class="w-full text-sm md:text-base table-auto">
            <thead class="bg-[#800020] text-[#D4AF37] font-semibold select-none">
                <tr>
                    <th class="text-left px-6 py-3 whitespace-nowrap">ID</th>
                    <th class="text-left px-6 py-3 whitespace-nowrap">Name</th>
                    <th class="text-left px-6 py-3 whitespace-nowrap">Email</th>
                    <th class="text-left px-6 py-3 whitespace-nowrap">Registered On</th>
                    <th class="text-left px-6 py-3 whitespace-nowrap">Actions</th>
                </tr>
            </thead>

            <tbody class="text-[#4B2E0A]">
                @forelse($users as $user)
                <tr class="border-t border-[#D4AF37]/40 hover:bg-[#f9f3e8] transition">
                    <td class="px-6 py-3 whitespace-nowrap font-semibold">{{ $user->id }}</td>
                    <td class="px-6 py-3 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-3 whitespace-nowrap truncate max-w-xs">{{ $user->email }}</td>
                    <td class="px-6 py-3 whitespace-nowrap">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-3 flex flex-wrap gap-2">
                        <a href="{{ route('users.show', $user->id) }}"
                           class="bg-[#D4AF37] hover:bg-[#c39f2c] text-[#4B2E0A] px-4 py-1 rounded text-xs font-semibold transition">
                            View
                        </a>

                        <a href="{{ route('users.edit', $user->id) }}"
                           class="bg-[#800020] hover:bg-[#a8324a] text-[#FFFFF0] px-4 py-1 rounded text-xs font-semibold transition">
                            Edit
                        </a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-700 hover:bg-red-800 text-white px-4 py-1 rounded text-xs font-semibold transition">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center px-6 py-8 text-gray-500 italic select-none">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 📄 Pagination -->
    <div class="mt-8">
        {{ $users->appends(request()->query())->links('pagination::tailwind') }}
    </div>
</div>
@endsection
