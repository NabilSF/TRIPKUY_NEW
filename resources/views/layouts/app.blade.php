<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TripKuy - Booking Hotel Murah & Nyaman')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans text-secondary antialiased selection:bg-primary selection:text-white">

    @include('layouts.partials.navbar')

    <main class="grow pt-20">
        @yield('content')
    </main>

    <footer class="bg-gray-900 border-t border-gray-800 pt-16 pb-8 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                        <div class="w-10 h-10 bg-[#2aa090] rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-[#2aa090]/30">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <span class="text-2xl font-extrabold text-white tracking-tight">TripKuy</span>
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Platform booking hotel dan wisata nomor #1 di Indonesia. Wujudkan liburan impianmu dengan mudah dan hemat.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-6">Perusahaan</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li>
                            {{-- Link Anchor ke section di Home --}}
                            <a href="{{ route('home') }}#tentang-kami" class="hover:text-[#2aa090] transition flex items-center gap-2">
                                Tentang Kami
                            </a>
                        </li>
                        <li>
                            {{-- Link ke Halaman Blog --}}
                            <a href="{{ route('blog') }}" class="hover:text-[#2aa090] transition">
                                Blog & Inspirasi
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-6">Bantuan</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#2aa090] transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-[#2aa090] transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-[#2aa090] transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-[#2aa090] mt-1"></i>
                            <span>Dusun II, Makamhaji, Kec. Kartasura<br>Sukoharjo, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-[#2aa090]"></i>
                            <span>support@tripkuy.com</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-[#2aa090]"></i>
                            <span>+62 812 3332 9103</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-gray-500">© 2026 TripKuy Indonesia. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#2aa090] hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#2aa090] hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-[#2aa090] hover:text-white transition"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>