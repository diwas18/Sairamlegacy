@extends('layouts.app')
@section('content')

<h1 class="text-4xl font-extrabold text-[#800020] mb-2">Dashboard</h1>
<hr class="h-1 bg-[#D4AF37] rounded mb-8">

<div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-8">

    {{-- Statistic Cards --}}
    <div class="bg-[#FFFFF0] border-l-8 border-[#800020] p-6 shadow rounded-lg">
        <h2 class="text-2xl font-bold text-[#4B2E0A] mb-2">Categories</h2>
        <p class="text-lg font-semibold text-[#800020]">Total Categories: {{ $categories }}</p>
    </div>

    <div class="bg-[#FFFFF0] border-l-8 border-[#D4AF37] p-6 shadow rounded-lg">
        <h2 class="text-2xl font-bold text-[#4B2E0A] mb-2">Products</h2>
        <p class="text-lg font-semibold text-[#800020]">Total Products: {{ $products }}</p>
    </div>

    <div class="bg-[#FFFFF0] border-l-8 border-[#4B2E0A] p-6 shadow rounded-lg">
        <h2 class="text-2xl font-bold text-[#4B2E0A] mb-2">Users</h2>
        <p class="text-lg font-semibold text-[#800020]">Total Users: 15</p>
    </div>

    <div class="bg-[#FFFFF0] border-l-8 border-[#D4AF37] p-6 shadow rounded-lg">
        <h2 class="text-2xl font-bold text-[#4B2E0A] mb-2">Pending Orders</h2>
        <p class="text-lg font-semibold text-[#800020]">Pending Orders: 20</p>
    </div>

    <div class="bg-[#FFFFF0] border-l-8 border-[#800020] p-6 shadow rounded-lg">
        <h2 class="text-2xl font-bold text-[#4B2E0A] mb-2">Processing Orders</h2>
        <p class="text-lg font-semibold text-[#800020]">Processing Orders: 30</p>
    </div>

    <div class="bg-[#FFFFF0] border-l-8 border-[#D4AF37] p-6 shadow rounded-lg">
        <h2 class="text-2xl font-bold text-[#4B2E0A] mb-2">Completed Orders</h2>
        <p class="text-lg font-semibold text-[#800020]">Completed Orders: 40</p>
    </div>

    {{-- Charts --}}
    <div class="col-span-1 md:col-span-2 bg-white p-6 rounded-lg shadow">
        <canvas id="myChart"></canvas>
    </div>

    <div class="col-span-1 bg-white p-6 rounded-lg shadow">
        <canvas id="myChart2"></canvas>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data = {
        labels: ["Pending", "Processing", "Shipping", "Delivered"],
        datasets: [{
            label: "No. of Orders",
            data: [{{ $pending }}, {{ $processing }}, {{ $shipping }}, {{ $delivered }}],
            backgroundColor: [
                "rgb(128, 0, 32)",       // Burgundy
                "rgb(212, 175, 55)",     // Gold
                "rgb(75, 46, 10)",       // Dark Brown
                "rgb(244, 244, 236)"     // Ivory (light)
            ],
            hoverOffset: 4,
        }],
    };

    const configPie2 = {
        type: "pie",
        data: data,
        options: {
            plugins: { legend: { position: 'bottom' } }
        },
    };

    new Chart(document.getElementById("myChart"), configPie2);

    // Use PHP arrays for labels and data
    const allcat = @json($allcatNames);
    const productcount = @json($productcount);

    // Generate gold colors for each slice
    const goldColors = productcount.map(() => '#D4AF37');

    const ctx = document.getElementById('myChart2');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: allcat,
            datasets: [{
                label: '# of Products',
                data: productcount,
                backgroundColor: goldColors,
                borderWidth: 1
            }]
        },
        options: {
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>


@endsection
