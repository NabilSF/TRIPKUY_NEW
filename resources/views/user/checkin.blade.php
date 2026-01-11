@extends('layouts.app')
@section('title', 'Booking Hotel')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Konfirmasi Pemesanan</h2>
        <div class="bg-gray-50 p-4 rounded-xl mb-6 flex gap-4">
            <div class="w-24 h-24 bg-gray-200 rounded-lg overflow-hidden shrink-0">
                @php
                    $hotel = $kamar->hotel;
                    // PERBAIKAN: id_hotel -> id
                    if ($hotel->gambar && file_exists(public_path('storage/' . $hotel->gambar))) {
                        $imgUrl = asset('storage/' . $hotel->gambar);
                    } elseif (file_exists(public_path('images/hotel_' . $hotel->id . '.jpg'))) {
                        $imgUrl = asset('images/hotel_' . $hotel->id . '.jpg');
                    } else { $imgUrl = 'https://via.placeholder.com/150'; }
                @endphp
                <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
            </div>
            <div>
                <h3 class="font-bold text-gray-800">{{ $hotel->nama_hotel }}</h3>
                <p class="text-sm text-gray-500">{{ $kamar->nama_kamar }}</p>
                <p class="text-[#2aa090] font-bold mt-1">Rp {{ number_format($kamar->harga, 0, ',', '.') }} / malam</p>
            </div>
        </div>

        <form action="{{ route('user.reservasi.store') }}" method="POST">
            @csrf
            {{-- PERBAIKAN: id_kamar -> id --}}
            <input type="hidden" name="id_kamar" value="{{ $kamar->id }}">
            {{-- Form Input Tanggal Dll Tetap Sama --}}
            <button type="submit" class="w-full bg-[#2aa090] text-white font-bold py-4 rounded-xl shadow-lg">Bayar & Konfirmasi</button>
        </form>
    </div>
</div>
@endsection