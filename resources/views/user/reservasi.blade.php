@extends('layouts.app')

@section('title', 'Riwayat Reservasi Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 min-h-screen">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Riwayat Perjalanan</h1>
        <p class="text-gray-500 mt-2">Daftar semua reservasi hotel Anda</p>
    </div>

    {{-- Alert Pesan --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($reservasis->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300 text-3xl">
                <i class="fas fa-suitcase-rolling"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Reservasi</h3>
            <p class="text-gray-500 mb-6">Yuk mulai rencanakan liburanmu sekarang!</p>
            <a href="{{ route('home') }}" class="inline-block bg-[#2aa090] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#1f7a6e] transition">
                Cari Hotel
            </a>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($reservasis as $res)
            
            @php
                // Logika H-2 untuk Tampilan
                $checkInDate = \Carbon\Carbon::parse($res->tanggal_check_in)->startOfDay();
                $today = now()->startOfDay();
                $diffDays = $today->diffInDays($checkInDate, false);
                
                // Boleh cancel jika status aktif DAN masih >= 2 hari
                $canCancel = ($res->status == 'pending' || $res->status == 'confirmed') && $diffDays >= 2;
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-6 hover:shadow-md transition relative overflow-hidden">
                
                {{-- Badge Status di Pojok Kanan Atas (Mobile) --}}
                <div class="absolute top-0 right-0 p-4 md:hidden">
                    @if($res->status == 'confirmed') <i class="fas fa-check-circle text-green-500"></i>
                    @elseif($res->status == 'pending') <i class="fas fa-clock text-yellow-500"></i>
                    @elseif($res->status == 'canceled') <i class="fas fa-times-circle text-red-500"></i>
                    @endif
                </div>

                <div class="md:w-1/4 flex flex-col justify-center border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                    <span class="text-xs font-bold text-gray-400 uppercase mb-1">Status Booking</span>
                    @if($res->status == 'pending')
                        <span class="text-yellow-600 font-bold bg-yellow-50 px-3 py-1 rounded-full w-fit text-sm">Menunggu Pembayaran</span>
                        <a href="{{ route('user.pembayaran', $res->id_reservasi) }}" class="mt-3 text-sm text-[#2aa090] font-bold hover:underline">
                            <i class="fas fa-arrow-right"></i> Lanjut Bayar
                        </a>
                    @elseif($res->status == 'confirmed')
                        <span class="text-green-600 font-bold bg-green-50 px-3 py-1 rounded-full w-fit text-sm">Confirmed (Lunas)</span>
                    @elseif($res->status == 'checked_in')
                        <span class="text-blue-600 font-bold bg-blue-50 px-3 py-1 rounded-full w-fit text-sm">Sedang Menginap</span>
                    @elseif($res->status == 'completed')
                        <span class="text-gray-600 font-bold bg-gray-100 px-3 py-1 rounded-full w-fit text-sm">Selesai</span>
                    @else
                        <span class="text-red-600 font-bold bg-red-50 px-3 py-1 rounded-full w-fit text-sm">Dibatalkan</span>
                    @endif
                    <p class="text-xs text-gray-400 mt-3">ID: #{{ $res->id_reservasi }}</p>
                </div>

                <div class="md:w-3/4 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">
                            {{ $res->kamar->hotel->nama_hotel ?? 'Hotel Tidak Ditemukan' }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-bed text-[#2aa090] mr-1"></i> {{ $res->kamar->nama_kamar ?? '-' }} ({{ $res->jumlah_kamar }} Kamar)
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                            <div>
                                <span class="block text-gray-400 text-xs">Check-in</span>
                                <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($res->tanggal_check_in)->format('d M Y') }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-400 text-xs">Check-out</span>
                                <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($res->tanggal_check_out)->format('d M Y') }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-400 text-xs">Total Harga</span>
                                <span class="font-bold text-[#2aa090]">Rp {{ number_format($res->pembayaran->total_harga ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-50">
                        @if($canCancel)
                            <form action="{{ route('user.reservasi.cancel', $res->id_reservasi) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Aksi ini tidak dapat dibatalkan.')" class="text-red-500 text-sm font-bold hover:text-red-700 bg-red-50 px-4 py-2 rounded-lg transition">
                                    <i class="fas fa-times-circle mr-1"></i> Batalkan Pesanan
                                </button>
                            </form>
                            <span class="text-[10px] text-gray-400 italic ml-2">
                                (Bisa dibatalkan s.d {{ $checkInDate->subDays(2)->format('d M Y') }})
                            </span>
                        @elseif($res->status == 'canceled')
                            <span class="text-sm text-red-400 italic">Pesanan telah dibatalkan.</span>
                        @elseif($res->status == 'confirmed' && $diffDays < 2)
                            <span class="text-xs text-gray-400 italic">Tidak dapat dibatalkan (Kurang dari H-2).</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection