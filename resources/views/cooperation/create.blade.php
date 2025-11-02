<x-app-layout>

    <x-slot name="style">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
            Koperasi &raquo; Tambah
        </h2>
    </x-slot>

    <x-slot name="script">

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            // Inisialisasi peta
            var map = L.map('map').setView([-3.4126, 119.3435], 10);

            // Basemap 1: Google Hybrid (satellite + label)
            var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });

            // Basemap 2: Google Streets (jalan)
            var googleStreets = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });

            // Basemap 3: OpenStreetMap (default)
            var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            });

            // Tambahkan layer default
            googleHybrid.addTo(map);

            // Layer control
            var baseMaps = {
                "OpenStreetMap": osm,
                "Google Streets": googleStreets,
                "Google Hybrid": googleHybrid,
            };

            L.control.layers(baseMaps).addTo(map);

            // Custom icon marker
            var customIcon = L.icon({
                iconUrl: '/images/icon-marker.png', // Ganti dengan path icon kamu
                iconSize: [80, 60],
                iconAnchor: [40, 60],
                popupAnchor: [0, -32]
            });

            var marker = null;

            // Fungsi set marker
            function setMarker(lat, lng) {
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {
                        icon: customIcon
                    }).addTo(map);
                }
            }

            // Klik pada peta
            map.on('click', function(e) {
                var lat = e.latlng.lat.toFixed(7);
                var lng = e.latlng.lng.toFixed(7);

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                setMarker(lat, lng);
            });

            // Jika user isi manual lat/lng, update marker
            document.getElementById('latitude').addEventListener('change', updateMarkerFromInput);
            document.getElementById('longitude').addEventListener('change', updateMarkerFromInput);

            function updateMarkerFromInput() {
                var lat = parseFloat(document.getElementById('latitude').value);
                var lng = parseFloat(document.getElementById('longitude').value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    setMarker(lat, lng);
                    map.setView([lat, lng], 15);
                }
            }
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

            <form method="POST" action="#">
                @csrf

                <label class="block mb-2 font-medium">Nama KDKMP : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">SK AHU : </label>
                <input type="text" name="legal_entity_number" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Tanggal SK AHU : </label>
                <input type="date" name="date_legal_entity_number" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Alamat Lengkap</label>
                <textarea name="full_address" class="w-full border rounded p-2 mb-4"></textarea>

                <label class="block mb-2 font-medium">Nomor Telepon : </label>
                <input type="text" name="phone_number" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Email : </label>
                <input type="text" name="email" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Tabungan Pokok : </label>
                <input type="text" name="principal_saving" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Tabungan Wajib : </label>
                <input type="text" name="mandatory_saving" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Sub Domain : </label>
                <input type="url" name="subdomain" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Sembako : </label>
                <input type="text" name="grocery_outlet" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Apotek : </label>
                <input type="text" name="village_pharmacy_outlet" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Kantor Koperasi : </label>
                <input type="text" name="cooperative_office_outlet" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Simpan Pinjam : </label>
                <input type="text" name="savings_and_loan_outlet" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Klinik : </label>
                <input type="text" name="village" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Cold Storage : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Logistik : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Pupuk : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Pangkalan LPG : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Agen POS : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Gerai Akun Laku Pandai : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Akun Microsite : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Nama Ketua : </label>
                <input type="text" name="name" class="w-full border rounded p-2 mb-4">

                <!-- MAP -->
                <label class="block mb-2 font-medium">Lokasi Koperasi:</label>
                <div id="map" class="w-full h-64 mb-4 border rounded"></div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 font-medium">Latitude:</label>
                        <input type="text" id="latitude" name="latitude" class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">Longitude:</label>
                        <input type="text" id="longitude" name="longitude" class="w-full border rounded p-2">
                    </div>
                </div>

                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
            </form>
        </div>
    </div>

</x-app-layout>
