<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Management Akses</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- MapLibre GL (for MapTiler) -->
    <link href="https://unpkg.com/maplibre-gl@3.3.1/dist/maplibre-gl.css" rel="stylesheet" />
    <script src="https://unpkg.com/maplibre-gl@3.3.1/dist/maplibre-gl.js"></script>
    
    <!-- Vite CSS -->
    @vite(['resources/css/admin.css'])

    <style>
        /* Form Styles Backup */
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color, #e5e7eb);
            border-radius: 8px;
            outline: none;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--color-text-dark, #1f2937);
            transition: all 0.3s;
            background: var(--color-white, #ffffff);
        }
        .form-control:focus {
            border-color: var(--color-teal, #24b1b1);
            box-shadow: 0 0 0 3px rgba(36, 177, 177, 0.1);
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--color-text-muted, #6b7280);
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

    <div class="admin-layout">
        
        <!-- Mobile Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Admin</span>Panel
            </div>
            <nav class="sidebar-nav animate-fade-in delay-2">
                <a href="{{ url('/admin/dashboard') }}" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ url('/admin/akses') }}" class="nav-item {{ request()->is('admin/akses') ? 'active' : '' }}">
                    <i class="fa-solid fa-shield-halved"></i> SPP/SPM
                </a>
                <a href="{{ url('/admin/assets') }}" class="nav-item {{ request()->is('admin/assets*') ? 'active' : '' }}">
                    <i class="fa-solid fa-folder-open"></i> Assets
                </a>
                <a href="{{ route('sensus.index') }}" class="nav-item {{ request()->is('admin/sensus*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-signature"></i> Data Sensus Asset
                </a>
                <!-- <a href="#" class="nav-item">
                    <i class="fa-solid fa-chart-pie"></i> Laporan
                </a> -->
                

                <div style="margin: 24px 20px 10px 20px; font-size: 0.75rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Sistem
                </div>
                <a href="{{ route('admin.backup') }}" class="nav-item" onclick="return confirm('Mulai proses backup database? File SQL akan diunduh ke komputer Anda.')">
                    <i class="fa-solid fa-database"></i> Backup Database
                </a>
                <div style="margin: 24px 20px 10px 20px; font-size: 0.75rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Master Data
                </div>
                <a href="{{ url('/admin/kecamatan') }}" class="nav-item {{ request()->is('admin/kecamatan*') ? 'active' : '' }}">
                    <i class="fa-solid fa-map-location-dot"></i> Kecamatan
                </a>
                <a href="{{ url('/admin/kelurahan') }}" class="nav-item {{ request()->is('admin/kelurahan*') ? 'active' : '' }}">
                    <i class="fa-solid fa-map-pin"></i> Kelurahan
                </a>
                <!-- <a href="{{ url('/admin/dewan') }}" class="nav-item {{ request()->is('admin/dewan*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-viewfinder"></i> Data Dewan
                </a> -->
                
                <div style="margin: 24px 20px 10px 20px; font-size: 0.75rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Pengaturan
                </div>
                
                <!-- <a href="#" class="nav-item">
                    <i class="fa-solid fa-gear"></i> Sistem
                </a> -->
                
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" class="nav-item" style="color: var(--color-orange); background: transparent; border: none; width: 100%; text-align: left; cursor: pointer; font-size: 1rem; margin-top: 10px; display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="header-title">@yield('page_title', 'Dashboard')</h1>
                </div>
                <div class="header-right">
                    <div class="user-profile">
                        <div style="text-align: right; display: block;" class="d-md-block">
                            <div style="font-size: 0.875rem; font-weight: 600;">{{ Auth::user()->name ?? 'Administrator' }}</div>
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">{{ Auth::user()->email ?? 'admin@gmail.com' }}</div>
                        </div>
                        <div class="avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                    </div>
                </div>
            </header>

            <!-- Dynamic Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Script for Mobile Sidebar Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleMenu() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            if(menuToggle) {
                menuToggle.addEventListener('click', toggleMenu);
            }
            if(overlay) {
                overlay.addEventListener('click', toggleMenu);
            }
        });
    </script>
</body>
</html>
