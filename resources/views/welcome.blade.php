<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kaleidoskop dan Portal Aplikasi Terintegrasi Suku Dinas Tata Kelola Air Wilayah Jakarta Utara.">
    <title>Sistem Informasi Digital Sumber Daya Air Jakarta Utara (SIDAJU)</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                }
            }
        }
    </script>

    <style>
        /* ── Scrollbar ─────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #0ea5e9; border-radius: 3px; }

        /* ── Navbar ─────────────────────────────────────────── */
        .nav-transparent { background: transparent; }
        .nav-solid       { background: rgba(15, 23, 42, 0.97); box-shadow: 0 1px 0 rgba(255,255,255,0.05); }

        /* ── Carousel ─────────────────────────────────────────── */
        .slide-enter   { opacity: 0; transform: scale(1.04); }
        .slide-visible { opacity: 1; transform: scale(1); }
        .slide-leave   { opacity: 0; transform: scale(0.96); }

        /* ── Ken Burns ─────────────────────────────────────────── */
        @keyframes kenburns {
            0%   { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.12) translate(-2%, -1%); }
        }
        .ken-burns { animation: kenburns 10s ease-out forwards; }

        /* ── Number Ticker ─────────────────────────────────────── */
        @keyframes count-up {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .count-anim { animation: count-up 0.6s ease-out forwards; }

        /* ── Article card hover ─────────────────────────────────── */
        .article-card { transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease; }
        .article-card:hover { transform: translateY(-8px); box-shadow: 0 24px 60px -10px rgba(14,165,233,0.2); }

        /* ── Glow ─────────────────────────────────────────────── */
        .glow-blue  { box-shadow: 0 0 40px rgba(14,165,233,0.2); }
        .glow-line  { box-shadow: 0 2px 20px rgba(14,165,233,0.5); }

        /* ── Section reveal ────────────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal.in-view { opacity: 1; transform: translateY(0); }

        /* Mobile menu */
        #mobile-menu { transition: max-height 0.35s ease, opacity 0.3s ease; max-height: 0; opacity: 0; overflow: hidden; }
        #mobile-menu.open { max-height: 480px; opacity: 1; }
    </style>
</head>

<body class="bg-slate-950 text-slate-200 antialiased selection:bg-sky-500 selection:text-white"
      x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 60)">

    <!-- ──────────────────────────────────────────── -->
    <!--                   NAVBAR                    -->
    <!-- ──────────────────────────────────────────── -->
    <nav id="navbar"
         :class="scrolled ? 'nav-solid py-3' : 'nav-transparent py-5'"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">

            <!-- Logo -->
            <a href="#" class="flex items-center gap-3 group flex-shrink-0">
                <div class="w-10 h-10 rounded-xl bg-sky-600 shadow-lg shadow-sky-500/30 group-hover:bg-sky-500 transition-colors overflow-hidden border border-sky-400">
                    <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo SIDAJU" class="w-full h-full object-cover">
                </div>
                <div class="leading-tight">
                    <p class="text-white font-extrabold text-base tracking-wider">SIDAJU</p>
                    <p class="text-sky-400 text-[10px] font-semibold tracking-[0.15em] uppercase">Tata Kelola Air Jakarta Utara</p>
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-8">
                <a href="#tentang"    class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Tentang</a>
                <a href="{{ route('public.map') }}"    class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Peta Aset</a>
                <a href="{{ route('public.map.reses') }}"  class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Peta Reses </a>
                <a href="{{ route('kaleidoskop') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Artikel</a>
                <a href="{{ route('portal') }}"     class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Portal Aplikasi</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-full bg-sky-600 text-white font-semibold text-sm hover:bg-sky-500 hover:shadow-lg hover:shadow-sky-500/30 transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full border border-slate-700 text-slate-300 font-semibold text-sm hover:border-sky-500 hover:text-white transition-all">Masuk Portal</a>
                    @endauth
                @endif
            </div>

            <!-- Hamburger -->
            <button id="hamburger" onclick="document.getElementById('mobile-menu').classList.toggle('open')" class="lg:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden bg-slate-900/95 backdrop-blur-sm border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-2">
                <a href="#tentang"     onclick="document.getElementById('mobile-menu').classList.remove('open')" class="px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white font-medium transition-colors">Tentang</a>
                <a href="#layanan"     onclick="document.getElementById('mobile-menu').classList.remove('open')" class="px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white font-medium transition-colors">Layanan</a>
                <a href="#statistik"   onclick="document.getElementById('mobile-menu').classList.remove('open')" class="px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white font-medium transition-colors">Statistik</a>
                <a href="{{ route('kaleidoskop') }}" onclick="document.getElementById('mobile-menu').classList.remove('open')" class="px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white font-medium transition-colors">Kaleidoskop</a>
                <a href="{{ route('portal') }}"      onclick="document.getElementById('mobile-menu').classList.remove('open')" class="px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white font-medium transition-colors">Portal Aplikasi</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="mt-2 w-full px-4 py-3 rounded-full bg-sky-600 text-white font-bold text-center">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="mt-2 w-full px-4 py-3 rounded-full border border-slate-700 text-slate-300 font-bold text-center">Masuk Portal</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- ──────────────────────────────────────────── -->
    <!--             HERO CAROUSEL                   -->
    <!-- ──────────────────────────────────────────── -->
    <section id="beranda" x-data="{
        activeSlide: 0,
        totalSlides: 3,
        autoPlayInterval: null,
        slides: [
            {
                img: '{{ asset('img/slide1.jpg') }}',
                tag: 'Pengerukan Saluran',
                headline: 'Normalisasi & Pengerukan',
                subline: '1.240 Titik Saluran',
                desc: 'Program normalisasi dan pengerukan saluran drainase sepanjang lebih dari 180 km yang dilaksanakan seluruh wilayah Jakarta Utara guna mencegah banjir dan genangan air.'
            },
            {
                img: '{{ asset('img/slide2.jpg') }}',
                tag: 'Monitoring Real-Time',
                headline: 'Sistem Pompa Terpadu',
                subline: '64 Stasiun Pompa Aktif',
                desc: 'Operasional 64 stasiun pompa dipantau secara real-time melalui ruang kendali terpusat, memastikan penanganan banjir yang cepat dan terukur selama 24 jam penuh.'
            },
            {
                img: '{{ asset('img/slide3.jpg') }}',
                tag: 'Infrastruktur Pintu Air',
                headline: 'Pemeliharaan Pintu Air',
                subline: '38 Pintu Air Terpelihara',
                desc: 'Inspeksi berkala dan pemeliharaan 38 pintu air strategis di sepanjang pesisir Jakarta Utara sebagai garis terdepan pertahanan banjir rob dan limpasan.'
            }
        ],
        startAutoPlay() {
            this.autoPlayInterval = setInterval(() => {
                this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
            }, 6000);
        },
        goTo(index) {
            clearInterval(this.autoPlayInterval);
            this.activeSlide = index;
            this.startAutoPlay();
        },
        prev() { this.goTo((this.activeSlide - 1 + this.totalSlides) % this.totalSlides); },
        next() { this.goTo((this.activeSlide + 1) % this.totalSlides); }
    }" x-init="startAutoPlay()" class="relative w-full h-screen min-h-[600px] overflow-hidden">

        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                 :class="activeSlide === index ? 'opacity-100 z-10' : 'opacity-0 z-0'">

                <!-- BG Image -->
                <div class="absolute inset-0 bg-cover bg-center"
                     :class="activeSlide === index ? 'ken-burns' : ''"
                     :style="`background-image: url('${slide.img}');`">
                </div>

                <!-- Gradient overlays -->
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/60 to-slate-950/20"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-70"></div>

                <!-- Content -->
                <div class="absolute inset-0 flex items-center" style="padding-top: 80px;">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                        <div class="max-w-2xl"
                             x-show="activeSlide === index"
                             x-transition:enter="transition ease-out duration-700 delay-200"
                             x-transition:enter-start="opacity-0 translate-y-8"
                             x-transition:enter-end="opacity-100 translate-y-0">

                            <!-- Tag -->
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-500/20 border border-sky-500/40 mb-6">
                                <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                                <span class="text-sky-300 font-semibold text-xs tracking-widest uppercase" x-text="slide.tag"></span>
                            </div>

                            <!-- Headline -->
                            <h2 class="font-serif text-5xl md:text-7xl font-bold text-white leading-tight mb-3">
                                <span x-text="slide.headline"></span>
                            </h2>
                            <p class="text-2xl md:text-3xl font-semibold text-sky-400 mb-6" x-text="slide.subline"></p>

                            <!-- Desc -->
                            <p class="text-slate-300 text-base md:text-lg leading-relaxed font-light mb-10 max-w-xl" x-text="slide.desc"></p>

                            <!-- CTA -->
                            <div class="flex flex-wrap gap-4">
                                <a href="#kaleidoskop" class="inline-flex items-center gap-3 px-7 py-4 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-none text-sm uppercase tracking-widest transition-all hover:pl-9">
                                    Baca Kaleidoskop
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                                <a href="#portal" class="inline-flex items-center gap-3 px-7 py-4 border border-slate-600 hover:border-white text-slate-300 hover:text-white font-bold rounded-none text-sm uppercase tracking-widest transition-all">
                                    Portal Aplikasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Bottom Controls -->
        <div class="absolute bottom-8 left-0 right-0 z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-end justify-between">

                <!-- Dots -->
                <div class="flex items-center gap-3">
                    <template x-for="(slide, i) in slides" :key="i">
                        <button @click="goTo(i)"
                                class="h-1 transition-all duration-500 rounded-full focus:outline-none"
                                :class="activeSlide === i ? 'w-10 bg-sky-500 glow-line' : 'w-5 bg-slate-600 hover:bg-slate-400'">
                        </button>
                    </template>
                    <span class="ml-3 text-slate-500 text-xs font-mono">
                        <span class="text-white" x-text="('0' + (activeSlide + 1)).slice(-2)"></span> / 03
                    </span>
                </div>

                <!-- Arrows -->
                <div class="flex gap-3">
                    <button @click="prev()" class="w-12 h-12 rounded-full border border-slate-700 hover:border-sky-500 flex items-center justify-center text-slate-400 hover:text-white hover:bg-sky-600/20 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="next()" class="w-12 h-12 rounded-full border border-slate-700 hover:border-sky-500 flex items-center justify-center text-slate-400 hover:text-white hover:bg-sky-600/20 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Scroll Hint -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 hidden lg:flex flex-col items-center gap-2 text-slate-500">
            <span class="text-[10px] font-semibold tracking-widest uppercase">Scroll</span>
            <div class="w-px h-8 bg-gradient-to-b from-slate-500 to-transparent"></div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────── -->
    <!--               TENTANG                       -->
    <!-- ──────────────────────────────────────────── -->
    <section id="tentang" class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Text -->
                <div class="reveal">
                    <div class="inline-flex items-center gap-3 mb-4">
                        <span class="w-8 h-0.5 bg-sky-600"></span>
                        <span class="text-sky-600 font-bold text-xs tracking-widest uppercase">Tentang SIDAJU</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 leading-tight mb-6">
                        Menjaga Jakarta Utara<br>Dari Ancaman <span class="text-sky-600">Banjir</span>
                    </h2>
                    <p class="text-lg text-slate-600 font-light leading-relaxed mb-6">
                        Sistem Informasi Digital Sumber Daya Air Jakarta Utara (SIDAJU)  adalah inisiatif digitalisasi pengelolaan infrastruktur perairan. Kami mengawasi, memelihara, dan menormalisasi sistem tata air demi menciptakan lingkungan yang aman dan nyaman bagi masyarakat.
                    </p>
                    <p class="text-slate-500 font-light leading-relaxed mb-8">
                        Melalui portal ini, kami mendokumentasikan setiap langkah perbaikan (Kaleidoskop) dan menyatukan seluruh aplikasi operasional ke dalam satu gerbang digital yang transparan dan mudah diakses.
                    </p>
                    <div class="flex items-center gap-6">
                        <div class="flex flex-col">
                            <span class="text-3xl font-extrabold font-serif text-slate-900">24/7</span>
                            <span class="text-xs font-bold text-sky-600 uppercase tracking-widest mt-1">Pemantauan</span>
                        </div>
                        <div class="w-px h-12 bg-slate-200"></div>
                        <div class="flex flex-col">
                            <span class="text-3xl font-extrabold font-serif text-slate-900">100%</span>
                            <span class="text-xs font-bold text-sky-600 uppercase tracking-widest mt-1">Transparansi</span>
                        </div>
                    </div>
                </div>
                
                <!-- Image Grid -->
                <div class="reveal grid grid-cols-2 gap-4">
                    <img src="{{ asset('img/slide3.jpg') }}" alt="Pintu Air" class="rounded-2xl h-64 w-full object-cover shadow-lg transform translate-y-8">
                    <img src="{{ asset('img/kantor-walikota.jpg') }}" alt="Kantor Walikota" class="rounded-2xl h-80 w-full object-cover shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────── -->
    <!--               LAYANAN UTAMA                 -->
    <!-- ──────────────────────────────────────────── -->
    <section id="layanan" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                <div class="inline-flex items-center gap-3 mb-4">
                    <span class="w-8 h-0.5 bg-sky-600"></span>
                    <span class="text-sky-600 font-bold text-xs tracking-widest uppercase">Fokus Layanan</span>
                    <span class="w-8 h-0.5 bg-sky-600"></span>
                </div>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 mb-6">Bidang Kerja Utama</h2>
                <p class="text-lg text-slate-500 font-light leading-relaxed">
                    Suku Dinas Tata Kelola Air Jakarta Utara memiliki tiga pilar utama dalam menjaga stabilitas dan manajemen perairan kota.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="reveal bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-shadow duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-slate-900 mb-3">Normalisasi Saluran</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-light">Pengerukan lumpur dan sampah secara rutin di ribuan titik saluran mikro hingga makro untuk memastikan air mengalir lancar.</p>
                </div>
                <!-- Service 2 -->
                <div class="reveal bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-shadow duration-300" style="transition-delay: 100ms;">
                    <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-slate-900 mb-3">Manajemen Pompa</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-light">Pemeliharaan dan pengoperasian puluhan stasiun pompa polder yang siaga 24 jam untuk menyedot genangan saat curah hujan tinggi.</p>
                </div>
                <!-- Service 3 -->
                <div class="reveal bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-shadow duration-300" style="transition-delay: 200ms;">
                    <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-slate-900 mb-3">Infrastruktur & Pintu Air</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-light">Pengendalian arus laut (banjir rob) melalui pemantauan dan perawatan berkala pada pintu-pintu air strategis di pesisir utara.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────── -->
    <!--              STATISTIK                      -->
    <!-- ──────────────────────────────────────────── -->
    <section id="statistik" class="bg-slate-950 border-y border-slate-800/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @php
                    $stats = [
                        ['value' => $pintuAirCount, 'label' => 'Total Pintu Air', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['value' => $pompaCount, 'label' => 'Stasiun Pompa Aktif', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                        ['value' => '180 km', 'label' => 'Panjang Saluran Dinormalisasi','icon' => 'M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4'],
                        ['value' => $portalCount ?: '—', 'label' => 'Aplikasi Terintegrasi', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ];
                @endphp
                @foreach($stats as $stat)
                <div class="reveal flex flex-col items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-sky-900/40 border border-sky-800/60 flex items-center justify-center text-sky-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl md:text-4xl font-extrabold text-white font-serif">{{ $stat['value'] }}</p>
                        <p class="text-slate-500 text-sm font-medium mt-1">{{ $stat['label'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- CTA Button -->
            <div class="mt-12 text-center reveal">
                <a href="{{ route('public.map') }}" class="inline-flex items-center gap-3 px-8 py-3.5 bg-slate-800 hover:bg-sky-600 text-white font-bold text-sm uppercase tracking-widest transition-all rounded-full shadow-lg hover:shadow-sky-500/25 group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Lihat Peta Persebaran Aset
                </a>
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────── -->
    <!--            KALEIDOSKOP TAHUNAN              -->
    <!-- ──────────────────────────────────────────── -->
    <section id="kaleidoskop" class="py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="reveal flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16 pb-10 border-b-2 border-slate-100">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 mb-4">
                        <span class="w-8 h-0.5 bg-sky-600"></span>
                        <span class="text-sky-600 font-bold text-xs tracking-widest uppercase">Laporan Pekerjaan Tahunan 2025</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 leading-tight mb-4">
                        Kaleidoskop Tahunan<br>
                        <span class="text-sky-600">SDA Jakarta Utara</span>
                    </h2>
                    <p class="text-lg text-slate-500 font-light leading-relaxed max-w-2xl">
                        Rekam jejak pekerjaan perbaikan, pemeliharaan, dan penanganan banjir yang telah dilaksanakan Suku Dinas Tata Kelola Air Wilayah Jakarta Utara sepanjang tahun 2025.
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-6xl font-extrabold font-serif text-slate-100 leading-none">2025</p>
                    <p class="text-slate-400 text-sm font-semibold mt-1">Tahun Anggaran</p>
                </div>
            </div>

            <!-- Article Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($articles as $index => $article)
                <article class="article-card reveal flex flex-col bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm"
                         style="transition-delay: {{ $index * 80 }}ms">

                    <!-- Image -->
                    <div class="relative overflow-hidden bg-slate-100 h-52 flex-shrink-0">
                        @if($article->images->count() > 0)
                            <img src="{{ asset('storage/' . $article->images->first()->image_path) }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                <svg class="w-14 h-14 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <!-- Overlay corner badge -->
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-sky-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-full">
                                Laporan
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-7 flex flex-col flex-1">
                        <!-- Date -->
                        <div class="flex items-center gap-2 text-sky-600 text-xs font-bold uppercase tracking-widest mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $article->activity_date ? $article->activity_date->translatedFormat('d F Y') : 'Dokumentasi' }}
                        </div>

                        <!-- Title -->
                        <h3 class="text-xl font-serif font-bold text-slate-900 leading-snug mb-4 flex-1">
                            <a href="{{ route('articles.show', $article) }}" class="hover:text-sky-600 transition-colors">
                                {{ $article->title }}
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-2 font-light">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>

                        <!-- Footer Link -->
                        <a href="{{ route('articles.show', $article) }}"
                           class="inline-flex items-center gap-2 text-xs font-bold text-slate-800 hover:text-sky-600 uppercase tracking-widest transition-colors group">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </article>
                @empty
                <div class="col-span-full py-24 text-center">
                    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <p class="text-slate-400 font-medium text-lg">Laporan Kaleidoskop belum tersedia.</p>
                    <p class="text-slate-500 text-sm mt-2">Tambahkan laporan melalui Dashboard Admin.</p>
                </div>
                </div>
                @endforelse
            </div>

            <!-- Lihat Semua Button -->
            <div class="mt-16 text-center reveal">
                <a href="{{ route('kaleidoskop') }}" class="inline-flex items-center gap-3 px-8 py-4 border-2 border-slate-200 hover:border-sky-600 text-slate-700 hover:text-sky-600 font-bold text-sm uppercase tracking-widest transition-all rounded-full group">
                    Lihat Seluruh Laporan
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────── -->
    <!--            PETA PEMANTAUAN ASET             -->
    <!-- ──────────────────────────────────────────── -->
    <section id="monitoring" class="py-28 relative overflow-hidden bg-slate-900">
        <!-- Ambient Glow -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1542360663-8f4020fc25fd?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-sky-900/20 blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Text -->
                <div class="reveal">
                    <div class="inline-flex items-center gap-3 mb-4">
                        <span class="w-8 h-0.5 bg-sky-500"></span>
                        <span class="text-sky-400 font-bold text-xs tracking-widest uppercase">Live Control Room</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-white leading-tight mb-6">
                        Pemantauan Aset SDA<br>
                        <span class="text-sky-400">Secara Real-Time</span>
                    </h2>
                    <p class="text-lg text-slate-300 font-light leading-relaxed mb-6">
                        Pantau pergerakan dan status operasional seluruh aset infrastruktur perairan di Jakarta Utara. Mulai dari Pintu Air, Stasiun Pompa, Pompa Mobile, hingga Sub Polder.
                    </p>
                    <p class="text-slate-400 font-light leading-relaxed mb-10">
                        Kami menyediakan peta interaktif publik untuk memastikan transparansi kegiatan pemeliharaan dan memberikan informasi terkini bagi warga Jakarta.
                    </p>
                    
                    <a href="{{ route('public.map') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-full shadow-[0_0_40px_rgba(14,165,233,0.4)] transition-all hover:scale-105 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                        Lihat Peta Pemantauan
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <!-- Map Illustration/Preview -->
                <div class="reveal relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-sky-500/20 to-blue-600/20 rounded-3xl transform rotate-3 scale-105 blur-lg"></div>
                    <a href="{{ route('public.map') }}" class="relative block bg-slate-900 border border-slate-700/50 rounded-3xl p-2 shadow-2xl overflow-hidden group cursor-pointer hover:border-sky-500/50 transition-all duration-300">
                        <!-- Mac OS style dots -->
                        <div class="flex gap-2 px-4 py-3 border-b border-slate-800">
                            <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500/80"></div>
                        </div>
                        
                        <!-- Overlay for "Click to view" -->
                        <div class="absolute inset-0 z-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 bg-sky-900/40 backdrop-blur-[2px]">
                            <span class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 text-white font-bold text-sm uppercase tracking-widest rounded-full shadow-2xl scale-90 group-hover:scale-100 transition-all duration-500">
                                Buka Peta Interaktif
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </span>
                        </div>

                        <!-- Static Map Image Local -->
                        <img src="{{ asset('assets/peta.jpg') }}" alt="Peta Jakarta Utara" class="w-full h-80 object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                        
                        <!-- Floating Markers (Decorations) -->
                        <div class="absolute top-1/3 left-1/4 w-4 h-4 rounded-full bg-sky-500 border-2 border-slate-900 shadow-[0_0_15px_rgba(14,165,233,0.8)] animate-pulse z-0"></div>
                        <div class="absolute bottom-1/3 right-1/4 w-4 h-4 rounded-full bg-emerald-500 border-2 border-slate-900 shadow-[0_0_15px_rgba(16,185,129,0.8)] animate-bounce z-0" style="animation-duration: 2s;"></div>
                        <div class="absolute top-1/2 left-1/2 w-4 h-4 rounded-full bg-pink-500 border-2 border-slate-900 shadow-[0_0_15px_rgba(236,72,153,0.8)] animate-ping z-0" style="animation-duration: 3s;"></div>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────── -->
    <!--            PETA MONITORING RESES            -->
    <!-- ──────────────────────────────────────────── -->
    <section id="monitoring-reses" class="py-28 relative overflow-hidden bg-slate-950">
        <!-- Ambient Glow -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-950/80 to-slate-900"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-indigo-900/10 blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Map Illustration/Preview (Left Side) -->
                <div class="reveal relative lg:order-1 order-2">
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/20 to-purple-600/20 rounded-3xl transform -rotate-3 scale-105 blur-lg"></div>
                    <a href="{{ route('public.map.reses') }}" class="relative block bg-slate-900 border border-slate-700/50 rounded-3xl p-2 shadow-2xl overflow-hidden group cursor-pointer hover:border-indigo-500/50 transition-all duration-300">
                        <!-- Mac OS style dots -->
                        <div class="flex gap-2 px-4 py-3 border-b border-slate-800">
                            <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500/80"></div>
                        </div>
                        
                        <!-- Overlay for "Click to view" -->
                        <div class="absolute inset-0 z-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 bg-indigo-900/40 backdrop-blur-[2px]">
                            <span class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold text-sm uppercase tracking-widest rounded-full shadow-2xl scale-90 group-hover:scale-100 transition-all duration-500">
                                Buka Peta Usulan
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </span>
                        </div>

                        <!-- Static Map Image Local -->
                        <img src="{{ asset('assets/reses.png') }}" alt="Peta Jakarta Utara" class="w-full h-120 object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700">
                        
                        <!-- Floating Markers (Decorations) -->
                        <div class="absolute top-1/4 left-1/3 w-4 h-4 rounded-full bg-emerald-500 border-2 border-slate-900 shadow-[0_0_15px_rgba(16,185,129,0.8)] animate-pulse z-0"></div>
                        <div class="absolute bottom-1/4 right-1/3 w-4 h-4 rounded-full bg-blue-500 border-2 border-slate-900 shadow-[0_0_15px_rgba(59,130,246,0.8)] animate-bounce z-0" style="animation-duration: 2.5s;"></div>
                        <div class="absolute top-1/2 right-1/4 w-4 h-4 rounded-full bg-orange-500 border-2 border-slate-900 shadow-[0_0_15px_rgba(249,115,22,0.8)] animate-ping z-0" style="animation-duration: 3s;"></div>
                    </a>
                </div>

                <!-- Text (Right Side) -->
                <div class="reveal lg:order-2 order-1">
                    <div class="inline-flex items-center gap-3 mb-4">
                        <span class="w-8 h-0.5 bg-indigo-500"></span>
                        <span class="text-indigo-400 font-bold text-xs tracking-widest uppercase">Usulan Masyarakat & Reses</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-white leading-tight mb-6">
                        Transparansi Data<br>
                        <span class="text-indigo-400">Pekerjaan SDA</span>
                    </h2>
                    <p class="text-lg text-slate-300 font-light leading-relaxed mb-6">
                        Kawal pembangunan di sekitar Anda! Lihat titik lokasi pengerjaan saluran air hasil usulan masyarakat dan kegiatan Reses secara langsung dan akurat.
                    </p>
                    <p class="text-slate-400 font-light leading-relaxed mb-10">
                        Terintegrasi dengan sistem pusat untuk menyajikan bar progres pengerjaan di lapangan yang diperbarui secara langsung.
                    </p>
                    
                    <a href="{{ route('public.map.reses') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-full shadow-[0_0_40px_rgba(79,70,229,0.4)] transition-all hover:scale-105 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Lihat Peta Usulan Warga
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────── -->
    <!--           PORTAL APLIKASI                   -->
    <!-- ──────────────────────────────────────────── -->
    <section id="portal" class="py-28 bg-slate-950 relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-sky-900/30 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-sky-800/20 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <!-- Header -->
            <div class="reveal text-center mb-20">
                <div class="inline-flex items-center gap-3 mb-4">
                    <span class="w-8 h-0.5 bg-sky-600"></span>
                    <span class="text-sky-400 font-bold text-xs tracking-widest uppercase">Ekosistem Digital Terintegrasi</span>
                    <span class="w-8 h-0.5 bg-sky-600"></span>
                </div>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-white mb-6">Gerbang Portal Aplikasi</h2>
                <p class="text-lg text-slate-400 font-light max-w-2xl mx-auto leading-relaxed">
                    Akses terpusat ke seluruh sistem dan aplikasi operasional yang mendukung tata kelola air di wilayah Jakarta Utara.
                </p>
            </div>

            <!-- Portal Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($portals as $index => $portal)
                <div class="reveal flex flex-col bg-slate-900/60 backdrop-blur-sm rounded-2xl border border-slate-800 overflow-hidden group hover:border-sky-500/50 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(14,165,233,0.12)]"
                     style="transition-delay: {{ $index * 80 }}ms">

                    <!-- Image -->
                    <div class="relative h-52 overflow-hidden bg-slate-800 flex-shrink-0">
                        @if($portal->images->count() > 0)
                            <img src="{{ asset('storage/' . $portal->images->first()->image_path) }}"
                                 alt="{{ $portal->title }}"
                                 class="w-full h-full object-cover opacity-70 group-hover:opacity-90 group-hover:scale-105 transition-all duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
                                <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>

                        <!-- Launch overlay -->
                        <a href="{{ $portal->url }}" target="_blank"
                           class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 bg-sky-900/60 backdrop-blur-sm">
                            <span class="inline-flex items-center gap-3 px-6 py-3 bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs uppercase tracking-widest rounded-full shadow-xl transition-colors">
                                Buka Aplikasi
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </span>
                        </a>
                    </div>

                    <!-- Card Body -->
                    <div class="p-7 flex flex-col flex-1">
                        <h4 class="text-xl font-serif font-bold text-white mb-3 group-hover:text-sky-400 transition-colors">
                            <a href="{{ route('portals.show', $portal) }}">{{ $portal->title }}</a>
                        </h4>
                        <p class="text-slate-400 text-sm leading-relaxed font-light mb-6 line-clamp-3">
                            {{ Str::limit(strip_tags($portal->description), 120) }}
                        </p>
                        <div class="mt-auto flex items-center justify-between">
                            <a href="{{ route('portals.show', $portal) }}"
                               class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-white uppercase tracking-widest transition-colors group">
                                Detail Aplikasi
                            </a>
                            <a href="{{ $portal->url }}" target="_blank"
                               class="inline-flex items-center gap-2 text-xs font-bold text-sky-400 hover:text-sky-300 uppercase tracking-widest transition-colors group">
                                Akses Portal
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-24 text-center border border-dashed border-slate-800 rounded-2xl">
                    <p class="text-slate-500 font-medium text-lg">Portal Aplikasi belum dikonfigurasi.</p>
                    <p class="text-slate-600 text-sm mt-2">Tambahkan aplikasi melalui Dashboard Admin.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ──────────────────────────────────────────── -->
    <!--                  FOOTER                     -->
    <!-- ──────────────────────────────────────────── -->
    <footer class="bg-black border-t border-slate-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 pb-12 border-b border-slate-900 mb-10">
                <!-- Branding -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-sky-700/40 border border-sky-700/60 flex items-center justify-center">
                            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h2 class="text-white font-extrabold text-base tracking-widest">SIDAJU</h2>
                            <p class="text-sky-600 text-[10px] font-bold tracking-widest uppercase">SDA Jakarta Utara</p>
                        </div>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed font-light">
                        Sistem Informasi Digital Sumber Daya Air Jakarta Utara (SIDAJU) Suku Dinas Tata Kelola Air Wilayah Kota Administrasi Jakarta Utara.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-bold text-xs tracking-widest uppercase mb-5">Navigasi Cepat</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#tentang" class="text-slate-500 hover:text-white transition-colors font-light">Tentang SIDAJU</a></li>
                        <li><a href="#layanan" class="text-slate-500 hover:text-white transition-colors font-light">Fokus Layanan</a></li>
                        <li><a href="{{ route('public.map') }}" class="text-slate-500 hover:text-white transition-colors font-light">Peta Pemantauan</a></li>
                        <li><a href="{{ route('kaleidoskop') }}" class="text-slate-500 hover:text-white transition-colors font-light">Kaleidoskop Tahunan</a></li>
                        <li><a href="{{ route('portal') }}" class="text-slate-500 hover:text-white transition-colors font-light">Portal Aplikasi</a></li>
                        <li><a href="#kontak" class="text-slate-500 hover:text-white transition-colors font-light">Hubungi Kami</a></li>
                        <li><a href="{{ route('login') }}" class="text-slate-500 hover:text-sky-400 transition-colors font-light mt-4 block">Masuk Dashboard</a></li>
                    </ul>
                </div>

                <!-- Info -->
                <div>
                    <h3 class="text-white font-bold text-xs tracking-widest uppercase mb-5">Instansi</h3>
                    <address class="not-italic text-sm text-slate-500 leading-relaxed font-light space-y-2">
                        <p>Suku Dinas Tata Kelola Air</p>
                        <p>Kota Administrasi Jakarta Utara</p>
                        <p>Provinsi DKI Jakarta</p>
                    </address>
                </div>
            </div>

            <p class="text-center text-slate-700 text-xs tracking-widest uppercase font-medium">
                &copy; {{ date('Y') }} Power By Tata Usaha Suku Dinas Tata Kelola Air Jakarta Utara — Hak Cipta Dilindungi
            </p>
        </div>
    </footer>

    <script>
        // Reveal on scroll
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        revealEls.forEach(el => observer.observe(el));
    </script>
</body>
</html>