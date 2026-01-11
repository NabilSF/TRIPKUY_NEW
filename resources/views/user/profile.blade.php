@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    
    {{-- Pesan Sukses --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold">Berhasil!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        
        <div class="relative h-48 bg-[#2aa090]">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute bottom-0 left-0 w-full px-8 pb-8 flex items-end translate-y-1/2">
                <div class="w-32 h-32 rounded-full bg-white p-1 shadow-lg">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=random&color=fff&size=128" 
                         alt="Foto Profil" 
                         class="w-full h-full rounded-full object-cover">
                </div>
                <div class="ml-6 mb-2">
                    <h1 class="text-3xl font-bold text-gray-800">{{ Auth::user()->nama }}</h1>
                    <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-bold mt-1">
                        Member Setia
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-20 px-8 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-user-circle text-[#2aa090]"></i> Informasi Pribadi
                        </h3>
                        {{-- TOMBOL EDIT --}}
                        <button onclick="openEditModal()" class="text-sm font-bold text-[#2aa090] hover:text-[#1f7a6e] bg-[#2aa090]/10 px-3 py-1.5 rounded-lg transition">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nama Lengkap</label>
                            <p class="text-gray-800 font-medium">{{ Auth::user()->nama }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Alamat Email</label>
                            <p class="text-gray-800 font-medium">{{ Auth::user()->email }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Nomor Telepon</label>
                            <p class="text-gray-800 font-medium">{{ Auth::user()->no_telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-[#2aa090]"></i> Ringkasan Aktivitas
                    </h3>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-xl text-center">
                            <h4 class="text-3xl font-bold text-blue-600">
                                {{ \App\Models\Reservasi::where('id_user', Auth::id())->count() }}
                            </h4>
                            <p class="text-xs text-blue-400 font-bold uppercase mt-1">Total Pesanan</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-xl text-center">
                            <h4 class="text-3xl font-bold text-green-600">
                                {{ \App\Models\Reservasi::where('id_user', Auth::id())->where('status', 'confirmed')->count() }}
                            </h4>
                            <p class="text-xs text-green-400 font-bold uppercase mt-1">Berhasil</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('user.reservasi') }}" class="block w-full py-3 px-4 bg-[#2aa090] text-white text-center rounded-xl font-bold hover:bg-[#1f7a6e] transition shadow-lg shadow-[#2aa090]/20">
                            <i class="fas fa-history mr-2"></i> Lihat Riwayat Pesanan
                        </a>
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-3 px-4 bg-red-50 text-red-600 text-center rounded-xl font-bold hover:bg-red-100 transition border border-red-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="editProfileModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
    
    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-2xl transform transition-all relative z-10 scale-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Edit Profil</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-times text-xl"></i></button>
        </div>
        
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ Auth::user()->nama }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-[#2aa090] focus:ring-1 focus:ring-[#2aa090]" required>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-[#2aa090] focus:ring-1 focus:ring-[#2aa090]" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="no_telepon" value="{{ Auth::user()->no_telepon }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-[#2aa090] focus:ring-1 focus:ring-[#2aa090]">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">Batal</button>
                <button type="submit" class="px-6 py-2 bg-[#2aa090] text-white font-bold rounded-lg hover:bg-[#1f7a6e] shadow-lg shadow-[#2aa090]/20 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
</script>
@endsection