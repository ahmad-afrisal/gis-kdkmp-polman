<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        @include('components.sidebar')

        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

        <x-slot name="style">
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <style>
                #coordinate-map {
                    height: 60vh;
                    min-height: 320px;
                }
            </style>
        </x-slot>

        <x-slot name="script">
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                (() => {
                    const districtSelect = document.getElementById('district_id');
                    const villageSelect = document.getElementById('village_id');

                    if (!districtSelect || !villageSelect) return;

                    const urlTemplate = villageSelect.dataset.url;

                    async function loadVillages(districtId, selectedVillage = '') {
                        villageSelect.innerHTML = '<option value="">Memuat desa...</option>';
                        villageSelect.disabled = true;

                        if (!districtId) {
                            villageSelect.innerHTML =
                                '<option value="">Pilih Kecamatan Terlebih Dahulu</option>';
                            return;
                        }

                        try {
                            const url = urlTemplate.replace('__DISTRICT__', districtId);

                            const response = await fetch(url, {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            });

                            if (!response.ok) throw new Error('Gagal mengambil data desa');

                            const villages = await response.json();

                            villageSelect.innerHTML =
                                '<option value="">Pilih Desa/Kelurahan</option>';

                            Object.entries(villages).forEach(([id, name]) => {
                                const option = document.createElement('option');

                                option.value = id;
                                option.textContent = name;

                                if (String(id) === String(selectedVillage)) {
                                    option.selected = true;
                                }

                                villageSelect.appendChild(option);
                            });

                            villageSelect.disabled = Object.keys(villages).length === 0;

                        } catch (error) {
                            console.error(error);

                            villageSelect.innerHTML =
                                '<option value="">Gagal memuat data desa</option>';
                        }
                    }

                    // Ketika kecamatan berubah
                    districtSelect.addEventListener('change', function() {
                        loadVillages(this.value);
                    });

                    if (districtSelect.value) {
                        loadVillages(
                            districtSelect.value,
                            villageSelect.dataset.oldVillage
                        );
                    }
                })();

                (() => {
                    const latitudeInput = document.getElementById('latitude');
                    const longitudeInput = document.getElementById('longitude');
                    const modal = document.getElementById('coordinate-map-modal');
                    const mapElement = document.getElementById('coordinate-map');
                    const openButton = document.getElementById('choose-coordinate-button');
                    const closeButtons = document.querySelectorAll('[data-close-coordinate-map]');
                    const center = [-3.4126, 119.3435];
                    let map;
                    let marker;

                    function getCoordinates() {
                        const latitude = Number(latitudeInput.value);
                        const longitude = Number(longitudeInput.value);

                        if (
                            latitudeInput.value === '' ||
                            longitudeInput.value === '' ||
                            !Number.isFinite(latitude) ||
                            !Number.isFinite(longitude) ||
                            latitude < -90 ||
                            latitude > 90 ||
                            longitude < -180 ||
                            longitude > 180
                        ) {
                            return null;
                        }

                        return [latitude, longitude];
                    }

                    function updateMarker(coordinates, zoom = false) {
                        if (!map) return;

                        if (!coordinates) {
                            if (marker) {
                                map.removeLayer(marker);
                                marker = null;
                            }
                            return;
                        }

                        if (marker) {
                            marker.setLatLng(coordinates);
                        } else {
                            marker = L.marker(coordinates).addTo(map);
                        }

                        if (zoom) map.setView(coordinates, 15);
                    }

                    function openMap() {
                        modal.classList.remove('hidden');

                        if (!map) {
                            map = L.map(mapElement).setView(center, 10);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '&copy; OpenStreetMap contributors'
                            }).addTo(map);

                            map.on('click', event => {
                                const latitude = event.latlng.lat.toFixed(7);
                                const longitude = event.latlng.lng.toFixed(7);
                                latitudeInput.value = latitude;
                                longitudeInput.value = longitude;
                                updateMarker([Number(latitude), Number(longitude)]);
                            });
                        }

                        window.setTimeout(() => {
                            map.invalidateSize();
                            const coordinates = getCoordinates();
                            if (coordinates) {
                                map.setView(coordinates, 15);
                                updateMarker(coordinates);
                            }
                        }, 0);
                    }

                    openButton.addEventListener('click', openMap);
                    closeButtons.forEach(button => {
                        button.addEventListener('click', () => modal.classList.add('hidden'));
                    });

                    [latitudeInput, longitudeInput].forEach(input => {
                        input.addEventListener('change', () => {
                            const coordinates = getCoordinates();
                            if (coordinates) updateMarker(coordinates, true);
                        });
                    });
                })();
            </script>
        </x-slot>

        <main class="flex-1 overflow-y-auto">

            @include('components.header')

            <div class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-6">
                        <a href="{{ route('dashboard') }}" class="hover:text-green-600">
                            Home
                        </a>
                        <span>›</span>
                        <span>Master Data</span>
                        <span>›</span>
                        <span>Koperasi Existing</span>
                        <span>›</span>
                        <span class="text-green-600">{{ isset($data) ? 'Edit' : 'Tambah' }}</span>
                    </nav>

                    <!-- Error Validation -->
                    @if ($errors->any())
                        <div class="mb-5 bg-red-100 border border-red-400 text-red-700 rounded-lg p-4">
                            <strong>Terdapat kesalahan!</strong>
                            <ul class="list-disc pl-5 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ isset($data) ? route('existing-cooperatives.update', $data->id) : route('existing-cooperatives.store') }}"
                        method="POST"
                        class="bg-white rounded-xl shadow-md p-6 space-y-8">

                        @csrf
                        @isset($data)
                            @method('PUT')
                        @endisset

                        <!-- IDENTITAS KOPERASI -->
                        <section>
                            <div class="border-b pb-3 mb-5">
                                <h3 class="text-lg font-bold text-gray-800">
                                    1. Identitas Koperasi
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Informasi dasar dan identitas resmi koperasi.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="form-label">Nomor Induk Koperasi (NIK) *</label>
                                    <input type="text" name="nik" value="{{ old('nik', $data->nik ?? '') }}" class="form-input"
                                        required>
                                </div>

                                <div>
                                    <label class="form-label">Nama Koperasi *</label>
                                    <input type="text" name="name" value="{{ old('name', $data->name ?? '') }}" class="form-input"
                                        required>
                                </div>

                                <div>
                                    <label class="form-label">Nomor Badan Hukum (AHU) *</label>
                                    <input type="text" name="legal_entity_number"
                                        value="{{ old('legal_entity_number', $data->legal_entity_number ?? '') }}" class="form-input" required>
                                </div>

                                <div>
                                    <label class="form-label">Bentuk Koperasi *</label>
                                    <select name="form_of_cooperative" class="form-input" required>
                                        <option value="">Pilih Bentuk Koperasi</option>
                                        <option value="Primer"
                                            {{ old('form_of_cooperative', $data->form_of_cooperative ?? '') == 'Primer' ? 'selected' : '' }}>Primer
                                        </option>
                                        <option value="Sekunder"
                                            {{ old('form_of_cooperative', $data->form_of_cooperative ?? '') == 'Sekunder' ? 'selected' : '' }}>Sekunder
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Jenis Koperasi *</label>
                                    <input type="text" name="type_of_cooperative"
                                        value="{{ old('type_of_cooperative', $data->type_of_cooperative ?? '') }}" class="form-input" required>
                                </div>

                                <div>
                                    <label class="form-label">Model Pengelolaan *</label>
                                    <select name="management_model" class="form-input" required>
                                        <option value="">Pilih Model Pengelolaan</option>
                                        <option value="Konvensional"
                                            {{ old('management_model', $data->management_model ?? '') == 'Konvensional' ? 'selected' : '' }}>
                                            Konvensional</option>
                                        <option value="Syariah"
                                            {{ old('management_model', $data->management_model ?? '') == 'Syariah' ? 'selected' : '' }}>Syariah
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Status Koperasi *</label>
                                    <select name="cooperative_status_id" class="form-input" required>
                                        <option value="">Pilih Status</option>
                                        @foreach ($cooperativeStatuses as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('cooperative_status_id', $data->cooperative_status_id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $id }} - {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Kegiatan Usaha *</label>
                                    <select name="business_activity_id" class="form-input" required>
                                        <option value="">Pilih Kegiatan Usaha</option>
                                        @foreach ($businessActivities as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('business_activity_id', $data->business_activity_id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $id }} - {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Kelompok Koperasi *</label>
                                    <input type="text" name="cooperative_group"
                                        value="{{ old('cooperative_group', $data->cooperative_group ?? '') }}" class="form-input" required>
                                </div>
                            </div>
                        </section>

                        <!-- LOKASI -->
                        <section>
                            <div class="border-b pb-3 mb-5">
                                <h3 class="text-lg font-bold text-gray-800">
                                    2. Lokasi dan Alamat
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="form-label">Kecamatan *</label>

                                    <select name="district_id" id="district_id" class="form-input" required>
                                        <option value="">Pilih Kecamatan</option>

                                        @foreach ($districts as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('district_id', $data->district_id ?? '') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label">Desa/Kelurahan *</label>

                                    <select name="village_id" id="village_id" class="form-input"
                                        data-url="{{ route('districts.villages', '__DISTRICT__') }}"
                                        data-old-village="{{ old('village_id', $data->village_id ?? '') }}" disabled required>

                                        <option value="">Pilih Kecamatan Terlebih Dahulu</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="form-label">Alamat Lengkap *</label>
                                    <textarea name="address" rows="3" class="form-input" required>{{ old('address', $data->address ?? '') }}</textarea>
                                </div>

                                <div class="md:col-span-2 rounded-lg border border-gray-200 bg-gray-50 p-4">
                                    <h4 class="font-semibold text-gray-800">Titik Koordinat (Opsional)</h4>
                                    <p class="mb-4 text-sm text-gray-500">Pilih titik pada peta atau masukkan latitude dan longitude. Isi keduanya jika koordinat tersedia.</p>
                                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                        <div>
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="number" id="latitude" name="latitude" min="-90" max="90" step="any"
                                                value="{{ old('latitude', $data->latitude ?? '') }}" class="form-input">
                                        </div>
                                        <div>
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="number" id="longitude" name="longitude" min="-180" max="180" step="any"
                                                value="{{ old('longitude', $data->longitude ?? '') }}" class="form-input">
                                        </div>
                                    </div>
                                    <button type="button" id="choose-coordinate-button"
                                        class="mt-4 rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                                        Pilih Titik di Peta
                                    </button>
                                </div>

                                <div>
                                    <label class="form-label">Kode Pos *</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code', $data->postal_code ?? '') }}"
                                        class="form-input" required>
                                </div>

                            </div>
                        </section>

                        <!-- KONTAK -->
                        <section>
                            <div class="border-b pb-3 mb-5">
                                <h3 class="text-lg font-bold text-gray-800">
                                    3. Informasi Kontak dan Keanggotaan
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', $data->phone_number ?? '') }}"
                                        class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $data->email ?? '') }}"
                                        class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Jumlah Anggota *</label>
                                    <input type="number" name="number_of_members"
                                        value="{{ old('number_of_members', $data->number_of_members ?? '') }}" min="0" class="form-input"
                                        required>
                                </div>

                            </div>
                        </section>

                        <!-- PENGURUS -->
                        <section>
                            <div class="border-b pb-3 mb-5">
                                <h3 class="text-lg font-bold text-gray-800">
                                    4. Susunan Pengurus
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Masukkan nama pengurus koperasi sesuai jabatan.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="form-label">Ketua</label>
                                    <input type="text" name="chairperson_name"
                                        value="{{ old('chairperson_name', $data->chairperson_name ?? '') }}" class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Sekretaris</label>
                                    <input type="text" name="secretary_name" value="{{ old('secretary_name', $data->secretary_name ?? '') }}"
                                        class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Bendahara</label>
                                    <input type="text" name="treasurer_name" value="{{ old('treasurer_name', $data->treasurer_name ?? '') }}"
                                        class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Wakil Ketua Bidang Keanggotaan</label>
                                    <input type="text" name="vice_chairperson_membership_name"
                                        value="{{ old('vice_chairperson_membership_name', $data->vice_chairperson_membership_name ?? '') }}" class="form-input">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="form-label">Wakil Ketua Bidang Usaha</label>
                                    <input type="text" name="vice_chairperson_business_operations_name"
                                        value="{{ old('vice_chairperson_business_operations_name', $data->vice_chairperson_business_operations_name ?? '') }}"
                                        class="form-input">
                                </div>

                            </div>
                        </section>

                        <!-- PENGAWAS -->
                        <section>
                            <div class="border-b pb-3 mb-5">
                                <h3 class="text-lg font-bold text-gray-800">
                                    5. Susunan Pengawas
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="form-label">Ketua Pengawas</label>
                                    <input type="text" name="head_supervisory_board_name"
                                        value="{{ old('head_supervisory_board_name', $data->head_supervisory_board_name ?? '') }}" class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Anggota Pengawas I</label>
                                    <input type="text" name="member_supervisory_board_i_name"
                                        value="{{ old('member_supervisory_board_i_name', $data->member_supervisory_board_i_name ?? '') }}" class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Anggota Pengawas II</label>
                                    <input type="text" name="member_supervisory_board_ii_name"
                                        value="{{ old('member_supervisory_board_ii_name', $data->member_supervisory_board_ii_name ?? '') }}" class="form-input">
                                </div>

                            </div>
                        </section>

                        <!-- ACTION -->
                        <div class="flex justify-end gap-3 border-t pt-5">
                            <a href="{{ route('existing-cooperatives.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-5 rounded-lg">
                                Kembali
                            </a>

                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg">
                                {{ isset($data) ? 'Perbarui Data Koperasi' : 'Simpan Data Koperasi' }}
                            </button>
                        </div>

                    </form>

                    <div id="coordinate-map-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 p-4">
                        <div class="w-full max-w-4xl rounded-xl bg-white p-5 shadow-xl">
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">Pilih Titik Koordinat</h3>
                                    <p class="text-sm text-gray-500">Klik lokasi koperasi pada peta, lalu tutup jendela ini.</p>
                                </div>
                                <button type="button" data-close-coordinate-map aria-label="Tutup peta"
                                    class="rounded px-3 py-1 text-2xl text-gray-500 hover:bg-gray-100">&times;</button>
                            </div>
                            <div id="coordinate-map" class="rounded-lg"></div>
                            <div class="mt-4 flex justify-end">
                                <button type="button" data-close-coordinate-map
                                    class="rounded-lg bg-green-600 px-5 py-2 font-semibold text-white hover:bg-green-700">
                                    Gunakan Titik Ini
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .form-label {
            display: block;
            color: #374151;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-input {
            display: block;
            width: 100%;
            background-color: #f9fafb;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 14px;
            outline: none;
        }

        .form-input:focus {
            background-color: white;
            border-color: #16a34a;
            box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.1);
        }
    </style>

</x-app-layout>
