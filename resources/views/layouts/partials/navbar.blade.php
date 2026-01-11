<nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300" x-data="{ open: false, userOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30 group-hover:bg-primaryDark transition-all duration-300">
                    <i class="fas fa-suitcase-rolling"></i>
                </div>
                <span class="text-2xl font-bold text-gray-800 tracking-tight">Trip<span class="text-primary">Kuy</span></span>
            </a>

            <div class="hidden md:flex items-center space-x-1">
                
                <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary rounded-full hover:bg-gray-50 transition-all {{ request()->routeIs('home') ? 'text-primary bg-primary/5' : '' }}">
                    Home
                </a>
                <a href="{{ route('blog') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary rounded-full hover:bg-gray-50 transition-all {{ request()->routeIs('blog') ? 'text-primary bg-primary/5' : '' }}">
                    Blog
                </a>

                <div class="h-6 w-px bg-gray-200 mx-3"></div>

                @guest
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-primary transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-primary hover:bg-primaryDark text-white text-sm font-semibold rounded-full shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                            Daftar
                        </a>
                    </div>
                @endguest

                @auth
                    @if(Auth::user()->role === 'user')
                        <a href="{{ route('user.reservasi') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary rounded-full hover:bg-gray-50 transition-all mr-2">
                            <i class="fas fa-search-location"></i> Cek Reservasi
                        </a>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-5 py-2 bg-red-50 text-red-600 text-sm font-semibold rounded-full border border-red-100 hover:bg-red-100 hover:shadow-sm transition-all mr-2">
                            <i class="fas fa-shield-alt"></i> Panel Admin
                        </a>
                    @endif

                    <div class="relative ml-1" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-full border border-gray-200 bg-white hover:border-primary/50 hover:shadow-md transition-all duration-300">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 border border-white shadow-inner">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 max-w-25 truncate">{{ Auth::user()->nama }}</span>
                            <div class="w-6 h-6 rounded-full bg-gray-50 flex items-center justify-center">
                                <i class="fas fa-chevron-down text-[10px] text-gray-400 transition-transform duration-300" :class="{'rotate-180': dropdownOpen}"></i>
                            </div>
                        </button>
                        
                        <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="absolute right-0 top-full mt-2 w-60 bg-white rounded-2xl shadow-xl ring-1 ring-black/5 z-50" style="display: none;">
                            <div class="px-5 py-4 border-b border-gray-50 bg-gray-50/50 rounded-t-2xl">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Login Sebagai</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-flex mt-2 items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide {{ Auth::user()->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                            
                            <div class="p-2 space-y-1">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 rounded-xl hover:bg-gray-50 hover:text-primary transition-colors">
                                        <i class="fas fa-tachometer-alt w-4 text-center"></i> Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 rounded-xl hover:bg-gray-50 hover:text-primary transition-colors">
                                        <i class="fas fa-user-circle w-4 text-center"></i> Profil Saya
                                    </a>
                                    <a href="{{ route('user.reservasi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 rounded-xl hover:bg-gray-50 hover:text-primary transition-colors">
                                        <i class="fas fa-history w-4 text-center"></i> Riwayat
                                    </a>
                                @endif
                                
                                <div class="h-px bg-gray-100 my-1 mx-2"></div>
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 rounded-xl hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt w-4 text-center"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            <div class="flex md:hidden items-center gap-4">
                <button @click="open = !open" class="text-gray-500 hover:text-primary transition p-2 rounded-lg hover:bg-gray-100 focus:outline-none">
                    <i class="fas fa-bars text-xl" x-show="!open"></i>
                    <i class="fas fa-times text-xl" x-show="open" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-lg" style="display: none;">
        <div class="px-4 pt-4 pb-6 space-y-2">
            
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 {{ request()->routeIs('home') ? 'bg-primary/5 text-primary' : '' }}">
                <i class="fas fa-home w-6 text-center mr-2"></i> Home
            </a>
            <a href="{{ route('blog') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 {{ request()->routeIs('blog') ? 'bg-primary/5 text-primary' : '' }}">
                <i class="fas fa-newspaper w-6 text-center mr-2"></i> Blog
            </a>

            <div class="border-t border-gray-100 my-2"></div>

            @guest
                <div class="grid grid-cols-2 gap-4 px-2 mt-4">
                    <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center px-4 py-3 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primaryDark shadow-md">
                        Daftar
                    </a>
                </div>
            @endguest

            @auth
                <div class="px-4 py-3 bg-gray-50 rounded-xl mt-2 mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-500 border border-gray-200 shadow-sm">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="overflow-hidden">
                            <div class="font-bold text-gray-800 truncate">{{ Auth::user()->nama }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->role === 'user')
                    <a href="{{ route('user.profile') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50">
                        <i class="fas fa-user-circle w-6 text-center mr-2"></i> Profil Saya
                    </a>
                    <a href="{{ route('user.reservasi') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50">
                        <i class="fas fa-history w-6 text-center mr-2"></i> Riwayat Booking
                    </a>
                @endif

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-red-600 bg-red-50 hover:bg-red-100">
                        <i class="fas fa-shield-alt w-6 text-center mr-2"></i> Panel Admin
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-base font-medium text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt w-6 text-center mr-2"></i> Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<script src="//unpkg.com/alpinejs" defer></script>