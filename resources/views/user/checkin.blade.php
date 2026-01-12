@extends('layouts.app')

@section('title', 'Check-in Online')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">

    <h2 class="text-2xl font-bold mb-6">Check-in Online</h2>

    {{-- Siap Check-in --}}
    <h3 class="font-bold text-lg mb-4">Siap Check-in</h3>

    @forelse($readyToCheckin as $r)
        @php
            $kamar = $r->tipeKamar;
            $hotel = $kamar->hotel;
        @endphp

        <div class="bg-white p-5 rounded-xl shadow mb-4 flex justify-between items-center">
            <div>
                <h4 class="font-bold">{{ $hotel->nama_hotel }}</h4>
                <p class="text-sm text-gray-500">{{ $kamar->nama_kamar }}</p>
                <p class="text-xs text-gray-400">
                    {{ $r->tanggal_check_in }} → {{ $r->tanggal_check_out }}
                </p>
            </div>

            <form action="{{ route('admin.checkin.process', $r->id) }}" method="POST">
                @csrf
                <button class="bg-primary text-white px-4 py-2 rounded-lg">
                    Check-in
                </button>
            </form>
        </div>
    @empty
        <p class="text-gray-500">Tidak ada reservasi yang bisa di-check-in.</p>
    @endforelse

</div>
@endsection
