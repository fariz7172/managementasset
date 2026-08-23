@extends('layouts.admin')

@section('title', 'Monitoring Pekerjaan SDA (RESES)')

@push('styles')
<!-- MapLibre GL JS -->
<link href="https://unpkg.com/maplibre-gl@3.6.2/dist/maplibre-gl.css" rel="stylesheet" />
<style>
    .map-container {
        height: calc(100vh - 120px);
        width: 100%;
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05);
    }
    
    /* Legend Styling */
    .map-legend {
        position: absolute;
        bottom: 30px;
        left: 30px;
        background: white;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        z-index: 10;
        border: 1px solid #e2e8f0;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #334155;
    }
    .legend-item:last-child {
        margin-bottom: 0;
    }
    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        margin-right: 10px;
    }
    
    /* Custom Marker Styling */
    .custom-marker {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .custom-marker:hover {
        transform: scale(1.2);
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Monitoring RESES (Pekerjaan SDA)</h1>
            <p class="text-slate-500 text-sm mt-1 flex items-center gap-2">
                <span>Total: <strong class="text-slate-700">{{ count($locations) }} Titik</strong></span> &bull; 
                <span class="text-blue-600 font-medium">Sumber Reses: {{ $totalReses }}</span> &bull; 
                <span class="text-orange-600 font-medium">Sumber Masyarakat: {{ $totalMasyarakat }}</span>
            </p>
        </div>
    </div>

    @if($error)
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-red-600 font-medium">
        {{ $error }}
    </div>
    @endif

    <!-- Map Container -->
    <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-sm relative">
        <div id="monitoring-map" class="map-container"></div>
        
        <!-- Legend -->
        <div class="map-legend">
            <h3 class="font-bold text-slate-900 mb-3 text-sm uppercase tracking-wider">Keterangan Marker</h3>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #10b981;"></div>
                <span>Selesai (Progress 100%)</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #3b82f6;"></div>
                <span>Sumber: Reses (Belum Selesai)</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #f97316;"></div>
                <span>Sumber: Masyarakat (Belum Selesai)</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #ef4444;"></div>
                <span>Lainnya (Belum Selesai)</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- MapLibre GL JS -->
<script src="https://unpkg.com/maplibre-gl@3.6.2/dist/maplibre-gl.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const apiKey = 'ZDiWx4r1ToT9jGdlNPco';
        
        const map = new maplibregl.Map({
            container: 'monitoring-map',
            style: `https://api.maptiler.com/maps/streets-v2/style.json?key=${apiKey}`,
            center: [106.8837, -6.1384], // Default center (Jakarta Utara)
            zoom: 12
        });

        map.addControl(new maplibregl.NavigationControl());

        const locations = @json($locations);
        
        if (locations && locations.length > 0) {
            const bounds = new maplibregl.LngLatBounds();
            let validMarkers = 0;

            locations.forEach(loc => {
                if (loc.lat && loc.lng && !isNaN(loc.lat) && !isNaN(loc.lng)) {
                    // Normalize coordinates if necessary
                    let lat = parseFloat(loc.lat);
                    let lng = parseFloat(loc.lng);
                    
                    if (lat < -90 || lat > 90) {
                        const temp = lat;
                        lat = lng;
                        lng = temp;
                    }
                    
                    // Create a custom SVG marker based on the color
                    const svgMarker = `
                        <svg width="24" height="34" viewBox="0 0 24 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 0C5.37258 0 0 5.37258 0 12C0 21 12 34 12 34C12 34 24 21 24 12C24 5.37258 18.6274 0 12 0Z" fill="${loc.color}"/>
                            <circle cx="12" cy="12" r="5" fill="white"/>
                        </svg>
                    `;
                    
                    const el = document.createElement('div');
                    el.className = 'custom-marker';
                    el.innerHTML = svgMarker;
                    
                    // Create popup content
                    const popupContent = `
                        <div class="p-3 max-w-xs">
                            <div class="text-[10px] font-bold uppercase tracking-wider mb-1" style="color: ${loc.color}">${loc.type}</div>
                            <h3 class="font-bold text-slate-900 mb-1 leading-tight">${loc.name}</h3>
                            <div class="text-xs text-slate-500 mb-3">${loc.no_skpd}</div>
                            
                            <div class="mb-3 text-xs text-slate-600 bg-slate-50 p-2 rounded border border-slate-100">
                                <strong>Deskripsi:</strong><br>
                                ${loc.deskripsi}
                            </div>
                            
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs text-slate-500 font-medium w-16">Progress:</span>
                                <div class="w-full bg-slate-200 rounded-full h-2">
                                  <div class="h-2 rounded-full" style="width: ${loc.progress}%; background-color: ${loc.color};"></div>
                                </div>
                                <span class="text-xs font-bold" style="color: ${loc.color};">${loc.progress}%</span>
                            </div>
                            
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs text-slate-500 font-medium w-16">Status:</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold" style="background-color: ${loc.color}20; color: ${loc.color}">${loc.status}</span>
                            </div>
                            
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-xs text-slate-500 font-medium w-16">Tdk Lanjut:</span>
                                <span class="text-xs font-medium text-slate-700">${loc.status_tindak_lanjut}</span>
                            </div>

                            <a href="https://www.google.com/maps/@?api=1&map_action=pano&viewpoint=${lat},${lng}" target="_blank" 
                               class="block w-full py-2 text-center text-xs font-bold text-white rounded-lg transition-colors shadow-sm"
                               style="background-color: ${loc.color}; hover:opacity-90;">
                                <i class="fa-solid fa-street-view mr-1"></i> Buka Street View
                            </a>
                        </div>
                    `;
                    
                    const popup = new maplibregl.Popup({ offset: 25, closeButton: false })
                        .setHTML(popupContent);

                    // Add marker to map
                    const marker = new maplibregl.Marker({
                        element: el,
                        anchor: 'bottom'
                    })
                    .setLngLat([lng, lat])
                    .setPopup(popup)
                    .addTo(map);

                    loc.marker = marker;
                    loc.element = el;
                    loc.isOnMap = true;
                    
                    
                    // Add to bounds
                    bounds.extend([lng, lat]);
                    validMarkers++;
                }
            });

            // Fit map to markers bounds
            if (validMarkers > 0) {
                map.fitBounds(bounds, { padding: 50 });
            }

            // Global Search Logic
            const searchInput = document.getElementById('globalSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase().trim();
                    let hasVisibleMarker = false;
                    const searchBounds = new maplibregl.LngLatBounds();

                    locations.forEach(loc => {
                        if (loc.marker) {
                            const nameStr = (loc.name || '').toLowerCase();
                            const typeStr = (loc.type || '').toLowerCase();
                            const statusStr = (loc.status || '').toLowerCase();
                            const searchStr = (loc.search_text || '').toLowerCase();

                            const isMatch = nameStr.includes(searchTerm) || 
                                            typeStr.includes(searchTerm) ||
                                            statusStr.includes(searchTerm) ||
                                            searchStr.includes(searchTerm);
                            
                            if (isMatch) {
                                if (!loc.isOnMap) {
                                    loc.marker.addTo(map);
                                    loc.isOnMap = true;
                                }
                                searchBounds.extend(loc.marker.getLngLat());
                                hasVisibleMarker = true;
                            } else {
                                if (loc.isOnMap) {
                                    loc.marker.remove();
                                    loc.isOnMap = false;
                                }
                                // close popup if open and doesn't match
                                if (loc.marker.getPopup().isOpen()) {
                                    loc.marker.getPopup().remove();
                                }
                            }
                        }
                    });

                    // Optional: re-center map on filtered results
                    if (searchTerm !== '') {
                        if (hasVisibleMarker) {
                            map.fitBounds(searchBounds, { padding: 50, maxZoom: 15 });
                        }
                    } else {
                        // Reset to original bounds if search is cleared
                        map.fitBounds(bounds, { padding: 50 });
                    }
                });
            }
        }
    });
</script>
@endpush
