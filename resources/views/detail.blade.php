@extends('layouts.app')
@section('title', $hotel->nama_hotel)
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-[#2aa090]">Home</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900 font-medium">Detail Hotel</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $hotel->nama_hotel }}</h1>
        <div class="flex items-center gap-4 text-sm text-gray-600">
            <span class="flex items-center gap-1"><i class="fas fa-map-marker-alt text-[#2aa090]"></i> {{ $hotel->alamat }}</span>
            <span class="flex items-center gap-1"><i class="fas fa-star text-yellow-400"></i> 4.8 (Ulasan)</span>
        </div>
    </div>

    @php
        // PERBAIKAN: id_hotel -> id
        $hotelImgPath = 'images/hotel_' . $hotel->id . '.jpg';
        $mainImage = file_exists(public_path($hotelImgPath)) ? asset($hotelImgPath) : 'https://via.placeholder.com/800x600?text=' . urlencode($hotel->nama_hotel);

        $kamar1 = file_exists(public_path('images/kamar_1.jpg')) ? asset('images/kamar_1.jpg') : 'https://via.placeholder.com/400x300?text=Kamar+1';
        $kamar2 = file_exists(public_path('images/kamar_2.jpg')) ? asset('images/kamar_2.jpg') : 'https://via.placeholder.com/400x300?text=Kamar+2';
        $kamar3 = file_exists(public_path('images/kamar_3.jpg')) ? asset('images/kamar_3.jpg') : 'https://via.placeholder.com/400x300?text=Kamar+3';
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-2 h-100 mb-8 rounded-2xl overflow-hidden">
        <div class="md:col-span-2 relative h-full group">
            <img src="{{ $mainImage }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105 cursor-pointer">
        </div>
        <div class="md:col-span-1 grid grid-rows-2 gap-2 h-full">
            <div class="relative h-full overflow-hidden group">
                <img src="{{ $kamar1 }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105 cursor-pointer">
            </div>
            <div class="relative h-full overflow-hidden group">
                <img src="{{ $kamar2 }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105 cursor-pointer">
            </div>
        </div>
        <div class="md:col-span-1 relative h-full overflow-hidden group">
            <img src="{{ $kamar3 }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105 cursor-pointer">
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center cursor-pointer hover:bg-black/50 transition">
                <span class="text-white font-medium border border-white px-4 py-2 rounded-full text-sm hover:bg-white hover:text-black transition">Lihat Semua Foto</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Tentang Akomodasi</h2>
                <p class="text-gray-600 leading-relaxed">{{ $hotel->deskripsi }}</p>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-4">Pilihan Tipe Kamar</h2>
                <div class="space-y-4">
                    @forelse($hotel->tipeKamars as $index => $kamar)
                        @php
                            $kamarImgIndex = ($index % 3) + 1; 
                            $kamarImg = file_exists(public_path('images/kamar_'.$kamarImgIndex.'.jpg')) ? asset('images/kamar_'.$kamarImgIndex.'.jpg') : 'https://via.placeholder.com/300x200?text=Kamar';
                        @endphp
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden flex flex-col md:flex-row hover:shadow-md transition">
                        <div class="md:w-1/3 h-48 md:h-auto bg-gray-100 relative group">
                            <img src="{{ $kamarImg }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $kamar->nama_kamar }}</h3>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $kamar->deskripsi }}</p>
                                <div class="flex gap-2 mt-3">
                                    <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded border border-green-100 flex items-center gap-1"><i class="fas fa-check"></i> Sarapan</span>
                                    <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded border border-blue-100 flex items-center gap-1"><i class="fas fa-user"></i> {{ $kamar->kapasitas_orang }} Orang</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-100">
                                <div>
                                    <span class="text-2xl font-bold text-[#2aa090]">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-400">/ malam</span>
                                </div>
                                <form action="{{ route('user.reservasi') }}" method="GET">
                                    {{-- PERBAIKAN: id_hotel -> id dan id_kamar -> id --}}
                                    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                    <input type="hidden" name="room_id" value="{{ $kamar->id }}">
                                    <button class="bg-[#2aa090] hover:bg-[#1f7a6e] text-white px-5 py-2 rounded-lg font-bold text-sm shadow-md transition transform hover:-translate-y-0.5">Pilih Kamar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300 text-gray-500">Tidak ada tipe kamar tersedia saat ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                <div class="text-center mb-6">
                    <p class="text-sm text-gray-500">Harga mulai dari</p>
                    <h3 class="text-3xl font-bold text-[#2aa090]">Rp {{ number_format($hotel->tipeKamars->min('harga') ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg text-xs text-blue-700 mb-4 border border-blue-100 flex items-start gap-2">
                    <i class="fas fa-info-circle mt-0.5"></i> <span>Pilih tipe kamar di samping untuk melanjutkan pemesanan.</span>
                </div>
                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
                    <i class="fas fa-lock text-green-500"></i> Transaksi Aman & Terpercaya
                </div>
            </div>
        </div>
    </div>
</div>
@endsection