@extends('layouts.admin')

@section('title', 'Data Hotel')
@section('header', 'Daftar Hotel')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 text-lg">Total {{ $hotels->count() }} Properti Terdaftar</h3>
        <button onclick="openCreateModal()" class="bg-[#2aa090] hover:bg-[#1f7a6e] text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Tambah Hotel Baru
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($hotels as $hotel)
            @php
                // --- LOGIKA PENENTUAN GAMBAR ---
                
                // 1. Prioritas Utama: Gambar hasil upload (di folder storage/hotel_images)
                if ($hotel->gambar && file_exists(public_path('storage/' . $hotel->gambar))) {
                    $imgUrl = asset('storage/' . $hotel->gambar);
                } 
                // 2. Prioritas Kedua: Gambar bawaan di folder public/images (format: hotel_{id}.jpg)
                elseif (file_exists(public_path('images/hotel_' . $hotel->id_hotel . '.jpg'))) {
                    $imgUrl = asset('images/hotel_' . $hotel->id_hotel . '.jpg');
                }
                // 3. Fallback: Gambar placeholder jika tidak ada di kedua lokasi
                else {
                    $imgUrl = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80';
                }
            @endphp
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group h-full flex flex-col">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute top-3 right-3 bg-white/90 px-2 py-1 rounded text-xs font-bold text-[#2aa090] shadow-sm">
                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $hotel->kota ?? 'Indonesia' }}
                    </div>
                </div>
                
                <div class="p-5 flex-grow flex flex-col">
                    <h3 class="font-bold text-lg text-gray-800 mb-1 line-clamp-1">{{ $hotel->nama_hotel }}</h3>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2 flex-grow">{{ $hotel->alamat }}</p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-50 flex gap-2">
                        <button onclick="openEditModal({{ $hotel->id_hotel }}, '{{ addslashes($hotel->nama_hotel) }}', '{{ addslashes($hotel->kota) }}', '{{ addslashes($hotel->alamat) }}')" 
                                class="flex-1 bg-gray-50 hover:bg-[#2aa090] text-gray-600 hover:text-white py-2 rounded-lg text-sm font-semibold transition flex justify-center items-center gap-2">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    
    <div class="bg-white w-full max-w-lg rounded-2xl p-6 shadow-2xl transform transition-all relative z-10 scale-100">
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
            <h3 class="text-xl font-bold text-gray-800">Edit Data Hotel</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-xl"></i></button>
        </div>
        
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Nama Hotel</label>
                    <input type="text" name="nama_hotel" id="modalNama" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-[#2aa090] focus:ring-1 focus:ring-[#2aa090] transition" required>
                </div>
                
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Kota</label>
                    <select name="kota" id="modalKota" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-[#2aa090] focus:ring-1 focus:ring-[#2aa090] transition bg-white">
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bali">Bali</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Solo">Solo</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Lombok">Lombok</option>
                        <option value="Makassar">Makassar</option>
                    </select>
                </div>
                
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Alamat Lengkap</label>
                    <textarea name="alamat" id="modalAlamat" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:border-[#2aa090] focus:ring-1 focus:ring-[#2aa090] transition resize-none" required></textarea>
                </div>
                
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Update Foto</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                <p class="text-xs text-gray-500">Klik untuk upload gambar baru</p>
                                <p class="text-[10px] text-gray-400 mt-1">File akan disimpan & menggantikan gambar lama</p>
                            </div>
                            <input id="dropzone-file" type="file" name="gambar" class="hidden" accept="image/*" />
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-[#2aa090] text-white font-bold rounded-lg hover:bg-[#1f7a6e] shadow-lg shadow-[#2aa090]/20 transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nama, kota, alamat) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        
        // Set action URL dinamis
        form.action = `/admin/data-hotel/${id}`;
        
        // Isi value input
        document.getElementById('modalNama').value = nama;
        
        // Pilih opsi kota yang sesuai
        const kotaSelect = document.getElementById('modalKota');
        const options = Array.from(kotaSelect.options);
        const optionToSelect = options.find(item => item.value === kota);
        kotaSelect.value = optionToSelect ? kota : 'Jakarta';

        document.getElementById('modalAlamat').value = alamat;
        
        // Tampilkan modal
        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    
    // Optional: Close modal on Esc key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeModal();
        }
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
</style>
@endsection