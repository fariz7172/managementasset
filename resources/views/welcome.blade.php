<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Aset – Sudin SDA Jakarta Utara</title>
    <meta name="description" content="Sistem Informasi Manajemen Aset Suku Dinas Sumber Daya Air Jakarta Utara – Pengelolaan aset infrastruktur air secara digital, transparan, dan terintegrasi.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --color-primary:   #0e6fad;
            --color-teal:      #17a2b8;
            --color-dark:      #0a1628;
            --color-navy:      #0d2240;
            --color-light:     #f0f6fc;
            --color-muted:     #6b7fa3;
            --color-white:     #ffffff;
            --radius-card:     16px;
            --shadow-card:     0 8px 32px rgba(14,111,173,0.13);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--color-dark);
            color: var(--color-white);
            overflow-x: hidden;
        }

        /* ───────── NAVBAR ───────── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 1000;
            background: rgba(10, 22, 40, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 14px 0;
            transition: background 0.3s;
        }
        .navbar-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
        }
        .navbar-brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: var(--color-white);
        }
        .navbar-brand .logo-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-teal));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: white;
        }
        .navbar-brand .brand-text { font-size: 0.85rem; line-height: 1.3; }
        .navbar-brand .brand-text strong { display: block; font-size: 0.95rem; font-weight: 700; }
        .navbar-login {
            background: linear-gradient(135deg, var(--color-primary), var(--color-teal));
            color: white; text-decoration: none;
            padding: 9px 22px; border-radius: 50px;
            font-size: 0.875rem; font-weight: 600;
            transition: opacity 0.2s, transform 0.2s;
        }
        .navbar-login:hover { opacity: 0.88; transform: translateY(-1px); }

        /* ───────── HERO / CAROUSEL ───────── */
        .hero {
            position: relative; height: 100vh; min-height: 600px;
            overflow: hidden;
        }
        .carousel-track {
            display: flex; height: 100%;
            transition: transform 0.8s cubic-bezier(0.77,0,0.175,1);
        }
        .carousel-slide {
            min-width: 100%; height: 100%; position: relative; flex-shrink: 0;
        }
        .carousel-slide img {
            width: 100%; height: 100%; object-fit: cover;
            filter: brightness(0.45);
        }
        .carousel-content {
            position: absolute; inset: 0;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            text-align: center;
            padding: 24px;
        }
        .carousel-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(23,162,184,0.25);
            border: 1px solid rgba(23,162,184,0.5);
            border-radius: 50px;
            padding: 6px 18px; font-size: 0.78rem; font-weight: 600;
            color: #5dd5e8; letter-spacing: 1px; text-transform: uppercase;
            margin-bottom: 24px;
            animation: fadeUp 0.8s ease both 0.2s;
        }
        .carousel-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800; line-height: 1.15;
            margin-bottom: 20px;
            animation: fadeUp 0.8s ease both 0.4s;
            text-shadow: 0 2px 12px rgba(0,0,0,0.5);
        }
        .carousel-title span { color: #5dd5e8; }
        .carousel-desc {
            font-size: 1.05rem; color: rgba(255,255,255,0.8);
            max-width: 640px; line-height: 1.7;
            margin-bottom: 36px;
            animation: fadeUp 0.8s ease both 0.6s;
        }
        .carousel-cta {
            display: flex; gap: 14px; flex-wrap: wrap; justify-content: center;
            animation: fadeUp 0.8s ease both 0.8s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary), var(--color-teal));
            color: white; text-decoration: none;
            padding: 13px 32px; border-radius: 50px;
            font-size: 0.95rem; font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(14,111,173,0.4);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(14,111,173,0.5); }
        .btn-outline-white {
            color: white; text-decoration: none;
            padding: 12px 30px; border-radius: 50px;
            font-size: 0.95rem; font-weight: 600;
            border: 2px solid rgba(255,255,255,0.5);
            transition: background 0.2s;
        }
        .btn-outline-white:hover { background: rgba(255,255,255,0.1); }

        /* Carousel Controls */
        .carousel-controls {
            position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%);
            display: flex; gap: 10px;
        }
        .carousel-dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: rgba(255,255,255,0.4); border: none; cursor: pointer;
            transition: background 0.3s, width 0.3s;
        }
        .carousel-dot.active { background: #5dd5e8; width: 28px; border-radius: 10px; }
        .carousel-arrow {
            position: absolute; top: 50%; transform: translateY(-50%);
            background: rgba(255,255,255,0.12); backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2); border-radius: 50%;
            width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.1rem; cursor: pointer;
            transition: background 0.2s;
        }
        .carousel-arrow:hover { background: rgba(255,255,255,0.25); }
        .carousel-arrow.prev { left: 24px; }
        .carousel-arrow.next { right: 24px; }

        /* ───────── STATS STRIP ───────── */
        .stats-strip {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-teal) 100%);
            padding: 28px 0;
        }
        .stats-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 24px;
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 8px; text-align: center;
        }
        .stat-item { padding: 8px; border-right: 1px solid rgba(255,255,255,0.2); }
        .stat-item:last-child { border-right: none; }
        .stat-number { font-size: 2rem; font-weight: 800; }
        .stat-label { font-size: 0.8rem; opacity: 0.85; margin-top: 4px; }

        /* ───────── SECTION COMMONS ───────── */
        section { padding: 96px 24px; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--color-teal); font-size: 0.8rem; font-weight: 700;
            letter-spacing: 2px; text-transform: uppercase; margin-bottom: 16px;
        }
        .section-title {
            font-size: clamp(1.75rem, 3.5vw, 2.6rem); font-weight: 800;
            line-height: 1.2; margin-bottom: 20px;
        }
        .section-desc { color: var(--color-muted); font-size: 1.05rem; line-height: 1.7; max-width: 600px; }

        /* ───────── ABOUT SECTION ───────── */
        .about-section { background: var(--color-navy); }
        .about-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 64px; align-items: center;
        }
        .about-image-wrap { position: relative; }
        .about-image-wrap img {
            width: 100%; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .about-badge-float {
            position: absolute; bottom: -20px; right: -20px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-teal));
            border-radius: 16px; padding: 20px 24px;
            text-align: center; box-shadow: var(--shadow-card);
        }
        .about-badge-float .num { font-size: 2rem; font-weight: 800; }
        .about-badge-float .lbl { font-size: 0.75rem; opacity: 0.85; }
        .about-points { display: flex; flex-direction: column; gap: 18px; margin-top: 32px; }
        .about-point {
            display: flex; gap: 16px; align-items: flex-start;
            background: rgba(255,255,255,0.04); border-radius: 12px;
            padding: 16px; border: 1px solid rgba(255,255,255,0.06);
        }
        .about-point .icon {
            width: 40px; height: 40px; min-width: 40px;
            border-radius: 10px; background: rgba(23,162,184,0.15);
            display: flex; align-items: center; justify-content: center;
            color: var(--color-teal); font-size: 1rem;
        }
        .about-point h4 { font-size: 0.9rem; font-weight: 700; margin-bottom: 4px; }
        .about-point p { font-size: 0.82rem; color: var(--color-muted); line-height: 1.6; }

        /* ───────── FITUR SECTION ───────── */
        .features-section { background: var(--color-dark); }
        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 24px; margin-top: 56px;
        }
        .feature-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: var(--radius-card);
            padding: 32px; transition: transform 0.3s, border-color 0.3s;
        }
        .feature-card:hover { transform: translateY(-6px); border-color: rgba(23,162,184,0.4); }
        .feature-icon {
            width: 56px; height: 56px; border-radius: 14px;
            background: linear-gradient(135deg, rgba(14,111,173,0.25), rgba(23,162,184,0.25));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: var(--color-teal);
            margin-bottom: 20px;
        }
        .feature-card h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 10px; }
        .feature-card p { font-size: 0.85rem; color: var(--color-muted); line-height: 1.7; }

        /* ───────── TUGAS POKOK ───────── */
        .tugas-section {
            background: linear-gradient(160deg, var(--color-navy) 0%, #0a1628 100%);
        }
        .tugas-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center; }
        .tugas-list { display: flex; flex-direction: column; gap: 16px; }
        .tugas-item {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 18px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }
        .tugas-item:hover { border-color: rgba(23,162,184,0.4); }
        .tugas-item .bullet {
            width: 10px; height: 10px; border-radius: 50%;
            background: linear-gradient(135deg, var(--color-primary), var(--color-teal));
            flex-shrink: 0;
        }
        .info-box {
            background: linear-gradient(135deg, rgba(14,111,173,0.15), rgba(23,162,184,0.1));
            border: 1px solid rgba(23,162,184,0.25);
            border-radius: 20px; padding: 36px;
        }
        .info-box h3 { font-size: 1.3rem; font-weight: 700; margin-bottom: 16px; }
        .info-box p { color: var(--color-muted); line-height: 1.8; font-size: 0.9rem; }
        .info-contact { margin-top: 24px; display: flex; flex-direction: column; gap: 10px; }
        .info-contact-item {
            display: flex; align-items: center; gap: 12px;
            font-size: 0.85rem; color: rgba(255,255,255,0.75);
        }
        .info-contact-item i { color: var(--color-teal); width: 16px; }

        /* ───────── FOOTER ───────── */
        footer {
            background: #070f1c;
            border-top: 1px solid rgba(255,255,255,0.07);
            padding: 64px 24px 0;
        }
        .footer-inner {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: 2fr 1fr 1fr;
            gap: 48px; padding-bottom: 48px;
        }
        .footer-brand .logo { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .footer-brand .logo-icon {
            width: 46px; height: 46px; border-radius: 12px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-teal));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .footer-brand .logo-text strong { display: block; font-size: 1rem; font-weight: 700; }
        .footer-brand .logo-text span { font-size: 0.78rem; color: var(--color-muted); }
        .footer-brand p { font-size: 0.85rem; color: var(--color-muted); line-height: 1.7; max-width: 340px; }
        .footer-col h4 { font-size: 0.9rem; font-weight: 700; margin-bottom: 20px; color: white; }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .footer-col ul li a {
            color: var(--color-muted); text-decoration: none; font-size: 0.85rem;
            transition: color 0.2s;
        }
        .footer-col ul li a:hover { color: var(--color-teal); }
        .footer-address { display: flex; flex-direction: column; gap: 10px; margin-top: 4px; }
        .footer-address-item {
            display: flex; gap: 10px; align-items: flex-start;
            font-size: 0.83rem; color: var(--color-muted); line-height: 1.5;
        }
        .footer-address-item i { color: var(--color-teal); margin-top: 3px; flex-shrink: 0; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.07);
            padding: 20px 0;
            max-width: 1200px; margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
            font-size: 0.8rem; color: var(--color-muted);
        }

        /* ───────── ANIMATIONS ───────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ───────── RESPONSIVE ───────── */
        @media (max-width: 900px) {
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
            .about-grid, .tugas-grid, .footer-inner { grid-template-columns: 1fr; gap: 40px; }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .about-badge-float { position: static; margin-top: 20px; display: inline-block; }
        }
        @media (max-width: 600px) {
            .features-grid { grid-template-columns: 1fr; }
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
            .footer-inner { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- ───────── NAVBAR ───────── -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="/" class="navbar-brand">
            <div class="logo-icon"><i class="fa-solid fa-water"></i></div>
            <div class="brand-text">
                <strong>Manajemen Aset</strong>
                Sudin SDA Jakarta Utara
            </div>
        </a>
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/admin') }}" class="navbar-login"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="navbar-login"><i class="fa-solid fa-right-to-bracket"></i> Masuk</a>
            @endauth
        @endif
    </div>
</nav>

<!-- ───────── HERO CAROUSEL ───────── -->
<section class="hero" style="padding:0;">
    <div class="carousel-track" id="carouselTrack">
        <!-- Slide 1 -->
        <div class="carousel-slide">
            <img src="{{ asset('images/hero_banner.jpg') }}" alt="Gedung Sudin SDA Jakarta Utara">
            <div class="carousel-content">
                <div class="carousel-badge"><i class="fa-solid fa-droplet"></i> Suku Dinas SDA Jakarta Utara</div>
                <h1 class="carousel-title">Sistem Manajemen Aset<br><span>Infrastruktur Air</span> Jakarta Utara</h1>
                <p class="carousel-desc">Platform digital terintegrasi untuk pencatatan, pemantauan, dan pengelolaan seluruh aset Suku Dinas Sumber Daya Air Kota Administrasi Jakarta Utara secara transparan dan akuntabel.</p>
                <div class="carousel-cta">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/admin') }}" class="btn-primary"><i class="fa-solid fa-gauge"></i> Buka Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary"><i class="fa-solid fa-right-to-bracket"></i> Masuk ke Sistem</a>
                        @endauth
                    @endif
                    <a href="#tentang" class="btn-outline-white"><i class="fa-solid fa-circle-info"></i> Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-slide">
            <img src="{{ asset('images/carousel_flood.jpg') }}" alt="Pengendalian Banjir Jakarta Utara">
            <div class="carousel-content">
                <div class="carousel-badge"><i class="fa-solid fa-shield-halved"></i> Pengendalian Banjir</div>
                <h1 class="carousel-title">Menjaga <span>Infrastruktur Air</span><br>dari Pintu ke Pintu</h1>
                <p class="carousel-desc">Pemantauan kondisi pompa, pintu air, dan saluran drainase secara real-time untuk memastikan ketahanan Jakarta Utara terhadap banjir dan genangan.</p>
                <div class="carousel-cta">
                    @auth
                        <a href="{{ url('/admin') }}" class="btn-primary"><i class="fa-solid fa-gauge"></i> Buka Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary"><i class="fa-solid fa-right-to-bracket"></i> Masuk ke Sistem</a>
                    @endauth
                </div>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-slide">
            <img src="{{ asset('images/carousel_asset.jpg') }}" alt="Sistem Manajemen Aset Digital">
            <div class="carousel-content">
                <div class="carousel-badge"><i class="fa-solid fa-database"></i> Manajemen Aset Digital</div>
                <h1 class="carousel-title">Data Aset yang <span>Akurat</span>,<br>Keputusan yang <span>Tepat</span></h1>
                <p class="carousel-desc">Inventarisasi aset berbasis sensus lapangan yang dilengkapi koordinat GPS, dokumentasi foto, dan riwayat perolehan untuk tata kelola yang lebih baik.</p>
                <div class="carousel-cta">
                    @auth
                        <a href="{{ url('/admin') }}" class="btn-primary"><i class="fa-solid fa-gauge"></i> Buka Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary"><i class="fa-solid fa-right-to-bracket"></i> Masuk ke Sistem</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Arrows -->
    <button class="carousel-arrow prev" id="prevArrow"><i class="fa-solid fa-chevron-left"></i></button>
    <button class="carousel-arrow next" id="nextArrow"><i class="fa-solid fa-chevron-right"></i></button>

    <!-- Dots -->
    <div class="carousel-controls" id="carouselDots">
        <button class="carousel-dot active"></button>
        <button class="carousel-dot"></button>
        <button class="carousel-dot"></button>
    </div>
</section>

<!-- ───────── STATS STRIP ───────── -->
<div class="stats-strip">
    <div class="stats-inner">
        <div class="stat-item">
            <div class="stat-number">6</div>
            <div class="stat-label">Kecamatan di Jakarta Utara</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">31</div>
            <div class="stat-label">Kelurahan Terlayani</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">1.000+</div>
            <div class="stat-label">Aset Terdata</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">100%</div>
            <div class="stat-label">Sistem Terintegrasi</div>
        </div>
    </div>
</div>

<!-- ───────── TENTANG KAMI ───────── -->
<section class="about-section" id="tentang">
    <div class="section-inner">
        <div class="about-grid">
            <div class="about-image-wrap">
                <img src="{{ asset('images/hero_banner.jpg') }}" alt="Sudin SDA Jakarta Utara">
                <div class="about-badge-float">
                    <div class="num">2024</div>
                    <div class="lbl">Digitalisasi Aset</div>
                </div>
            </div>
            <div>
                <div class="section-eyebrow"><i class="fa-solid fa-building-columns"></i> Tentang Instansi</div>
                <h2 class="section-title">Suku Dinas Sumber Daya Air<br>Jakarta Utara</h2>
                <p class="section-desc">Suku Dinas Sumber Daya Air (Sudin SDA) Kota Administrasi Jakarta Utara adalah unit kerja di bawah Dinas Sumber Daya Air Provinsi DKI Jakarta yang bertugas mengelola, memelihara, dan mengembangkan infrastruktur sumber daya air di wilayah Jakarta Utara, meliputi saluran, pompa, pintu air, dan tanggul pengendali banjir.</p>
                <div class="about-points">
                    <div class="about-point">
                        <div class="icon"><i class="fa-solid fa-shield-water"></i></div>
                        <div>
                            <h4>Pengendalian Banjir</h4>
                            <p>Operasi dan pemeliharaan pompa banjir, pintu air, dan saluran drainase utama di seluruh wilayah Jakarta Utara.</p>
                        </div>
                    </div>
                    <div class="about-point">
                        <div class="icon"><i class="fa-solid fa-clipboard-check"></i></div>
                        <div>
                            <h4>Inventarisasi Aset</h4>
                            <p>Pendataan dan dokumentasi seluruh aset infrastruktur air secara digital berbasis sensus lapangan dengan GPS.</p>
                        </div>
                    </div>
                    <div class="about-point">
                        <div class="icon"><i class="fa-solid fa-chart-line"></i></div>
                        <div>
                            <h4>Perencanaan & Pembangunan</h4>
                            <p>Perencanaan pembangunan infrastruktur baru dan rehabilitasi aset lama berbasis data yang akurat dan terkini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───────── FITUR SISTEM ───────── -->
<section class="features-section">
    <div class="section-inner">
        <div style="text-align: center; max-width: 640px; margin: 0 auto;">
            <div class="section-eyebrow" style="justify-content: center;"><i class="fa-solid fa-star"></i> Fitur Unggulan</div>
            <h2 class="section-title">Semua yang Anda Butuhkan<br>dalam Satu Platform</h2>
            <p class="section-desc" style="margin: 0 auto;">Sistem manajemen aset modern yang dirancang khusus untuk kebutuhan pengelolaan infrastruktur air pemerintah daerah.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-database"></i></div>
                <h3>Manajemen Aset</h3>
                <p>Pencatatan lengkap seluruh aset infrastruktur air: pompa, pintu air, tanggul, gedung, kendaraan, dan peralatan kantor dalam satu database terpadu.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                <h3>Peta Interaktif</h3>
                <p>Visualisasi lokasi aset di atas peta berbasis koordinat GPS hasil sensus lapangan, memudahkan pemantauan persebaran dan kondisi aset.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-camera"></i></div>
                <h3>Dokumentasi Foto</h3>
                <p>Penyimpanan foto kondisi aset dari lapangan, lengkap dengan tanggal pengambilan dan lokasi, untuk bukti audit dan evaluasi.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-file-excel"></i></div>
                <h3>Import/Export Excel</h3>
                <p>Kemudahan migrasi data dari file Excel hasil sensus lapangan ke dalam sistem digital secara massal dan cepat.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                <h3>Sensus Aset</h3>
                <p>Modul khusus pendataan hasil sensus lapangan yang mencakup data lokasi RT/RW, koordinat, kondisi fisik, dan nilai perolehan aset.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h3>Keamanan Data</h3>
                <p>Sistem otentikasi berlapis dan manajemen akses berbasis peran memastikan data aset pemerintah terlindungi dari akses yang tidak berwenang.</p>
            </div>
        </div>
    </div>
</section>

<!-- ───────── TUGAS POKOK ───────── -->
<section class="tugas-section">
    <div class="section-inner">
        <div class="tugas-grid">
            <div>
                <div class="section-eyebrow"><i class="fa-solid fa-list-check"></i> Tugas & Fungsi</div>
                <h2 class="section-title">Tugas Pokok<br>Sudin SDA Jakarta Utara</h2>
                <p class="section-desc" style="margin-bottom: 32px;">Berdasarkan Pergub DKI Jakarta, Sudin SDA Jakarta Utara menyelenggarakan tugas dan fungsi sebagai berikut:</p>
                <div class="tugas-list">
                    <div class="tugas-item"><div class="bullet"></div> Penyusunan Rencana Strategis (Renstra) bidang SDA</div>
                    <div class="tugas-item"><div class="bullet"></div> Pelaksanaan pembangunan sarana dan prasarana SDA</div>
                    <div class="tugas-item"><div class="bullet"></div> Operasi dan pemeliharaan pompa banjir & pintu air</div>
                    <div class="tugas-item"><div class="bullet"></div> Pengelolaan drainase dan normalisasi sungai/kali</div>
                    <div class="tugas-item"><div class="bullet"></div> Inventarisasi dan pengamanan aset SDA wilayah Jakarta Utara</div>
                    <div class="tugas-item"><div class="bullet"></div> Koordinasi penanganan banjir dan genangan</div>
                    <div class="tugas-item"><div class="bullet"></div> Pelaporan kinerja dan pengelolaan administrasi</div>
                </div>
            </div>
            <div class="info-box">
                <h3><i class="fa-solid fa-location-dot" style="color: var(--color-teal); margin-right: 8px;"></i>Informasi Kantor</h3>
                <p>Suku Dinas Sumber Daya Air Kota Administrasi Jakarta Utara melayani 6 kecamatan dan 31 kelurahan dalam pengelolaan infrastruktur air.</p>
                <div class="info-contact">
                    <div class="info-contact-item">
                        <i class="fa-solid fa-map-marker-alt"></i>
                        <span>Jl. Yos Sudarso No. 27-29, Sunter Jaya, Kec. Tanjung Priok, Kota Administrasi Jakarta Utara, DKI Jakarta 14350</span>
                    </div>
                    <div class="info-contact-item">
                        <i class="fa-solid fa-clock"></i>
                        <span>Senin – Jumat: 07.30 – 16.00 WIB</span>
                    </div>
                    <div class="info-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>(021) 6500 532</span>
                    </div>
                    <div class="info-contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>sudin.sda.jakut@jakarta.go.id</span>
                    </div>
                    <div class="info-contact-item">
                        <i class="fa-solid fa-globe"></i>
                        <span>sda.jakarta.go.id</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───────── FOOTER ───────── -->
<footer>
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="logo">
                <div class="logo-icon"><i class="fa-solid fa-water" style="color: white;"></i></div>
                <div class="logo-text">
                    <strong>Sistem Manajemen Aset</strong>
                    <span>Sudin SDA Jakarta Utara</span>
                </div>
            </div>
            <p>Platform digital pengelolaan aset infrastruktur air Suku Dinas Sumber Daya Air Kota Administrasi Jakarta Utara, Pemerintah Provinsi DKI Jakarta.</p>
        </div>
        <div class="footer-col">
            <h4>Navigasi</h4>
            <ul>
                <li><a href="#tentang">Tentang Sudin SDA</a></li>
                <li><a href="#tentang">Tugas & Fungsi</a></li>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/admin') }}">Dashboard Aset</a></li>
                        <li><a href="{{ url('/admin/sensus') }}">Data Sensus</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Masuk ke Sistem</a></li>
                    @endauth
                @endif
            </ul>
        </div>
        <div class="footer-col">
            <h4>Alamat</h4>
            <div class="footer-address">
                <div class="footer-address-item">
                    <i class="fa-solid fa-map-marker-alt"></i>
                    <span>Jl. Yos Sudarso No. 27-29, Sunter Jaya, Tanjung Priok, Jakarta Utara 14350</span>
                </div>
                <div class="footer-address-item">
                    <i class="fa-solid fa-phone"></i>
                    <span>(021) 6500 532</span>
                </div>
                <div class="footer-address-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span>sudin.sda.jakut@jakarta.go.id</span>
                </div>
                <div class="footer-address-item">
                    <i class="fa-solid fa-clock"></i>
                    <span>Senin–Jumat, 07.30–16.00 WIB</span>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} Sudin SDA Jakarta Utara – Pemerintah Provinsi DKI Jakarta. Seluruh hak dilindungi.</span>
        <span>Sistem Manajemen Aset v1.0</span>
    </div>
</footer>

<script>
    // ─── Carousel Logic ───
    const track  = document.getElementById('carouselTrack');
    const dots   = document.querySelectorAll('.carousel-dot');
    const prev   = document.getElementById('prevArrow');
    const next   = document.getElementById('nextArrow');
    let current  = 0;
    let timer;

    function goTo(index) {
        current = (index + 3) % 3;
        track.style.transform = `translateX(-${current * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    function startTimer() {
        clearInterval(timer);
        timer = setInterval(() => goTo(current + 1), 5000);
    }

    prev.addEventListener('click', () => { goTo(current - 1); startTimer(); });
    next.addEventListener('click', () => { goTo(current + 1); startTimer(); });
    dots.forEach((d, i) => d.addEventListener('click', () => { goTo(i); startTimer(); }));

    // Touch swipe support
    let touchStartX = 0;
    track.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; });
    track.addEventListener('touchend', e => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) { diff > 0 ? goTo(current + 1) : goTo(current - 1); startTimer(); }
    });

    startTimer();

    // ─── Navbar scroll effect ───
    window.addEventListener('scroll', () => {
        document.querySelector('.navbar').style.background =
            window.scrollY > 60 ? 'rgba(10,22,40,0.97)' : 'rgba(10,22,40,0.85)';
    });
</script>
</body>
</html>
