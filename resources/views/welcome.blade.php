<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Wilayah Pendampingan</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        #map {
            width: 100%;
            height: 600px;
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="relative bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-white py-10 shadow-xl">

        <!-- Tombol Login -->
        <div class="absolute top-5 right-6">
            <a href="{{ route('login') }}"
                class="px-4 py-2 bg-white/20 backdrop-blur-lg text-white rounded-lg border border-white/30 hover:bg-white/30 transition duration-200">
                Login
            </a>
        </div>

        <!-- Title -->
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl font-extrabold tracking-wide drop-shadow-md">
                🌍 Peta Sebaran KDKMP Kabupaten Polewali Mandar
            </h1>
            <p class="text-blue-100 mt-3 text-lg">
                {{-- Filter dan lihat data wilayah berdasarkan Kecamatan, Desa, atau Business Assistant --}}
            </p>

            <!-- Decorative underline -->
            <div class="mt-4 flex justify-center">
                <span class="block w-24 h-1 bg-white/50 rounded-full"></span>
            </div>
        </div>

    </header>


    {{-- <!-- Filter Section -->
    <section class="max-w-7xl mx-auto px-6 mt-10">
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col sm:flex-row items-center gap-4 justify-between">
            <div class="flex flex-wrap items-center gap-4 w-full sm:w-auto">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filter Berdasarkan</label>
                    <select id="filterType"
                        class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-48">
                        <option value="">-- Pilih Filter --</option>
                        <option value="kecamatan">Kecamatan</option>
                        <option value="desa">Desa</option>
                        <option value="ba">Business Assistant</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Item</label>
                    <select id="filterItem"
                        class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-56">
                        <option value="">-- Pilih Item --</option>
                    </select>
                </div>
            </div>

            <button id="applyFilter"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md font-semibold transition">
                Tampilkan
            </button>
        </div>
    </section> --}}

    <!-- Map Section -->
    <section class="max-w-7xl mx-auto px-6 mt-10 mb-10">
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div id="map"></div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // ==== INISIALISASI PETA ====
        var map = L.map('map').setView([-3.4126, 119.3435], 10);

        // ==== BASEMAPS ====
        var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        var googleStreets = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        });

        var baseMaps = {
            "OpenStreetMap": osm,
            "Google Streets": googleStreets,
            "Google Hybrid": googleHybrid,
        };

        // ==== DATA DARI BACKEND ====
        var cooperations = @json($locations);
        var villages = @json($villages);
        var districts = @json($districts);

        // ==== LAYER SEBARAN KOPERASI ====
        var coopLayer = L.layerGroup();

        var customIcon = L.icon({
            iconUrl: '/images/icon-marker.png',
            iconSize: [80, 60],
            iconAnchor: [40, 60],
            popupAnchor: [0, -32]
        });

        cooperations.forEach(function(coop) {
            if (coop.latitude && coop.longtitude) {
                var lat = parseFloat(coop.latitude);
                var lng = parseFloat(coop.longtitude);
                var mapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;
                var imageUrl = 'https://placehold.co/600x400.png';

                var popupContent = `
                <div class="max-w-[260px] bg-white shadow-lg rounded-xl overflow-hidden">
                    <img src="${imageUrl}" alt="${coop.name}" class="w-full h-32 object-cover">
                    <div class="p-3 max-h-48 overflow-y-auto">
                        <h3 class="text-lg font-semibold mb-1">${coop.name}</h3>
                        <p class="text-sm text-gray-600 mb-1"><b>Ketua:</b> ${coop.leader_name ?? '-'}</p>
                        <p class="text-sm text-gray-600 mb-1"><b>Alamat:</b> ${coop.full_address}</p>
                        <p class="text-sm text-gray-600 mb-1"><b>Telepon:</b> ${coop.legal_entity_number ?? '-'}</p>
                        <p class="text-sm text-gray-600 mb-1"><b>Email:</b> ${coop.email ?? '-'}</p>
                        <p class="text-sm text-gray-600 mb-1"><b>NIB:</b> ${coop.nib ? 'Ada' : 'Tidak Ada'}</p>
                        <div class="mt-2 flex justify-between">
                            <a href="${coop.subdomain}" target="_blank" class="text-blue-600 text-xs font-semibold hover:underline">Detail</a>
                            <a href="${mapsUrl}" target="_blank" class="text-green-600 text-xs font-semibold hover:underline">Kunjungi di Maps</a>
                        </div>
                    </div>
                </div>`;

                L.marker([lat, lng], {
                        icon: customIcon
                    })
                    .bindPopup(popupContent)
                    .addTo(coopLayer);
            }
        });

        // ==== LAYER GEOJSON DESA ====
        var villageLayer = L.layerGroup();

        villages.forEach(function(v) {
            if (v.geojson) {
                try {
                    var gj = JSON.parse(v.geojson);
                    var layer = L.geoJSON(gj, {
                        style: {
                            color: '#1E90FF',
                            weight: 1,
                            fillColor: '#ADD8E6',
                            fillOpacity: 0.3
                        }
                    }).bindPopup(`<strong>${v.type} ${v.name}</strong>`);
                    layer.addTo(villageLayer);
                } catch (e) {
                    console.error("GeoJSON tidak valid untuk desa:", v.name);
                }
            }
        });

        // ==== LAYER GEOJSON KECAMATAN ====
        var districtLayer = L.layerGroup();

        districts.forEach(function(d) {
            if (d.geojson) {
                try {
                    var gj = JSON.parse(d.geojson);
                    var layer = L.geoJSON(gj, {
                        style: {
                            color: '#FF6600',
                            weight: 2,
                            fillColor: '#FFA500',
                            fillOpacity: 0.1
                        }
                    }).bindPopup(`<strong>Kecamatan ${d.name}</strong>`);
                    layer.addTo(districtLayer);
                } catch (e) {
                    console.error("GeoJSON tidak valid untuk kecamatan:", d.name);
                }
            }
        });

        // ==== TAMBAHKAN KE PETA ====
        coopLayer.addTo(map);
        // villageLayer.addTo(map);
        // districtLayer.addTo(map);

        // ==== CONTROL LAYERS ====
        var overlayMaps = {
            "Sebaran Koperasi": coopLayer,
            "Batas Desa": villageLayer,
            "Batas Kecamatan": districtLayer
        };

        L.control.layers(baseMaps, overlayMaps, {
            collapsed: false
        }).addTo(map);

        // ==== FIT BOUNDS ====
        var validCoords = cooperations
            .filter(c => c.latitude && c.longtitude)
            .map(c => [parseFloat(c.latitude), parseFloat(c.longtitude)]);

        if (validCoords.length > 0) {
            map.fitBounds(L.latLngBounds(validCoords));
        } else {
            map.setView([-3.4126, 119.3435], 10);
        }
    </script>
</body>

</html>
