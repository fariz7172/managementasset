@extends('layouts.admin')

@section('title', 'Tambah Data Sensus')
@section('page_title', 'Tambah Data Sensus')

@section('content')
<div class="glass-card animate-fade-in delay-1" style="max-width: 100%;">
    <div class="card-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 class="card-title" style="margin: 0; font-size: 1.25rem;">Formulir Pendataan Sensus</h2>
            <p style="font-size: 0.875rem; color: var(--color-text-muted); margin: 4px 0 0 0;">Harap isi data dengan lengkap dan benar.</p>
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

    <form action="{{ route('sensus.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                    <select name="status_pelaksanaan" class="form-control" style="appearance: auto;">
                        <option value="">-- Pilih Status --</option>
                        <option value="Belum Inventarisasi" {{ old('status_pelaksanaan') == 'Belum Inventarisasi' ? 'selected' : '' }}>Belum Inventarisasi</option>
                        <option value="Menunggu Inventarisasi Mobile" {{ old('status_pelaksanaan') == 'Menunggu Inventarisasi Mobile' ? 'selected' : '' }}>Menunggu Inventarisasi Mobile</option>
                        <option value="Disetujui P3B" {{ old('status_pelaksanaan') == 'Disetujui P3B' ? 'selected' : '' }}>Disetujui P3B</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang') }}">
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nomor Register</label>
                    <input type="text" name="nomor_register" class="form-control" value="{{ old('nomor_register') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Tanggal Perolehan</label>
                    <input type="date" name="tanggal_perolehan" class="form-control" value="{{ old('tanggal_perolehan') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" step="0.01" name="harga" class="form-control" value="{{ old('harga') }}">
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Objek</label>
                    <input type="text" name="objek" class="form-control" value="{{ old('objek') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nama Objek</label>
                    <input type="text" name="nama_objek" class="form-control" value="{{ old('nama_objek') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Sub Rincian Objek</label>
                    <input type="text" name="sub_rincian_objek" class="form-control" value="{{ old('sub_rincian_objek') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nama Sub Rincian Objek</label>
                    <input type="text" name="nama_sub_rincian_objek" class="form-control" value="{{ old('nama_sub_rincian_objek') }}">
                </div>
            </div>

            <!-- Dimensi & Detail -->
            <div style="background: var(--color-bg); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                <h3 style="font-size: 1rem; color: var(--color-teal); margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">Dimensi & Spesifikasi</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label">Panjang</label>
                        <input type="number" step="0.01" name="panjang" class="form-control" value="{{ old('panjang') }}">
                    </div>
                    <div>
                        <label class="form-label">Lebar</label>
                        <input type="number" step="0.01" name="lebar" class="form-control" value="{{ old('lebar') }}">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Ukuran</label>
                    <input type="text" name="ukuran" class="form-control" value="{{ old('ukuran') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Penggunaan</label>
                    <input type="text" name="penggunaan" class="form-control" value="{{ old('penggunaan') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Keterangan Masalah</label>
                    <textarea name="ket_masalah" class="form-control" rows="3">{{ old('ket_masalah') }}</textarea>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Pengembang</label>
                    <input type="text" name="pengembang" class="form-control" value="{{ old('pengembang') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Jenis Objek KIB D</label>
                    <input type="text" name="jenis_objek_kib_d" class="form-control" value="{{ old('jenis_objek_kib_d') }}">
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
                    <input type="text" name="nama_jalan_alamat" class="form-control" value="{{ old('nama_jalan_alamat') }}">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div>
                        <label class="form-label">No. Jalan</label>
                        <input type="text" name="nomor_jalan" class="form-control" value="{{ old('nomor_jalan') }}">
                    </div>
                    <div>
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control" value="{{ old('rt') }}">
                    </div>
                    <div>
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control" value="{{ old('rw') }}">
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Kode Kelurahan</label>
                    <input type="text" name="kode_kelurahan" class="form-control" value="{{ old('kode_kelurahan') }}">
                </div>
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Kelurahan</label>
                    <input type="text" name="kelurahan" class="form-control" value="{{ old('kelurahan') }}">
                </div>
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                </div>

                <!-- Map Picker Area -->
                <div style="padding: 16px; background: rgba(227, 116, 52, 0.05); border-radius: 8px; border: 1px dashed rgba(227, 116, 52, 0.3); margin-bottom: 16px;">
                    <label class="form-label" style="color: var(--color-orange); margin-bottom: 0;"><i class="fa-solid fa-map-location-dot"></i> Titik Koordinat Sensus (Peta)</label>
                    <small style="color: var(--color-text-muted); display: block; margin-bottom: 12px;">Ketik nama jalan/wilayah lalu tekan Cari, atau langsung geser Pin (Marker) merah di peta.</small>
                    
                    <!-- Search Box -->
                    <div style="display: flex; gap: 10px; margin-bottom: 12px;">
                        <input type="text" id="mapSearchInput" class="form-control" placeholder="Cari wilayah, jalan, atau area (contoh: Pademangan, Ancol)..." onkeydown="if(event.key === 'Enter'){ event.preventDefault(); searchLocation(); }">
                        <button type="button" class="btn btn-primary" onclick="searchLocation()" style="white-space: nowrap;"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                    </div>
                    
                    <div id="pickerMap" style="width: 100%; height: 350px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 16px; z-index: 1;"></div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label class="form-label">Latitude Sensus <small style="color:var(--color-teal); font-weight:normal;">*Bisa diubah manual</small></label>
                            <input type="text" name="latitude" id="edit_latitude" class="form-control" value="{{ old('latitude') }}">
                        </div>
                        <div>
                            <label class="form-label">Longitude Sensus <small style="color:var(--color-teal); font-weight:normal;">*Bisa diubah manual</small></label>
                            <input type="text" name="longitude" id="edit_longitude" class="form-control" value="{{ old('longitude') }}">
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Alamat Foto Pendataan</label>
                    <textarea name="alamat_foto_pendataan" class="form-control" rows="2">{{ old('alamat_foto_pendataan') }}</textarea>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Foto Pendataan (File)</label>
                    <input type="file" name="url_foto_pendataan[]" class="form-control" accept="image/*" multiple>
                    <small style="color: var(--color-text-muted); display: block; margin-top: 4px;">Anda dapat memilih lebih dari satu foto. Foto akan otomatis dikonversi ke format WebP.</small>
                </div>

                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 24px 0;">

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Dibuat/Diperbarui Pada</label>
                    <input type="date" name="dibuat_diperbaharui_pada" class="form-control" value="{{ old('dibuat_diperbaharui_pada') }}">
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Dibuat/Diperbarui Oleh</label>
                    <input type="text" name="dibuat_diperbaharui_oleh" class="form-control" value="{{ old('dibuat_diperbaharui_oleh') }}">
                </div>
            </div>
                </div>
            </div> <!-- Tutup Kolom Kanan -->
        </div>

        <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border-color); padding-top: 24px;">
            <a href="{{ route('sensus.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 1rem;">
                <i class="fa-solid fa-save"></i> Simpan Sensus
            </button>
        </div>
    </form>
</div>
@endsection

<script>
    // --- Interactive Map Logic ---
    let pickerMap;
    let pickerMarker;
    const mapTilerKey = 'weAPV9ipc6W0MVacaEf6';

    document.addEventListener("DOMContentLoaded", function() {
        const latInput = document.getElementById('edit_latitude');
        const lngInput = document.getElementById('edit_longitude');
        
        let initialLat = parseFloat(latInput.value);
        let initialLng = parseFloat(lngInput.value);
        let zoomLevel = 15;

        // Jika belum ada koordinat, arahkan ke pusat Jakarta
        if (isNaN(initialLat) || isNaN(initialLng) || (initialLat === 0 && initialLng === 0)) {
            initialLat = -6.200000;
            initialLng = 106.816666;
            zoomLevel = 11;
        }

        pickerMap = new maplibregl.Map({
            container: 'pickerMap',
            style: `https://api.maptiler.com/maps/streets-v4/style.json?key=${mapTilerKey}`,
            center: [initialLng, initialLat],
            zoom: zoomLevel
        });

        pickerMap.addControl(new maplibregl.NavigationControl(), 'top-right');

        // Buat marker yang bisa di-drag
        pickerMarker = new maplibregl.Marker({ color: "#e37434", draggable: true })
            .setLngLat([initialLng, initialLat])
            .addTo(pickerMap);

        // Update input saat marker selesai di-drag
        pickerMarker.on('dragend', function() {
            const lngLat = pickerMarker.getLngLat();
            latInput.value = lngLat.lat.toFixed(6);
            lngInput.value = lngLat.lng.toFixed(6);
        });
        
        // Pindahkan marker saat map diklik
        pickerMap.on('click', function(e) {
            pickerMarker.setLngLat(e.lngLat);
            latInput.value = e.lngLat.lat.toFixed(6);
            lngInput.value = e.lngLat.lng.toFixed(6);
        });

        // Sinkronisasi: Pindah marker saat user mengetik koordinat secara manual
        function updateMapFromInputs() {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                pickerMarker.setLngLat([lng, lat]);
                pickerMap.flyTo({ center: [lng, lat], essential: true });
            }
        }

        latInput.addEventListener('input', updateMapFromInputs);
        lngInput.addEventListener('input', updateMapFromInputs);
    });

    // Fungsi Geocoding Search
    async function searchLocation() {
        const query = document.getElementById('mapSearchInput').value;
        if (!query) return;

        const btn = document.querySelector('button[onclick="searchLocation()"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        btn.disabled = true;

        try {
            // Pencarian Geocoding dibatasi di area Indonesia secara umum
            const response = await fetch(`https://api.maptiler.com/geocoding/${encodeURIComponent(query)}.json?key=${mapTilerKey}&bbox=94.97,-11.0,141.01,6.07`);
            const data = await response.json();

            if (data.features && data.features.length > 0) {
                const bestResult = data.features[0];
                const coords = bestResult.center; // [longitude, latitude]
                
                // Terbang ke lokasi baru
                pickerMap.flyTo({
                    center: coords,
                    zoom: 15,
                    essential: true
                });
                
                // Pindahkan marker dan update input
                pickerMarker.setLngLat(coords);
                document.getElementById('edit_latitude').value = coords[1].toFixed(6);
                document.getElementById('edit_longitude').value = coords[0].toFixed(6);
            } else {
                alert("Lokasi tidak ditemukan. Coba gunakan kata kunci yang lebih umum.");
            }
        } catch (error) {
            console.error("Geocoding Error: ", error);
            alert("Terjadi kesalahan saat mencari lokasi.");
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }
</script>
