@extends('layouts.app')

@section('title', 'Check-in & Check-out Online')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 min-h-screen">
    
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-bold text-gray-800">Layanan Check-in Online</h1>
        <p class="text-gray-500 mt-2">Kelola kedatangan dan kepergian Anda tanpa antre di resepsionis.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 animate-fade-in-up">
            <strong class="font-bold"><i class="fas fa-check-circle mr-2"></i>Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- KONDISI 1: TIDAK ADA DATA --}}
    @if($readyToCheckin->isEmpty() && $activeStays->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-concierge-bell text-gray-300 text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Jadwal Check-in</h3>
            <p class="text-gray-500 mb-6">Anda tidak memiliki jadwal check-in hari ini atau reservasi aktif.</p>
            <a href="{{ route('home') }}" class="inline-block bg-[#2aa090] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#1f7a6e] transition">
                Pesan Hotel Sekarang
            </a>
        </div>
    @else

        <div class="grid gap-8">
            
            {{-- KONDISI 2: SIAP CHECK-IN --}}
            @if(!$readyToCheckin->isEmpty())
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></span> Siap Check-in
                    </h2>
                    
                    @foreach($readyToCheckin as $res)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col md:flex-row mb-6">
                        <div class="bg-gray-900 p-6 flex flex-col items-center justify-center text-white md:w-1/3">
                            <div class="bg-white p-2 rounded-lg mb-3">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $res->id_reservasi }}-CHECKIN" alt="QR Code" class="w-32 h-32">
                            </div>
                            <p class="text-xs font-mono text-gray-400">SCAN DI RESEPSIONIS</p>
                            <p class="text-lg font-bold mt-1">#{{ $res->id_reservasi }}</p>
                        </div>

                        <div class="p-6 md:w-2/3 flex flex-col justify-between">
                            <div>
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block">CONFIRMED</span>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $res->kamar->hotel->nama_hotel }}</h3>
                                <p class="text-gray-500 mb-4"><i class="fas fa-bed mr-1"></i> {{ $res->kamar->nama_kamar }} ({{ $res->jumlah_kamar }} Unit)</p>
                                
                                <div class="grid grid-cols-2 gap-4 text-sm bg-gray-50 p-3 rounded-xl mb-4">
                                    <div>
                                        <p class="text-gray-400 text-xs">Check-in</p>
                                        <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($res->tanggal_check_in)->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400 text-xs">Durasi</p>
                                        <p class="font-bold text-gray-800">{{ $res->total_malam }} Malam</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('user.checkin.process', $res->id_reservasi) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-[#2aa090] hover:bg-[#1f7a6e] text-white font-bold py-3 px-6 rounded-xl shadow-lg transition flex justify-center items-center gap-2 group">
                                    <i class="fas fa-key group-hover:rotate-45 transition-transform"></i> Check-in Sekarang
                                </button>
                                <p class="text-[10px] text-gray-400 text-center mt-2">*Pastikan Anda sudah berada di lokasi hotel</p>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

            {{-- KONDISI 3: SEDANG MENGINAP (SIAP CHECK-OUT) --}}
            @if(!$activeStays->isEmpty())
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-suitcase text-[#2aa090]"></i> Sedang Menginap
                    </h2>

                    @foreach($activeStays as $stay)
                    <div class="bg-white rounded-2xl shadow-sm border border-[#2aa090] overflow-hidden p-6 mb-4 relative">
                        <div class="absolute top-0 right-0 bg-[#2aa090] text-white text-xs font-bold px-4 py-1 rounded-bl-xl">
                            ACTIVE
                        </div>

                        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                            <div class="flex items-center gap-4 w-full md:w-auto">
                                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-blue-500 text-2xl flex-shrink-0">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-gray-800">{{ $stay->kamar->hotel->nama_hotel }}</h4>
                                    <p class="text-sm text-gray-500">Check-out: <span class="text-red-500 font-bold">{{ \Carbon\Carbon::parse($stay->tanggal_check_out)->format('d M Y') }}</span></p>
                                </div>
                            </div>

                            <div class="w-full md:w-auto">
                                <form action="{{ route('user.checkout.process', $stay->id_reservasi) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin Check-out? Kunci kamar akan dinonaktifkan.')" class="w-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 font-bold py-2 px-6 rounded-xl transition flex justify-center items-center gap-2">
                                        <i class="fas fa-sign-out-alt"></i> Check-out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

        </div>

    @endif
</div>

<style>
    @keyframes fade-in-up {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.5s ease-out forwards;
    }
</style>
@endsection