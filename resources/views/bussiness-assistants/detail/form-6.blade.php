<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


        <x-slot name="style">
            <style>
                /* Hilangkan input file asli */
                .hidden-file-input {
                    display: none;
                }
            </style>
        </x-slot>

        <x-slot name="script">
            <script>
                function previewImage(input, previewId) {
                    const file = input.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.getElementById(previewId);
                        img.src = e.target.result;
                        img.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
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
                        <span class="text-gray-500">Form 6</span>
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

                        <form action="{{ route('bussiness-assistants.form-6.store', $bussinessAssistant->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Scroll container --}}
                            <div class="overflow-x-auto rounded-lg border border-gray-300">
                                <table class="min-w-full text-sm text-center border-collapse">

                                    <thead>
                                        <tr class="bg-green-600 ">
                                            <th class="border border-gray-300 px-3 py-2">No</th>
                                            <th class="w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                                                Nama KDKMP
                                            </th>
                                            <th class=" min-w-[130px] border border-gray-300 px-3 py-2">Foto Tanah</th>
                                            <th class="w-[400px] min-w-[300px] border border-gray-300 px-3 py-2">Titik
                                                Koordinat
                                            </th>
                                            <th class="min-w-[120px] border border-gray-300 px-3 py-2">Lebar Tanah</th>
                                            <th class="min-w-[120px] border border-gray-300 px-3 py-2">Panjang Tanah
                                            </th>
                                            <th class="min-w-[120px] border border-gray-300 px-3 py-2">Surat Tanah</th>
                                            <th class="min-w-[220px] border border-gray-300 px-3 py-2">Kondisi Jalan
                                            </th>
                                            <th class="min-w-[220px] border border-gray-300 px-3 py-2">Tipe Aset</th>
                                            <th class="min-w-[120px] border border-gray-300 px-3 py-2">Jarak Permukiman
                                            </th>
                                            <th class="min-w-[120px] border border-gray-300 px-3 py-2">Akses Internet
                                            </th>
                                            <th class="min-w-[120px] border border-gray-300 px-3 py-2">Akses Air</th>
                                            <th class="min-w-[120px] border border-gray-300 px-3 py-2">Akses Listrik
                                            </th>
                                            <th class="min-w-[400px] border border-gray-300 px-3 py-2">Keterangan</th>
                                        </tr>

                                    </thead>

                                    <tbody class="text-gray-700">
                                        @forelse ($cooperations as $index => $coop)
                                            @php
                                                $form = $coop->formSix; // Bisa null, aman
                                            @endphp
                                            <tr class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">
                                                <td class="border border-gray-300 px-2 py-1 font-medium text-center">
                                                    {{ $index + 1 }}
                                                </td>

                                                {{-- Nama Koperasi --}}
                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="text" name="data[{{ $index }}][nama]"
                                                        value="{{ $coop->name ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>


                                                <td class="border border-gray-300 px-2 py-1">
                                                    <div class="flex items-center gap-3">
                                                        <!-- Preview gambar -->
                                                        @if (!empty($coop->name))
                                                            <img id="preview-{{ $index }}"
                                                                src="{{ $form?->picture_land ? asset('storage/' . $form->picture_land) : '' }}"
                                                                class="w-12 h-12 rounded-md object-cover border {{ $form?->picture_land ? '' : 'hidden' }}" />
                                                        @else
                                                            <img id="preview-{{ $index }}"
                                                                src="{{ $form?->picture_land ? asset($form->picture_land) : '' }}"
                                                                class="w-12 h-12 rounded-md object-cover border {{ $form?->picture_land ? '' : 'hidden' }}" />
                                                        @endif

                                                        <!-- Tombol Upload Bulat -->
                                                        <label
                                                            class="w-10 h-10 rounded-full cursor-pointer flex items-center justify-center
                 bg-blue-600 hover:bg-blue-700 text-white shadow transition">

                                                            <!-- Icon upload -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V4m0 0L8 8m4-4l4 4" />
                                                            </svg>

                                                            <input type="file" accept="image/*"
                                                                name="data[{{ $index }}][picture_land]"
                                                                id="file-{{ $index }}" class="hidden"
                                                                onchange="previewImage(this, 'preview-{{ $index }}')">

                                                        </label>
                                                    </div>



                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <div class="flex gap-2">
                                                        <input type="text"
                                                            name="data[{{ $index }}][latitude]"
                                                            value="{{ $form?->latitude ?? '' }}"
                                                            class="w-1/2 border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">

                                                        <input type="text"
                                                            name="data[{{ $index }}][longitude]"
                                                            value="{{ $form?->longitude ?? '' }}"
                                                            class="w-1/2 border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                    </div>
                                                </td>


                                                {{-- Profil Koperasi --}}
                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="number" name="data[{{ $index }}][width_land]"
                                                        value="{{ $form?->width_land ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="number" name="data[{{ $index }}][long_land]"
                                                        value="{{ $form?->long_land ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1">

                                                    <div class="flex items-center gap-3">

                                                        <!-- Preview Surat Tanah -->
                                                        <img id="preview-letter-{{ $index }}"
                                                            src="{{ $form?->letter_land ? asset('storage/' . $form->letter_land) : '' }}"
                                                            class="w-12 h-12 rounded-md object-cover border {{ $form?->letter_land ? '' : 'hidden' }}" />

                                                        <!-- Tombol Upload -->
                                                        <label
                                                            class="w-10 h-10 rounded-full cursor-pointer flex items-center justify-center
                      bg-orange-600 hover:bg-orange-700 text-white shadow transition">

                                                            <!-- Ikon upload -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V4m0 0L8 8m4-4l4 4" />
                                                            </svg>

                                                            <input type="file" accept="image/*"
                                                                name="data[{{ $index }}][letter_land]"
                                                                id="letter-land-{{ $index }}" class="hidden"
                                                                onchange="previewImage(this, 'preview-letter-{{ $index }}')">
                                                        </label>
                                                    </div>

                                                </td>


                                                {{-- Gerai --}}
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <select name="data[{{ $index }}][road_condition]"
                                                        class="border-gray-300 rounded w-full p-1">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach (['Tanah', 'Batu', 'Beraspal', 'Beton', 'Belum Ada Akses Jalan'] as $g)
                                                            <option value="{{ $g }}"
                                                                {{ $form?->road_condition == $g ? 'selected' : '' }}>
                                                                {{ $g }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <select name="data[{{ $index }}][asset]"
                                                        class="border-gray-300 rounded w-full p-1">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach (['Milik Sendiri', 'Hibah', 'Barang Milik KUD', 'Barang Milik Desa (BMDes)', 'Barang Milik Daerah (BMD)', 'Barang Milik Negara (BMN)'] as $g)
                                                            <option value="{{ $g }}"
                                                                {{ $form?->asset == $g ? 'selected' : '' }}>
                                                                {{ $g }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="number" name="data[{{ $index }}][distance]"
                                                        value="{{ $form?->distance ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <select name="data[{{ $index }}][internet_access]"
                                                        class="border-gray-300 rounded w-full p-1">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach (['Sinyal Kuat', 'Sinyal Lemah', 'Internet Fiber', 'Tidak Ada'] as $g)
                                                            <option value="{{ $g }}"
                                                                {{ $form?->internet_access == $g ? 'selected' : '' }}>
                                                                {{ $g }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <select name="data[{{ $index }}][water_access]"
                                                        class="border-gray-300 rounded w-full p-1">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach (['Sumur', 'PAM', 'Mata Air', 'Tidak'] as $g)
                                                            <option value="{{ $g }}"
                                                                {{ $form?->water_access == $g ? 'selected' : '' }}>
                                                                {{ $g }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                {{-- Hidden cooperation_id --}}
                                                <input type="hidden"
                                                    name="data[{{ $index }}][cooperation_id]"
                                                    value="{{ $coop->id }}">

                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <select name="data[{{ $index }}][electricity_access]"
                                                        class="border-gray-300 rounded w-full p-1">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach (['PLN', 'Surya', 'Diesel', 'Tidak'] as $g)
                                                            <option value="{{ $g }}"
                                                                {{ $form?->electricity_access == $g ? 'selected' : '' }}>
                                                                {{ $g }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="text"
                                                        name="data[{{ $index }}][description]"
                                                        value="{{ $form?->description }}"
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
