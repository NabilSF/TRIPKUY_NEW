@extends('layouts.app')

@section('title', 'Daftar Akun - TripKuy')

@section('content')
<div class="flex min-h-[calc(100vh-64px)] bg-white">
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h1>
                <p class="text-sm text-gray-500 mt-2">Gabung TripKuy dan nikmati promo eksklusif</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="John Doe" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="nama@email.com" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No Telepon</label>
                    <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="0812..." required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="••••••" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Konfirmasi</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none" placeholder="••••••" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primaryDark text-white py-3 rounded-xl font-bold shadow-lg transition transform hover:-translate-y-0.5 mt-4">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Login</a>
            </p>
        </div>
    </div>

    <div class="hidden lg:block w-1/2 relative">
        <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=1200&q=80" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gray-900/40"></div>
        <div class="absolute bottom-20 left-16 right-16 text-white">
            <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20">
                <p class="text-xl font-medium italic">"Pengalaman booking hotel paling mudah yang pernah saya coba. Harganya transparan dan banyak promo menarik!"</p>
                <div class="mt-4 flex items-center gap-3">
                    <img src="https://i.pravatar.cc/100?img=5" class="w-10 h-10 rounded-full border-2 border-white">
                    <span class="font-bold">Sarah J. - Traveler</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection