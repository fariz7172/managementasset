@extends('layouts.admin')

@section('title', 'Overview Dashboard')

@section('content')
<!-- Page Header -->
<div class="flex justify-between items-end mb-8">
    <div>
        <h2 class="text-3xl font-display font-bold text-slate-900">Overview Dashboard</h2>
        <p class="text-slate-500 mt-1 font-medium">Ringkasan operasional dan data konten Portal SDA Jakarta Utara.</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Stat Card 1: Articles -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary-50 rounded-full group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Artikel Kegiatan</p>
                <h3 class="text-3xl font-display font-bold text-slate-900">{{ $articleCount }}<span class="text-lg text-slate-400 font-medium ml-1">Data</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3m0 0l3-3m-3 3V8"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-primary-600 font-semibold flex items-center">
                Total Laporan Kegiatan
            </span>
        </div>
    </div>

    <!-- Stat Card 2: Portals -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-cyan-50 rounded-full group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Portal Aplikasi</p>
                <h3 class="text-3xl font-display font-bold text-slate-900">{{ $portalCount }}<span class="text-lg text-slate-400 font-medium ml-1">App</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center text-cyan-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-cyan-600 font-semibold flex items-center">
                Sistem Terpublikasi
            </span>
        </div>
    </div>

    <!-- Stat Card 3: Images -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Foto Dokumentasi</p>
                <h3 class="text-3xl font-display font-bold text-slate-900">{{ $imageCount }}<span class="text-lg text-slate-400 font-medium ml-1">File</span></h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-indigo-600 font-semibold">
                Tersimpan di Server
            </span>
        </div>
    </div>

    <!-- Stat Card 4: System -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10 flex justify-between items-start">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-1">Status Sistem</p>
                <h3 class="text-3xl font-display font-bold text-slate-900">100%</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-emerald-600 font-semibold">
                Aman & Optimal
            </span>
        </div>
    </div>
</div>

<!-- Content Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column (Tables) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Recent Articles -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-display font-bold text-lg text-slate-800">Kegiatan Terbaru</h3>
                <a href="{{ route('admin.articles.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">Lihat Semua &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-6 py-4">Judul Kegiatan</th>
                            <th class="px-6 py-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($recentArticles as $article)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $article->title }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($article->status == 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Published</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">Draft</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-slate-500">Belum ada data kegiatan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Portals -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-display font-bold text-lg text-slate-800">Portal Aplikasi Terbaru</h3>
                <a href="{{ route('admin.portals.index') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700">Lihat Semua &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="px-6 py-4">Nama Aplikasi</th>
                            <th class="px-6 py-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($recentPortals as $portal)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $portal->title }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($portal->status == 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">Draft</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-slate-500">Belum ada data aplikasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column (Weather) -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col sticky top-6">
            <div class="p-6 border-b border-slate-100">
                <h3 class="font-display font-bold text-lg text-slate-800">Cuaca Jakarta Utara (Real-time)</h3>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-center items-center text-center bg-gradient-to-br from-indigo-500 to-primary-600 text-white relative min-h-[300px]">
                <!-- Decorative clouds -->
                <svg class="absolute top-4 left-4 w-12 h-12 text-white/20" fill="currentColor" viewBox="0 0 24 24"><path d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5 0-2.316-1.748-4.225-4-4.464V9.5C18 6.462 15.538 4 12.5 4 9.873 4 7.674 5.845 7.126 8.312 4.182 8.784 2 11.263 2 14.25 2 17.426 4.574 20 7.75 20h9.75z"/></svg>
                
                @if($weather)
                    @php
                        // Mapping WMO Weather interpretation codes
                        $code = $weather['weathercode'] ?? 0;
                        $desc = 'Cerah';
                        $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>'; // Sun
                        
                        if (in_array($code, [1, 2, 3])) {
                            $desc = 'Berawan';
                            $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15h18M3 15a4 4 0 114-4M3 15a4 4 0 104 4M21 15a4 4 0 11-4-4M21 15a4 4 0 10-4 4m-8-4v-4m0 4v4m4-4v-4m0 4v4m-4-8a4 4 0 114-4"></path>'; // Cloud
                        } elseif (in_array($code, [51, 53, 55, 61, 63, 65, 80, 81, 82])) {
                            $desc = 'Hujan';
                            $icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7.5 7.5 0 00-15 0v3.5A7.5 7.5 0 0011.5 22h1.5M12 11v8m-4-6v6m8-4v4"></path>'; // Rain
                        } elseif (in_array($code, [71, 73, 75, 77, 85, 86])) {
                            $desc = 'Salju/Dingin';
                        } elseif (in_array($code, [95, 96, 99])) {
                            $desc = 'Badai Petir';
                        }
                    @endphp
                    
                    <div class="mb-4">
                        <svg class="w-20 h-20 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                    </div>
                    <h4 class="text-4xl font-display font-bold mb-1 drop-shadow-md">{{ $desc }}</h4>
                    <p class="text-primary-100 font-medium mb-6">Suhu: {{ $weather['temperature'] }}°C</p>
                    
                    <div class="w-full bg-white/20 backdrop-blur-md rounded-xl p-4 flex justify-around">
                        <div>
                            <p class="text-xs text-primary-200 font-medium uppercase mb-1">Angin</p>
                            <p class="font-bold text-lg">{{ $weather['windspeed'] }} km/j</p>
                        </div>
                        <div>
                            <p class="text-xs text-primary-200 font-medium uppercase mb-1">Arah</p>
                            <p class="font-bold text-lg">{{ $weather['winddirection'] }}°</p>
                        </div>
                    </div>
                @else
                    <div class="mb-4">
                        <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-primary-100 font-medium">Gagal memuat data cuaca saat ini.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
