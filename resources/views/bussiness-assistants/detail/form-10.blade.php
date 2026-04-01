<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


        <x-slot name="script">
            <script>
                document.addEventListener('DOMContentLoaded', function() {
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
                        <span class="text-gray-500">Form 4 2026</span>
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

                        <form action="{{ route('bussiness-assistants.form-10.store', $bussinessAssistant->id) }}"
                            method="POST">
                            @csrf

                            {{-- Scroll container --}}
                            <div class="overflow-x-auto rounded-lg border border-gray-300">
                                <table class="min-w-full text-sm text-center border-collapse">

                                    <thead>
                                        <tr class="bg-green-600 ">
                                            <th rowspan="2"
                                                class="sticky left-0 z-20 border bg-green-600 border border-gray-300 px-3 py-2">
                                                No</th>
                                            <th rowspan="2"
                                                class="sticky left-[45px] z-20 bg-green-600  w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                                                Nama KDKMP
                                            </th>

                                            <th colspan="2" class="border border-gray-300 px-3 py-2">Update Profil
                                                Koperasi
                                                Desa/Kelurahan
                                                Merah Putih
                                            </th>
                                            <th colspan="2"
                                                class="w-[600px] min-w-[300px border border-gray-300 px-3 py-2">Potensi
                                                Desa</th>
                                            <th colspan="7" class="border border-gray-300 px-3 py-2">Gerai yang ada
                                            </th>
                                            <th colspan="2" class="border border-gray-300 px-3 py-2">RAT
                                            </th>
                                            <th colspan="2"
                                                class="w-[600px] min-w-[300px border border-gray-300 px-3 py-2">Jumlah
                                                Anggota</th>
                                            <th rowspan="2"
                                                class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                                                Kendala</th>
                                            <th rowspan="2"
                                                class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                                                Keterangan</th>

                                        </tr>
                                        <tr class="bg-green-700 ">
                                            <th class="border border-gray-300 px-3 py-2">Sudah</th>
                                            <th class="border border-gray-300 px-3 py-2">Belum</th>

                                            <th class="w-[150px] min-w-[80px] border border-gray-300 px-3 py-2">Sudah
                                            </th>
                                            <th class="w-[150px] min-w-[80px] border border-gray-300 px-3 py-2">Belum
                                            </th>

                                            <th class="border border-gray-300 px-3 py-2">Sembako</th>
                                            <th class="border border-gray-300 px-3 py-2">Apotek</th>
                                            <th class="border border-gray-300 px-3 py-2">Pergudangan</th>
                                            <th class="border border-gray-300 px-3 py-2">Klinik</th>
                                            <th class="border border-gray-300 px-3 py-2">Logistik / Distribusi</th>
                                            <th class="border border-gray-300 px-3 py-2">USP</th>
                                            <th class="border border-gray-300 px-3 py-2">Usaha Lain</th>

                                            <th class="border border-gray-300 px-3 py-2">Sudah</th>
                                            <th class="border border-gray-300 px-3 py-2">Belum</th>

                                            <th class="border border-gray-300 px-3 py-2">Jumlah anggota awal</th>
                                            <th class="border border-gray-300 px-3 py-2">Penambahan anggota</th>

                                        </tr>
                                    </thead>

                                    <tbody class="text-gray-700">
                                        @forelse ($cooperations as $index => $coop)
                                            @php
                                                $form = $coop->formTen; // Bisa null, aman
                                            @endphp
                                            <tr class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">
                                                <td
                                                    class="sticky left-0 z-10 bg-inherit border border-gray-300 px-2 py-1 font-medium text-center">
                                                    {{ $index + 1 }}
                                                </td>

                                                {{-- Hidden cooperation_id --}}
                                                <input type="hidden" name="data[{{ $index }}][cooperation_id]"
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
                                                        data-group="{{ $index }}" data-type="ada"
                                                        name="data[{{ $index }}][profile_update_ada]"
                                                        value="1" {{ $form?->profile_update ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="{{ $index }}" data-type="belum"
                                                        name="data[{{ $index }}][profile_update_belum]"
                                                        value="0" {{ !$form?->profile_update ? 'checked' : '' }}>
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="village_potential_{{ $index }}"
                                                        data-type="ada"
                                                        name="data[{{ $index }}][village_potential_ada]"
                                                        value="1"
                                                        {{ $form?->village_potential ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="village_potential_{{ $index }}"
                                                        data-type="belum"
                                                        name="data[{{ $index }}][village_potential_belum]"
                                                        value="0"
                                                        {{ !$form?->village_potential ? 'checked' : '' }}>
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="grocery_outlet_{{ $index }}"
                                                        data-type="disetujui"
                                                        name="data[{{ $index }}][grocery_outlet]"
                                                        value="1"
                                                        {{ $form?->grocery_outlet === 1 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="pharmacy_outlet_{{ $index }}"
                                                        data-type="ditolak"
                                                        name="data[{{ $index }}][pharmacy_outlet]"
                                                        value="1"
                                                        {{ $form?->pharmacy_outlet === 1 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="warehousing_outlet_{{ $index }}"
                                                        data-type="disetujui"
                                                        name="data[{{ $index }}][warehousing_outlet]"
                                                        value="1"
                                                        {{ $form?->warehousing_outlet === 1 ? 'checked' : '' }}>
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="clinic_outlet_{{ $index }}"
                                                        data-type="ditolak"
                                                        name="data[{{ $index }}][clinic_outlet]"
                                                        value="1"
                                                        {{ $form?->clinic_outlet === 1 ? 'checked' : '' }}>
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="logistics_outlet_{{ $index }}"
                                                        data-type="ditolak"
                                                        name="data[{{ $index }}][logistics_outlet]"
                                                        value="1"
                                                        {{ $form?->logistics_outlet === 1 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="usp_outlet_{{ $index }}"
                                                        data-type="disetujui"
                                                        name="data[{{ $index }}][usp_outlet]" value="1"
                                                        {{ $form?->usp_outlet === 1 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="other_businesses_outlet_{{ $index }}"
                                                        data-type="ditolak"
                                                        name="data[{{ $index }}][other_businesses_outlet]"
                                                        value="1"
                                                        {{ $form?->other_businesses_outlet === 1 ? 'checked' : '' }}>
                                                </td>

                                                {{-- RAT --}}
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="rat_{{ $index }}" data-type="ada"
                                                        name="data[{{ $index }}][rat_ada]" value="1"
                                                        {{ $form?->rat ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="rat_{{ $index }}" data-type="belum"
                                                        name="data[{{ $index }}][rat_belum]" value="0"
                                                        {{ !$form?->rat ? 'checked' : '' }}>
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="number"
                                                        name="data[{{ $index }}][initial_membership]"
                                                        value="{{ $form?->initial_membership ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="number"
                                                        name="data[{{ $index }}][addition_of_members]"
                                                        value="{{ $form?->addition_of_members ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>




                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="text" name="data[{{ $index }}][problem]"
                                                        value="{{ $form?->problem ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="text"
                                                        name="data[{{ $index }}][information]"
                                                        value="{{ $form?->information ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>

                                            </tr>
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
