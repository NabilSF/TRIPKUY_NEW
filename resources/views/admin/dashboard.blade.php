@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="relative bg-gradient-to-r from-[#2aa090] to-[#1f7a6e] rounded-2xl p-8 text-white shadow-lg mb-8 overflow-hidden">
    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->nama }}! 👋</h2>
            <p class="text-white/90">Pantau performa bisnis properti Anda hari ini.</p>
        </div>
        <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-xl border border-white/30">
            <span class="text-lg font-bold">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase">Total Reservasi</p>
        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $total_reservasi }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase">Pendapatan</p>
        <h3 class="text-3xl font-bold text-[#2aa090] mt-1">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase">Perlu Tindakan</p>
        <h3 class="text-3xl font-bold text-red-500 mt-1">{{ $pembatalan }}</h3>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-6">Grafik Pendapatan (6 Bulan Terakhir)</h3>
    <div class="h-80">
        <canvas id="incomeChart"></canvas>
    </div>
</div>

<script>
    const ctx = document.getElementById('incomeChart').getContext('2d');
    
    // Data Dummy jika database kosong agar grafik tetap tampil cantik
    const labels = {!! json_encode($chartData->keys()->isEmpty() ? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'] : $chartData->keys()) !!};
    const data = {!! json_encode($chartData->values()->isEmpty() ? [1000000, 2500000, 1800000, 3200000, 2100000, 4500000] : $chartData->values()) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                borderColor: '#2aa090',
                backgroundColor: 'rgba(42, 160, 144, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection