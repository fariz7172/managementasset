@extends('layouts.admin')

@section('title', 'Data Asset')
@section('page_title', 'Master Data Asset')

@section('content')

@if(session('success'))
<div style="background: var(--color-teal); color: white; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="glass-card animate-fade-in delay-1" style="max-width: 100%; overflow-x: hidden;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 class="card-title" style="margin: 0;">Daftar Asset</h2>
            <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-top: 4px;">Arsip asset hasil pemrosesan dari tagihan pembayaran API.</p>
        </div>
    </div>
    
    <div class="table-responsive" style="margin-top: 16px; overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
        <table style="width: 100%; border-collapse: collapse; min-width: 1000px;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                    <th style="padding: 12px; color: var(--color-text-muted);">Foto</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Dewan & Wilayah</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Lokasi & Detail</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Spesifikasi</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Biaya</th>
                    <th style="padding: 12px; color: var(--color-text-muted); text-align: center;">Status</th>
                    <th style="padding: 12px; color: var(--color-text-muted); text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets as $asset)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px; vertical-align: top;">
                        @if($asset->foto)
                            <img src="{{ asset('storage/' . $asset->foto) }}" alt="Foto Asset" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 1px solid var(--border-color);" onclick="zoomImage(this.src)">
                        @else
                            <div style="width: 80px; height: 80px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; text-align: center; border: 1px dashed var(--border-color);">Tanpa<br>Foto</div>
                        @endif
                    </td>
                    <td style="padding: 12px; vertical-align: top;">
                        <div style="font-weight: 600; color: var(--color-text-dark); margin-bottom: 4px;">{{ $asset->dewan->nama ?? '-' }}</div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">
                            <i class="fa-solid fa-map-location-dot"></i> {{ $asset->kecamatan->nama_kecamatan ?? '-' }}<br>
                            <i class="fa-solid fa-map-pin"></i> {{ $asset->kelurahan->nama_kelurahan ?? '-' }}
                        </div>
                    </td>
                    <td style="padding: 12px; vertical-align: top;">
                        <div style="font-size: 0.85rem; color: var(--color-text-dark); margin-bottom: 4px;">
                            <strong>Lokasi:</strong> {{ $asset->lokasi ?? '-' }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-bottom: 4px;">
                            <strong>Lat, Long:</strong> {{ $asset->latitude ?? '-' }}, {{ $asset->longtitude ?? '-' }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">
                            <strong>Usulan:</strong> {{ \Illuminate\Support\Str::limit($asset->permintaan, 50) }}
                        </div>
                    </td>
                    <td style="padding: 12px; vertical-align: top; font-size: 0.85rem; color: var(--color-text-dark);">
                        <div style="margin-bottom: 2px;"><strong>P:</strong> {{ $asset->panjang ?? 0 }} m</div>
                        <div style="margin-bottom: 2px;"><strong>L:</strong> {{ $asset->lebar ?? 0 }} m</div>
                        <div style="margin-bottom: 2px;"><strong>T:</strong> {{ $asset->tinggi ?? 0 }} m</div>
                        <div style="margin-top: 6px; padding-top: 4px; border-top: 1px dashed var(--border-color); color: var(--color-teal); font-weight: 600;">
                            Vol: {{ $asset->volume ?? 0 }}
                        </div>
                    </td>
                    <td style="padding: 12px; vertical-align: top; font-weight: 700; color: var(--color-text-dark);">
                        Rp {{ number_format($asset->biaya, 0, ',', '.') }}
                    </td>
                    <td style="padding: 12px; vertical-align: top; text-align: center;">
                        @if($asset->status == 'Selesai')
                            <span class="badge" style="background: rgba(36, 177, 177, 0.1); color: var(--color-teal); padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Selesai</span>
                        @elseif($asset->status == 'Proses')
                            <span class="badge" style="background: rgba(227, 116, 52, 0.1); color: var(--color-orange); padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Proses</span>
                        @else
                            <span class="badge" style="background: #f3f4f6; color: var(--color-text-muted); padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">{{ $asset->status ?? 'Tertunda' }}</span>
                        @endif
                        
                        <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 8px;">
                            {{ $asset->tanggal_reses ? \Carbon\Carbon::parse($asset->tanggal_reses)->format('d M Y') : '-' }}
                        </div>
                    </td>
                    <td style="padding: 12px; vertical-align: top; text-align: center; white-space: nowrap;">
                        <button class="btn-icon view" title="Detail" style="color: var(--color-teal); background: rgba(36, 177, 177, 0.1);" onclick="openDetailModal({{ $asset->id }})">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn-icon edit" title="Edit" style="color: var(--color-orange); background: rgba(227, 116, 52, 0.1); display: inline-flex; text-decoration: none;">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data asset ini beserta fotonya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon delete" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 24px; text-align: center; color: var(--color-text-muted);">Belum ada data Asset yang tersimpan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Image Zoom Modal -->
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1050; align-items: center; justify-content: center; backdrop-filter: blur(5px);" onclick="this.style.display='none'">
    <span style="position: absolute; top: 20px; right: 30px; font-size: 2rem; color: white; cursor: pointer;">&times;</span>
    <img id="zoomedImage" src="" style="max-width: 90%; max-height: 90vh; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
</div>

<!-- Detail Modal -->
<div id="modalDetailAsset" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1050; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; margin: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
            <h3 style="margin: 0; color: var(--color-text-dark); display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(36, 177, 177, 0.1); color: var(--color-teal); display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-eye"></i></div>
                Detail Asset
            </h3>
            <span style="font-size: 1.5rem; cursor: pointer; color: var(--color-text-muted);" onclick="document.getElementById('modalDetailAsset').style.display='none'">&times;</span>
        </div>

        <div id="detailContent" style="display: grid; gap: 16px;">
            <!-- Rendered via JS -->
        </div>
        
        <div id="mapContainer" style="width: 100%; height: 250px; margin-top: 16px; border-radius: 8px; border: 1px solid var(--border-color); display: none; z-index: 1;"></div>
        
        <div style="margin-top: 24px; text-align: right;">
            <button type="button" class="btn btn-outline" onclick="document.getElementById('modalDetailAsset').style.display='none'">Tutup</button>
        </div>
    </div>
</div>

<!-- Edit Modal Removed, moved to separate view -->

<script>
    const allAssets = @json($assets ?? []);
    const allKelurahans = @json($kelurahans ?? []);
    
    let detailMap = null;
    let detailMarker = null;

    function zoomImage(src) {
        document.getElementById('zoomedImage').src = src;
        document.getElementById('imageModal').style.display = 'flex';
    }

    function openDetailModal(id) {
        const asset = allAssets.find(a => a.id === id);
        if (!asset) return;

        const dewan = asset.dewan ? asset.dewan.nama : '-';
        const fraksi = asset.dewan ? asset.dewan.fraksi : '-';
        const kecamatan = asset.kecamatan ? asset.kecamatan.nama_kecamatan : '-';
        const kelurahan = asset.kelurahan ? asset.kelurahan.nama_kelurahan : '-';
        const formatRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(asset.biaya || 0);
        
        let photoHtml = '';
        if (asset.foto) {
            photoHtml = `<img src="/storage/${asset.foto}" style="width: 100%; max-height: 250px; object-fit: cover; border-radius: 8px; margin-bottom: 16px; border: 1px solid var(--border-color);">`;
        }

        const html = `
            ${photoHtml}
            <div style="display: grid; grid-template-columns: 130px 1fr; gap: 8px; font-size: 0.9rem; color: var(--color-text-dark);">
                <span style="color: var(--color-text-muted);">Pengusul</span> <strong>${dewan} (${fraksi})</strong>
                <span style="color: var(--color-text-muted);">Wilayah</span> <strong>${kecamatan} - ${kelurahan}</strong>
                <span style="color: var(--color-text-muted);">Lokasi</span> <strong>${asset.lokasi || '-'}</strong>
                <span style="color: var(--color-text-muted);">Koordinat</span> <strong>${asset.latitude || '-'}, ${asset.longtitude || '-'}</strong>
                <hr style="grid-column: span 2; border: 0; border-top: 1px dashed var(--border-color); margin: 8px 0;">
                <span style="color: var(--color-text-muted);">Permintaan</span> <strong>${asset.permintaan || '-'}</strong>
                <span style="color: var(--color-text-muted);">Dimensi (PxLxT)</span> <strong>${asset.panjang||0}m x ${asset.lebar||0}m x ${asset.tinggi||0}m</strong>
                <span style="color: var(--color-text-muted);">Volume</span> <strong style="color: var(--color-teal);">${asset.volume||0} m³</strong>
                <span style="color: var(--color-text-muted);">Biaya</span> <strong style="color: var(--color-orange); font-size: 1.1rem;">${formatRupiah}</strong>
                <hr style="grid-column: span 2; border: 0; border-top: 1px dashed var(--border-color); margin: 8px 0;">
                <span style="color: var(--color-text-muted);">Status</span> <strong>${asset.status || 'Tertunda'}</strong>
                <span style="color: var(--color-text-muted);">Tanggal Reses</span> <strong>${asset.tanggal_reses || '-'}</strong>
                <span style="color: var(--color-text-muted);">Keterangan</span> <strong>${asset.keterangan || '-'}</strong>
            </div>
        `;
        document.getElementById('detailContent').innerHTML = html;
        document.getElementById('modalDetailAsset').style.display = 'flex';
        
        // Handle Map
        const mapContainer = document.getElementById('mapContainer');
        const lat = parseFloat(asset.latitude);
        const lng = parseFloat(asset.longtitude);
        
        if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
            mapContainer.style.display = 'block';
            
            // Wait for modal transition to finish before rendering map
            setTimeout(() => {
                if (!detailMap) {
                    detailMap = new maplibregl.Map({
                        container: 'mapContainer',
                        style: 'https://api.maptiler.com/maps/streets-v4/style.json?key=weAPV9ipc6W0MVacaEf6',
                        center: [lng, lat],
                        zoom: 16
                    });
                    detailMap.addControl(new maplibregl.NavigationControl(), 'top-right');
                    detailMarker = new maplibregl.Marker({ color: "#e37434" })
                        .setLngLat([lng, lat])
                        .addTo(detailMap);
                } else {
                    detailMap.resize();
                    detailMap.setCenter([lng, lat]);
                    detailMarker.setLngLat([lng, lat]);
                }
            }, 100);
        } else {
            mapContainer.style.display = 'none';
        }
    }
</script>

@endsection
