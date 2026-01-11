@extends('layouts.app')

@section('title', 'Blog & Inspirasi Wisata')

@section('content')

<div class="bg-[#f8f9fa] py-16 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="text-[#2aa090] font-bold tracking-widest uppercase text-xs mb-2 block">TripKuy Blog</span>
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Jelajahi Inspirasi <br>Liburan Tak Terlupakan</h1>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto mb-8">Temukan rekomendasi destinasi, tips traveling hemat, hingga review hotel terbaru langsung dari para ahli perjalanan.</p>
        
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">
    
    <div class="flex flex-wrap justify-center gap-3 mb-12">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16 items-center">
        <div class="rounded-2xl overflow-hidden h-[400px] shadow-lg group cursor-pointer relative">
            <img src="{{ $articles[0]['image'] }}" alt="Featured" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-xs font-bold text-[#2aa090]">
                TRENDING
            </div>
        </div>
        <div class="md:pl-6">
            <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                <span class="text-[#2aa090] font-bold uppercase tracking-wider">{{ $articles[0]['category'] }}</span>
                <span>•</span>
                <span>{{ $articles[0]['date'] }}</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 hover:text-[#2aa090] transition cursor-pointer">
                {{ $articles[0]['title'] }}
            </h2>
            <p class="text-gray-500 text-lg mb-6 leading-relaxed">
                {{ $articles[0]['excerpt'] }}
            </p>
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($articles[0]['author']) }}&background=random" class="w-10 h-10 rounded-full">
                <div>
                    <p class="text-sm font-bold text-gray-900">{{ $articles[0]['author'] }}</p>
                    <p class="text-xs text-gray-500">Travel Enthusiast</p>
                </div>
            </div>
        </div>
    </div>

   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach(array_slice($articles, 1) as $article)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 group flex flex-col h-full">
            <div class="relative h-56 overflow-hidden">
                
             
                @php
                    $imageUrl = $article['image']; 

                    if (str_contains($article['title'], 'Solo Safari')) {
                        $imageUrl = 'https://i.pinimg.com/736x/bf/90/c0/bf90c0737fc32ffe1be0f2917df9b2cb.jpg';
                    }
                @endphp
                <img src="{{ $imageUrl }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                
                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2 py-1 rounded text-[10px] font-bold text-gray-800">
                    {{ $article['category'] }}
                </div>
            </div>
            <div class="p-6 flex flex-col grow">
                <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                    <i class="far fa-calendar-alt"></i> {{ $article['date'] }}
                    <span>•</span>
                    <i class="far fa-user"></i> {{ $article['author'] }}
                </div>
                <h3 class="font-bold text-xl text-gray-800 mb-3 line-clamp-2 group-hover:text-[#2aa090] transition">
                    {{ $article['title'] }}
                </h3>
                <p class="text-sm text-gray-500 line-clamp-3 mb-4 grow">
                    {{ $article['excerpt'] }}
                </p>
                <a href="#" class="text-[#2aa090] font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all mt-auto">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-20 bg-[#2aa090] rounded-3xl p-8 md:p-16 text-center relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-white mb-4">Jangan Lewatkan Promo & Tips Terbaru!</h2>
            <p class="text-white/80 mb-8 max-w-xl mx-auto">Berlangganan newsletter TripKuy untuk mendapatkan info diskon hotel dan rekomendasi wisata langsung ke emailmu.</p>
            
            <div class="max-w-md mx-auto flex gap-2">
                <input type="email" placeholder="Masukkan email Anda" class="w-full px-4 py-3 rounded-xl focus:outline-none text-gray-800">
                <button class="bg-gray-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-black transition">Gabung</button>
            </div>
        </div>
        
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full -ml-32 -mt-32"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mb-32"></div>
    </div>

</div>
@endsection