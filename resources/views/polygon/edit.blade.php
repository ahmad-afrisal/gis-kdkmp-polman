<x-app-layout>

    <x-slot name="style">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
        <style>
            #map {
                width: 100%;
                height: 80vh;
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lahan Sawit &raquo; Edit &raquo; {{ $data->id }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
        <script>
            var map = L.map('map').setView([-3.4126, 119.3435], 10);

            // 🔥 Ganti tile jadi Esri Satelit (mirip Google Earth)
            L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                // attribution: 'Tiles © Esri — Source: Esri, Maxar, Earthstar Geographics'
            }).addTo(map);

            // Layer untuk polygon
            var drawnItems = new L.FeatureGroup();
            map.addLayer(drawnItems);

            // Jika sudah ada geojson tersimpan, tampilkan
            @if ($data->geojson)
                var existingGeoJSON = {!! $data->geojson !!};
                var layer = L.geoJSON(existingGeoJSON).getLayers()[0];
                drawnItems.addLayer(layer);
                map.fitBounds(layer.getBounds());
                document.getElementById('geojsonField').value = JSON.stringify(existingGeoJSON);
            @endif

            // Control untuk menggambar/edit
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

            // Event: buat polygon baru
            map.on(L.Draw.Event.CREATED, function(event) {
                drawnItems.clearLayers();
                var layer = event.layer;
                drawnItems.addLayer(layer);
                var geojson = layer.toGeoJSON();
                document.getElementById('geojsonField').value = JSON.stringify(geojson.geometry);
            });

            // Event: edit polygon
            map.on(L.Draw.Event.EDITED, function(event) {
                event.layers.eachLayer(function(layer) {
                    var geojson = layer.toGeoJSON();
                    document.getElementById('geojsonField').value = JSON.stringify(geojson.geometry);
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#cooperation_id').select2({
                    width: '100%',
                    placeholder: "-- Pilih KDKMP --",
                    allowClear: true
                });
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <form action="{{ route('polygons.update', $data->id) }}" method="post" enctype="multipart/form-data"
                class="bg-white p-6 rounded-lg shadow-md">
                @csrf
                @method('PUT')

                <!-- Petani -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Nama KDKMP</label>
                    <select name="cooperation_id" id="cooperation_id"
                        class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                        <option value="">-- Pilih KDKMP--</option>
                        @foreach ($cooperations as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('cooperation_id', $data->cooperation_id) == $id ? 'selected' : '' }}>
                                {{ $id }} - {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- Hidden field untuk simpan polygon -->
                <input type="hidden" name="geojson" id="geojsonField">

                <div id="map" class="rounded-lg shadow mb-4"></div>

                <div class="flex space-x-2">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                        Simpan
                    </button>
                    <a href="{{ route('polygons.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
