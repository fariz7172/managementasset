<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ Str::limit(strip_tags($article->content), 160) }}">
    <title>{{ $article->title }} — SIDAJU SDA Jakarta Utara</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
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
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #0ea5e9; border-radius: 3px; }

        /* Prose overrides */
        .article-body h1, .article-body h2, .article-body h3 {
            font-family: 'Playfair Display', serif;
            color: #0f172a;
            font-weight: 700;
            line-height: 1.3;
            margin-top: 2em;
            margin-bottom: 0.75em;
        }
        .article-body h1 { font-size: 1.875rem; }
        .article-body h2 { font-size: 1.5rem; }
        .article-body h3 { font-size: 1.25rem; }
        .article-body p  { color: #334155; line-height: 1.85; margin-bottom: 1.25em; font-size: 1.0625rem; font-weight: 300; }
        .article-body ul, .article-body ol { color: #334155; padding-left: 1.5em; margin-bottom: 1.25em; }
        .article-body li { margin-bottom: 0.5em; font-weight: 300; }
        .article-body table { width: 100%; border-collapse: collapse; margin-bottom: 1.5em; font-size: 0.9rem; }
        .article-body th { background: #0f172a; color: white; padding: 10px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .article-body td { padding: 10px 14px; border-bottom: 1px solid #e2e8f0; color: #334155; }
        .article-body tr:nth-child(even) td { background: #f8fafc; }
        .article-body img { border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); max-width: 100%; }
        .article-body a { color: #0ea5e9; text-decoration: underline; }
        .article-body blockquote { border-left: 4px solid #0ea5e9; padding-left: 1.25em; color: #64748b; font-style: italic; margin: 1.5em 0; }

        /* Lightbox */
        #lightbox { display: none; }
        #lightbox.open { display: flex; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-950/90 backdrop-blur-md border-b border-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-sky-700 overflow-hidden border border-sky-400 group-hover:bg-sky-600 transition-colors">
                    <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo SIDAJU" class="w-full h-full object-cover">
                </div>
                <div class="leading-tight">
                    <p class="text-white font-extrabold text-sm tracking-wider">SIDAJU</p>
                    <p class="text-sky-400 text-[9px] font-bold tracking-widest uppercase">SDA Jakarta Utara</p>
                </div>
            </a>

            <!-- Back Button -->
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Kaleidoskop
            </a>
        </div>
    </nav>

    <!-- Hero Header -->
    <header class="relative w-full overflow-hidden" style="padding-top: 64px; min-height: 420px;">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            @if($article->images->count() > 0)
                <img src="{{ Storage::url($article->images->first()->image_path) }}"
                     alt="{{ $article->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-slate-900 to-slate-800"></div>
            @endif
            <!-- Multi-layer gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-slate-950/30"></div>
            <div class="absolute inset-0 bg-sky-950/30"></div>
        </div>

        <!-- Header Content -->
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 text-center flex flex-col items-center justify-center">
            
            <!-- Tag -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-500/20 border border-sky-500/40 mb-6">
                <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                <span class="text-sky-300 font-bold text-xs tracking-widest uppercase">Kaleidoskop · Laporan Kegiatan</span>
            </div>

            <!-- Title — responsive sizing, clamps at 3 lines -->
            <h1 class="font-serif font-bold text-white leading-tight mb-6
                        text-2xl sm:text-3xl md:text-4xl lg:text-5xl
                        max-w-3xl">
                {{ $article->title }}
            </h1>

            <!-- Meta info -->
            <div class="flex flex-wrap items-center justify-center gap-6 text-sm">
                @if($article->activity_date)
                <div class="flex items-center gap-2 text-slate-300">
                    <svg class="w-4 h-4 text-sky-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">{{ $article->activity_date->translatedFormat('d F Y') }}</span>
                </div>
                @endif
                @if($article->images->count() > 0)
                <div class="flex items-center gap-2 text-slate-300">
                    <svg class="w-4 h-4 text-sky-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium">{{ $article->images->count() }} Foto Dokumentasi</span>
                </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">

        <!-- Content Card -->
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 -mt-12 relative z-10 overflow-hidden">
            <div class="p-8 md:p-12">
                <!-- Article body -->
                <div class="article-body">
                    {!! $article->content !!}
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        @if($article->images->count() > 1)
        <div class="mt-16">
            <div class="flex items-center gap-4 mb-8">
                <span class="w-8 h-0.5 bg-sky-600"></span>
                <h2 class="text-xs font-bold text-sky-600 uppercase tracking-widest">Galeri Dokumentasi</h2>
            </div>
            <h3 class="font-serif text-2xl font-bold text-slate-900 mb-8">
                {{ $article->images->count() }} Foto Kegiatan
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($article->images as $i => $image)
                <div class="group relative rounded-xl overflow-hidden aspect-[4/3] bg-slate-100 cursor-pointer border border-slate-200"
                     onclick="openLightbox('{{ Storage::url($image->image_path) }}', '{{ addslashes($article->title) }} #{{ $i + 1 }}')">
                    <img src="{{ Storage::url($image->image_path) }}"
                         alt="Foto {{ $i + 1 }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                    <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/40 transition-all duration-300 flex items-center justify-center">
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm border border-white/40 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-2 right-2 px-2 py-0.5 bg-slate-900/70 text-white text-xs font-bold rounded-md">
                        {{ $i + 1 }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="mt-16 flex justify-center">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-3 px-8 py-4 bg-slate-950 hover:bg-slate-800 text-white font-bold text-sm uppercase tracking-widest transition-colors rounded-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Kaleidoskop
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800 py-10 text-center">
        <p class="text-slate-500 text-sm font-light tracking-wide">
            &copy; {{ date('Y') }} Suku Dinas Tata Kelola Air — Kota Administrasi Jakarta Utara
        </p>
    </footer>

    <!-- Lightbox -->
    <div id="lightbox"
         class="fixed inset-0 z-[999] bg-black/90 backdrop-blur-sm items-center justify-center p-4"
         onclick="if(event.target===this) closeLightbox()">
        <button onclick="closeLightbox()"
                class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[88vh] object-contain rounded-lg shadow-2xl">
        <p id="lightbox-caption" class="text-center text-slate-400 text-sm mt-4 font-light"></p>
    </div>

    <script>
        function openLightbox(src, caption) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-caption').textContent = caption;
            document.getElementById('lightbox').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('open');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
    </script>
</body>
</html>
