<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portal Aplikasi Terintegrasi — Gerbang seluruh sistem dan aplikasi operasional Suku Dinas Tata Kelola Air Jakarta Utara.">
    <title>Portal Aplikasi — SIDAJU SDA Jakarta Utara</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0a0f18; }
        ::-webkit-scrollbar-thumb { background: #0ea5e9; border-radius: 3px; }

        .portal-card {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease, border-color 0.3s ease;
        }
        .portal-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 60px -10px rgba(14, 165, 233, 0.2);
            border-color: rgba(14, 165, 233, 0.5);
        }
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.in-view { opacity: 1; transform: translateY(0); }
    </style>
</head>

<body class="bg-slate-950 text-slate-200 antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-slate-950/95 backdrop-blur-md border-b border-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-sky-700 overflow-hidden border border-sky-400 group-hover:bg-sky-600 transition-colors">
                    <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo SIDAJU" class="w-full h-full object-cover">
                </div>
                <div class="leading-tight">
                    <p class="text-white font-extrabold text-sm tracking-wider">SIDAJU</p>
                    <p class="text-sky-400 text-[9px] font-bold tracking-widest uppercase">SDA Jakarta Utara</p>
                </div>
            </a>

            <div class="flex items-center gap-6">
                <a href="{{ route('kaleidoskop') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Kaleidoskop</a>
                <a href="{{ route('portal') }}" class="text-sm font-semibold text-sky-400 border-b-2 border-sky-500 pb-0.5">Portal Aplikasi</a>
                <a href="{{ url('/') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-slate-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="py-20 md:py-28 relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0" style="background: radial-gradient(ellipse at 30% 50%, rgba(14,165,233,0.12) 0%, transparent 60%), radial-gradient(ellipse at 80% 20%, rgba(7,89,133,0.15) 0%, transparent 60%);"></div>
        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(#0ea5e9 1px, transparent 1px), linear-gradient(to right, #0ea5e9 1px, transparent 1px); background-size: 48px 48px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-500/15 border border-sky-500/30 mb-6">
                <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                <span class="text-sky-300 font-bold text-xs tracking-widest uppercase">Ekosistem Digital Terintegrasi</span>
            </div>
            <h1 class="font-serif text-4xl md:text-6xl font-bold text-white mb-5">
                Gerbang Portal Aplikasi
            </h1>
            <p class="text-lg text-slate-400 font-light max-w-2xl leading-relaxed mb-10">
                Akses terpusat ke seluruh sistem dan aplikasi operasional yang mendukung tata kelola air di wilayah Jakarta Utara. Satu gerbang, semua layanan.
            </p>

            <!-- Stats -->
            <div class="flex flex-wrap gap-8 pt-8 border-t border-slate-800">
                <div>
                    <p class="text-3xl font-extrabold font-serif text-white">{{ $portals->count() }}</p>
                    <p class="text-slate-500 text-xs font-semibold tracking-widest uppercase mt-1">Aplikasi Aktif</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold font-serif text-sky-400">Live</p>
                    <p class="text-slate-500 text-xs font-semibold tracking-widest uppercase mt-1">Status Sistem</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Portal Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

        @if($portals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($portals as $index => $portal)
            <div class="portal-card reveal flex flex-col bg-slate-900/60 backdrop-blur-sm rounded-2xl border border-slate-800 overflow-hidden"
                 style="transition-delay: {{ $index * 60 }}ms">

                <!-- Image -->
                <div class="relative h-52 overflow-hidden bg-slate-800 flex-shrink-0">
                    @if($portal->images->count() > 0)
                        <img src="{{ asset('storage/' . $portal->images->first()->image_path) }}"
                             alt="{{ $portal->title }}"
                             loading="lazy"
                             class="w-full h-full object-cover opacity-75 hover:opacity-95 hover:scale-105 transition-all duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
                            <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>

                    <!-- Online badge -->
                    <div class="absolute top-4 left-4 flex items-center gap-1.5 px-3 py-1 bg-emerald-900/80 border border-emerald-600/50 rounded-full backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-emerald-300 text-[10px] font-bold uppercase tracking-wider">Online</span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-7 flex flex-col flex-1">
                    <h2 class="font-serif text-xl font-bold text-white mb-3 group-hover:text-sky-400 transition-colors leading-snug">
                        <a href="{{ route('portals.show', $portal) }}">{{ $portal->title }}</a>
                    </h2>
                    <p class="text-slate-400 text-sm leading-relaxed font-light mb-6 line-clamp-3">
                        {{ Str::limit(strip_tags($portal->description), 140) }}
                    </p>

                    <div class="mt-auto flex items-center justify-between gap-4">
                        <a href="{{ route('portals.show', $portal) }}"
                           class="inline-flex items-center justify-center w-full gap-2 px-4 py-3.5 bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs uppercase tracking-widest transition-colors rounded-xl border border-slate-700">
                            Detail Aplikasi
                        </a>
                        <a href="{{ $portal->url }}" target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center w-full gap-2 px-4 py-3.5 bg-sky-700 hover:bg-sky-600 text-white font-bold text-xs uppercase tracking-widest transition-colors rounded-xl">
                            Akses Portal
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <div class="py-32 text-center border border-dashed border-slate-800 rounded-2xl">
            <div class="w-20 h-20 rounded-full bg-slate-900 flex items-center justify-center mx-auto mb-6 border border-slate-800">
                <svg class="w-10 h-10 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-slate-500 font-medium text-lg">Belum ada portal aplikasi yang aktif.</p>
            <p class="text-slate-600 text-sm mt-2">Tambahkan aplikasi melalui <a href="{{ route('admin.dashboard') }}" class="text-sky-500 hover:underline">Dashboard Admin</a>.</p>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-black border-t border-slate-900 py-10 text-center">
        <p class="text-slate-600 text-sm font-light">
            &copy; {{ date('Y') }} SIDAJU × TATA USAHA Suku Dinas Tata Kelola Air — Kota Administrasi Jakarta Utara
        </p>
    </footer>

    <script>
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in-view'); observer.unobserve(e.target); } });
        }, { threshold: 0.08 });
        revealEls.forEach(el => observer.observe(el));
    </script>
</body>
</html>
