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
            Koperasi &raquo; Edit &raquo; {{ $cooperation->name }}
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

            <form method="POST" action="{{ route('cooperations.update', $cooperation) }}">
                @csrf
                @method('PUT')

                <label class="block mb-2 font-medium">Nama KDKMP : </label>
                <input type="text" name="name" value="{{ old('name', $cooperation->name) }}"
                    class="w-full border
                    rounded p-2 mb-4">

                <label class="block mb-2 font-medium">SK AHU : </label>
                <input type="text" name="legal_entity_number"
                    value="{{ old('legal_entity_number', $cooperation->legal_entity_number) }}"
                    class="w-full border
                    rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Tanggal SK AHU : </label>
                <input type="date"
                    value="{{ old('date_legal_entity_number', $cooperation->date_legal_entity_number) }}"
                    name="date_legal_entity_number" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Alamat Lengkap</label>
                <textarea name="full_address" class="w-full border rounded p-2 mb-4">{{ old('full_address', $cooperation->full_address) }}</textarea>

                <label class="block mb-2 font-medium">Nomor Telepon : </label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $cooperation->phone_number) }}"
                    class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Email : </label>
                <input type="text" name="email" alue="{{ old('email', $cooperation->email) }}"
                    class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Tabungan Pokok : </label>
                <input type="text" name="principal_saving"
                    alue="{{ old('principal_saving', $cooperation->principal_saving) }}"
                    class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Tabungan Wajib : </label>
                <input type="text" name="mandatory_saving" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Sub Domain : </label>
                <input type="url" name="subdomain" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Nama Ketua : </label>
                <input type="text" name="leader_name" value="{{ old('leader_name', $cooperation->leader_name) }}"
                    class="w-full border rounded p-2 mb-4">

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Sembako :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="grocery_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('grocery_outlet', $cooperation->grocery_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="grocery_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('grocery_outlet', $cooperation->grocery_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Apotek :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="village_pharmacy_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('village_pharmacy_outlet', $cooperation->village_pharmacy_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="village_pharmacy_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('village_pharmacy_outlet', $cooperation->village_pharmacy_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Kantor Koperasi :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="cooperative_office_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('cooperative_office_outlet', $cooperation->cooperative_office_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="cooperative_office_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('cooperative_office_outlet', $cooperation->cooperative_office_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Simpan Pinjam :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="savings_and_loan_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('savings_and_loan_outlet', $cooperation->savings_and_loan_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="savings_and_loan_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('savings_and_loan_outlet', $cooperation->savings_and_loan_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Klinik :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="village_clinic_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('village_clinic_outlet', $cooperation->village_clinic_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="village_clinic_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('village_clinic_outlet', $cooperation->village_clinic_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Cold Storage :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="cold_storage_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('cold_storage_outlet', $cooperation->cold_storage_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="cold_storage_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('cold_storage_outlet', $cooperation->cold_storage_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Logistik :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="logistics_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('logistics_outlet', $cooperation->logistics_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="logistics_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('logistics_outlet', $cooperation->logistics_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Pupuk :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="fertilize_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('fertilize_outlet', $cooperation->fertilize_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="fertilize_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('fertilize_outlet', $cooperation->fertilize_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Pangkalan LPG :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="lpg_base_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('lpg_base_outlet', $cooperation->lpg_base_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="lpg_base_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('lpg_base_outlet', $cooperation->lpg_base_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Agen POS :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="postal_agent_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('postal_agent_outlet', $cooperation->postal_agent_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="postal_agent_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('postal_agent_outlet', $cooperation->postal_agent_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Gerai Laku Pandai :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="smart_agent_outlet" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('smart_agent_outlet', $cooperation->smart_agent_outlet ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="smart_agent_outlet" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('smart_agent_outlet', $cooperation->smart_agent_outlet ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            Akun Microsite :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="microsite_account" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('microsite_account', $cooperation->microsite_account ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="microsite_account" value="0"
                                    class="form-radio text-red-600"
                                    {{ old('microsite_account', $cooperation->microsite_account ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 font-medium">
                            NIB :
                        </label>
                        <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                            <label class="inline-flex items-center">
                                <input type="radio" name="nib" value="1"
                                    class="form-radio text-green-600"
                                    {{ old('nib', $cooperation->nib ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Ada</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="radio" name="nib" value="0" class="form-radio text-red-600"
                                    {{ old('nib', $cooperation->nib ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Tidak Ada</span>
                            </label>
                        </div>
                    </div>
                </div>




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
