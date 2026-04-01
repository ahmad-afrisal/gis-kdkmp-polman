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
                        <span class="text-gray-500">Form 8</span>
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

                        <form action="{{ route('bussiness-assistants.form-8.store', $bussinessAssistant->id) }}"
                            method="POST">
                            @csrf

                            {{-- Scroll container --}}
                            <div class="overflow-x-auto rounded-lg border border-gray-300">
                                <table class="min-w-full text-sm text-center border-collapse">

                                    <thead>
                                        <tr class="bg-green-600 ">
                                            <th rowspan="3"
                                                class="sticky left-0 z-20 border bg-green-600  border-gray-300 px-3 py-2">
                                                No</th>
                                            <th rowspan="3"
                                                class="sticky left-[45px] z-20 w-[800px] min-w-[600px] bg-green-600 border border-gray-300 px-2 py-1">
                                                Nama KDKMP
                                            </th>

                                            <th rowspan="2" colspan="2" class="border border-gray-300 px-3 py-2">
                                                Kesiapan
                                                Lokasi/Lahan
                                            </th>
                                            <th rowspan="2" colspan="3" class="border border-gray-300 px-3 py-2">
                                                Pembangunan
                                                Gerai
                                            </th>
                                            <th colspan="8"
                                                class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                                                Sarana & Prasarana</th>

                                            <th rowspan="3"
                                                class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">Kendala
                                            </th>
                                            <th rowspan="3"
                                                class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                                                Keterangan</th>

                                        </tr>
                                        <tr class="bg-green-600 ">

                                            <th colspan="2" class=" border border-gray-300 px-3 py-2">
                                                Kendaraan</th>
                                            <th colspan="2" class=" border border-gray-300 px-3 py-2">
                                                Meja & Kursi</th>
                                            <th colspan="2" class=" border border-gray-300 px-3 py-2">
                                                Etalase</th>
                                            <th colspan="2" class=" border border-gray-300 px-3 py-2">
                                                Komputer</th>

                                        </tr>
                                        <tr class="bg-green-600 ">
                                            <th class="border border-gray-300 px-3 py-2">Ada</th>
                                            <th class="border border-gray-300 px-3 py-2">Tidak</th>

                                            <th class="border border-gray-300 px-3 py-2">Selesai</th>
                                            <th class="border border-gray-300 px-3 py-2">Belum</th>
                                            <th class="border border-gray-300 px-3 py-2">Tidak dibangun</th>

                                            <th class="border border-gray-300 px-3 py-2">Ada</th>
                                            <th class="border border-gray-300 px-3 py-2">Tidak</th>

                                            <th class="border border-gray-300 px-3 py-2">Ada</th>
                                            <th class="border border-gray-300 px-3 py-2">Tidak</th>

                                            <th class="border border-gray-300 px-3 py-2">Ada</th>
                                            <th class="border border-gray-300 px-3 py-2">Tidak</th>

                                            <th class="border border-gray-300 px-3 py-2">Ada</th>
                                            <th class="border border-gray-300 px-3 py-2">Tidak</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-gray-700">
                                        @forelse ($cooperations as $index => $coop)
                                            @php
                                                $form = $coop->formEight; // Bisa null, aman
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
                                                        data-group="land_readiness_{{ $index }}" data-type="ada"
                                                        name="data[{{ $index }}][land_readiness_ada]"
                                                        value="1" {{ $form?->land_readiness ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="land_readiness_{{ $index }}"
                                                        data-type="belum"
                                                        name="data[{{ $index }}][land_readiness_belum]"
                                                        value="0" {{ !$form?->land_readiness ? 'checked' : '' }}>
                                                </td>

                                                {{-- Store Development --}}
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="store_development_{{ $index }}"
                                                        data-type="belum"
                                                        name="data[{{ $index }}][store_development_rejected]"
                                                        value="1"
                                                        {{ $form?->store_development === 0 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="store_development_{{ $index }}"
                                                        data-type="selesai"
                                                        name="data[{{ $index }}][store_development_approved]"
                                                        value="1"
                                                        {{ $form?->store_development === 1 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="store_development_{{ $index }}"
                                                        data-type="tidak"
                                                        name="data[{{ $index }}][store_development_not]"
                                                        value="1"
                                                        {{ $form?->store_development === 2 ? 'checked' : '' }}>
                                                </td>
                                                {{-- End Store Development --}}


                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="vehicle_{{ $index }}" data-type="ada"
                                                        name="data[{{ $index }}][vehicle_ada]" value="1"
                                                        {{ $form?->vehicle ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="vehicle_{{ $index }}" data-type="belum"
                                                        name="data[{{ $index }}][vehicle_belum]"
                                                        value="0" {{ !$form?->vehicle ? 'checked' : '' }}>
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="table_and_chair{{ $index }}"
                                                        data-type="ada"
                                                        name="data[{{ $index }}][table_and_chair_ada]"
                                                        value="1" {{ $form?->table_and_chair ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="table_and_chair{{ $index }}"
                                                        data-type="belum"
                                                        name="data[{{ $index }}][table_and_chair_belum]"
                                                        value="0"
                                                        {{ !$form?->table_and_chair ? 'checked' : '' }}>
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="display_case_{{ $index }}" data-type="ada"
                                                        name="data[{{ $index }}][display_case_ada]"
                                                        value="1" {{ $form?->display_case ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="display_case_{{ $index }}"
                                                        data-type="belum"
                                                        name="data[{{ $index }}][display_case_belum]"
                                                        value="0" {{ !$form?->display_case ? 'checked' : '' }}>
                                                </td>

                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="{{ $index }}" data-type="ada"
                                                        name="data[{{ $index }}][computer_ada]" value="1"
                                                        {{ $form?->computer ? 'checked' : '' }}>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        data-group="{{ $index }}" data-type="belum"
                                                        name="data[{{ $index }}][computer_belum]"
                                                        value="0" {{ !$form?->computer ? 'checked' : '' }}>
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
