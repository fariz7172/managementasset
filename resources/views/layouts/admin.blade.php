<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - SIDAJU Jakarta Utara</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.ico') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: '#0f172a',
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-primary-500 selection:text-white flex overflow-hidden h-screen">

    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col transition-all duration-300 z-20 shrink-0" id="sidebar">
        <!-- Sidebar Header -->
        <div class="h-20 flex items-center px-8 border-b border-slate-100">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-600 to-primary-400 shadow-lg shadow-primary-500/30 overflow-hidden border border-primary-200">
                    <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo SIDAJU" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="font-display font-bold text-lg leading-none text-slate-800 tracking-wide">SIDAJU JAKUT</h1>
                    <p class="text-xs font-medium text-slate-500">Admin Panel</p>
                </div>
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
            <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} rounded-xl font-medium transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            <!-- Group 1: Monitoring -->
            <div x-data="{ open: {{ request()->routeIs(['admin.monitoring.*', 'admin.monitoring-reses.*', 'admin.payments.*']) ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-slate-600 hover:bg-slate-100 hover:text-slate-900 rounded-xl font-medium transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        Monitoring
                    </div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse class="pl-11 pr-2 space-y-1 mt-1">
                    <a href="{{ route('admin.monitoring.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.monitoring.index') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Monitoring Map
                    </a>
                    <a href="{{ route('admin.monitoring-reses.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.monitoring-reses.index') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Monitoring RESES
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.payments.index') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Monitoring SPP / SPM
                    </a>
                </div>
            </div>

            <!-- Group 2: Publikasi & Aplikasi -->
            <div x-data="{ open: {{ request()->routeIs(['admin.articles.*', 'admin.portals.*']) ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-slate-600 hover:bg-slate-100 hover:text-slate-900 rounded-xl font-medium transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"></path></svg>
                        Data Aplikasi
                    </div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse class="pl-11 pr-2 space-y-1 mt-1">
                    <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.articles.*') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Kegiatan & Galeri
                    </a>
                    <a href="{{ route('admin.portals.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.portals.*') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Portal Aplikasi
                    </a>
                </div>
            </div>

            <!-- Group 3: Data Master Aset -->
            <div x-data="{ open: {{ request()->routeIs(['admin.pompas.*', 'admin.sub-polders.*', 'admin.pompa-mobiles.*', 'admin.pintu-airs.*']) ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-slate-600 hover:bg-slate-100 hover:text-slate-900 rounded-xl font-medium transition-colors">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                        Data Master Aset
                    </div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-collapse class="pl-11 pr-2 space-y-1 mt-1">
                    <a href="{{ route('admin.pompas.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.pompas.*') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Data Pompa
                    </a>
                    <a href="{{ route('admin.sub-polders.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.sub-polders.*') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Data Sub Polder
                    </a>
                    <a href="{{ route('admin.pompa-mobiles.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.pompa-mobiles.*') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Data Pompa Mobile
                    </a>
                    <a href="{{ route('admin.pintu-airs.index') }}" class="block px-3 py-2 text-sm {{ request()->routeIs('admin.pintu-airs.*') ? 'text-primary-600 font-bold' : 'text-slate-500 hover:text-slate-900' }} rounded-lg transition-colors">
                        Data Pintu Air
                    </a>
                </div>
            </div>

        </nav>
        
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 z-10 shrink-0">
            <!-- Search -->
            <div class="flex-1 max-w-xl">
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="globalSearchInput" class="w-full bg-slate-50 border border-slate-200 rounded-full pl-11 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all font-medium text-slate-800 placeholder:text-slate-400" placeholder="Cari data pompa, aduan, atau kegiatan...">
                </div>
            </div>

            <!-- Profile & Notifications -->
            <div class="flex items-center space-x-6 ml-4">
                <button class="relative text-slate-500 hover:text-primary-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                </button>
                
                <div class="flex items-center gap-3 border-l border-slate-200 pl-6 cursor-pointer">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs font-medium text-slate-500">Super Admin</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-primary-100 border border-primary-200 flex items-center justify-center text-primary-700 font-bold font-display">
                        AD
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-8 bg-slate-50/50 relative">
            
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 mr-3 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <span class="font-bold">Ada beberapa kesalahan:</span>
                        <ul class="list-disc ml-5 mt-1 text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')

            <!-- Footer within main content -->
            <div class="mt-8 pt-4 border-t border-slate-200 text-center md:text-left text-sm text-slate-500 font-medium pb-8">
                &copy; {{ date('Y') }} Power By Tata Usaha Suku Dinas SIDAJU Jakarta Utara. 
            </div>
        </div>
    </main>

    @stack('scripts')
</body>
</html>
