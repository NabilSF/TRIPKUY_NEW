@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="flex items-center justify-center mb-10 text-sm font-medium text-gray-500">
        <div class="flex items-center">
            <span class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-2"><i class="fas fa-check"></i></span>
            <span class="text-green-600">Pesan</span>
        </div>
        <div class="w-16 h-1 bg-gray-200 mx-4 relative">
            <div class="absolute top-0 left-0 h-full bg-[#2aa090] w-full"></div>
        </div>
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
                    <h3 class="font-bold text-gray-800">Detail Pesanan #{{ $reservasi->id_reservasi }}</h3>
                </div>
                <div class="p-6">
                    <div class="flex gap-4 mb-6">
                        <div class="w-24 h-24 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                            @php
                                $hotel = $reservasi->kamar->hotel;
                                // Logic Gambar
                                if ($hotel->gambar && file_exists(public_path('storage/' . $hotel->gambar))) {
                                    $imgUrl = asset('storage/' . $hotel->gambar);
                                } 
                                elseif (file_exists(public_path('images/hotel_' . $hotel->id_hotel . '.jpg'))) {
                                    $imgUrl = asset('images/hotel_' . $hotel->id_hotel . '.jpg');
                                }
                                else {
                                    $imgUrl = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80';
                                }
                            @endphp
                            <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-gray-800">{{ $hotel->nama_hotel }}</h4>
                            <p class="text-sm text-gray-500">{{ $reservasi->kamar->nama_kamar }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $hotel->alamat }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm mb-6 bg-gray-50 p-4 rounded-xl">
                        <div>
                            <span class="block text-gray-400 text-xs">Check-in</span>
                            <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($reservasi->tanggal_check_in)->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-400 text-xs">Check-out</span>
                            <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($reservasi->tanggal_check_out)->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-400 text-xs">Durasi</span>
                            <span class="font-bold text-gray-800">{{ $reservasi->total_malam }} Malam</span>
                        </div>
                        <div>
                            <span class="block text-gray-400 text-xs">Jumlah Kamar</span>
                            <span class="font-bold text-gray-800">{{ $reservasi->jumlah_kamar }} Unit</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4">Metode Pembayaran (Sandbox)</h3>
                <div class="space-y-3">
                    <label class="flex items-center p-4 border border-[#2aa090] bg-[#2aa090]/5 rounded-xl cursor-pointer">
                        <input type="radio" name="payment_method" checked class="w-5 h-5 text-[#2aa090] focus:ring-[#2aa090]">
                        <div class="ml-3 flex-1">
                            <span class="block font-bold text-gray-800">Virtual Account Simulator</span>
                            <span class="block text-xs text-gray-500">Pembayaran instan otomatis</span>
                        </div>
                        <i class="fas fa-university text-[#2aa090] text-xl"></i>
                    </label>
                    <label class="flex items-center p-4 border border-gray-200 rounded-xl opacity-50 cursor-not-allowed">
                        <input type="radio" name="payment_method" disabled class="w-5 h-5 text-gray-300">
                        <div class="ml-3">
                            <span class="block font-bold text-gray-400">Kartu Kredit (Non-aktif)</span>
                        </div>
                        <i class="fas fa-credit-card text-gray-300 text-xl ml-auto"></i>
                    </label>
                </div>
            </div>
        </div>

        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                <h3 class="font-bold text-gray-800 mb-4">Rincian Biaya</h3>
                
                <div class="space-y-3 text-sm mb-6 border-b border-gray-100 pb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Harga Kamar</span>
                        <span class="font-medium">Rp {{ number_format($reservasi->kamar->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ $reservasi->total_malam }} Malam x {{ $reservasi->jumlah_kamar }} Kamar</span>
                        <span class="font-medium">x {{ $reservasi->total_malam * $reservasi->jumlah_kamar }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pajak & Layanan</span>
                        <span class="font-medium text-green-600">Gratis</span>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <span class="font-bold text-gray-800 text-lg">Total Bayar</span>
                    <span class="font-bold text-[#2aa090] text-xl">Rp {{ number_format($reservasi->pembayaran->total_harga, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('user.pembayaran.process', $reservasi->id_reservasi) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-[#2aa090] hover:bg-[#1f7a6e] text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-[#2aa090]/40 transition flex justify-center items-center gap-2 group">
                        <span>Bayar Sekarang</span>
                        <i class="fas fa-lock group-hover:scale-110 transition-transform"></i>
                    </button>
                </form>
                
                <p class="text-xs text-gray-400 text-center mt-4 flex items-center justify-center gap-1">
                    <i class="fas fa-shield-alt"></i> Transaksi Aman & Terenkripsi
                </p>
            </div>
        </div>
    </div>
</div>
@endsection