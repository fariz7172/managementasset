@extends('layouts.admin')

@section('title', isset($pintuAir) ? 'Edit Pintu Air' : 'Tambah Pintu Air')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/maplibre-gl@3.6.2/dist/maplibre-gl.css" />
<style>
    /* Prevent map from overlapping fixed headers */
    .maplibregl-canvas-container { z-index: 10 !important; }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto pb-12">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.pintu-airs.index') }}" class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-primary-600 hover:border-primary-200 hover:bg-primary-50 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-900">{{ isset($pintuAir) ? 'Edit Pintu Air' : 'Tambah Pintu Air Baru' }}</h1>
            <p class="text-slate-500 mt-1">Lengkapi informasi detail mengenai data Pintu Air</p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form action="{{ isset($pintuAir) ? route('admin.pintu-airs.update', $pintuAir) : route('admin.pintu-airs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($pintuAir))
                @method('PUT')
            @endif

            <div class="p-8 space-y-8">
                <!-- Basic Info Section -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100">Informasi Pintu Air</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700">Status</label>
                            <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                                <option value="1" {{ old('status', $pintuAir->status ?? '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status', $pintuAir->status ?? '') == '0' ? 'selected' : '' }}>Perbaikan</option>
                            </select>
                        </div>
                        
                        <!-- Nama Pintu Air -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700">Nama Pintu Air</label>
                            <input type="text" name="nama" value="{{ old('nama', $pintuAir->nama ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                                placeholder="Contoh: Pintu Air Manggarai">
                        </div>

                        <!-- Jumlah Pintu -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Jumlah Pintu</label>
                            <input type="number" name="jumlah_pintu" value="{{ old('jumlah_pintu', $pintuAir->jumlah_pintu ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                                placeholder="Contoh: 3">
                        </div>

                        <!-- Tahun Pekerjaan -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Tahun Pekerjaan</label>
                            <input type="text" name="tahun_pekerjaan" value="{{ old('tahun_pekerjaan', $pintuAir->tahun_pekerjaan ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                                placeholder="Contoh: 2020">
                        </div>

                        <!-- KIB D -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">KIB D</label>
                            <input type="text" name="kib_d" value="{{ old('kib_d', $pintuAir->kib_d ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                                placeholder="Nomor KIB D">
                        </div>
                        
                        <!-- Keterangan -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700">Keterangan</label>
                            <textarea name="keterangan" rows="2" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all placeholder:text-slate-400"
                                placeholder="Catatan...">{{ old('keterangan', $pintuAir->keterangan ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Location Section -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100">Lokasi & Pemetaan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Alamat -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all placeholder:text-slate-400"
                                placeholder="Jl. Raya...">{{ old('alamat', $pintuAir->alamat ?? '') }}</textarea>
                        </div>

                        <!-- Kelurahan -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Kelurahan</label>
                            <input type="text" name="kelurahan" value="{{ old('kelurahan', $pintuAir->kelurahan ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        </div>

                        <!-- Kecamatan -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Kecamatan</label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan', $pintuAir->kecamatan ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        </div>
                        
                        <!-- Google Map URL -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700">Tautan Google Map</label>
                            <input type="text" name="google_map" value="{{ old('google_map', $pintuAir->google_map ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                                placeholder="https://maps.google.com/...">
                        </div>
                        
                        <!-- Map Container -->
                        <div class="space-y-3 md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700">Titik Koordinat Peta</label>
                            
                            <!-- Search Box -->
                            <div class="relative w-full max-w-md flex gap-2">
                                <input type="text" id="mapSearchInput" placeholder="Cari nama jalan atau tempat..." autocomplete="off"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all font-medium text-slate-800 shadow-sm" onkeydown="if(event.key === 'Enter') { event.preventDefault(); searchLocation(); }">
                                <button type="button" onclick="searchLocation()" class="px-6 py-2.5 bg-primary-600 text-white rounded-xl font-bold shadow-sm hover:bg-primary-700 transition-colors">
                                    Cari
                                </button>
                            </div>

                            <!-- Map -->
                            <div id="map" class="w-full h-[400px] rounded-xl border border-slate-200 shadow-inner"></div>
                        </div>

                        <!-- Latitude -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Latitude (Y)</label>
                            <input type="text" name="latitude" id="input-latitude" value="{{ old('latitude', $pintuAir->latitude ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                                placeholder="Contoh: -6.1345" readonly>
                        </div>

                        <!-- Longitude -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Longitude (X)</label>
                            <input type="text" name="longitude" id="input-longitude" value="{{ old('longitude', $pintuAir->longitude ?? '') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                                placeholder="Contoh: 106.8778" readonly>
                        </div>
                        
                        <!-- Raw Koordinat (Optional/Hidden from view ideally, but keeping it for completeness based on schema) -->
                        <input type="hidden" name="koordinat" id="input-koordinat" value="{{ old('koordinat', $pintuAir->koordinat ?? '') }}">
                    </div>
                </div>

                <!-- Media Section -->
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100">Media</h3>
                    
                    <div class="space-y-4">
                        <label class="block text-sm font-bold text-slate-700">Upload Foto Pintu Air</label>
                        <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:bg-slate-50 hover:border-primary-400 transition-all group">
                            <input type="file" name="photos[]" id="photos" multiple class="hidden" accept="image/png, image/jpeg, image/jpg" onchange="previewFiles()">
                            <label for="photos" class="cursor-pointer flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-primary-50 flex items-center justify-center text-primary-500 mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <span class="text-lg font-bold text-slate-700">Klik untuk memilih beberapa gambar</span>
                                <span class="text-sm font-medium text-slate-500 mt-1">PNG, JPG up to 5MB (Bisa pilih lebih dari satu)</span>
                            </label>
                        </div>
                        
                        <!-- New Files Preview -->
                        <div id="new-files-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 hidden"></div>

                        <!-- Existing Photos -->
                        @if(isset($pintuAir) && is_array($pintuAir->photo) && count($pintuAir->photo) > 0)
                            <div class="mt-6">
                                <h4 class="text-sm font-bold text-slate-700 mb-4">Foto Saat Ini:</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="existing-photos">
                                    @foreach($pintuAir->photo as $index => $photo)
                                        <div class="relative group rounded-xl overflow-hidden aspect-video border border-slate-200" id="photo-container-{{ $index }}">
                                            <img src="{{ asset('storage/' . $photo) }}" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <button type="button" onclick="deleteImage({{ $pintuAir->id }}, {{ $index }})" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-lg">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Form Footer -->
            <div class="p-8 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pintu-airs.index') }}" class="px-6 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors">Batal</a>
                <button type="submit" class="px-8 py-2.5 bg-primary-600 text-white rounded-xl font-bold shadow-sm shadow-primary-500/30 hover:bg-primary-700 focus:ring-4 focus:ring-primary-500/20 transition-all">
                    {{ isset($pintuAir) ? 'Simpan Perubahan' : 'Tambahkan Pintu Air' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewFiles() {
        const preview = document.getElementById('new-files-preview');
        const input = document.getElementById('photos');
        
        preview.innerHTML = '';
        
        if(input.files.length > 0) {
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }

        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative rounded-xl overflow-hidden aspect-video border border-slate-200 shadow-sm';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent flex items-end p-2">
                        <span class="text-xs text-white font-medium truncate w-full">${file.name}</span>
                    </div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }

    function deleteImage(pintuId, index) {
        if(confirm('Yakin ingin menghapus foto ini?')) {
            fetch(`/admin/pintu-airs/image/${pintuId}/${index}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById(`photo-container-${index}`).remove();
                } else {
                    alert('Gagal menghapus gambar');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }
    }
</script>

<!-- MapLibre Map Script -->
<script src="https://unpkg.com/maplibre-gl@3.6.2/dist/maplibre-gl.js"></script>
<script>
    let pickerMap;
    let pickerMarker;
    const MAPTILER_KEY = 'ZDiWx4r1ToT9jGdlNPco';

    document.addEventListener('DOMContentLoaded', function() {
        const latInput = document.getElementById('input-latitude');
        const lngInput = document.getElementById('input-longitude');
        const koorInput = document.getElementById('input-koordinat');
        
        // Initial coordinates (Jakarta Utara by default or from DB)
        let initialLat = parseFloat(latInput.value);
        let initialLng = parseFloat(lngInput.value);
        let zoomLevel = 15;

        // Validasi dan perbaikan jika data dari database terbalik (misal lat = 106)
        if (!isNaN(initialLat) && !isNaN(initialLng)) {
            if (initialLat < -90 || initialLat > 90) {
                // Tukar nilainya
                let temp = initialLat;
                initialLat = initialLng;
                initialLng = temp;
                
                // Perbaiki juga di input field
                latInput.value = initialLat;
                lngInput.value = initialLng;
            }
        }

        if (isNaN(initialLat) || isNaN(initialLng) || (initialLat === 0 && initialLng === 0)) {
            initialLat = -6.1384;
            initialLng = 106.8837;
            zoomLevel = 11;
        }

        pickerMap = new maplibregl.Map({
            container: 'map',
            style: `https://api.maptiler.com/maps/streets-v4/style.json?key=${MAPTILER_KEY}`,
            center: [initialLng, initialLat],
            zoom: zoomLevel
        });

        pickerMap.addControl(new maplibregl.NavigationControl(), 'top-right');

        // Buat marker yang bisa di-drag
        pickerMarker = new maplibregl.Marker({ color: "#0ea5e9", draggable: true })
            .setLngLat([initialLng, initialLat])
            .addTo(pickerMap);

        // Update input saat marker selesai di-drag
        pickerMarker.on('dragend', function() {
            const lngLat = pickerMarker.getLngLat();
            latInput.value = lngLat.lat.toFixed(6);
            lngInput.value = lngLat.lng.toFixed(6);
            koorInput.value = `${lngLat.lat.toFixed(6)}, ${lngLat.lng.toFixed(6)}`;
        });
        
        // Pindahkan marker saat map diklik
        pickerMap.on('click', function(e) {
            pickerMarker.setLngLat(e.lngLat);
            latInput.value = e.lngLat.lat.toFixed(6);
            lngInput.value = e.lngLat.lng.toFixed(6);
            koorInput.value = `${e.lngLat.lat.toFixed(6)}, ${e.lngLat.lng.toFixed(6)}`;
        });

        // Sinkronisasi: Pindah marker saat user mengetik koordinat secara manual
        function updateMapFromInputs() {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                pickerMarker.setLngLat([lng, lat]);
                pickerMap.flyTo({ center: [lng, lat], essential: true });
                koorInput.value = `${lat}, ${lng}`;
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
        btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        btn.disabled = true;

        try {
            // Pencarian Geocoding dibatasi di area Indonesia secara umum
            const response = await fetch(`https://api.maptiler.com/geocoding/${encodeURIComponent(query)}.json?key=${MAPTILER_KEY}&bbox=94.97,-11.0,141.01,6.07`);
            const data = await response.json();

            if (data.features && data.features.length > 0) {
                const bestResult = data.features[0];
                const coords = bestResult.geometry.coordinates; // [longitude, latitude]
                
                // Terbang ke lokasi baru
                pickerMap.flyTo({
                    center: coords,
                    zoom: 15,
                    essential: true
                });
                
                // Pindahkan marker dan update input
                pickerMarker.setLngLat(coords);
                document.getElementById('input-latitude').value = coords[1].toFixed(6);
                document.getElementById('input-longitude').value = coords[0].toFixed(6);
                document.getElementById('input-koordinat').value = `${coords[1].toFixed(6)}, ${coords[0].toFixed(6)}`;
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
@endpush
@endsection
