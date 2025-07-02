@extends('layouts.app')

@section('content')
<h1 class="text-4xl font-extrabold text-[#800020]">Orders</h1>
<hr class="h-1 bg-[#D4AF37] mb-6">

<div class="max-w-7xl mx-auto px-4 md:px-0 bg-[#FFFFF0] rounded-xl shadow-md overflow-x-auto">
    <table class="w-full text-sm md:text-base text-[#4B2E0A]">
        <thead class="bg-[#FFF8E7] text-[#800020] font-semibold">
            <tr class="text-left">
                <th class="px-4 py-3">Order Date</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Product Image</th>
                <th class="px-4 py-3">Product Name</th>
                <th class="px-4 py-3">Phone</th>
                <th class="px-4 py-3">Address</th>
                <th class="px-4 py-3">Rate</th>
                <th class="px-4 py-3">Quantity</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Payment</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)
            <tr class="bg-white hover:bg-[#FFF8E7] transition duration-200 shadow-sm rounded-lg mb-2">
                <td class="px-4 py-3">{{ $order->created_at->format('Y-m-d') }}</td>
                <td class="px-4 py-3">{{ $order->user->name ?? 'Guest' }}</td>
                <td class="px-4 py-3">
                    <img src="{{ asset('images/products/' . $order->product->photopath) }}"
                         class="w-14 h-14 object-cover rounded shadow-sm mx-auto">
                </td>
                <td class="px-4 py-3 font-semibold">{{ $order->product->name }}</td>
                <td class="px-4 py-3">{{ $order->phone }}</td>
                <td class="px-4 py-3 truncate">{{ $order->address }}</td>
                <td class="px-4 py-3">₹{{ $order->price }}</td>
                <td class="px-4 py-3 text-center">{{ $order->qty }}</td>
                <td class="px-4 py-3 font-semibold">₹{{ $order->qty * $order->price }}</td>
                <td class="px-4 py-3">{{ $order->payment_method }}</td>
                <td class="px-4 py-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ strtolower($order->status) === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="px-4 py-3 flex flex-wrap gap-1 justify-center">
                    <a href="{{ route('order.status', [$order->id, 'Pending']) }}"
                       class="bg-yellow-300 hover:bg-yellow-400 text-[#4B2E0A] px-3 py-1 text-xs rounded-full font-semibold transition">
                        Pending
                    </a>
                    <a href="{{ route('order.status', [$order->id, 'Processing']) }}"
                       class="bg-[#D4AF37] hover:bg-yellow-300 text-[#800020] px-3 py-1 text-xs rounded-full font-semibold transition">
                        Processing
                    </a>
                    <a href="{{ route('order.status', [$order->id, 'Shipping']) }}"
                       class="bg-[#800020] hover:bg-[#9e2e36] text-white px-3 py-1 text-xs rounded-full font-semibold transition">
                        Shipping
                    </a>
                    <a href="{{ route('order.status', [$order->id, 'Delivered']) }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 text-xs rounded-full font-semibold transition">
                        Delivered
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
