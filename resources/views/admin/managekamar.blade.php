@extends('layouts.admin')

@section('title', 'Manajemen Kamar')
@section('header', 'Manajemen & Harga Kamar')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="font-bold text-gray-800"><i class="fas fa-tags text-[#2aa090]"></i> Atur Harga Kamar</h3>
        <p class="text-sm text-gray-500">Perubahan harga akan langsung tampil di halaman pengguna.</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                <tr>
                    <th class="p-4">Tipe Kamar</th>
                    <th class="p-4">Hotel</th>
                    <th class="p-4">Kapasitas</th>
                    <th class="p-4">Harga Saat Ini</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($kamars as $kamar)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-bold text-gray-800">{{ $kamar->nama_kamar }}</td>
                    <td class="p-4 text-sm text-gray-500">{{ $kamar->hotel->nama_hotel }}</td>
                    <td class="p-4 text-sm">{{ $kamar->kapasitas_orang }} Orang</td>
                    <td class="p-4 text-[#2aa090] font-bold">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</td>
                    <td class="p-4 text-center">
                        <button onclick="editHarga({{ $kamar->id }}, '{{ $kamar->nama_kamar }}', {{ $kamar->harga }})" 
                                class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-100">
                            Ubah Harga
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="priceModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white w-96 rounded-2xl p-6 shadow-2xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Update Harga</h3>
        <p id="kamarNameDisplay" class="text-sm text-gray-500 mb-4"></p>
        
        <form id="priceForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="text-xs font-bold text-gray-500 uppercase">Harga Baru (Rp)</label>
                <input type="number" name="harga" id="modalHarga" class="w-full border rounded-lg p-3 mt-1 focus:ring-[#2aa090] font-bold text-lg" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('priceModal').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="px-6 py-2 bg-[#2aa090] text-white font-bold rounded-lg hover:bg-[#1f7a6e]">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editHarga(id, nama, harga) {
        document.getElementById('priceModal').classList.remove('hidden');
        document.getElementById('priceForm').action = '/admin/manage-kamar/' + id;
        document.getElementById('kamarNameDisplay').innerText = 'Mengubah harga untuk: ' + nama;
        document.getElementById('modalHarga').value = harga;
    }
</script>
@endsection