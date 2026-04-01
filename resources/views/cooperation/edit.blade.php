<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


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
                        <span>›</span>
                        <span class="text-gray-500">Edit</span>
                        <span>›</span>
                        <span class="text-gray-500">{{ $cooperation->id }}</span>
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
                        <input type="text" name="phone_number"
                            value="{{ old('phone_number', $cooperation->phone_number) }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Email : </label>
                        <input type="text" name="email" value="{{ old('email', $cooperation->email) }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Tabungan Pokok : </label>
                        <input type="text" name="principal_saving"
                            value="{{ old('principal_saving', $cooperation->principal_saving) }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Tabungan Wajib : </label>
                        <input type="text" name="mandatory_saving"
                            value="{{ old('mandatory_saving', $cooperation->mandatory_saving) }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Sub Domain : </label>
                        <input type="url" name="subdomain" value="{{ old('subdomain', $cooperation->subdomain) }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Nama Ketua : </label>
                        <input type="text" name="leader_name"
                            value="{{ old('leader_name', $cooperation->leader_name) }}"
                            class="w-full border rounded p-2 mb-4">




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
                                        <input type="radio" name="nib" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('nib', $cooperation->nib ?? 1) == 0 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Tidak Ada</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white mb-3 p-6 rounded-2xl border border-gray-100 shadow-sm">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Ketersediaan Gerai Layanan
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">

                                @php
                                    // Array untuk memudahkan looping agar kode tidak panjang berulang
                                    $outlets = [
                                        ['name' => 'grocery_outlet', 'label' => 'Gerai Sembako'],
                                        ['name' => 'village_pharmacy_outlet', 'label' => 'Gerai Apotek'],
                                        ['name' => 'cooperative_office_outlet', 'label' => 'Kantor Koperasi'],
                                        ['name' => 'savings_and_loan_outlet', 'label' => 'Simpan Pinjam'],
                                        ['name' => 'village_clinic_outlet', 'label' => 'Gerai Klinik'],
                                        ['name' => 'cold_storage_outlet', 'label' => 'Cold Storage'],
                                        ['name' => 'logistics_outlet', 'label' => 'Gerai Logistik'],
                                        ['name' => 'fertilize_outlet', 'label' => 'Gerai Pupuk'],
                                        ['name' => 'lpg_base_outlet', 'label' => 'Pangkalan LPG'],
                                        ['name' => 'postal_agent_outlet', 'label' => 'Agen POS'],
                                        ['name' => 'smart_agent_outlet', 'label' => 'Laku Pandai'],
                                    ];
                                @endphp

                                @foreach ($outlets as $outlet)
                                    <div
                                        class="flex flex-col space-y-2 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                                        <label class="text-sm font-semibold text-gray-600 tracking-wide">
                                            {{ $outlet['label'] }} :
                                        </label>

                                        <div class="flex items-center space-x-6">
                                            <label class="inline-flex items-center cursor-pointer group">
                                                <div class="relative flex items-center">
                                                    <input type="radio" name="{{ $outlet['name'] }}"
                                                        value="1"
                                                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2 transition"
                                                        {{ old($outlet['name'], $cooperation->{$outlet['name']} ?? 1) == 1 ? 'checked' : '' }}>
                                                    <span
                                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-green-600 transition-colors">Ada</span>
                                                </div>
                                            </label>

                                            <label class="inline-flex items-center cursor-pointer group">
                                                <div class="relative flex items-center">
                                                    <input type="radio" name="{{ $outlet['name'] }}"
                                                        value="0"
                                                        class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 focus:ring-2 transition"
                                                        {{ old($outlet['name'], $cooperation->{$outlet['name']} ?? 1) == 0 ? 'checked' : '' }}>
                                                    <span
                                                        class="ml-2 text-sm font-medium text-gray-700 group-hover:text-red-600 transition-colors">Tidak
                                                        Ada</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>




                        <!-- MAP -->
                        <label class="block mb-2 font-medium">Lokasi Koperasi:</label>
                        <div id="map" class="w-full h-64 mb-4 border rounded"></div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 font-medium">Latitude:</label>
                                <input type="text" id="latitude" name="latitude"
                                    value="{{ old('latitude', $cooperation->latitude) }}"
                                    class="w-full border rounded p-2">
                            </div>
                            <div>
                                <label class="block mb-2 font-medium">Longitude:</label>
                                <input type="text" id="longitude" name="longitude"
                                    value="{{ old('longtitude', $cooperation->longtitude) }}"
                                    class="w-full border rounded p-2">
                            </div>
                        </div>

                        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

</x-app-layout>
