@extends('layouts.master')
@section('content')

<div class="bg-[#FFFDF4] min-h-screen py-12 px-4 md:px-16">
    <h1 class="text-3xl md:text-4xl font-bold text-center text-[#800020] mb-10 tracking-wide">
        Choose Your Payment Method
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">

        {{-- eSewa Payment --}}
        <form
            action="https://rc-epay.esewa.com.np/api/epay/main/v2/form"
            method="POST"
            class="bg-white p-8 rounded-xl shadow-lg border border-[#F3E9C9] hover:shadow-xl transition"
        >
            <input type="hidden" name="amount" value="{{ $cart->total }}">
            <input type="hidden" name="tax_amount" value="0">
            <input type="hidden" name="total_amount" value="{{ $cart->total }}">
            <input type="hidden" name="transaction_uuid" id="transaction_uuid">
            <input type="hidden" name="product_code" value="EPAYTEST">
            <input type="hidden" name="product_service_charge" value="0">
            <input type="hidden" name="product_delivery_charge" value="0">
            <input type="hidden" name="success_url" value="{{ route('order.store', $cart->id) }}">
            <input type="hidden" name="failure_url" value="https://google.com">
            <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
            <input type="hidden" name="signature" id="signature">

            <h2 class="text-2xl font-semibold text-[#800020] mb-3">eSewa Payment</h2>
            <p class="text-gray-600 mb-6">Secure online payment via eSewa with instant confirmation.</p>

            <div class="text-center">
                <button
                    type="submit"
                    class="bg-[#800020] hover:bg-[#D4AF37] text-white hover:text-[#800020] px-6 py-3 rounded-full font-medium transition"
                >
                    Pay with eSewa
                </button>
            </div>
        </form>

        {{-- Cash on Delivery --}}
        <form
            action="{{ route('order.storecod') }}"
            method="POST"
            class="bg-white p-8 rounded-xl shadow-lg border border-[#F3E9C9] hover:shadow-xl transition"
        >
            @csrf
            <input type="hidden" name="cart_id" value="{{ $cart->id }}">

            <h2 class="text-2xl font-semibold text-[#800020] mb-3">Cash On Delivery</h2>
            <p class="text-gray-600 mb-6">Pay with cash when your product is delivered to your doorstep.</p>

            <div class="text-center">
                <button
                    type="submit"
                    class="bg-[#D4AF37] hover:bg-[#800020] text-[#800020] hover:text-white px-6 py-3 rounded-full font-medium transition"
                >
                    Place Order - COD
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Signature Setup --}}
@php
    $transaction_uuid = auth()->id() . time();
    $totalamount = $cart->total;
    $productcode = 'EPAYTEST';
    $datastring = 'total_amount=' . $totalamount . ',transaction_uuid=' . $transaction_uuid . ',product_code=' . $productcode;
    $secret = '8gBm/:&EnhH.1/q';
    $signature = base64_encode(hash_hmac('sha256', $datastring, $secret, true));
@endphp

<script>
    document.getElementById('transaction_uuid').value = '{{ $transaction_uuid }}';
    document.getElementById('signature').value = '{{ $signature }}';
</script>

@endsection
