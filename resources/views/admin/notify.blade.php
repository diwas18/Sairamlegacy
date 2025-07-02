@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-8 bg-white rounded-xl shadow-lg mt-12 border border-[#D4AF37]">
    <h2 class="text-3xl font-extrabold mb-6 text-[#4B2E0A] text-center">Send Notification</h2>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.notify.users') }}" method="POST" class="space-y-6">
        @csrf
        <label for="message" class="block mb-1 font-semibold text-[#4B2E0A] text-lg">Notification Message:</label>
        <textarea
            name="message"
            id="message"
            rows="6"
            required
            placeholder="Type your notification message here..."
            class="w-full rounded-lg border border-[#800020] px-4 py-3 text-[#4B2E0A] placeholder:text-gray-400
                   focus:outline-none focus:ring-4 focus:ring-[#D4AF37] transition-shadow resize-none shadow-sm"
        ></textarea>

        <button
            type="submit"
            class="w-full bg-[#800020] hover:bg-[#a8324a] text-white font-bold py-3 rounded-lg shadow-md
                   transition-colors duration-300 focus:outline-none focus:ring-4 focus:ring-[#D4AF37]"
        >
            Send Notification
        </button>
    </form>
</div>
@endsection
