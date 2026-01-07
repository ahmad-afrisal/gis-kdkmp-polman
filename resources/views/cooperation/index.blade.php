<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>



        {{-- LEAFLET CSS --}}
        <x-slot name="style">
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <style>
                #map {
                    width: 100%;
                    height: 500px;
                    margin-top: 20px;
                    border-radius: 8px;
                    overflow: hidden;
                }
            </style>
        </x-slot>

        <x-slot name="script">
            <script>
                var datatable = $('#crudTable').DataTable({
                    responsive: true,
                    ajax: {
                        url: '{!! url()->current() !!}'
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            width: '10%'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            width: '15%'
                        }
                    ]
                })
            </script>
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
        </x-slot>

        <main class="flex-1 overflow-y-auto">

            @include('components.header')
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-7">
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-green-600">
                            <i data-lucide="home" class="w-4 h-4 mr-1"></i> Home
                        </a>
                        <span>›</span>
                        <span class="text-gray-500">Koperasi</span>
                    </nav>

                    {{-- Tombol tambah --}}
                    <div class="mb-10">
                        <a href="{{ route('cooperations.create') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">
                            + Tambah Koperasi
                        </a>
                    </div>

                    {{-- DATA TABLE --}}
                    <div class="shadow overflow-hidden sm-rounded-md bg-white p-4">
                        <table id="crudTable" class="display cell-border">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    {{-- PETA --}}
                    <div class="shadow overflow-hidden sm-rounded-md bg-white p-4">
                        <h3 class="text-lg font-bold mb-2">Peta Sebaran KDKMP</h3>
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
