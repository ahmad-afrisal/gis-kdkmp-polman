<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


        <x-slot name="style">
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
            {{-- SELECT2 CSS --}}
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

            <style>
                #map {
                    width: 100%;
                    height: 80vh;
                }

                .select2-container--default .select2-selection--single {
                    height: 42px !important;
                    border: 1px solid #d1d5db !important;
                    /* border-gray-300 */
                    border-radius: 0.375rem !important;
                    /* rounded-md */
                    padding: 6px 10px !important;
                }

                .select2-container--default .select2-selection--single .select2-selection__arrow {
                    height: 38px !important;
                    right: 10px !important;
                }
            </style>
        </x-slot>

        <x-slot name="script">

            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            {{-- SELECT2 JS --}}
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    document.getElementById('longtitude').value = lng;

                    setMarker(lat, lng);
                });

                // Jika user isi manual lat/lng, update marker
                document.getElementById('latitude').addEventListener('change', updateMarkerFromInput);
                document.getElementById('longtitude').addEventListener('change', updateMarkerFromInput);

                function updateMarkerFromInput() {
                    var lat = parseFloat(document.getElementById('latitude').value);
                    var lng = parseFloat(document.getElementById('longtitude').value);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        setMarker(lat, lng);
                        map.setView([lat, lng], 15);
                    }
                }

                $(document).ready(function() {
                    $('#village_id').select2({
                        placeholder: "-- Pilih Desa --",
                        allowClear: true,
                        width: '100%' // agar lebar select2 mengikuti container
                    });

                    $('#bussiness_assistant_id').select2({
                        placeholder: "-- Pilih BA --",
                        allowClear: true,
                        width: '100%' // agar lebar select2 mengikuti container
                    });
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
                        <span class="text-gray-500">Koperasi</span>
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

                    <form method="POST" action="{{ route('cooperations.store') }}">
                        @csrf

                        <label class="block mb-2 font-medium">Nama KDKMP : </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">SK AHU : </label>
                        <input type="text" name="legal_entity_number" value="{{ old('legal_entity_number') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Tanggal SK AHU : </label>
                        <input type="date" value="{{ old('date_legal_entity_number') }}"
                            name="date_legal_entity_number" class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Alamat Lengkap :</label>
                        <textarea name="full_address" class="w-full border rounded p-2 mb-4">{{ old('full_address') }}</textarea>

                        <div class="mb-6">
                            <label class="block mb-2 font-medium">Desa : </label>
                            <select name="village_id" id="village_id" class="w-full border rounded p-2 mb-4 select2">
                                <option value="">-- Pilih Desa --</option>
                                @foreach ($villages as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('village_id') == $id ? 'selected' : '' }}>
                                        {{ $id }} - {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 font-medium">Bussiness Assistant : </label>
                            <select name="bussiness_assistant_id" id="bussiness_assistant_id"
                                class="w-full border rounded p-2 mb-4 select2">
                                <option value="">-- Pilih Bussiness Assistant --</option>
                                @foreach ($bussinessAssistants as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('bussiness_assistant_id') == $id ? 'selected' : '' }}>
                                        {{ $id }} - {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="block mb-2 font-medium">Nomor Telepon : </label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Email : </label>
                        <input type="email" name="email" alue="{{ old('email') }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Tabungan Pokok : </label>
                        <input type="number" name="principal_saving" value="{{ old('principal_saving') }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Tabungan Wajib : </label>
                        <input type="number" name="mandatory_saving" value="{{ old('mandatory_saving') }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Sub Domain : </label>
                        <input type="text" name="subdomain" value="{{ old('subdomain') }}"
                            class="w-full border rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Nama Ketua : </label>
                        <input type="text" name="leader_name" value="{{ old('leader_name') }}"
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
                                            {{ old('grocery_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="grocery_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('grocery_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('village_pharmacy_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="village_pharmacy_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('village_pharmacy_outlet') == 0 ? 'checked' : '' }}>
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
                                        <input type="radio" name="coopeative_office_outlet" value="1"
                                            class="form-radio text-green-600"
                                            {{ old('coopeative_office_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="coopeative_office_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('coopeative_office_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('savings_and_loan_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="savings_and_loan_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('savings_and_loan_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('village_clinic_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="village_clinic_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('village_clinic_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('cold_storage_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="cold_storage_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('cold_storage_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('logistics_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="logistics_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('logistics_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('fertilize_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="fertilize_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('fertilize_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('lpg_base_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="lpg_base_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('lpg_base_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('postal_agent_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="postal_agent_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('postal_agent_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('smart_agent_outlet', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="smart_agent_outlet" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('smart_agent_outlet') == 0 ? 'checked' : '' }}>
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
                                            {{ old('microsite_account', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="microsite_account" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('microsite_account') == 0 ? 'checked' : '' }}>
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
                                            {{ old('nib', 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Ada</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="nib" value="0"
                                            class="form-radio text-red-600" {{ old('nib', 1) == 0 ? 'checked' : '' }}>
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
                                <input type="text" id="latitude" name="latitude"
                                    class="w-full border rounded p-2">
                            </div>
                            <div>
                                <label class="block mb-2 font-medium">Longitude:</label>
                                <input type="text" id="longtitude" name="longtitude"
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
