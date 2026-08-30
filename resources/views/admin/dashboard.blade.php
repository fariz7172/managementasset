@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')

<!-- Welcome Banner -->
<div class="glass-card animate-fade-in delay-1" style="background: linear-gradient(135deg, rgba(36,177,177,0.1) 0%, rgba(36,177,177,0.02) 100%); border-left: 4px solid var(--color-teal);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="font-size: 1.5rem; color: var(--color-teal); margin-bottom: 8px;">Selamat Datang, Super Admin! 👋</h2>
            <p style="color: var(--color-text-muted); font-size: 0.95rem;">Berikut adalah ringkasan aktivitas dan status sistem hari ini.</p>
        </div>
        <div>
            <a href="{{ url('/admin/akses') }}" class="btn btn-primary">
                <i class="fa-solid fa-users-gear"></i> Kelola Akses
            </a>
        </div>
    </div>
</div>

<!-- Main Stats -->
<div class="stats-grid animate-fade-in delay-2">
    <div class="stat-card">
        <div class="stat-icon teal">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <div class="stat-info">
            <h3>Total Assets</h3>
            <p>{{ number_format($totalAssets, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>
        <div class="stat-info">
            <h3>Total Tagihan API</h3>
            <p>{{ number_format($totalApiPayments, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon teal">
            <i class="fa-solid fa-spinner"></i>
        </div>
        <div class="stat-info">
            <h3>Asset Proses/Tertunda</h3>
            <p>{{ number_format($assetProses, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fa-solid fa-check-double"></i>
        </div>
        <div class="stat-info">
            <h3>Asset Selesai</h3>
            <p>{{ number_format($assetSelesai, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<!-- Total Nilai Pembayaran Section -->
<div class="glass-card animate-fade-in delay-2" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 16px;">
        <h2 class="card-title" style="margin: 0;">Total Nilai Pembayaran API</h2>
        
        <!-- Filter Form -->
        <form action="{{ url('/admin/dashboard') }}" method="GET" style="display: flex; gap: 10px; align-items: flex-end;">
            <div>
                <label style="font-size: 0.75rem; font-weight: 600; color: var(--color-text-muted); display: block; margin-bottom: 4px;">Tanggal Awal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="padding: 6px 12px; font-size: 0.85rem; border-radius: 6px;">
            </div>
            <div>
                <label style="font-size: 0.75rem; font-weight: 600; color: var(--color-text-muted); display: block; margin-bottom: 4px;">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="padding: 6px 12px; font-size: 0.85rem; border-radius: 6px;">
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.85rem; border-radius: 6px;">Filter</button>
            @if(request('start_date') || request('end_date'))
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem; border-radius: 6px;">Reset</a>
            @endif
        </form>
    </div>

    <div style="background: rgba(36, 177, 177, 0.05); padding: 20px; border-radius: 12px; border: 1px solid rgba(36, 177, 177, 0.2);">
        <small style="color: var(--color-teal); text-transform: uppercase; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Total Seluruh Nilai Pembayaran</small>
        <div style="color: var(--color-teal); font-size: 2rem; font-weight: 700; margin-top: 8px;">Rp {{ number_format($totalNilaiPembayaran, 0, ',', '.') }}</div>
        <div style="font-size: 0.85rem; font-style: italic; color: var(--color-text-muted); margin-top: 8px; font-weight: 500;">{{ $terbilangTotal }}</div>
    </div>
</div>

<!-- Lower Section (Two columns on desktop) -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;" class="animate-fade-in delay-3">
    
    <!-- Recent Activity -->
    <div class="glass-card" style="margin-bottom: 0;">
        <div class="card-header">
            <h2 class="card-title">Aktivitas Terbaru</h2>
            <button class="btn btn-outline" style="padding: 6px 12px; font-size: 0.75rem;">Lihat Semua</button>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($recentAssets as $index => $asset)
            <div style="display: flex; gap: 16px; align-items: flex-start; padding-bottom: 16px; border-bottom: {{ $loop->last ? 'none' : '1px solid var(--border-color)' }};">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $index % 2 == 0 ? 'rgba(36,177,177,0.1)' : 'rgba(227,116,52,0.1)' }}; color: {{ $index % 2 == 0 ? 'var(--color-teal)' : 'var(--color-orange)' }}; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid {{ $asset->created_at == $asset->updated_at ? 'fa-plus' : 'fa-pen-to-square' }}"></i>
                </div>
                <div>
                    <h4 style="font-size: 0.875rem; color: var(--color-text-dark); margin-bottom: 4px;">{{ $asset->created_at == $asset->updated_at ? 'Asset Baru Ditambahkan' : 'Data Asset Diperbarui' }}</h4>
                    <p style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $asset->lokasi ?? 'Lokasi tidak diketahui' }} (Usulan: <strong>{{ $asset->dewan->nama ?? 'N/A' }}</strong>).</p>
                    <span style="font-size: 0.7rem; color: {{ $index % 2 == 0 ? 'var(--color-teal)' : 'var(--color-orange)' }}; font-weight: 500; margin-top: 4px; display: inline-block;">{{ \Carbon\Carbon::parse($asset->updated_at)->diffForHumans() }}</span>
                </div>
            </div>
            @empty
            <div style="text-align: center; color: var(--color-text-muted); padding: 20px;">
                <p>Belum ada aktivitas asset.</p>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Quick Actions / Shortcuts -->
    <div class="glass-card" style="margin-bottom: 0;">
        <div class="card-header">
            <h2 class="card-title">Aksi Cepat</h2>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <a href="{{ url('/admin/akses') }}" style="text-decoration: none; padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; transition: var(--transition);" onmouseover="this.style.borderColor='var(--color-teal)'; this.style.backgroundColor='rgba(36,177,177,0.03)';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.backgroundColor='transparent';">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(36,177,177,0.1); color: var(--color-teal); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <span style="font-size: 0.875rem; color: var(--color-text-dark); font-weight: 500;">Kelola Akses</span>
            </a>
            
            <a href="{{ url('/admin/assets') }}" style="text-decoration: none; padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; transition: var(--transition);" onmouseover="this.style.borderColor='var(--color-orange)'; this.style.backgroundColor='rgba(227,116,52,0.03)';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.backgroundColor='transparent';">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(227,116,52,0.1); color: var(--color-orange); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <span style="font-size: 0.875rem; color: var(--color-text-dark); font-weight: 500;">Master Asset</span>
            </a>
            
            <a href="{{ url('/admin/dewan') }}" style="text-decoration: none; padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; transition: var(--transition);" onmouseover="this.style.borderColor='var(--color-teal)'; this.style.backgroundColor='rgba(36,177,177,0.03)';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.backgroundColor='transparent';">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(36,177,177,0.1); color: var(--color-teal); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <span style="font-size: 0.875rem; color: var(--color-text-dark); font-weight: 500;">Master Dewan</span>
            </a>
            
            <a href="{{ url('/admin/kecamatan') }}" style="text-decoration: none; padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; transition: var(--transition);" onmouseover="this.style.borderColor='var(--color-orange)'; this.style.backgroundColor='rgba(227,116,52,0.03)';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.backgroundColor='transparent';">
                <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(227,116,52,0.1); color: var(--color-orange); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <span style="font-size: 0.875rem; color: var(--color-text-dark); font-weight: 500;">Master Wilayah</span>
            </a>
        </div>
    </div>
</div>

@endsection
