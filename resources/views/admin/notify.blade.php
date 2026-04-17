@extends('layouts.app')

@section('content')
<div class="bg-[#FFFFF0] min-h-screen flex flex-col items-center py-10 px-4">

    {{-- Back button --}}
    <div class="w-full max-w-lg mb-6">
        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 text-[#800020] text-sm font-medium border-[1.5px] border-[#e8d9be] bg-white px-4 py-2 rounded-full hover:border-[#D4AF37] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to dashboard
        </a>
    </div>

    <div class="w-full max-w-lg bg-white border-[1.5px] border-[#e8d9be] rounded-2xl overflow-hidden">

        {{-- Card Header --}}
        <div class="bg-[#800020] px-7 py-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-full border-2 border-[#D4AF37] bg-[#D4AF37]/15 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-[#D4AF37]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div>
                <h2 class="text-[#FFFFF0] font-medium text-base">Send notification</h2>
                <p class="text-white/55 text-xs mt-0.5">Broadcast a message to all users</p>
            </div>
        </div>

        {{-- Form Body --}}
        <div class="px-7 py-7">

            {{-- Success message --}}
            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border-[1.5px] border-green-200 text-green-800 text-sm rounded-xl px-4 py-3 mb-5">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Recipients indicator --}}
            <div class="flex items-center gap-3 bg-[#fff8f0] border border-[#f0e8d4] rounded-xl px-4 py-3 mb-5">
                <svg class="w-4 h-4 text-[#D4AF37] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-sm text-[#4B2E0A]">Sending to <strong class="text-[#800020]">all registered users</strong></span>
            </div>

            <form action="{{ route('admin.notify.users') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label for="message" class="block text-xs font-medium text-[#800020] uppercase tracking-wide mb-2">
                        Notification message
                    </label>
                    <textarea
                        name="message"
                        id="message"
                        rows="6"
                        required
                        placeholder="Type your notification message here..."
                        oninput="document.getElementById('charCount').textContent = this.value.length + ' characters'"
                        class="w-full border-[1.5px] border-[#e0cebc] rounded-xl px-4 py-3 text-sm text-[#4B2E0A] bg-[#fffdf8] placeholder:text-gray-300 focus:outline-none focus:border-[#D4AF37] focus:ring-2 focus:ring-[#D4AF37]/20 transition resize-none"
                    ></textarea>
                    <p id="charCount" class="text-[11px] text-gray-400 text-right mt-1.5">0 characters</p>
                </div>

                <hr class="border-[#f0e8d4] mb-5">

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-[#800020] hover:bg-[#a8324a] text-[#FFFFF0] text-sm font-medium py-3 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Send notification
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
