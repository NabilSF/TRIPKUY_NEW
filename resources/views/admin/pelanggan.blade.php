@extends('layouts.admin')

@section('title', 'Data Pelanggan')
@section('header', 'Data Pelanggan')

@section('content')
<div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h4 class="text-2xl font-bold text-gray-800">{{ $users->count() }}</h4>
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total User</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-xl">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
                <h4 class="text-2xl font-bold text-gray-800">{{ $users->sum('reservasis_count') }}</h4>
                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Total Transaksi</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Daftar Pengguna Terdaftar</h3>
            
            {{-- Search Bar (Visual Only) --}}
            <div class="relative">
                <input type="text" id="searchUser" placeholder="Cari nama..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#2aa090] transition w-64">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="userTable">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                    <tr>
                        <th class="p-4">Profil</th>
                        <th class="p-4">Kontak</th>
                        <th class="p-4 text-center">Riwayat Booking</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=random&color=fff" class="w-10 h-10 rounded-full border border-gray-200">
                                <div>
                                    <div class="font-bold text-gray-800 group-hover:text-[#2aa090] transition">{{ $user->nama }}</div>
                                    <div class="text-xs text-gray-400">ID: #{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-gray-600 flex items-center gap-2">
                                    <i class="fas fa-envelope text-gray-300 w-4"></i> {{ $user->email }}
                                </span>
                                <span class="text-gray-600 flex items-center gap-2">
                                    <i class="fas fa-phone text-gray-300 w-4"></i> {{ $user->no_telepon ?? '-' }}
                                </span>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            @if($user->reservasis_count > 0)
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $user->reservasis_count }}x Reservasi
                                </span>
                            @else
                                <span class="text-gray-400 text-xs italic">Belum ada transaksi</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <button onclick="openDetailModal('{{ $user->nama }}', '{{ $user->email }}', '{{ $user->no_telepon ?? '-' }}', '{{ $user->role }}', {{ $user->reservasis_count }})" 
                                    class="text-gray-400 hover:text-[#2aa090] transition p-2 bg-gray-100 rounded-lg hover:bg-[#2aa090]/10 mr-2" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            
                            <form action="{{ route('admin.pelanggan.delete', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus user ini? Data tidak bisa dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition p-2 bg-gray-100 rounded-lg hover:bg-red-50" title="Hapus User">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400">
                            Belum ada data pelanggan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="detailUserModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeDetailModal()"></div>
    
    <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl transform transition-all relative z-10 scale-100 text-center">
        <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition"><i class="fas fa-times"></i></button>
        
        <div class="w-24 h-24 rounded-full bg-gray-100 mx-auto mb-4 p-1 shadow-md">
            <img id="modalAvatar" src="" class="w-full h-full rounded-full object-cover">
        </div>
        
        <h3 id="modalNama" class="text-xl font-bold text-gray-800"></h3>
        <span id="modalRole" class="inline-block bg-[#2aa090]/10 text-[#2aa090] px-3 py-1 rounded-full text-xs font-bold mt-2 uppercase">USER</span>
        
        <div class="mt-6 space-y-3 text-left bg-gray-50 p-4 rounded-xl">
            <div class="flex justify-between border-b border-gray-200 pb-2">
                <span class="text-gray-500 text-xs uppercase font-bold">Email</span>
                <span id="modalEmail" class="text-gray-800 font-medium text-sm"></span>
            </div>
            <div class="flex justify-between border-b border-gray-200 pb-2">
                <span class="text-gray-500 text-xs uppercase font-bold">No. Telepon</span>
                <span id="modalPhone" class="text-gray-800 font-medium text-sm"></span>
            </div>
            <div class="flex justify-between pt-1">
                <span class="text-gray-500 text-xs uppercase font-bold">Total Reservasi</span>
                <span id="modalReservasi" class="font-bold text-[#2aa090]"></span>
            </div>
        </div>

        <button onclick="closeDetailModal()" class="mt-6 w-full bg-gray-800 text-white py-2.5 rounded-xl font-bold hover:bg-black transition">
            Tutup
        </button>
    </div>
</div>

<script>
    // Search Function Simple
    document.getElementById('searchUser').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#userTable tbody tr');
        
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });

    function openDetailModal(nama, email, phone, role, reservasi) {
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalEmail').innerText = email;
        document.getElementById('modalPhone').innerText = phone;
        document.getElementById('modalRole').innerText = role;
        document.getElementById('modalReservasi').innerText = reservasi + ' Kali';
        
        // Update Avatar Source
        document.getElementById('modalAvatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=random&color=fff`;
        
        document.getElementById('detailUserModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailUserModal').classList.add('hidden');
    }
</script>
@endsection