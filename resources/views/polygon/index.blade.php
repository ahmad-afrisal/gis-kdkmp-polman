<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peta Lokasi Gerai') }}
        </h2>
    </x-slot>

    <x-slot name="style">

        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
        <style>
            #map {
                width: 100%;
                height: 80vh;
            }
        </style>
    </x-slot>

    <x-slot name="script">
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
        <script>
            // AJAX DataTable

            var datatable = $('#crudTable').DataTable({
                responsive: true, // <--- aktifkan fitur ini
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '10%'
                    },
                    {
                        data: 'cooperation',
                        name: 'cooperation',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '15%',
                    }
                ]
            })
        </script>

        <script>
            // Inisialisasi peta
            var map = L.map('map').setView([-3.4126, 119.3435], 10);


            // Google Hybrid Layer
            var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            // Ambil semua data polygon dari controller
            var lahanData = @json($lands);

            lahanData.forEach(function(lahan) {

                if (lahan.geojson) {
                    var geojson = (typeof lahan.geojson === "string") ?
                        JSON.parse(lahan.geojson) :
                        lahan.geojson;

                    // Style polygon tetap sama untuk semua
                    L.geoJSON(geojson, {
                            style: {
                                color: "#1E90FF", // biru
                                weight: 2,
                                fillOpacity: 0.4
                            }
                        })
                        .bindPopup(`
                <b>KDKMP:</b> ${lahan.cooperation ? lahan.cooperation.name : '-'}
            `)
                        .addTo(map);
                }
            });
        </script>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-5" role="alert">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        Error
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-5" role="alert">
                    <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                        Berhasil
                    </div>
                    <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="mb-10">
                <a href="{{ route('polygons.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">+ Tambah
                    Lahan</a>
            </div>

            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable" class="display cell-border">
                        <thead>
                            <tr>
                                <th>ID Lahan</th>
                                <th>Nama KDKMP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Map -->
            <div class="max-w-7xl mx-auto my-8 px-4">
                <div id="map" class="w-full h-[600px] rounded-lg shadow"></div>
            </div>

        </div>
    </div>
</x-app-layout>
