<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Aplikasi & Kaleidoskop - SIDAJU SDA Jakarta Utara</title>

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
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .hero-pattern {
            background-color: #0f172a;
            background-image: radial-gradient(at 0% 0%, hsla(199,89%,48%,0.3) 0px, transparent 50%),
                              radial-gradient(at 100% 100%, hsla(199,89%,38%,0.3) 0px, transparent 50%),
                              radial-gradient(at 100% 0%, hsla(217,91%,60%,0.2) 0px, transparent 50%);
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-primary-500 selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-600 to-primary-400 overflow-hidden border border-primary-200 shadow-lg shadow-primary-500/30">
                        <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo SIDAJU" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="font-display font-bold text-xl leading-none text-slate-800 tracking-wide">SDA JAKUT</h1>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/') }}" class="text-slate-600 hover:text-primary-600 font-semibold transition-colors">Kembali ke Beranda</a>
                    <a href="#portal" class="text-slate-600 hover:text-primary-600 font-semibold transition-colors">Portal Aplikasi</a>
                    <a href="#kegiatan" class="text-slate-600 hover:text-primary-600 font-semibold transition-colors">Kaleidoskop</a>
                </div>

                <!-- Action Button -->
                <div class="hidden md:flex items-center">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-full bg-slate-900 text-white font-semibold text-sm hover:bg-slate-800 hover:shadow-lg transition-all duration-300">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full border-2 border-slate-200 text-slate-700 font-semibold text-sm hover:border-primary-500 hover:text-primary-600 transition-all duration-300">
                            Login Admin
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 hero-pattern overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-white/10 text-primary-200 border border-white/20 mb-6 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                Sistem Terintegrasi v2.0
            </span>
            <h1 class="text-5xl lg:text-7xl font-display font-bold text-white mb-8 tracking-tight leading-tight">
                Gerbang <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-300 to-cyan-300">Layanan Digital</span> <br class="hidden lg:block"> SDA Jakarta Utara
            </h1>
            <p class="mt-4 text-xl text-slate-300 max-w-3xl mx-auto font-medium mb-10 leading-relaxed">
                Pusat informasi, transparansi kegiatan, dan portal integrasi seluruh aplikasi operasional Suku Dinas Sumber Daya Air Kota Administrasi Jakarta Utara.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#portal" class="px-8 py-4 rounded-full bg-primary-500 text-white font-bold text-lg hover:bg-primary-600 hover:shadow-xl hover:shadow-primary-500/20 transition-all duration-300">
                    Jelajahi Aplikasi
                </a>
                <a href="#kegiatan" class="px-8 py-4 rounded-full bg-white/10 text-white border border-white/20 font-bold text-lg hover:bg-white/20 backdrop-blur-md transition-all duration-300">
                    Lihat Laporan
                </a>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="absolute bottom-0 w-full leading-none z-20 translate-y-[1px]">
            <svg class="block w-full h-12 md:h-24 lg:h-32" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118,137.31,120.73,205,108.6,245.54,101.44,284.15,81.42,321.39,56.44Z" class="fill-slate-50"></path>
            </svg>
        </div>
    </section>

    <!-- Portal Aplikasi Section -->
    <section id="portal" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-sm font-bold text-primary-600 uppercase tracking-widest mb-2">Ekosistem Digital</h2>
                <h3 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-4">Portal Aplikasi Terintegrasi</h3>
                <p class="text-lg text-slate-600 font-medium">Kumpulan aplikasi internal dan publik yang mendukung operasional tata kelola air secara pintar, cepat, dan transparan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($portals as $portal)
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden group flex flex-col h-full">
                        
                        <!-- Image Container -->
                        <div class="relative h-56 overflow-hidden bg-slate-100">
                            @if($portal->images->count() > 0)
                                <img src="{{ asset('storage/portals/' . $portal->images->first()->image_path) }}" alt="{{ $portal->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur text-xs font-bold text-slate-800 rounded-full shadow-sm">
                                    Aplikasi Web
                                </span>
                            </div>
                        </div>

                        <!-- Content Container -->
                        <div class="p-8 flex-1 flex flex-col">
                            <h4 class="text-xl font-display font-bold text-slate-900 mb-3 group-hover:text-primary-600 transition-colors">{{ $portal->title }}</h4>
                            
                            <!-- Description (Stripped & Truncated) -->
                            <div class="text-slate-600 text-sm mb-8 line-clamp-3 font-medium">
                                {!! Str::limit(strip_tags($portal->description), 150) !!}
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ $portal->url }}" target="_blank" class="inline-flex items-center justify-center w-full px-6 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-primary-600 transition-colors duration-300 shadow-md">
                                    Buka Aplikasi
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500 font-medium bg-white rounded-3xl border border-dashed border-slate-300">
                        Belum ada portal aplikasi yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Divider Line -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-slate-200">
    </div>

    <!-- Kaleidoskop Kegiatan Section -->
    <section id="kegiatan" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-sm font-bold text-primary-600 uppercase tracking-widest mb-2">Transparansi Kinerja</h2>
                    <h3 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-4">Kaleidoskop Laporan</h3>
                    <p class="text-lg text-slate-600 font-medium">Dokumentasi operasional, pemeliharaan infrastruktur, dan penanganan masalah secara real-time di lapangan.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($articles as $article)
                    <article class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg transition-shadow overflow-hidden flex flex-col group">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden bg-slate-100">
                            @if($article->images->count() > 0)
                                <img src="{{ asset('storage/articles/' . $article->images->first()->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center text-xs font-bold text-primary-600 mb-3 uppercase tracking-wider">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $article->activity_date ? $article->activity_date->translatedFormat('d M Y') : 'Tanpa Tanggal' }}
                            </div>
                            <h4 class="text-xl font-display font-bold text-slate-900 mb-3 line-clamp-2 leading-tight">
                                <a href="{{ route('articles.show', $article) }}" class="hover:text-primary-600 transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h4>
                            
                            <div class="mt-auto pt-6">
                                <a href="{{ route('articles.show', $article) }}" class="inline-flex items-center text-sm font-bold text-slate-900 hover:text-primary-600 transition-colors">
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4 ml-1.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500 font-medium bg-white rounded-3xl border border-dashed border-slate-300">
                        Belum ada laporan kegiatan yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h1 class="font-display font-bold text-lg leading-none text-white tracking-wide">SDA JAKUT</h1>
                    <p class="text-xs font-medium text-slate-500 mt-1">Suku Dinas Sumber Daya Air</p>
                </div>
            </div>
            
            <div class="text-sm font-medium">
                &copy; {{ date('Y') }} Suku Dinas SDA Kota Administrasi Jakarta Utara. <br class="md:hidden"> Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

</body>
</html>
