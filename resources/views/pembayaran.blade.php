@extends('layouts.app')
@section('title', 'Selesaikan Pembayaran')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="flex items-center justify-center mb-10 text-sm font-medium text-gray-500">
        <div class="flex items-center">
            <span class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-2"><i class="fas fa-check"></i></span>
            <span class="text-green-600">Pesan</span>
        </div>
        <div class="w-16 h-1 bg-gray-200 mx-4 relative"><div class="absolute top-0 left-0 h-full bg-[#2aa090] w-full"></div></div>
        <div class="flex items-center">
            <span class="w-8 h-8 rounded-full bg-[#2aa090] text-white flex items-center justify-center mr-2">2</span>
            <span class="text-[#2aa090] font-bold">Bayar</span>
        </div>
        <div class="w-16 h-1 bg-gray-200 mx-4"></div>
        <div class="flex items-center">
            <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-2">3</span>
            <span>Selesai</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    {{-- PERBAIKAN: id_reservasi -> id --}}
                    <h3 class="font-bold text-gray-800">Detail Pesanan #{{ $reservasi->id }}</h3>
                </div>
                <div class="p-6">
                    <div class="flex gap-4 mb-6">
                        <div class="w-24 h-24 bg-gray-200 rounded-lg overflow-hidden shrink-0">
                            @php
                                $hotel = $reservasi->tipeKamar->hotel;
                                // PERBAIKAN: id_hotel -> id
                                if ($hotel->gambar && file_exists(public_path('storage/' . $hotel->gambar))) {
                                    $imgUrl = asset('storage/' . $hotel->gambar);
                                } elseif (file_exists(public_path('images/hotel_' . $hotel->id . '.jpg'))) {
                                    $imgUrl = asset('images/hotel_' . $hotel->id . '.jpg');
                                } else {
                                    $imgUrl = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80';
                                }
                            @endphp
                            <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-800">{{ $hotel->nama_hotel }}</h4>
                            <p class="text-sm text-gray-500">{{ $reservasi->tipeKamar->nama_kamar }}</p>
                        </div>
                    </div>
                    {{-- Info Check-in Tetap Sama --}}
                </div>
            </div>
            {{-- Bagian Metode Pembayaran Tetap Sama --}}
        </div>

        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                <h3 class="font-bold text-gray-800 mb-4">Rincian Biaya</h3>
                {{-- Detail Biaya --}}
                <div class="flex justify-between items-center mb-6">
                    <span class="font-bold text-gray-800 text-lg">Total Bayar</span>
                    <span class="font-bold text-[#2aa090] text-xl">Rp {{ number_format($reservasi->pembayaran->total_harga, 0, ',', '.') }}</span>
                </div>
                {{-- PERBAIKAN: id_reservasi -> id --}}
                <form action="{{ route('user.pembayaran.process', $reservasi->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-[#2aa090] hover:bg-[#1f7a6e] text-white font-bold py-4 rounded-xl shadow-lg transition flex justify-center items-center gap-2 group">
                        <span>Bayar Sekarang</span> <i class="fas fa-lock group-hover:scale-110 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection