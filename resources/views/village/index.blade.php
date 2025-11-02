<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Desa') }}
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

        {{-- LEAFLET JS --}}
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            // Ambil data kecamatan dari Laravel
            var villages = @json($villages);

            // Inisialisasi peta
            var map = L.map('map').setView([-3.4, 119.2], 9);

            // Basemap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Array warna untuk per kecamatan
            var colors = ['#FF5733', '#33FF57', '#3357FF', '#FFC300', '#8E44AD', '#16A085', '#E67E22', '#2C3E50'];

            var allLayers = L.featureGroup(); // Untuk fitBounds semua kecamatan

            villages.forEach((village, index) => {
                if (!village.geojson) return;

                // Parse geojson string ke object
                var geo = JSON.parse(village.geojson);

                var layer = L.geoJSON(geo, {
                    style: {
                        color: colors[index % colors.length],
                        weight: 2,
                        fillOpacity: 0.4,
                        smoothFactor: 1.5, // garis lebih halus
                        lineJoin: 'round' // sudut tidak kotak
                    }
                }).bindPopup("<b>" + village.name + "</b>");


                layer.addTo(map);
                allLayers.addLayer(layer);
            });

            // Zoom otomatis ke semua kecamatan
            if (allLayers.getLayers().length > 0) {
                map.fitBounds(allLayers.getBounds());
            }
        </script>


    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol tambah --}}
            <div class="mb-10">
                <a href="{{ route('villages.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">
                    + Tambah Desa
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
                <h3 class="text-lg font-bold mb-2">Peta Kecamatan</h3>
                <div id="map"></div>
            </div>


        </div>
    </div>
</x-app-layout>
