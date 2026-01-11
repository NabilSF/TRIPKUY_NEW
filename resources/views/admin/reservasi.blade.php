@extends('layouts.admin')

@section('title', 'Data Reservasi')
@section('header', 'Daftar Reservasi')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-800"><i class="fas fa-list text-[#2aa090]"></i> Status Booking</h3>
        
        <div class="text-xs text-gray-500 italic">
            *Admin berhak membatalkan pesanan yang belum dibayar > 1x24 jam.
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                <tr>
                    <th class="p-4">ID & Tanggal</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Detail Kamar</th>
                    <th class="p-4">Tenggat Bayar</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi Sepihak</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @foreach($reservasis as $res)
                @php
                    // Hitung Tenggat Waktu (Misal: 24 jam setelah booking)
                    $waktuBooking = \Carbon\Carbon::parse($res->tanggal_reservasi);
                    $tenggatWaktu = $waktuBooking->copy()->addDay(); // +1 Hari
                    $sekarang = now();
                    
                    $isTelat = $sekarang->greaterThan($tenggatWaktu) && $res->status == 'pending';
                @endphp
                
                <tr class="hover:bg-gray-50 transition {{ $isTelat ? 'bg-red-50/50' : '' }}">
                    <td class="p-4">
                        <span class="font-mono text-gray-500 block">#{{ $res->id }}</span>
                        <span class="text-[10px] text-gray-400">{{ $waktuBooking->format('d M H:i') }}</span>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-gray-800">{{ $res->user->nama }}</div>
                        <div class="text-xs text-gray-500">{{ $res->user->no_telepon ?? '-' }}</div>
                    </td>
                    <td class="p-4">
                        <div class="text-gray-800">{{ $res->kamar->nama_kamar }}</div>
                        <div class="text-xs text-gray-500">{{ $res->kamar->hotel->nama_hotel }}</div>
                    </td>
                    <td class="p-4">
                        @if($res->status == 'pending')
                            <div class="text-xs">
                                @if($isTelat)
                                    <span class="text-red-600 font-bold flex items-center gap-1">
                                        <i class="fas fa-exclamation-circle"></i> Kadaluwarsa
                                    </span>
                                    <span class="text-[10px] text-red-400 line-through">{{ $tenggatWaktu->format('d M H:i') }}</span>
                                @else
                                    <span class="text-orange-500 font-bold flex items-center gap-1">
                                        <i class="fas fa-clock"></i> {{ $tenggatWaktu->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if($res->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold inline-block text-center min-w-[80px]">Pending</span>
                        @elseif($res->status == 'confirmed')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold inline-block text-center min-w-[80px]">Confirmed</span>
                        @elseif($res->status == 'checked_in')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold inline-block text-center min-w-[80px]">Check-in</span>
                        @elseif($res->status == 'completed')
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold inline-block text-center min-w-[80px]">Selesai</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold inline-block text-center min-w-[80px]">Dibatalkan</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($res->status == 'pending')
                            <form action="{{ route('admin.reservasi.cancel', $res->id) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini secara sepihak? {{ $isTelat ? '(Pesanan ini sudah melewati batas waktu pembayaran)' : '' }}')">
                                @csrf
                                <button type="submit" class="bg-red-50 border border-red-200 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-600 hover:text-white transition flex items-center justify-center gap-2 mx-auto w-full shadow-sm">
                                    <i class="fas fa-ban"></i> 
                                    {{ $isTelat ? 'Batalkan (Telat)' : 'Batalkan' }}
                                </button>
                            </form>
                        @else
                            <span class="text-gray-300 text-xl"><i class="fas fa-check-circle"></i></span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection