<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Live Monitoring RESES - SIDAJU Jakarta Utara</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        dark: '#0f172a',
                    }
                }
            }
        }
    </script>

    <!-- MapLibre GL JS -->
    <link href="https://unpkg.com/maplibre-gl@3.6.2/dist/maplibre-gl.css" rel="stylesheet" />
    <style>
        body { margin: 0; padding: 0; overflow: hidden; background-color: #0f172a; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }

        /* Custom Marker Styling */
        .custom-marker {
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }
        .custom-marker:hover {
            transform: scale(1.2) translateY(-5px);
            z-index: 50;
        }

        /* Glassmorphism Panel */
        .glass-panel {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* MapLibre overrides */
        .maplibregl-popup-content {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 1rem !important;
            padding: 0 !important;
            color: white !important;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4) !important;
        }
        .maplibregl-popup-tip {
            border-top-color: rgba(15, 23, 42, 0.95) !important;
        }
        .maplibregl-ctrl-group {
            background: rgba(15, 23, 42, 0.85) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .maplibregl-ctrl-group button {
            color: white !important;
        }
        .maplibregl-ctrl-icon {
            filter: invert(1);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
    </style>
</head>
<body class="antialiased text-slate-200">

    <!-- Map Container -->
    <div id="map"></div>

    <!-- Top Navigation / Search Bar -->
    <div class="absolute top-6 left-0 right-0 z-10 px-4 pointer-events-none flex flex-col md:flex-row justify-between items-start gap-4">
        
        <!-- Brand & Back Button -->
        <div class="pointer-events-auto flex flex-col gap-3 ml-2 md:ml-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-panel text-sm font-bold text-slate-300 hover:text-white hover:bg-slate-800 transition-all shadow-lg group">
                <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i> Kembali ke Beranda
            </a>
            
            <div class="glass-panel px-5 py-4 rounded-2xl shadow-xl flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-sky-600 to-sky-400 flex items-center justify-center shadow-lg shadow-sky-500/30">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h1 class="font-display font-bold text-lg text-white leading-none tracking-wide">Monitoring RESES</h1>
                    <p class="text-sky-400 text-xs font-semibold uppercase tracking-widest mt-1">Usulan Masyarakat</p>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="pointer-events-auto w-full md:w-96 mr-2 md:mr-6">
            <div class="glass-panel p-2 rounded-2xl shadow-xl flex items-center">
                <div class="w-10 h-10 flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-search"></i>
                </div>
                <input type="text" id="mapSearchInput" class="w-full bg-transparent border-none focus:ring-0 text-white placeholder:text-slate-500 font-medium text-sm px-2" placeholder="Cari nama aset, tipe, atau lokasi...">
                <div class="w-10 h-10 flex items-center justify-center text-slate-500">
                    <div id="search-spinner" class="animate-spin hidden">
                        <i class="fa-solid fa-circle-notch"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Overlay / Legend -->
    <div class="absolute bottom-8 left-0 right-0 z-10 px-4 pointer-events-none flex justify-center">
        <div class="pointer-events-auto glass-panel p-4 md:p-5 rounded-2xl shadow-2xl flex flex-col md:flex-row items-center gap-6 md:gap-8 max-w-full overflow-x-auto">
            
            <div class="flex items-center gap-3 shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-lg" style="background-color: #10b981;">
                    <i class="fa-solid fa-check text-white text-xs"></i>
                </div>
                <div>
                    <p class="text-white text-sm font-bold leading-none">Selesai</p>
                    <p class="text-slate-400 text-[10px] font-medium uppercase tracking-wider mt-1">Progress 100%</p>
                </div>
            </div>
            
            <div class="w-px h-8 bg-slate-700 hidden md:block"></div>

            <div class="flex items-center gap-3 shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-lg" style="background-color: #3b82f6;">
                    <i class="fa-solid fa-landmark text-white text-xs"></i>
                </div>
                <div>
                    <p class="text-white text-sm font-bold leading-none">Sumber: Reses</p>
                    <p class="text-slate-400 text-[10px] font-medium uppercase tracking-wider mt-1">Belum Selesai</p>
                </div>
            </div>
            
            <div class="w-px h-8 bg-slate-700 hidden md:block"></div>

            <div class="flex items-center gap-3 shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-lg" style="background-color: #f97316;">
                    <i class="fa-solid fa-users text-white text-xs"></i>
                </div>
                <div>
                    <p class="text-white text-sm font-bold leading-none">Masyarakat</p>
                    <p class="text-slate-400 text-[10px] font-medium uppercase tracking-wider mt-1">Belum Selesai</p>
                </div>
            </div>
            
            <div class="w-px h-8 bg-slate-700 hidden md:block"></div>

            <div class="flex items-center gap-3 shrink-0 opacity-80">
                <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-lg" style="background-color: #ef4444;">
                    <i class="fa-solid fa-circle-info text-white text-xs"></i>
                </div>
                <div>
                    <p class="text-white text-sm font-bold leading-none">Lainnya</p>
                    <p class="text-slate-500 text-[10px] font-medium uppercase tracking-wider mt-1">Belum Selesai</p>
                </div>
            </div>

        </div>
    </div>


    <!-- MapLibre GL JS -->
    <script src="https://unpkg.com/maplibre-gl@3.6.2/dist/maplibre-gl.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiKey = 'ZDiWx4r1ToT9jGdlNPco';
            
            // Using a dark style for professional control-room look
            const map = new maplibregl.Map({
                container: 'map',
                style: `https://api.maptiler.com/maps/dataviz-dark/style.json?key=${apiKey}`,
                center: [106.8837, -6.1384],
                zoom: 12,
                pitch: 45, // slight 3D pitch
                bearing: -17.6, // slight rotation
                antialias: true
            });

            map.addControl(new maplibregl.NavigationControl({
                visualizePitch: true
            }), 'top-right');

            const locations = @json($locations);
            
            if (locations && locations.length > 0) {
                const bounds = new maplibregl.LngLatBounds();
                let validMarkers = 0;

                locations.forEach(loc => {
                    if (loc.lat && loc.lng && !isNaN(loc.lat) && !isNaN(loc.lng)) {
                        let lat = parseFloat(loc.lat);
                        let lng = parseFloat(loc.lng);
                        
                        if (lat < -90 || lat > 90) {
                            const temp = lat;
                            lat = lng;
                            lng = temp;
                        }

                        // Determine icon based on status
                        let icon = 'fa-circle-info';
                        if (loc.status === 'Selesai') icon = 'fa-check';
                        else if (loc.sumber_data.toLowerCase() === 'reses') icon = 'fa-landmark';
                        else if (loc.sumber_data.toLowerCase() === 'masyarakat') icon = 'fa-users';

                        // Custom HTML Marker
                        const el = document.createElement('div');
                        el.className = 'custom-marker w-10 h-10 rounded-full flex items-center justify-center border-2 border-white/20';
                        el.style.backgroundColor = loc.color;
                        el.style.boxShadow = `0 0 20px ${loc.color}80`;
                        el.innerHTML = `<i class="fa-solid ${icon} text-white text-sm"></i>`;
                        
                        // Popup Content
                        const popupContent = `
                            <div class="p-5 max-w-sm w-72">
                                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/10">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background-color: ${loc.color}20; color: ${loc.color};">
                                        <i class="fa-solid ${icon}"></i>
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">${loc.type}</div>
                                        <h3 class="font-display font-bold text-white text-base leading-tight">${loc.name}</h3>
                                    </div>
                                </div>
                                
                                <div class="space-y-3 mb-5">
                                    <div class="mb-3 text-xs text-slate-300 bg-white/5 p-2 rounded border border-white/10">
                                        <strong class="text-white">Deskripsi:</strong><br>
                                        ${loc.deskripsi}
                                    </div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs text-slate-400 font-medium w-16">Progress:</span>
                                        <div class="w-full bg-slate-800 rounded-full h-2">
                                          <div class="h-2 rounded-full" style="width: ${loc.progress}%; background-color: ${loc.color};"></div>
                                        </div>
                                        <span class="text-xs font-bold" style="color: ${loc.color};">${loc.progress}%</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-slate-400">Status</span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold border border-current" style="background-color: ${loc.color}20; color: ${loc.color}">
                                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 bg-current ${loc.status === 'Selesai' ? '' : 'animate-pulse'}"></span>
                                            ${loc.status}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-slate-400">Koordinat</span>
                                        <span class="text-xs font-mono text-slate-300 bg-slate-800 px-2 py-1 rounded">${lat.toFixed(4)}, ${lng.toFixed(4)}</span>
                                    </div>
                                </div>

                                <a href="https://www.google.com/maps/@?api=1&map_action=pano&viewpoint=${lat},${lng}" target="_blank" 
                                   class="block w-full py-2.5 text-center text-xs font-bold text-white rounded-xl transition-all shadow-lg hover:shadow-xl group overflow-hidden relative"
                                   style="background-color: ${loc.color};">
                                    <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <i class="fa-solid fa-street-view mr-2"></i> Buka Street View
                                </a>
                            </div>
                        `;
                        
                        const popup = new maplibregl.Popup({ 
                            offset: 25, 
                            closeButton: true,
                            closeOnClick: false,
                            maxWidth: '300px'
                        }).setHTML(popupContent);

                        // Add marker
                        const marker = new maplibregl.Marker({
                            element: el,
                            anchor: 'bottom'
                        })
                        .setLngLat([lng, lat])
                        .setPopup(popup)
                        .addTo(map);
                        
                        loc.marker = marker;
                        loc.isOnMap = true;
                        
                        bounds.extend([lng, lat]);
                        validMarkers++;
                    }
                });

                if (validMarkers > 0) {
                    map.fitBounds(bounds, { padding: { top: 100, bottom: 150, left: 50, right: 50 }, maxZoom: 14 });
                }

                // Live Search Logic
                const searchInput = document.getElementById('mapSearchInput');
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
                                    if (loc.marker.getPopup().isOpen()) {
                                        loc.marker.getPopup().remove();
                                    }
                                }
                            }
                        });

                        if (searchTerm !== '') {
                            if (hasVisibleMarker) {
                                map.fitBounds(searchBounds, { padding: { top: 100, bottom: 150, left: 50, right: 50 }, maxZoom: 15 });
                            }
                        } else {
                            map.fitBounds(bounds, { padding: { top: 100, bottom: 150, left: 50, right: 50 } });
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>
