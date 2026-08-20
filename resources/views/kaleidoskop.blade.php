<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kaleidoskop Tahunan — Rekam jejak pekerjaan perbaikan dan pemeliharaan infrastruktur air Suku Dinas Tata Kelola Air Jakarta Utara.">
    <title>Kaleidoskop Tahunan — SIMSUDIN SDA Jakarta Utara</title>

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
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #0ea5e9; border-radius: 3px; }
        .card-hover { transition: transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.35s ease; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 50px -10px rgba(14,165,233,0.2); }
        .reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.in-view { opacity: 1; transform: translateY(0); }
    </style>
</head>

<body class="bg-white text-slate-800 antialiased">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-sky-700 flex items-center justify-center group-hover:bg-sky-600 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="leading-tight">
                    <p class="text-slate-900 font-extrabold text-sm tracking-wider">SIMSUDIN</p>
                    <p class="text-sky-600 text-[9px] font-bold tracking-widest uppercase">SDA Jakarta Utara</p>
                </div>
            </a>

            <div class="flex items-center gap-6">
                <a href="{{ route('kaleidoskop') }}" class="text-sm font-semibold text-sky-600 border-b-2 border-sky-500 pb-0.5">Kaleidoskop</a>
                <a href="{{ route('portal') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Portal Aplikasi</a>
                <a href="{{ url('/') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-slate-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <header class="bg-slate-950 py-16 md:py-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 50%, #0ea5e9 0%, transparent 50%), radial-gradient(circle at 80% 20%, #075985 0%, transparent 50%);"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-500/20 border border-sky-500/40 mb-6">
                <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                <span class="text-sky-300 font-bold text-xs tracking-widest uppercase">Laporan Pekerjaan Tahunan 2025</span>
            </div>
            <h1 class="font-serif text-4xl md:text-6xl font-bold text-white mb-5">
                Kaleidoskop Tahunan
            </h1>
            <p class="text-lg text-slate-400 font-light max-w-2xl leading-relaxed">
                Rekam jejak seluruh pekerjaan perbaikan, pemeliharaan infrastruktur, dan penanganan banjir yang telah dilaksanakan Suku Dinas Tata Kelola Air Wilayah Jakarta Utara sepanjang tahun anggaran 2025.
            </p>

            <!-- Stats Strip -->
            <div class="flex flex-wrap gap-8 mt-10 pt-8 border-t border-slate-800">
                <div>
                    <p class="text-3xl font-extrabold font-serif text-white">{{ $articles->total() }}</p>
                    <p class="text-slate-500 text-xs font-semibold tracking-widest uppercase mt-1">Total Laporan</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold font-serif text-white">2025</p>
                    <p class="text-slate-500 text-xs font-semibold tracking-widest uppercase mt-1">Tahun Anggaran</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold font-serif text-sky-400">Aktif</p>
                    <p class="text-slate-500 text-xs font-semibold tracking-widest uppercase mt-1">Status Program</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Article Grid -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

        @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $index => $article)
            <article class="card-hover reveal flex flex-col bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm"
                     style="transition-delay: {{ ($index % 12) * 60 }}ms">

                <!-- Image -->
                <div class="relative overflow-hidden bg-slate-100 h-52 flex-shrink-0">
                    @if($article->images->count() > 0)
                        <img src="{{ asset('storage/' . $article->images->first()->image_path) }}"
                             alt="{{ $article->title }}"
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                            <svg class="w-14 h-14 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-sky-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-full">
                            Laporan
                        </span>
                    </div>
                    @if($article->images->count() > 1)
                    <div class="absolute bottom-3 right-3 px-2.5 py-1 bg-black/60 backdrop-blur-sm text-white text-[10px] font-bold rounded-lg flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $article->images->count() }} Foto
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-7 flex flex-col flex-1">
                    <div class="flex items-center gap-2 text-sky-600 text-xs font-bold uppercase tracking-widest mb-3">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $article->activity_date ? $article->activity_date->translatedFormat('d F Y') : 'Tanpa Tanggal' }}
                    </div>

                    <h2 class="font-serif text-xl font-bold text-slate-900 leading-snug mb-4 flex-1">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-sky-600 transition-colors">
                            {{ $article->title }}
                        </a>
                    </h2>

                    <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-2 font-light">
                        {{ Str::limit(strip_tags($article->content), 120) }}
                    </p>

                    <a href="{{ route('articles.show', $article) }}"
                       class="inline-flex items-center gap-2 text-xs font-bold text-slate-800 hover:text-sky-600 uppercase tracking-widest transition-colors group mt-auto">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
        <div class="mt-16 flex justify-center">
            {{ $articles->links() }}
        </div>
        @endif

        @else
        <div class="py-32 text-center">
            <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <p class="text-slate-400 font-medium text-lg">Belum ada laporan kaleidoskop.</p>
            <p class="text-slate-400 text-sm mt-2">Tambahkan laporan melalui <a href="{{ route('admin.dashboard') }}" class="text-sky-500 hover:underline">Dashboard Admin</a>.</p>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800 py-10 text-center">
        <p class="text-slate-500 text-sm font-light">
            &copy; {{ date('Y') }} Suku Dinas Tata Kelola Air — Kota Administrasi Jakarta Utara
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
