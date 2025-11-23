<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Form Pendataan Koperasi</h2>
    </x-slot>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                applyRowspan();
            });

            // =============================
            // Add new gerai row
            // =============================
            function tambahGerai(btn) {
                const tbody = btn.closest('tbody');
                const row = btn.closest('tr');
                const newIndex = tbody.querySelectorAll('tr').length;

                const newRow = row.cloneNode(true);

                // kosongkan nilai input kecuali cooperation_id
                newRow.querySelectorAll('input, select').forEach(el => {
                    if (!el.name.includes("cooperation_id")) {
                        el.value = "";
                    }
                });

                // perbaiki nama index
                newRow.querySelectorAll('[name]').forEach(el => {
                    let name = el.getAttribute('name');
                    name = name.replace(/\[\d+\]/, `[${newIndex}]`);
                    el.setAttribute('name', name);
                });

                // kosongkan ID supaya create baru
                newRow.querySelector('input[name*="[id]"]').value = "";

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

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
            <div class="bg-white shadow-xl rounded-lg p-6">

                <form action="{{ route('bussiness-assistants.form-5.store', $bussinessAssistant->id) }}" method="POST">
                    @csrf

                    <div class="overflow-x-auto rounded-lg border border-gray-300">
                        <table class="min-w-full text-sm text-center border-collapse">

                            <thead>
                                <tr class="bg-green-600 text-white">
                                    <th class="border px-3 py-2">Aksi</th>
                                    <th class="border px-3 py-2">No</th>
                                    <th class="border px-3 py-2">Nama KDKMP</th>
                                    <th class="border px-3 py-2">Gerai</th>
                                    <th class="border px-3 py-2">Volume Usaha</th>
                                    <th class="border px-3 py-2">Total Aset</th>
                                    <th class="border px-3 py-2">Laba/Rugi</th>
                                    <th class="border px-3 py-2">Keterangan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($cooperations as $index => $coop)
                                    @php
                                        // jika ada banyak gerai, looping semuanya
                                        $rows = $coop->formFives->count() ? $coop->formFives : [null];
                                    @endphp

                                    @foreach ($rows as $rowIndex => $formFive)
                                        <tr data-group="{{ $coop->id }}"
                                            class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">

                                            <td class="border px-2 py-1">
                                                <button type="button" onclick="tambahGerai(this)"
                                                    class="text-xs bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded">
                                                    + Tambah Gerai
                                                </button>
                                            </td>

                                            <td class="border px-2 py-1 no-cell">{{ $index + 1 }}</td>

                                            <td class="border px-2 py-1 kdkmp-cell">
                                                <input type="text" value="{{ $coop->name }}"
                                                    class="w-64 border rounded p-2" disabled>
                                            </td>

                                            {{-- GERAI --}}
                                            <td class="border px-2 py-1">
                                                <select
                                                    name="data[{{ $index }}_{{ $rowIndex }}][branch_type]"
                                                    class="w-full border rounded p-2">
                                                    <option value="">Pilih Gerai</option>
                                                    @foreach (['Sembako', 'Apotik', 'Klinik', 'Simpan Pinjam', 'Pergudangan', 'Logistik', 'Usaha Lain'] as $g)
                                                        <option value="{{ $g }}"
                                                            {{ $formFive?->branch_type == $g ? 'selected' : '' }}>
                                                            {{ $g }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td class="border px-2 py-1">
                                                <input
                                                    name="data[{{ $index }}_{{ $rowIndex }}][business_volume]"
                                                    class="w-full border rounded p-2"
                                                    value="{{ $formFive?->business_volume }}">
                                            </td>

                                            <td class="border px-2 py-1">
                                                <input
                                                    name="data[{{ $index }}_{{ $rowIndex }}][total_assets]"
                                                    class="w-full border rounded p-2"
                                                    value="{{ $formFive?->total_assets }}">
                                            </td>

                                            <td class="border px-2 py-1">
                                                <input
                                                    name="data[{{ $index }}_{{ $rowIndex }}][profit_loss]"
                                                    class="w-full border rounded p-2"
                                                    value="{{ $formFive?->profit_loss }}">
                                            </td>

                                            <td class="border px-2 py-1">
                                                <input
                                                    name="data[{{ $index }}_{{ $rowIndex }}][information]"
                                                    class="w-full border rounded p-2"
                                                    value="{{ $formFive?->information }}">

                                                {{-- Hidden --}}
                                                <input type="hidden"
                                                    name="data[{{ $index }}_{{ $rowIndex }}][cooperation_id]"
                                                    value="{{ $coop->id }}">

                                                <input type="hidden"
                                                    name="data[{{ $index }}_{{ $rowIndex }}][id]"
                                                    value="{{ $formFive?->id }}">
                                            </td>

                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="mt-6 text-right">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow">
                            💾 Simpan Data
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
