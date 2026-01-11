@extends('layouts.app')

@section('title', 'TripKuy - Jelajahi Keindahan Indonesia')

@section('content')

<div class="relative h-150 flex items-center justify-center bg-gray-900 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1920&q=80" 
             alt="Luxury Hotel" 
             class="w-full h-full object-cover opacity-60 scale-105 animate-slow-zoom">
        <div class="absolute inset-0 bg-linear-to-b from-black/80 via-black/20 to-gray-50"></div>
    </div>

    <div class="relative z-10 w-full max-w-5xl px-4 text-center -mt-5">
        <div class="inline-block px-5 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-bold tracking-widest uppercase mb-6 shadow-lg animate-fade-in-up">
            #1 Platform Booking Indonesia
        </div>
        <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-8 drop-shadow-2xl tracking-tight leading-tight animate-fade-in-up animation-delay-100 font-sans">
            Wujudkan Liburan<br>
            <span class="text-transparent bg-clip-text bg-linear-to-r from-primary to-teal-300">Impianmu Sekarang</span>
        </h1>
        
        <div class="animate-fade-in-up animation-delay-200">
            <button onclick="document.getElementById('rekomendasi').scrollIntoView({behavior: 'smooth'})" 
                    class="bg-primary hover:bg-primary-dark text-white font-bold py-4 px-10 rounded-full transition-all shadow-lg hover:shadow-primary/50 flex items-center justify-center gap-3 mx-auto group active:scale-95 border-2 border-transparent hover:border-white/20">
                <span class="text-lg">Mulai Eksplorasi</span> 
                <i class="fas fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
            </button>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
    <div class="text-center md:text-left mb-10">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Jelajahi Kota Favorit</h2>
        <p class="text-gray-500 mt-2 text-lg">Inspirasi destinasi lokal paling hits untukmu</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @php
            $destinasi = [
                ['kota' => 'Jakarta', 'desc' => 'Metropolitan, Bisnis & Hiburan Malam', 'img' => 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=600&q=80'],
                ['kota' => 'Bali', 'desc' => 'Surga Pantai, Budaya & Relaksasi', 'img' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=80'],
                ['kota' => 'Yogyakarta', 'desc' => 'Kota Pelajar, Seni & Sejarah', 'img' => 'https://images.unsplash.com/photo-1584810359583-96fc3448beaa?auto=format&fit=crop&w=600&q=80'],
                ['kota' => 'Solo', 'desc' => 'Jantung Budaya Jawa & Batik', 'img' => 'https://i.pinimg.com/736x/eb/d2/f6/ebd2f686f9052f43589510110024dbdd.jpg'],
                ['kota' => 'Surabaya', 'desc' => 'Kota Pahlawan & Kuliner Pedas', 'img' => 'https://i.pinimg.com/736x/87/b6/ed/87b6ed1b600d6c414506030cae840ecc.jpg'],
                ['kota' => 'Malang', 'desc' => 'Sejuk, Apel & Pegunungan', 'img' => 'https://i.pinimg.com/1200x/a3/f9/b0/a3f9b0c52da6c429f12e9fc1895be997.jpg'],
            ];
        @endphp

        @foreach($destinasi as $d)
        <div class="group relative h-80 rounded-4xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 cursor-default">
            <img src="{{ $d['img'] }}" alt="{{ $d['kota'] }}" class="absolute inset-0 w-full h-full object-cover transition duration-1000 group-hover:scale-110">
            <div class="absolute inset-0 bg-linear-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-90 transition duration-500"></div>
            
            <div class="absolute bottom-0 left-0 p-8 w-full translate-y-2 group-hover:translate-y-0 transition duration-500">
                <h3 class="text-2xl font-bold text-white mb-2 tracking-wide">{{ $d['kota'] }}</h3>
                <div class="w-12 h-1 bg-primary rounded-full mb-3"></div>
                <p class="text-sm text-gray-300 font-medium opacity-90 group-hover:text-white transition">{{ $d['desc'] }}</p>
            </div>
            
            <div class="absolute top-4 right-4 bg-white/10 backdrop-blur-md p-2 rounded-full opacity-0 group-hover:opacity-100 transition duration-500 border border-white/20">
                <i class="fas fa-map-pin text-white"></i>
            </div>
        </div>
        @endforeach
    </div>
</div>

@php
    // Logic Data Hotel
    if (!isset($hotels) || $hotels->isEmpty()) {
        // Dummy data jika DB kosong
        $hotelsData = collect([
            (object)['id'=>1, 'nama_hotel'=>'The Langham Jakarta', 'alamat'=>'Jakarta Selatan', 'price'=>2500000],
            (object)['id'=>2, 'nama_hotel'=>'Padma Hotel Bandung', 'alamat'=>'Ciumbuleuit, Bandung', 'price'=>1800000],
            (object)['id'=>3, 'nama_hotel'=>'Ayana Resort Bali', 'alamat'=>'Jimbaran, Bali', 'price'=>3500000],
            (object)['id'=>4, 'nama_hotel'=>'Hotel Tentrem', 'alamat'=>'Yogyakarta', 'price'=>1500000],
        ]);
        $isDummy = true;
    } else {
        $hotelsData = $hotels;
        $isDummy = false;
    }
@endphp

<div id="rekomendasi" class="bg-white py-20 mt-12 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">Rekomendasi Spesial</h2>
                <p class="text-gray-500 mt-2 text-lg">Akomodasi terbaik dengan rating tinggi</p>
            </div>
            
            <div class="hidden md:flex gap-4">
                <button onclick="scrollContainer('cardSlider', -1)" class="w-12 h-12 rounded-full border-2 border-gray-100 flex items-center justify-center hover:bg-primary hover:border-primary hover:text-white transition-all shadow-sm bg-white text-gray-400 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                </button>
                <button onclick="scrollContainer('cardSlider', 1)" class="w-12 h-12 rounded-full border-2 border-gray-100 flex items-center justify-center hover:bg-primary hover:border-primary hover:text-white transition-all shadow-sm bg-white text-gray-400 group">
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>
        </div>

        <div id="cardSlider" class="flex gap-8 overflow-x-auto pb-12 scroll-smooth no-scrollbar snap-x snap-mandatory px-2 pt-2">
            @foreach($hotelsData as $h)
                @php
                    if(!$isDummy) {
                        // --- PERBAIKAN: Gunakan $h->id ---
                        if ($h->gambar && file_exists(public_path('storage/' . $h->gambar))) {
                            $imageUrl = asset('storage/' . $h->gambar);
                        } 
                        elseif (file_exists(public_path('images/hotel_' . $h->id . '.jpg'))) {
                            $imageUrl = asset('images/hotel_' . $h->id . '.jpg');
                        }
                        else {
                            $imageUrl = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80';
                        }

                        $kamarTermurah = $h->tipeKamars->sortBy('harga')->first();
                        $priceRaw = $kamarTermurah ? $kamarTermurah->harga : 0;
                        $tersedia = $kamarTermurah ? true : false;
                    } else {
                        // PERBAIKAN: Gunakan $h->id pada sig
                        $imageUrl = 'https://source.unsplash.com/400x300/?hotel,modern&sig=' . $h->id;
                        $priceRaw = $h->price;
                        $tersedia = true;
                    }
                    $fakeRating = number_format(rand(45, 50) / 10, 1);
                @endphp

                {{-- PERBAIKAN: id_hotel -> id --}}
                <div class="min-w-[280px] w-[280px] bg-white rounded-3xl shadow-[0_10px_40px_-15px_rgba(0,0,0,0.1)] hover:shadow-[0_20px_50px_-15px_rgba(42,160,144,0.3)] transition-all duration-300 border border-gray-50 shrink-0 snap-start group cursor-pointer relative hover:-translate-y-2" onclick="window.location='{{ route('detail', $h->id) }}'">
                    
                    <div class="relative h-48 overflow-hidden rounded-t-3xl">
                        <img src="{{ $imageUrl }}" alt="{{ $h->nama_hotel }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        
                        @if($tersedia)
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur text-primary text-[10px] font-bold px-3 py-1.5 rounded-full shadow-md tracking-wide flex items-center gap-1">
                                <i class="fas fa-tag"></i> PROMO
                            </div>
                        @endif
                        
                        <div class="absolute bottom-4 right-4 bg-gray-900/80 backdrop-blur-md px-3 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-lg text-white">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> {{ $fakeRating }}
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 truncate mb-1 group-hover:text-primary transition-colors">{{ $h->nama_hotel }}</h3>
                        <p class="text-xs text-gray-400 mb-5 flex items-center gap-1.5 truncate font-medium">
                            <i class="fas fa-map-marker-alt text-primary"></i> {{ $h->alamat }}
                        </p>
                        
                        <div class="flex justify-between items-end border-t border-dashed border-gray-200 pt-4">
                            @if($tersedia)
                                <div>
                                    <p class="text-[10px] text-gray-400 mb-0.5 font-medium uppercase tracking-wide">Mulai dari</p>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-300 line-through">Rp {{ number_format($priceRaw * 1.3, 0, ',', '.') }}</span>
                                        <div class="text-lg font-extrabold text-primary">Rp {{ number_format($priceRaw, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="text-xs font-bold text-gray-400 mt-2 italic">Cek Ketersediaan</div>
                            @endif
                            
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-300 shadow-sm">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@php
    $reviews = [
        ['name' => 'Sarah Wijaya', 'role' => 'Business Traveler', 'text' => 'Proses booking sangat cepat dan harga transparan. Sangat membantu perjalanan bisnis saya.', 'avatar' => 'https://i.pravatar.cc/100?img=5'],
        ['name' => 'Dimas Anggara', 'role' => 'Backpacker', 'text' => 'Aplikasi terbaik untuk cari hidden gem hotel. Fitur filternya lengkap banget!', 'avatar' => 'https://i.pravatar.cc/100?img=12'],
        ['name' => 'Rina Kartika', 'role' => 'Family Vacation', 'text' => 'Liburan keluarga jadi tenang karena rekomendasi hotelnya ramah anak.', 'avatar' => 'https://i.pravatar.cc/100?img=9'],
        ['name' => 'Budi Santoso', 'role' => 'Traveler', 'text' => 'Banyak promo menarik buat budget traveler kayak saya. Mantap TripKuy!', 'avatar' => 'https://i.pravatar.cc/100?img=11'],
    ];
@endphp

<div class="bg-[#f8f9fa] py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900">Apa Kata Mereka?</h2>
                <p class="text-gray-500 mt-2 text-lg max-w-xl">Kami bangga menjadi bagian dari perjalanan ribuan pelanggan yang puas.</p>
            </div>
            
            <div class="hidden md:flex gap-3">
                <button onclick="scrollContainer('reviewSlider', -1)" class="w-10 h-10 bg-white rounded-full shadow-sm border border-gray-200 flex items-center justify-center text-gray-600 hover:text-primary transition group">
                    <i class="fas fa-arrow-left text-sm"></i>
                </button>
                <button onclick="scrollContainer('reviewSlider', 1)" class="w-10 h-10 bg-white rounded-full shadow-sm border border-gray-200 flex items-center justify-center text-gray-600 hover:text-primary transition group">
                    <i class="fas fa-arrow-right text-sm"></i>
                </button>
            </div>
        </div>

        <div id="reviewSlider" class="flex gap-6 overflow-x-auto pb-8 scroll-smooth no-scrollbar snap-x snap-mandatory px-1">
            @foreach($reviews as $review)
            <div class="min-w-[320px] w-[320px] bg-white p-8 rounded-4xl shadow-sm border border-gray-100 snap-center shrink-0 hover:shadow-xl transition duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ $review['avatar'] }}" alt="{{ $review['name'] }}" class="w-14 h-14 rounded-full border-2 border-primary/20 p-0.5">
                    <div>
                        <h4 class="font-bold text-gray-900 text-base">{{ $review['name'] }}</h4>
                        <span class="text-[11px] text-primary font-bold uppercase tracking-wider bg-primary/5 px-3 py-1 rounded-full mt-1 inline-block">{{ $review['role'] }}</span>
                    </div>
                </div>
                <div class="flex text-yellow-400 text-xs mb-4 space-x-1">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 text-sm italic leading-relaxed">"{{ $review['text'] }}"</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="tentang-kami" class="py-24 bg-white border-t border-gray-50 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-64 h-64 bg-primary/5 rounded-full -ml-32 -mt-32 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-400/5 rounded-full -mr-32 -mb-32 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div class="relative group">
                <div class="absolute inset-0 bg-primary rounded-4xl rotate-6 opacity-20 group-hover:rotate-3 transition duration-500"></div>
                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80" 
                     alt="Tentang TripKuy" 
                     class="relative rounded-4xl shadow-2xl w-full object-cover h-[400px] group-hover:scale-[1.02] transition duration-500">
                
                <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-2xl shadow-xl border border-gray-100 hidden md:block animate-bounce-slow">
                    <p class="text-sm text-gray-500 font-bold uppercase tracking-wider mb-1">Pengalaman</p>
                    <p class="text-4xl font-extrabold text-primary">5+ Tahun</p>
                </div>
            </div>

            <div>
                <span class="text-primary font-bold tracking-widest uppercase text-sm mb-2 block">Tentang Kami</span>
                <h2 class="text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                    Partner Perjalanan <br>Terbaik Keliling Indonesia
                </h2>
                <p class="text-gray-500 text-lg mb-6 leading-relaxed">
                    TripKuy hadir dengan misi sederhana: membuat keindahan Indonesia dapat diakses oleh siapa saja. Kami menghubungkan traveler dengan ribuan hotel dan destinasi lokal dengan harga yang jujur dan transparan.
                </p>
                
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-primary mt-1"></i>
                        <span class="text-gray-600">Garansi harga terbaik tanpa biaya tersembunyi.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-primary mt-1"></i>
                        <span class="text-gray-600">Layanan pelanggan 24/7 siap menemani perjalananmu.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-primary mt-1"></i>
                        <span class="text-gray-600">Pembayaran aman & terpercaya dengan teknologi enkripsi.</span>
                    </li>
                </ul>

                <a href="{{ route('blog') }}" class="inline-flex items-center text-primary font-bold hover:text-primary-dark transition group">
                    Baca Cerita Perjalanan Kami 
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        @guest
            <div class="bg-primary rounded-[2.5rem] p-8 md:p-16 flex flex-col md:flex-row items-center justify-between relative overflow-hidden shadow-2xl shadow-primary/40 group">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-20 -mt-20 pointer-events-none blur-3xl group-hover:bg-white/15 transition duration-700"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/10 rounded-full -ml-20 -mb-20 pointer-events-none blur-3xl group-hover:bg-white/15 transition duration-700"></div>

                <div class="relative z-10 md:w-2/3 text-center md:text-left text-white">
                    <h2 class="text-3xl md:text-5xl font-extrabold mb-6 leading-tight">Gabung Member VIP <br>TripKuy Sekarang!</h2>
                    <p class="text-white/90 text-base md:text-lg mb-10 max-w-lg leading-relaxed font-light">
                        Nikmati diskon eksklusif hingga <span class="font-bold">30%</span>, prioritas check-in, dan akses promo rahasia. Gratis selamanya!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-5 justify-center md:justify-start">
                        <a href="{{ route('register') }}" class="bg-white text-primary px-10 py-4 rounded-2xl font-bold text-base shadow-xl hover:shadow-2xl hover:bg-gray-50 transition transform hover:-translate-y-1">
                            Daftar Gratis
                        </a>
                        <a href="{{ route('login') }}" class="px-10 py-4 rounded-2xl font-bold text-base border-2 border-white/30 hover:bg-white/10 transition backdrop-blur-sm">
                            Masuk Akun
                        </a>
                    </div>
                </div>
                
                <div class="relative z-10 md:w-1/3 mt-12 md:mt-0 flex justify-center">
                    <div class="w-32 h-32 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center shadow-2xl border border-white/20 animate-bounce-slow">
                        <i class="fas fa-gift text-6xl text-white"></i>
                    </div>
                </div>
            </div>
        @endguest

      @auth
            @if(Auth::user()->role === 'user')
                <div class="bg-gray-900 rounded-[2.5rem] p-8 md:p-16 flex flex-col md:flex-row items-center justify-between relative overflow-hidden shadow-2xl">
                    <div class="absolute inset-0 bg-linear-to-r from-gray-900 to-gray-800"></div>
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#6b7280 1px, transparent 1px); background-size: 24px 24px;"></div>
                    
                    <div class="relative z-10 md:w-2/3 text-center md:text-left text-white">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/20 text-primary text-xs font-bold uppercase tracking-wider rounded-full mb-4 border border-primary/20">
                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Member Access
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Mau liburan ke mana lagi,<br>{{ Auth::user()->nama }}?</h2>
                        <p class="text-gray-400 text-base mb-10 max-w-lg leading-relaxed">
                            Kelola perjalananmu dengan mudah. Akses tiket, riwayat pesanan, dan fitur check-in online dalam satu tempat.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                            <a href="{{ route('user.reservasi') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-bold text-base shadow-lg hover:bg-primary-dark transition flex items-center justify-center gap-3 group">
                                <i class="fas fa-ticket-alt group-hover:rotate-12 transition-transform"></i> Cek Booking Saya
                            </a>
                            <a href="{{ route('user.checkin') }}" class="bg-white/10 backdrop-blur text-white border border-white/20 px-8 py-4 rounded-2xl font-bold text-base hover:bg-white/20 transition flex items-center justify-center gap-3 group">
                                <i class="fas fa-key text-primary"></i> Check-in Online
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative z-10 md:w-1/3 mt-10 md:mt-0 flex justify-center opacity-80">
                        <i class="fas fa-plane-departure text-9xl text-gray-700"></i>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>

<script>
    function scrollContainer(containerId, direction) {
        const container = document.getElementById(containerId);
        if (container) {
            const firstCard = container.firstElementChild;
            const scrollAmount = firstCard ? firstCard.offsetWidth + 30 : 300; 
            
            if(direction === 1) {
                container.scrollLeft += scrollAmount;
            } else {
                container.scrollLeft -= scrollAmount;
            }
        }
    }
</script>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    @keyframes slow-zoom {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    .animate-slow-zoom {
        animation: slow-zoom 20s infinite alternate linear;
    }
    
    @keyframes fade-in-up {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out forwards;
    }
    
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(-5%); }
        50% { transform: translateY(5%); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s infinite ease-in-out;
    }
    
    .animation-delay-100 { animation-delay: 0.1s; }
    .animation-delay-200 { animation-delay: 0.2s; }
</style>

@endsection