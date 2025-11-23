<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Koperasi') }}
        </h2>
    </x-slot>

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
        {{-- DataTable JS --}}
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
            // Inisialisasi peta
            var map = L.map('map').setView([-3.4126, 119.3435], 10);

            // Basemap
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
            L.control.layers(baseMaps).addTo(map);

            // Custom icon marker
            var customIcon = L.icon({
                iconUrl: '/images/icon-marker.png',
                iconSize: [80, 60],
                iconAnchor: [40, 60],
                popupAnchor: [0, -32]
            });

            // Data lokasi dari backend (Blade -> JS)
            var cooperations = @json($locations);


            // Tambahkan marker untuk setiap koperasi
            cooperations.forEach(function(coop) {
                if (coop.latitude && coop.longtitude) {
                    var lat = parseFloat(coop.latitude);
                    var lng = parseFloat(coop.longtitude);

                    var marker = L.marker([lat, lng], {
                        icon: customIcon
                    }).addTo(map);

                    // link ke Google Maps
                    var mapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;


                    // Gambar (gunakan placeholder jika null)
                    var imageUrl =
                        'https://placehold.co/600x400.png';

                    // Konten popup
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
        </div>
        `;

                    marker.bindPopup(popupContent, {
                        maxWidth: 260,
                        minWidth: 240
                    });
                }
            });





            // Optional: zoom agar semua titik terlihat
            // if (cooperations.length > 0) {
            //     var bounds = L.latLngBounds(cooperations.map(c => [c.latitude, c.longtitude]));
            //     map.fitBounds(bounds);
            // }

            if (cooperations.length > 0) {
                // Ambil hanya data dengan koordinat valid
                var validCoords = cooperations
                    .filter(c => c.latitude && c.longtitude)
                    .map(c => [parseFloat(c.latitude), parseFloat(c.longtitude)]);

                if (validCoords.length > 0) {
                    var bounds = L.latLngBounds(validCoords);
                    map.fitBounds(bounds);
                } else {
                    // fallback ke posisi default Polewali Mandar
                    map.setView([-3.4126, 119.3435], 10);
                }
            } else {
                // fallback kalau tidak ada data sama sekali
                map.setView([-3.4126, 119.3435], 10);
            }
        </script>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
</x-app-layout>
