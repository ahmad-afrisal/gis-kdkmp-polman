<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


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
                        <span class="text-gray-500">Polygon</span>
                    </nav>
                    @include('components.alert')
                    <div class="mb-10">
                        <a href="{{ route('polygons.create') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">+
                            Tambah
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
        </main>
    </div>

</x-app-layout>
