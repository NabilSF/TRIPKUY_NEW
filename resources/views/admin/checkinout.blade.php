@extends('layouts.admin')

@section('title', 'Operasional Harian')
@section('header', 'Operasional Harian')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
    {{-- KOLOM JADWAL CHECK-IN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition h-fit">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-sm"><i class="fas fa-sign-in-alt"></i></span>
                Jadwal Check-in
            </h3>
            <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-bold">{{ $todayCheckins->count() }} Tamu</span>
        </div>
        
        <div class="space-y-3">
            @forelse($todayCheckins as $in)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 group hover:border-green-200 transition">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($in->user->nama) }}&background=random&color=fff" class="w-10 h-10 rounded-full border border-gray-200">
                        <div>
                            <div class="font-bold text-gray-800 text-sm group-hover:text-green-600 transition">{{ $in->user->nama }}</div>
                            <div class="text-xs text-gray-500">
                                #{{ $in->id_reservasi }} • {{ $in->kamar->nama_kamar }}
                            </div>
                            <div class="text-[10px] text-gray-400 mt-0.5">
                                <i class="fas fa-calendar-alt"></i> Check-in: {{ \Carbon\Carbon::parse($in->tanggal_check_in)->format('d M') }}
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.checkin.process', $in->id_reservasi) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#2aa090] text-white px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-[#1f7a6e] shadow-sm shadow-green-200 transition transform active:scale-95">
                            Proses
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-check-circle text-4xl mb-2 text-gray-200"></i>
                    <p class="text-sm">Tidak ada jadwal check-in saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- KOLOM JADWAL CHECK-OUT (TAMU MENGINAP) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition h-fit">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-sm"><i class="fas fa-sign-out-alt"></i></span>
                Tamu Menginap / Check-out
            </h3>
            <span class="bg-red-50 text-red-700 px-3 py-1 rounded-full text-xs font-bold">{{ $todayCheckouts->count() }} Aktif</span>
        </div>
        
        <div class="space-y-3">
            @forelse($todayCheckouts as $out)
                @php
                    $isToday = \Carbon\Carbon::parse($out->tanggal_check_out)->isToday();
                    $isPast = \Carbon\Carbon::parse($out->tanggal_check_out)->isPast() && !$isToday;
                @endphp

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border {{ $isPast ? 'border-red-300 bg-red-50' : 'border-gray-100' }} group hover:border-red-200 transition">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($out->user->nama) }}&background=random&color=fff" class="w-10 h-10 rounded-full border border-gray-200">
                        <div>
                            <div class="font-bold text-gray-800 text-sm group-hover:text-red-600 transition">{{ $out->user->nama }}</div>
                            <div class="text-xs text-gray-500">
                                #{{ $out->id_reservasi }} • {{ $out->kamar->nama_kamar }}
                            </div>
                            
                            @if($isPast)
                                <div class="text-[10px] text-red-600 font-bold mt-0.5 animate-pulse">
                                    <i class="fas fa-exclamation-circle"></i> Lewat Jadwal Check-out!
                                </div>
                            @elseif($isToday)
                                <div class="text-[10px] text-orange-500 font-bold mt-0.5">
                                    <i class="fas fa-clock"></i> Jadwal Pulang Hari Ini
                                </div>
                            @else
                                <div class="text-[10px] text-gray-400 mt-0.5">
                                    <i class="fas fa-calendar-check"></i> Pulang: {{ \Carbon\Carbon::parse($out->tanggal_check_out)->format('d M') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('admin.checkout.process', $out->id_reservasi) }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Konfirmasi Check-out tamu ini?')" class="bg-gray-800 text-white px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-black shadow-sm transition transform active:scale-95">
                            Selesai
                        </button>
                    </form>
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-bed text-4xl mb-2 text-gray-200"></i>
                    <p class="text-sm">Tidak ada tamu yang sedang menginap.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection