<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Sensus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/maplibre-gl@3.3.1/dist/maplibre-gl.js"></script>
    <link href="https://unpkg.com/maplibre-gl@3.3.1/dist/maplibre-gl.css" rel="stylesheet" />
    @vite(['resources/css/admin.css'])
    <style>
        body { padding: 24px; background: transparent; }
        .card-header .btn-outline { display: none !important; } /* Sembunyikan tombol kembali karena ini modal */
    </style>
</head>
<body>
<div class="glass-card animate-fade-in delay-1" style="max-width: 100%;">
    <div class="card-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 class="card-title" style="margin: 0; font-size: 1.25rem;">Detail Pendataan Sensus</h2>
            <p style="font-size: 0.875rem; color: var(--color-text-muted); margin: 4px 0 0 0;">Lihat rincian lengkap data sensus.</p>
        </div>
        <a href="{{ route('sensus.index') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div style="background: rgba(227, 116, 52, 0.1); border-left: 4px solid var(--color-orange); padding: 16px; border-radius: 8px; margin-bottom: 24px; color: var(--color-orange);">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
        
        

        <style>
            @media (max-width: 992px) {
                .sensus-grid { grid-template-columns: 1fr !important; }
            }
        </style>
        <div class="sensus-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            
            <!-- KOLOM KIRI -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Informasi Barang -->
                <div style="background: var(--color-bg); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1rem; color: var(--color-teal); margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">Informasi Barang</h3>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Status Pelaksanaan</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">
                        @if($sensus->status_pelaksanaan)
                            <span style="display: inline-block; padding: 4px 12px; background: rgba(36, 177, 177, 0.1); color: var(--color-teal); border-radius: 20px; font-size: 0.85rem;">{{ $sensus->status_pelaksanaan }}</span>
                        @else
                            -
                        @endif
                    </div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Kode Barang</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->kode_barang ?: '-' }}</div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nama Barang</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->nama_barang ?: '-' }}</div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nomor Register</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->nomor_register ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Tanggal Perolehan</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->tanggal_perolehan ? \Carbon\Carbon::parse($sensus->tanggal_perolehan)->format('d M Y') : '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Harga (Rp)</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->harga ?: '-' }}</div>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Objek</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->objek ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nama Objek</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->nama_objek ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Sub Rincian Objek</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->sub_rincian_objek ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nama Sub Rincian Objek</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->nama_sub_rincian_objek ?: '-' }}</div>
                </div>
            </div>

            <!-- Dimensi & Detail -->
            <div style="background: var(--color-bg); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1rem; color: var(--color-teal); margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">Dimensi & Spesifikasi</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label">Panjang</label>
                        <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->panjang ?: '-' }}</div>
                    </div>
                    <div>
                        <label class="form-label">Lebar</label>
                        <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->lebar ?: '-' }}</div>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Ukuran</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->ukuran ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Satuan</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->satuan ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Penggunaan</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->penggunaan ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Keterangan Masalah</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500; min-height: 60px;">{{ $sensus->ket_masalah ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Pengembang</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->pengembang ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Jenis Objek KIB D</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->jenis_objek_kib_d ?: '-' }}</div>
                </div>
            </div>

            </div> <!-- Tutup Kolom Kiri -->

            <!-- KOLOM KANAN -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <!-- Lokasi & Foto -->
                <div style="background: var(--color-bg); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                    <h3 style="font-size: 1rem; color: var(--color-teal); margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">Lokasi & Bukti</h3>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nama Jalan / Alamat</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->nama_jalan_alamat ?: '-' }}</div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label">No. Jalan</label>
                        <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->nomor_jalan ?: '-' }}</div>
                    </div>
                    <div>
                        <label class="form-label">RT</label>
                        <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->rt ?: '-' }}</div>
                    </div>
                    <div>
                        <label class="form-label">RW</label>
                        <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->rw ?: '-' }}</div>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Kode Kelurahan</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->kode_kelurahan ?: '-' }}</div>
                </div>
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Kelurahan</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->kelurahan ?: '-' }}</div>
                </div>
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Kecamatan</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->kecamatan ?: '-' }}</div>
                </div>

                <!-- Map Picker Area -->
                <div style="padding: 16px; background: rgba(227, 116, 52, 0.05); border-radius: 8px; border: 1px dashed rgba(227, 116, 52, 0.3); margin-bottom: 16px;">
                    <label class="form-label" style="color: var(--color-orange); margin-bottom: 0;"><i class="fa-solid fa-map-location-dot"></i> Titik Koordinat Sensus (Peta)</label>
                    <small style="color: var(--color-text-muted); display: block; margin-bottom: 12px;">Ketik nama jalan/wilayah lalu tekan Cari, atau langsung geser Pin (Marker) merah di peta.</small>
                    
                    
                    
                    <input type="hidden" id="edit_latitude" value="{{ $sensus->latitude }}">
                    <input type="hidden" id="edit_longitude" value="{{ $sensus->longitude }}">
                    <div id="pickerMap" style="width: 100%; height: 350px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 16px; z-index: 1;"></div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label class="form-label">Latitude Sensus </label>
                            <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->latitude ?: '-' }}</div>
                        </div>
                        <div>
                            <label class="form-label">Longitude Sensus </label>
                            <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->longitude ?: '-' }}</div>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Alamat Foto Pendataan</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500; min-height: 60px;">{{ $sensus->alamat_foto_pendataan ?: '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Foto Pendataan (Bukti)</label>
                    @if($sensus->url_foto_pendataan && is_array($sensus->url_foto_pendataan))
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px;">
                            @foreach($sensus->url_foto_pendataan as $photo)
                                <img src="{{ Str::startsWith($photo, ['http://', 'https://']) ? $photo : asset('storage/' . $photo) }}" alt="Foto Sensus" style="height: 80px; width: 80px; border-radius: 8px; border: 1px solid var(--border-color); object-fit: cover;">
                            @endforeach
                        </div>
                        
                    @endif
                    
                    
                </div>

                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 24px 0;">

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Dibuat/Diperbarui Pada</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->dibuat_diperbaharui_pada ? \Carbon\Carbon::parse($sensus->dibuat_diperbaharui_pada)->format('d M Y') : '-' }}</div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Dibuat/Diperbarui Oleh</label>
                    <div style="padding: 10px; background: #f9fafb; border: 1px solid var(--border-color); border-radius: 8px; color: var(--color-text-dark); font-weight: 500;">{{ $sensus->dibuat_diperbaharui_oleh ?: '-' }}</div>
                </div>
            </div>
                </div>
            </div> <!-- Tutup Kolom Kanan -->
        </div>

        <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border-color); padding-top: 24px;"><a href="{{ route('sensus.index') }}" class="btn btn-primary" style="padding: 10px 24px; font-size: 1rem;"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar</a></div>
    
</div>


<script src="https://unpkg.com/maplibre-gl@3.3.1/dist/maplibre-gl.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const latInput = document.getElementById('edit_latitude');
        const lngInput = document.getElementById('edit_longitude');
        if (!latInput || !lngInput) return;

        let initialLat = parseFloat(latInput.value);
        let initialLng = parseFloat(lngInput.value);
        let zoomLevel = 15;

        if (isNaN(initialLat) || isNaN(initialLng) || (initialLat === 0 && initialLng === 0)) {
            initialLat = -6.200000;
            initialLng = 106.816666;
            zoomLevel = 11;
        }

        const pickerMap = new maplibregl.Map({
            container: 'pickerMap',
            style: 'https://api.maptiler.com/maps/streets-v4/style.json?key=weAPV9ipc6W0MVacaEf6',
            center: [initialLng, initialLat],
            zoom: zoomLevel
        });

        pickerMap.addControl(new maplibregl.NavigationControl(), 'top-right');

        new maplibregl.Marker({ color: "#e37434", draggable: false })
            .setLngLat([initialLng, initialLat])
            .addTo(pickerMap);
    });
</script>
</body>
</html>