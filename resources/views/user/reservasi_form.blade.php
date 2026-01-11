@extends('layouts.app')

@section('title', 'Booking Hotel')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Konfirmasi Pemesanan</h2>
        
        {{-- TAMPILKAN ERROR VALIDASI DI SINI --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-gray-50 p-4 rounded-xl mb-6 flex gap-4">
            <div class="w-24 h-24 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                @php
                    $hotel = $kamar->hotel;
                    // PERBAIKAN: Gunakan $hotel->id (bukan id_hotel)
                    if ($hotel->gambar && file_exists(public_path('storage/' . $hotel->gambar))) {
                        $imgUrl = asset('storage/' . $hotel->gambar);
                    } 
                    elseif (file_exists(public_path('images/hotel_' . $hotel->id . '.jpg'))) {
                        $imgUrl = asset('images/hotel_' . $hotel->id . '.jpg');
                    }
                    else {
                        $imgUrl = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80';
                    }
                @endphp
                <img src="{{ $imgUrl }}" alt="{{ $hotel->nama_hotel }}" class="w-full h-full object-cover">
            </div>
            <div>
                <h3 class="font-bold text-gray-800">{{ $hotel->nama_hotel }}</h3>
                <p class="text-sm text-gray-500">{{ $kamar->nama_kamar }}</p>
                <p class="text-[#2aa090] font-bold mt-1">Rp {{ number_format($kamar->harga, 0, ',', '.') }} / malam</p>
                <p class="text-xs text-gray-400 mt-1"><i class="fas fa-map-marker-alt"></i> {{ $hotel->kota }}</p>
            </div>
        </div>

        <form action="{{ route('user.reservasi.store') }}" method="POST">
            @csrf
            {{-- PERBAIKAN: Gunakan $kamar->id (bukan id_kamar) --}}
            <input type="hidden" name="id_kamar" value="{{ $kamar->id }}">
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Check-in</label>
                    <input type="date" name="check_in" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-1 focus:ring-primary outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Check-out</label>
                    <input type="date" name="check_out" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-1 focus:ring-primary outline-none" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Kamar</label>
                <input type="number" name="jumlah_kamar" value="1" min="1" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-1 focus:ring-primary outline-none" required>
            </div>

            <button type="submit" class="w-full bg-[#2aa090] hover:bg-[#1f7a6e] text-white font-bold py-4 rounded-xl shadow-lg transition">
                Bayar & Konfirmasi
            </button>
        </form>
    </div>
</div>
@endsection