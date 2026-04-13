<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


        <x-slot name="script">
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    // Merge Rowspan
                    applyRowspan();

                    // Script checkbox logic (akun & bank)
                    document.querySelectorAll('.checkbox-status').forEach(function(checkbox) {
                        checkbox.addEventListener('change', function() {
                            const group = this.dataset.group;
                            const checkboxes = document.querySelectorAll(`input[data-group="${group}"]`);
                            if (this.checked) {
                                checkboxes.forEach(cb => {
                                    if (cb !== this) cb.checked = false;
                                });
                            }
                        });
                    });

                    // Script sinkronisasi input potensi dan checkbox "belum_terisi"
                    document.querySelectorAll('.potensi-input').forEach(function(input) {
                        input.addEventListener('input', function() {
                            const group = this.dataset.group;
                            const checkbox = document.querySelector(
                                `.checkbox-potensi[data-group="${group}"]`);
                            checkbox.checked = this.value.trim() === '';
                        });
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
                    applyRowspan();
                });

                // =============================
                // Add new gerai row
                // =============================
                // =============================
                // Add new gerai row
                // =============================
                function tambahGerai(btn) {
                    const tbody = btn.closest('tbody');
                    const row = btn.closest('tr');

                    // 1. Dapatkan index KDKMP (misal: 0) dari data-coop-index
                    const coopIndex = row.getAttribute('data-coop-index');

                    // 2. Hitung jumlah *gerai* yang sudah ada untuk KDKMP ini
                    // Dengan mencari semua baris yang memiliki data-coop-index yang sama
                    const existingGeraiCount = tbody.querySelectorAll(`tr[data-coop-index="${coopIndex}"]`).length;
                    const newRowIndex = existingGeraiCount; // Index baru dimulai dari jumlah yang ada

                    const newRow = row.cloneNode(true);

                    // 3. Update atribut data-coop-index pada baris baru (seharusnya sama, tapi untuk jaga-jaga)
                    newRow.setAttribute('data-coop-index', coopIndex);

                    // kosongkan nilai input kecuali cooperation_id
                    newRow.querySelectorAll('input, select').forEach(el => {
                        if (!el.name.includes("cooperation_id")) {
                            el.value = "";
                        }
                    });

                    // 4. Perbaiki nama index (KRUSIAL)
                    // Gunakan regex yang lebih spesifik untuk mengganti *HANYA* rowIndex (index kedua)
                    newRow.querySelectorAll('[name]').forEach(el => {
                        let name = el.getAttribute('name');

                        // Pola: Ganti angka kedua setelah [X_ (misal: [0_0] jadi [0_1])
                        // name.replace(/\[\d+_(\d+)\]/, `[${coopIndex}_${newRowIndex}]`);
                        // Cara paling aman adalah membangun ulang namanya:
                        const oldIndexPattern = name.match(/data\[(\d+)_(\d+)\]/);

                        if (oldIndexPattern) {
                            // Bagian pertama (cooperation_id) harus tetap $coopIndex
                            // Bagian kedua (rowIndex) harus menggunakan $newRowIndex
                            const newName = name.replace(oldIndexPattern[0], `data[${coopIndex}_${newRowIndex}]`);
                            el.setAttribute('name', newName);
                        } else {
                            // Untuk jaga-jaga jika ada name lain yang tidak mengikuti pola data[X_Y]
                            // Biarkan saja, atau sesuaikan jika ada kebutuhan lain.
                        }
                    });

                    // kosongkan ID supaya create baru
                    newRow.querySelector('input[name*="[id]"]').value = "";

                    // Perbarui data-group pada baris baru (jika ada) untuk rowspan
                    newRow.setAttribute('data-group', row.getAttribute('data-group'));

                    // Masukkan baris baru setelah baris saat ini
                    row.insertAdjacentElement('afterend', newRow);

                    applyRowspan();
                }

                // =============================
                // Rowspan grouping
                // =============================
                function applyRowspan() {
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const kdkmp = row.querySelector('.kdkmp-cell');
                        if (kdkmp) {
                            kdkmp.style.display = 'table-cell';
                            kdkmp.removeAttribute('rowspan');
                        }

                        const nomor = row.querySelector('.no-cell');
                        if (nomor) {
                            nomor.style.display = 'table-cell';
                            nomor.removeAttribute('rowspan');
                        }
                    });

                    const groups = {};

                    rows.forEach(row => {
                        const group = row.getAttribute('data-group');
                        if (!groups[group]) groups[group] = [];
                        groups[group].push(row);
                    });

                    Object.values(groups).forEach(groupRows => {
                        const first = groupRows[0];

                        const k = first.querySelector('.kdkmp-cell');
                        if (k) k.setAttribute('rowspan', groupRows.length);

                        const n = first.querySelector('.no-cell');
                        if (n) n.setAttribute('rowspan', groupRows.length);

                        groupRows.slice(1).forEach(r => {
                            let k = r.querySelector('.kdkmp-cell');
                            let n = r.querySelector('.no-cell');
                            if (k) k.style.display = 'none';
                            if (n) n.style.display = 'none';
                        });
                    });
                }
            </script>


        </x-slot>


        <main class="flex-1 overflow-y-auto">

            @include('components.header')
            <div class="py-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-7">
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-green-600">
                            <i data-lucide="home" class="w-4 h-4 mr-1"></i> Home
                        </a>
                        <span>›</span>
                        <span class="text-gray-500">Business Assitant</span>
                        <span>›</span>
                        <span class="text-gray-500">Form 5 2026</span>
                    </nav>
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
                            <div
                                class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @include('components.button-form')

                    <div class="bg-white shadow-xl rounded-lg p-6">

                        <form action="{{ route('bussiness-assistants.form-11.store', $bussinessAssistant->id) }}"
                            method="POST">
                            @csrf

                            {{-- Scroll container --}}
                            <div class="overflow-x-auto rounded-lg border border-gray-300">
                                <table class="min-w-full text-sm text-center border-collapse">

                                    <thead>
                                        <tr class="bg-green-600 ">
                                            <th rowspan="2"
                                                class="sticky left-0 z-20 border bg-green-600 border border-gray-300 px-3 py-2">
                                                Aksi</th>
                                            <th rowspan="2"
                                                class="sticky left-0 z-10 bg-inherit border border-gray-300 px-3 py-2">
                                                No</th>
                                            <th rowspan="2"
                                                class="sticky left-[45px] z-10 bg-inherit w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                                                Nama KDKMP
                                            </th>
                                            <th colspan="2" class="border border-gray-300 px-3 py-2">Calon Mitra /
                                                Mitra
                                            </th>

                                            <th rowspan="2"
                                                class="w-[800px] min-w-[200px] border border-gray-300 px-2 py-1">
                                                Pola
                                                Kemitraan
                                                /Kerja
                                                Sama
                                            </th>

                                            <th rowspan="2"
                                                class="w-[800px] min-w-[200px] border border-gray-300 px-2 py-1">
                                                Komoditas
                                            </th>

                                            <th rowspan="2"
                                                class="w-[800px] min-w-[200px] border border-gray-300 px-2 py-1">
                                                Kapasitas
                                            </th>

                                            <th colspan="3" class="border border-gray-300 px-3 py-2">Status Kemitraan
                                            </th>
                                            <th colspan="2" class="border border-gray-300 px-3 py-2">Output (PKS/
                                                Kesepakatan)
                                            </th>
                                            <th rowspan="2"
                                                class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                                                Kendala</th>
                                            <th rowspan="2"
                                                class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                                                Keterangan</th>

                                        </tr>
                                        <tr class="bg-green-700 ">
                                            <th class="border border-gray-300 px-3 py-2">BUMN</th>
                                            <th class="border border-gray-300 px-3 py-2">Non BUMN</th>

                                            <th class="border border-gray-300 px-3 py-2">Pengajuan</th>
                                            <th class="border border-gray-300 px-3 py-2">Proses</th>
                                            <th class="border border-gray-300 px-3 py-2">Perjanjian/
                                                Perintah Kerja</th>

                                            <th class="border border-gray-300 px-3 py-2">Ada</th>
                                            <th class="border border-gray-300 px-3 py-2">Tidak</th>

                                        </tr>
                                    </thead>

                                    <tbody class="text-gray-700">
                                        @forelse ($cooperations as $index => $coop)

                                            @php
                                                // jika ada banyak gerai, looping semuanya
                                                $rows = $coop->formElevens->count() ? $coop->formElevens : [null];
                                            @endphp

                                            @foreach ($rows as $rowIndex => $formEleven)
                                                <tr data-group="{{ $coop->id }}"
                                                    data-coop-index="{{ $index }}" {{-- ^^ TAMBAHKAN INI ^^ --}}
                                                    class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">
                                                    <td class="border px-2 py-1">
                                                        <button type="button" onclick="tambahGerai(this)"
                                                            class="text-xs bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded">
                                                            + Tambah Gerai
                                                        </button>
                                                    </td>
                                                    <td
                                                        class="sticky left-0 z-10 bg-inherit border border-gray-300 px-2 py-1 font-medium text-center">
                                                        {{ $index + 1 }}
                                                    </td>

                                                    {{-- Hidden cooperation_id --}}
                                                    <input type="hidden"
                                                        name="data[{{ $index }}][cooperation_id]"
                                                        value="{{ $coop->id }}">

                                                    {{-- Nama Koperasi --}}
                                                    <td
                                                        class="sticky left-[45px] z-10 bg-inherit border border-gray-300 px-2 py-1">
                                                        <input type="text" name="data[{{ $index }}][nama]"
                                                            value="{{ $coop->name ?? '' }}"
                                                            class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                    </td>

                                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                                        <input type="checkbox" class="checkbox-status"
                                                            data-group="potential_partners_{{ $index }}"
                                                            data-type="bumn"
                                                            name="data[{{ $index }}][potential_partners_bumn]"
                                                            value="1"
                                                            {{ $formEleven?->potential_partners === 1 ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                                        <input type="checkbox" class="checkbox-status"
                                                            data-group="potential_partners_{{ $index }}"
                                                            data-type="non-bumn"
                                                            name="data[{{ $index }}][potential_partners_non_bumn]"
                                                            value="0"
                                                            {{ $formEleven?->potential_partners === 0 ? 'checked' : '' }}>
                                                    </td>

                                                    <td class="border border-gray-300 px-2 py-1">
                                                        <select name="data[{{ $index }}][partnership_pattern]"
                                                            class="border-gray-300 rounded w-full p-1">
                                                            <option value="">-- Pilih --</option>
                                                            <option value="inti-plasma"
                                                                {{ $formEleven?->partnership_pattern == 'inti-plasma' ? 'selected' : '' }}>
                                                                inti-plasma
                                                            </option>
                                                            <option value="subkontrak"
                                                                {{ $formEleven?->partnership_pattern == 'subkontrak' ? 'selected' : '' }}>
                                                                subkontrak</option>
                                                            <option value="waralaba"
                                                                {{ $formEleven?->partnership_pattern == 'waralaba' ? 'selected' : '' }}>
                                                                waralaba
                                                            </option>
                                                            <option value="perdagangan umum"
                                                                {{ $formEleven?->partnership_pattern == 'perdagangan umum' ? 'selected' : '' }}>
                                                                perdagangan umum</option>
                                                            <option value="subkontrak"
                                                                {{ $formEleven?->partnership_pattern == 'subkontrak' ? 'selected' : '' }}>
                                                                subkontrak</option>
                                                            <option value="distribusi dan keagenan"
                                                                {{ $formEleven?->partnership_pattern == 'distribusi dan keagenan' ? 'selected' : '' }}>
                                                                distribusi dan keagenan
                                                            </option>
                                                            <option value="rantai pasok"
                                                                {{ $formEleven?->partnership_pattern == 'rantai pasok' ? 'selected' : '' }}>
                                                                rantai pasok</option>
                                                            <option value="bagi hasil"
                                                                {{ $formEleven?->partnership_pattern == 'bagi hasil' ? 'selected' : '' }}>
                                                                bagi hasil</option>
                                                            <option value="kerja sama operasional"
                                                                {{ $formEleven?->partnership_pattern == 'kerja sama operasional' ? 'selected' : '' }}>
                                                                kerja sama operasional</option>
                                                            <option value="usaha patungan (joint venture)"
                                                                {{ $formEleven?->partnership_pattern == 'usaha patungan (joint venture)' ? 'selected' : '' }}>
                                                                usaha patungan (joint venture)</option>
                                                            <option value="penyumberluaran (outsourcing)"
                                                                {{ $formEleven?->partnership_pattern == 'penyumberluaran (outsourcing)' ? 'selected' : '' }}>
                                                                penyumberluaran (outsourcing)</option>
                                                        </select>
                                                    </td>
                                                    <td class="border border-gray-300 px-2 py-1">
                                                        <select name="data[{{ $index }}][commodity_id]"
                                                            class="border-gray-300 rounded w-full p-1">
                                                            <option value="">-- Pilih --</option>
                                                            @foreach ($commodities as $id => $name)
                                                                <option value="{{ $id }}"
                                                                    {{ old("data.$index.commodity_id", $formEleven?->commodity_id) == $id ? 'selected' : '' }}>
                                                                    {{ $id }} - {{ $name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="border border-gray-300 px-2 py-1">
                                                        <select name="data[{{ $index }}][capacity]"
                                                            class="border-gray-300 rounded w-full p-1">
                                                            <option value="">-- Pilih --</option>

                                                            <optgroup label="Berat">
                                                                <option value="kg"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'kg' ? 'selected' : '' }}>
                                                                    Kilogram (kg)</option>
                                                                <option value="gr"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'gr' ? 'selected' : '' }}>
                                                                    Gram (gr)</option>
                                                                <option value="ton"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'ton' ? 'selected' : '' }}>
                                                                    Ton</option>
                                                                <option value="kw"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'kw' ? 'selected' : '' }}>
                                                                    Kuintal (kw)</option>
                                                                <option value="lb"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'lb' ? 'selected' : '' }}>
                                                                    Pound (lb)</option>
                                                            </optgroup>

                                                            <optgroup label="Kuantitas/Unit">
                                                                <option value="pcs"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'pcs' ? 'selected' : '' }}>
                                                                    Pieces (pcs)</option>
                                                                <option value="btg"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'btg' ? 'selected' : '' }}>
                                                                    Batang (btg)</option>
                                                                <option value="bks"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'bks' ? 'selected' : '' }}>
                                                                    Bungkus (bks)</option>
                                                                <option value="unit"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'unit' ? 'selected' : '' }}>
                                                                    Unit</option>
                                                                <option value="lsn"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'lsn' ? 'selected' : '' }}>
                                                                    Lusin</option>
                                                            </optgroup>

                                                            <optgroup label="Volume/Cair">
                                                                <option value="lt"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'lt' ? 'selected' : '' }}>
                                                                    Liter (lt)</option>
                                                                <option value="ml"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'ml' ? 'selected' : '' }}>
                                                                    Mililiter (ml)</option>
                                                                <option value="m3"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'm3' ? 'selected' : '' }}>
                                                                    Meter Kubik (m³)</option>
                                                            </optgroup>

                                                            <optgroup label="Luas/Panjang">
                                                                <option value="m"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'm' ? 'selected' : '' }}>
                                                                    Meter (m)</option>
                                                                <option value="ha"
                                                                    {{ old('capacity', $formEleven?->capacity ?? '') == 'ha' ? 'selected' : '' }}>
                                                                    Hektar (ha)</option>
                                                            </optgroup>



                                                        </select>
                                                    </td>
                                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                                        <input type="checkbox" class="checkbox-status"
                                                            data-group="partnership_status_{{ $index }}"
                                                            data-type="belum_ada"
                                                            name="data[{{ $index }}][partnership_status_belum_ada]"
                                                            value="0"
                                                            {{ $formEleven?->partnership_status == 0 ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                                        <input type="checkbox" class="checkbox-status"
                                                            data-group="partnership_status_{{ $index }}"
                                                            data-type="belum_buka"
                                                            name="data[{{ $index }}][partnership_status_belum_buka]"
                                                            value="1"
                                                            {{ $formEleven?->partnership_status == 1 ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                                        <input type="checkbox" class="checkbox-status"
                                                            data-group="partnership_status_{{ $index }}"
                                                            data-type="belum_operasional"
                                                            name="data[{{ $index }}][partnership_status_belum_operasional]"
                                                            value="1"
                                                            {{ $formEleven?->partnership_status == 2 ? 'checked' : '' }}>
                                                    </td>

                                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                                        <input type="checkbox" class="checkbox-status"
                                                            data-group="output_{{ $index }}"
                                                            data-type="disetujui"
                                                            name="data[{{ $index }}][output_approved]"
                                                            value="1"
                                                            {{ $formEleven?->output === 1 ? 'checked' : '' }}>
                                                    </td>
                                                    <td class="border border-gray-300 px-2 py-1 text-center">
                                                        <input type="checkbox" class="checkbox-status"
                                                            data-group="output_{{ $index }}"
                                                            data-type="ditolak"
                                                            name="data[{{ $index }}][output_rejected]"
                                                            value="0"
                                                            {{ $formEleven?->output === 0 ? 'checked' : '' }}>
                                                    </td>

                                                    <td class="border border-gray-300 px-2 py-1">
                                                        <input type="text"
                                                            name="data[{{ $index }}][problem]"
                                                            value="{{ $formEleven?->problem ?? '' }}"
                                                            class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                    </td>
                                                    <td class="border border-gray-300 px-2 py-1">
                                                        <input type="text"
                                                            name="data[{{ $index }}][information]"
                                                            value="{{ $formEleven?->information ?? '' }}"
                                                            class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td colspan="17"
                                                    class="border border-gray-300 px-4 py-3 text-center text-gray-500 italic">
                                                    Tidak ada data koperasi untuk BA ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 text-right space-x-2">
                                <a href="{{ route('bussiness-assistants.show', $bussinessAssistant->id) }}"
                                    class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg shadow transition text-center">
                                    Kembali
                                </a>

                                <button type="submit"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition text-center">
                                    💾 Simpan Data
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
