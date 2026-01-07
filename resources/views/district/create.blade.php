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
                var map = L.map('map').setView([-3.4126, 119.3435], 10);


                // 🔥 Ganti tile jadi Esri Satelit (mirip Google Earth)
                // L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                //     maxZoom: 20,
                //     attribution: 'Tiles © Esri — Source: Esri, Maxar, Earthstar Geographics'
                // }).addTo(map);
                // Gunakan tile Google Hybrid biar mirip Google Earth
                var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(map);


                // Layer hasil gambar
                var drawnItems = new L.FeatureGroup();
                map.addLayer(drawnItems);

                // Control untuk menggambar
                var drawControl = new L.Control.Draw({
                    edit: {
                        featureGroup: drawnItems
                    },
                    draw: {
                        polygon: true,
                        polyline: false,
                        rectangle: false,
                        circle: false,
                        marker: false,
                        circlemarker: false
                    }
                });
                map.addControl(drawControl);

                // Event ketika polygon dibuat
                map.on(L.Draw.Event.CREATED, function(event) {
                    drawnItems.clearLayers();
                    var layer = event.layer;
                    drawnItems.addLayer(layer);

                    // Simpan GeoJSON ke hidden input
                    var geojson = layer.toGeoJSON();
                    document.getElementById('geojsonField').value = JSON.stringify(geojson.geometry);
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
                        <span class="text-gray-500">Kecamatan</span>
                        <span>›</span>
                        <span class="text-gray-500">Tambah</span>
                    </nav>
                    @if ($errors->any())
                        <div class="mb-5" role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                Terdapat kesalahan
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('districts.store') }}" method="post" enctype="multipart/form-data"
                        class="bg-white p-6 rounded-lg shadow-md">
                        @csrf


                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Kecamatan</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                        </div>

                        <!-- Hidden field untuk simpan polygon -->
                        <input type="hidden" name="geojson" id="geojsonField">

                        <div id="map" class="rounded-lg shadow mb-4"></div>

                        <div class="flex space-x-2">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Simpan
                            </button>
                            <a href="{{ route('districts.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

</x-app-layout>
