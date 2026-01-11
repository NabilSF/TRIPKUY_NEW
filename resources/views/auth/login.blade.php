@extends('layouts.app')

@section('title', 'Login - TripKuy')

@section('content')
<div class="flex min-h-[calc(100vh-64px)] bg-white">
    <div class="hidden lg:block w-1/2 relative">
        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1200&q=80" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-primary/80 mix-blend-multiply"></div>
        <div class="absolute inset-0 flex flex-col justify-center px-16 text-white">
            <h2 class="text-4xl font-bold mb-4">Selamat Datang Kembali!</h2>
            <p class="text-lg text-white/90">Akses ribuan hotel dengan harga terbaik hanya di TripKuy. Liburan nyaman dimulai dari sini.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-primary/10 text-primary mb-4">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Login Akun</h1>
                <p class="text-sm text-gray-500 mt-2">Masuk untuk mengelola pesanan Anda</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm flex items-start gap-2 border border-red-100">
                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                    <div>
                        <span class="font-bold">Oops!</span> {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-3.5 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition" placeholder="nama@email.com" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-3.5 text-gray-400"></i>
                        <input type="password" name="password" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary outline-none transition" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-primary border-gray-300 focus:ring-primary">
                        <span class="text-gray-600">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primaryDark text-white py-3 rounded-xl font-bold shadow-lg transition transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-8">
                Belum punya akun? <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Daftar Gratis</a>
            </p>
        </div>
    </div>
</div>
@endsection