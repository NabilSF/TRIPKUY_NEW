<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin TripKuy - @yield('title')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2aa090;
            --primary-dark: #1f7a6e;
            --secondary: #222222;
            --bg-light: #f8fafc;
            --sidebar-width: 260px;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        
        /* Sidebar & Layout */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--secondary) 0%, #333333 100%);
            color: white;
            position: fixed; height: 100vh; z-index: 50; transition: all 0.3s ease;
        }
        .main-content { margin-left: var(--sidebar-width); transition: all 0.3s ease; min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .sidebar.active { transform: translateX(0); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }
    </style>
</head>
<body class="text-gray-800">

    <aside class="sidebar" id="sidebar">
        <div class="p-6 border-b border-white/10 flex items-center gap-3">
            <div class="w-10 h-10 bg-[#2aa090] rounded-lg flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fas fa-hotel"></i>
            </div>
            <div class="font-bold text-xl tracking-wide font-poppins">TRIP<span class="text-[#2aa090]">KUY</span></div>
        </div>
        
        <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-80px)]">
            <div class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 mt-4">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10 hover:text-white transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#2aa090] text-white shadow-md' : '' }}">
                <i class="fas fa-tachometer-alt w-5 text-center"></i> <span>Dashboard</span>
            </a>

            <div class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 mt-6">Manajemen</div>
            <a href="{{ route('admin.managekamar') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10 hover:text-white transition {{ request()->routeIs('admin.managekamar') ? 'bg-[#2aa090] text-white shadow-md' : '' }}">
                <i class="fas fa-bed w-5 text-center"></i> <span>Kamar</span>
            </a>
            <div class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 mt-6">Manajemen</div>

<a href="{{ route('admin.datahotel') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10 hover:text-white transition {{ request()->routeIs('admin.datahotel') ? 'bg-[#2aa090] text-white shadow-md' : '' }}">
    <i class="fas fa-hotel w-5 text-center"></i> <span>Data Hotel</span>
</a>
            <div class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 mt-6">Operasional</div>
            <a href="{{ route('admin.reservasi') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10 hover:text-white transition {{ request()->routeIs('admin.reservasi') ? 'bg-[#2aa090] text-white shadow-md' : '' }}">
                <i class="fas fa-calendar-check w-5 text-center"></i> <span>Reservasi</span>
                <span class="ml-auto bg-[#2aa090] text-white text-[10px] px-2 py-0.5 rounded-full">42</span>
            </a>
            <a href="{{ route('admin.checkinout') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10 hover:text-white transition {{ request()->routeIs('admin.checkinout') ? 'bg-[#2aa090] text-white shadow-md' : '' }}">
                <i class="fas fa-key w-5 text-center"></i> <span>Check In/Out</span>
            </a>
            <a href="{{ route('admin.pelanggan') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10 hover:text-white transition {{ request()->routeIs('admin.pelanggan') ? 'bg-[#2aa090] text-white shadow-md' : '' }}">
                <i class="fas fa-users w-5 text-center"></i> <span>Pelanggan</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="pt-10 pb-4">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-400 hover:bg-red-500/10 transition">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i> <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <div class="main-content">
        <header class="bg-white h-20 px-8 flex items-center justify-between sticky top-0 z-40 shadow-sm">
            <div class="flex items-center gap-4">
                <button id="menuToggle" class="text-gray-500 hover:text-[#2aa090] text-xl lg:hidden transition">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">@yield('header')</h1>
                    <p class="text-xs text-gray-500 hidden sm:block">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-bold text-gray-800">{{ Auth::user()->nama }}</div>
                    <div class="text-xs text-[#2aa090] font-medium">Administrator</div>
                </div>
                <div class="w-10 h-10 rounded-full bg-linear-to-br from-[#2aa090] to-teal-400 flex items-center justify-center text-white font-bold shadow-md">
                    {{ substr(Auth::user()->nama, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-8 grow">
            @yield('content')
        </div>
        
        <footer class="bg-white p-4 text-center text-xs text-gray-400 border-t border-gray-100">
            &copy; {{ date('Y') }} TripKuy Admin Panel. All rights reserved.
        </footer>
    </div>

    <script>
        // Toggle Sidebar Mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>