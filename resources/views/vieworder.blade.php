@extends('layouts.master') {{-- Assumes you have a base master layout --}}

@section('content')

<div class="px-4 py-12 md:px-8 lg:px-16 bg-white min-h-screen font-sans">
    <div class="max-w-5xl mx-auto"> {{-- Slightly narrower max-width for a more contained feel --}}
        {{-- Page Header --}}
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-[#4B2E0A] mb-3 tracking-tight">Your Order History</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                A refined overview of your purchases.
            </p>
        </div>

        @forelse ($orders as $order)
            {{-- Individual Order Card / Collapsible Item --}}
            <div x-data="{ expanded: false }" class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-6 overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:border-[#D4AF37]">

                {{-- Clickable Header for Collapse --}}
                <div @click="expanded = !expanded" class="p-6 cursor-pointer flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    {{-- Order Primary Info --}}
                    <div class="flex-grow">
                        <span class="text-xs font-semibold text-gray-500 mb-1 block">Order ID:</span>
                        <h2 class="text-xl font-bold text-[#4B2E0A] mb-1 leading-tight">#{{ $order->id }} - {{ $order->product->name ?? 'Product Not Found' }}</h2>
                        <p class="text-sm text-gray-600">Ordered on: <span class="font-medium text-gray-800">{{ $order->created_at->format('M d, Y') }}</span></p>
                    </div>

                    {{-- Status and Total --}}
                    <div class="flex flex-col md:flex-row items-end md:items-center gap-4 mt-3 md:mt-0">
                        <div class="text-right">
                            <span class="px-4 py-1.5 rounded-full text-xs font-bold tracking-wide transition-colors duration-300
                                @if(strtolower($order->status) === 'delivered')
                                    bg-green-50 text-green-700 ring-1 ring-green-200
                                @elseif(strtolower($order->status) === 'shipped')
                                    bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200
                                @elseif(strtolower($order->status) === 'processing')
                                    bg-blue-50 text-blue-700 ring-1 ring-blue-200
                                @elseif(strtolower($order->status) === 'pending')
                                    bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200
                                @elseif(strtolower($order->status) === 'cancelled')
                                    bg-red-50 text-red-700 ring-1 ring-red-200
                                @else
                                    bg-gray-50 text-gray-700 ring-1 ring-gray-200
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">Status</p>
                        </div>
                        <div class="text-right">
                            <span class="text-sm text-gray-500">Total</span>
                            <p class="text-3xl font-extrabold text-[#800020] leading-none mt-0.5">₹{{ number_format($order->qty * $order->price, 0) }}</p>
                        </div>
                        {{-- Collapse/Expand Arrow Icon --}}
                        <i x-bind:class="expanded ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line'" class="ri-2x text-gray-400 transition-transform duration-200 flex-shrink-0"></i>
                    </div>
                </div>

                {{-- Collapsible Content --}}
                <div x-show="expanded" x-collapse.duration.300ms class="px-6 pb-6 pt-4 border-t border-gray-100 bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8">

                        {{-- Product Details --}}
                        <div>
                            <h3 class="font-bold text-md text-[#4B2E0A] mb-3 border-b border-gray-200 pb-2">Product Info</h3>
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('images/products/' . ($order->product->photopath ?? 'placeholder.jpg')) }}"
                                     alt="{{ $order->product->name ?? 'Product Image' }}"
                                     class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow-sm">
                                <div>
                                    <p class="font-semibold text-gray-800 text-md mb-0.5">{{ $order->product->name ?? 'Not Found' }}</p>
                                    <p class="text-sm text-gray-600">Qty: <span class="font-bold">{{ $order->qty }}</span></p>
                                    <p class="text-sm text-gray-600">Unit Price: <span class="font-bold text-[#800020]">₹{{ number_format($order->price, 0) }}</span></p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="text-sm text-gray-600">Payment: <span class="font-bold text-gray-800">{{ $order->payment_method }}</span></p>
                            </div>
                        </div>

                        {{-- Delivery Information --}}
                        <div>
                            <h3 class="font-bold text-md text-[#4B2E0A] mb-3 border-b border-gray-200 pb-2">Delivery Details</h3>
                            <div class="mb-3">
                                <p class="font-semibold text-gray-800 text-md leading-relaxed">{{ $order->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">{{ $order->address ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">Phone: {{ $order->phone ?? 'N/A' }}</p>
                            </div>
                            {{-- Optional: Progress Tracker/Timeline --}}
                            {{-- ... (Your conceptual timeline structure goes here if desired) ... --}}
                        </div>

                        {{-- Order Actions --}}
                        <div class="flex flex-col justify-end items-start lg:items-end">
                            <h3 class="font-bold text-md text-[#4B2E0A] mb-3 border-b border-gray-200 pb-2 w-full lg:text-right">Actions</h3>
                            <div class="mt-2 w-full space-y-3"> {{-- Reduced space between buttons --}}
                                {{-- "Reorder This Item" Button --}}
                                <button type="button" class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-[#D4AF37] text-[#4B2E0A] rounded-full text-sm font-semibold hover:bg-[#800020] hover:text-white transition duration-300 shadow-sm"> {{-- Smaller padding, font --}}
                                    <i class="ri-refresh-line mr-2"></i> Reorder This Item
                                </button>

                                {{-- "Continue Shopping" Button --}}
                                <a href="{{ route('home') }}" class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-[#800020] text-white rounded-full text-sm font-semibold hover:bg-[#D4AF37] hover:text-[#4B2E0A] transition duration-300 shadow-sm"> {{-- Smaller padding, font --}}
                                    Continue Shopping <i class="ri-arrow-right-line ml-2"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State Message --}}
            <div class="text-center py-20 bg-white rounded-2xl shadow-xl border border-gray-100">
                <p class="text-2xl text-gray-700 mb-6 font-semibold leading-relaxed">It looks like your order history is empty. <br> Time to discover something new!</p>
                <a href="{{ route('home') }}" class="inline-block bg-[#800020] hover:bg-[#D4AF37] text-white hover:text-[#800020] px-10 py-4 rounded-full font-bold text-xl transition duration-300 shadow-lg transform hover:scale-105">
                    Start Shopping Now <i class="ri-arrow-right-line ml-3"></i>
                </a>
            </div>
        @endforelse
    </div>
</div>

{{-- Include Alpine.js for interactive elements like collapse/expand --}}
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
