@extends('layouts.app')
@section('title', 'Riwayat Reservasi Saya')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 min-h-screen">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Riwayat Perjalanan</h1>
    </div>

    @if($reservasis->isEmpty())
        {{-- Tampilan Kosong --}}
    @else
        <div class="grid gap-6">
            @foreach($reservasis as $res)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-6 transition relative overflow-hidden">
                <div class="md:w-1/4 flex flex-col justify-center border-b md:border-b-0 md:border-r border-gray-100 pb-4 md:pb-0 md:pr-4">
                    <span class="text-xs font-bold text-gray-400 uppercase mb-1">Status Booking</span>
                    @if($res->status == 'pending')
                        <span class="text-yellow-600 font-bold bg-yellow-50 px-3 py-1 rounded-full text-sm">Menunggu Pembayaran</span>
                        {{-- PERBAIKAN: id_reservasi -> id --}}
                        <a href="{{ route('user.pembayaran', $res->id) }}" class="mt-3 text-sm text-[#2aa090] font-bold hover:underline"><i class="fas fa-arrow-right"></i> Lanjut Bayar</a>
                    @elseif($res->status == 'confirmed')
                        <span class="text-green-600 font-bold bg-green-50 px-3 py-1 rounded-full text-sm">Confirmed (Lunas)</span>
                    @endif
                    {{-- PERBAIKAN: id_reservasi -> id --}}
                    <p class="text-xs text-gray-400 mt-3">ID: #{{ $res->id }}</p>
                </div>
                <div class="md:w-3/4 flex flex-col justify-between">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $res->kamar->hotel->nama_hotel }}</h3>
                    {{-- Bagian Button Cancel --}}
                    <div class="flex items-center gap-4 pt-4 border-t border-gray-50">
                        @if(($res->status == 'pending' || $res->status == 'confirmed'))
                            {{-- PERBAIKAN: id_reservasi -> id --}}
                            <form action="{{ route('user.reservasi.cancel', $res->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 text-sm font-bold bg-red-50 px-4 py-2 rounded-lg transition">Batalkan Pesanan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection