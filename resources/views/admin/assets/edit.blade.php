@extends('layouts.admin')

@section('title', 'Edit Asset')
@section('page_title', 'Edit Master Data Asset')

@section('content')
<div class="glass-card animate-fade-in delay-1">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px;">
        <h3 style="margin: 0; color: var(--color-text-dark); display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(227, 116, 52, 0.1); color: var(--color-orange); display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-pen-to-square"></i></div>
            Edit Data Asset ({{ $asset->dewan->nama ?? 'N/A' }})
        </h3>
        <a href="{{ route('assets.index') }}" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('assets.update', $asset->id) }}">
        @csrf
        @method('PUT')
        
        <div style="display: grid; gap: 20px;">


            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="form-label">Kecamatan</label>
                    <select name="kecamatan_id" id="edit_kecamatan_id" class="form-control" required onchange="updateEditKelurahan()">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}" {{ $asset->kecamatan_id == $kec->id ? 'selected' : '' }}>{{ $kec->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Kelurahan</label>
                    <select name="kelurahan_id" id="edit_kelurahan_id" class="form-control" required>
                        <option value="">-- Pilih Kelurahan --</option>
                        @foreach($kelurahans as $kel)
                            <option value="{{ $kel->id }}" data-kec="{{ $kel->kecamatan_id }}" {{ $asset->kelurahan_id == $kel->id ? 'selected' : '' }} style="display: {{ $asset->kecamatan_id == $kel->kecamatan_id ? 'block' : 'none' }};">{{ $kel->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">Lokasi Lengkap (Patokan / Alamat)</label>
                <input type="text" name="lokasi" id="edit_lokasi" class="form-control" value="{{ $asset->lokasi }}" required>
            </div>

            <!-- Map Picker Area -->
            <div style="padding: 16px; background: rgba(227, 116, 52, 0.05); border-radius: 8px; border: 1px dashed rgba(227, 116, 52, 0.3);">
                <label class="form-label" style="color: var(--color-orange); margin-bottom: 0;"><i class="fa-solid fa-map-location-dot"></i> Titik Koordinat (Peta)</label>
                <small style="color: var(--color-text-muted); display: block; margin-bottom: 12px;">Ketik nama jalan/wilayah lalu tekan Cari, atau langsung geser Pin (Marker) merah di peta.</small>
                
                <!-- Search Box -->
                <div style="display: flex; gap: 10px; margin-bottom: 12px;">
                    <input type="text" id="mapSearchInput" class="form-control" placeholder="Cari wilayah, jalan, atau area (contoh: Pademangan, Ancol)..." onkeydown="if(event.key === 'Enter'){ event.preventDefault(); searchLocation(); }">
                    <button type="button" class="btn btn-primary" onclick="searchLocation()" style="white-space: nowrap;"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                </div>
                
                <div id="pickerMap" style="width: 100%; height: 350px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 16px; z-index: 1;"></div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label class="form-label">Latitude <small style="color:var(--color-teal); font-weight:normal;">*Bisa diubah manual</small></label>
                        <input type="text" name="latitude" id="edit_latitude" class="form-control" value="{{ $asset->latitude }}">
                    </div>
                    <div>
                        <label class="form-label">Longtitude <small style="color:var(--color-teal); font-weight:normal;">*Bisa diubah manual</small></label>
                        <input type="text" name="longtitude" id="edit_longtitude" class="form-control" value="{{ $asset->longtitude }}">
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label">Permintaan</label>
                <textarea name="permintaan" id="edit_permintaan" class="form-control" rows="3" required>{{ $asset->permintaan }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div>
                    <label class="form-label">Panjang (m)</label>
                    <input type="number" step="0.01" name="panjang" id="edit_panjang" class="form-control" value="{{ $asset->panjang }}" oninput="calculateEditVolume()">
                </div>
                <div>
                    <label class="form-label">Lebar (m)</label>
                    <input type="number" step="0.01" name="lebar" id="edit_lebar" class="form-control" value="{{ $asset->lebar }}" oninput="calculateEditVolume()">
                </div>
                <div>
                    <label class="form-label">Tinggi (m)</label>
                    <input type="number" step="0.01" name="tinggi" id="edit_tinggi" class="form-control" value="{{ $asset->tinggi }}" oninput="calculateEditVolume()">
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="form-label">Volume (m³)</label>
                    <input type="number" step="0.01" name="volume" id="edit_volume" class="form-control" value="{{ $asset->volume }}" readonly style="background: #f3f4f6; color: var(--color-text-muted);">
                </div>
                <div>
                    <label class="form-label">Biaya (Rp) <small style="color:var(--color-orange); font-weight: normal;">*Berasal dari API Tagihan</small></label>
                    <input type="number" name="biaya" id="edit_biaya" class="form-control" value="{{ $asset->biaya }}" readonly style="background: #f3f4f6; color: var(--color-text-muted);">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="form-label">Tanggal Reses</label>
                    <input type="date" name="tanggal_reses" id="edit_tanggal_reses" class="form-control" value="{{ $asset->tanggal_reses ? \Carbon\Carbon::parse($asset->tanggal_reses)->format('Y-m-d') : '' }}">
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" id="edit_status" class="form-control" required>
                        <option value="Proses" {{ $asset->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ $asset->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Tertunda" {{ $asset->status == 'Tertunda' ? 'selected' : '' }}>Tertunda</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="2">{{ $asset->keterangan }}</textarea>
            </div>
            
            <div style="padding: 16px; background: rgba(36, 177, 177, 0.05); border-radius: 8px; border: 1px dashed rgba(36, 177, 177, 0.3);">
                <label class="form-label" style="color: var(--color-teal);">Foto Asset</label>
                <div style="display: flex; gap: 20px; align-items: flex-start; margin-top: 12px;">
                    @if($asset->foto)
                        <img src="{{ asset('storage/' . $asset->foto) }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                    @else
                        <div style="width: 120px; height: 120px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); font-size: 0.8rem; text-align: center; border: 1px dashed var(--border-color);">Belum Ada<br>Foto</div>
                    @endif
                    <div style="flex-grow: 1;">
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small style="color: var(--color-text-muted); display: block; margin-top: 8px;">
                            Biarkan kosong jika tidak ingin mengubah foto. Jika Anda mengunggah foto baru, foto lama akan dihapus. Foto akan dikonversi otomatis ke format WebP.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border-color); padding-top: 24px;">
            <a href="{{ route('assets.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 1rem;"><i class="fa-solid fa-save"></i> Simpan Perubahan Asset</button>
        </div>
    </form>
</div>

<script>
    function updateEditKelurahan() {
        const kecId = document.getElementById('edit_kecamatan_id').value;
        const kelSelect = document.getElementById('edit_kelurahan_id');
        
        // Hide all options first except the placeholder
        Array.from(kelSelect.options).forEach((opt, index) => {
            if (index > 0) {
                opt.style.display = opt.getAttribute('data-kec') == kecId ? 'block' : 'none';
            }
        });
        
        // If current value is not visible, reset it
        const currentSelected = kelSelect.options[kelSelect.selectedIndex];
        if (currentSelected && currentSelected.style.display === 'none') {
            kelSelect.value = '';
        }
    }

    function calculateEditVolume() {
        const p = parseFloat(document.getElementById('edit_panjang').value) || 0;
        const l = parseFloat(document.getElementById('edit_lebar').value) || 0;
        const t = parseFloat(document.getElementById('edit_tinggi').value) || 0;
        document.getElementById('edit_volume').value = (p * l * t).toFixed(2);
    }

    // --- Interactive Map Logic ---
    let pickerMap;
    let pickerMarker;
    const mapTilerKey = 'weAPV9ipc6W0MVacaEf6';

    document.addEventListener("DOMContentLoaded", function() {
        const latInput = document.getElementById('edit_latitude');
        const lngInput = document.getElementById('edit_longtitude');
        
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
                document.getElementById('edit_longtitude').value = coords[0].toFixed(6);
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
@endsection
