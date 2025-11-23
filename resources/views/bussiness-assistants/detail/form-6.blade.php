<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Pendataan Koperasi
        </h2>
    </x-slot>

    <x-slot name="script">
        <script></script>
    </x-slot>



    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-6">

                <form action="" method="POST">
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
                                    <th class="border border-gray-300 px-3 py-2">Foto Tanah</th>
                                    <th class="border border-gray-300 px-3 py-2">Titik Koordinat</th>
                                    <th class="border border-gray-300 px-3 py-2">Lebar Tanah</th>
                                    <th class="border border-gray-300 px-3 py-2">Panjang Tanah</th>
                                    <th class="border border-gray-300 px-3 py-2">Surat Tanah</th>
                                    <th class="border border-gray-300 px-3 py-2">Kondisi Jalan</th>
                                    <th class="border border-gray-300 px-3 py-2">Tipe Aset</th>
                                    <th class="border border-gray-300 px-3 py-2">Jarak Permukiman</th>
                                    <th class="border border-gray-300 px-3 py-2">Akses Internet</th>
                                    <th class="border border-gray-300 px-3 py-2">Akses Air</th>
                                    <th class="border border-gray-300 px-3 py-2">Akses Listrik</th>
                                </tr>

                            </thead>

                            <tbody class="text-gray-700">
                                @forelse ($cooperations as $index => $coop)
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
                                            <input type="file" name="data[{{ $index }}][nama]"
                                                value="{{ $coop->name ?? '' }}"
                                                class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                data-group="{{ $index }}" data-type="belum"
                                                name="data[{{ $index }}][belum_terdaftar]" value="1"
                                                {{ !$coop->microsite_account ? 'checked' : '' }}>
                                        </td>

                                        {{-- Profil Koperasi --}}
                                        <td class="border border-gray-300 px-2 py-1">
                                            <select name="data[{{ $index }}][berita_acara_musdes]"
                                                class="border-gray-300 rounded w-full p-1">
                                                <option value="">-- Pilih --</option>
                                                <option value="Ada">Ada</option>
                                                <option value="Belum Ada">Belum Ada</option>
                                            </select>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1">
                                            <select name="data[{{ $index }}][berita_acara_rapat]"
                                                class="border-gray-300 rounded w-full p-1">
                                                <option value="">-- Pilih --</option>
                                                <option value="Ada">Ada</option>
                                                <option value="Belum Ada">Belum Ada</option>
                                            </select>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">

                                            <input type="text" name="data[{{ $index }}][nama]"
                                                value="{{ $coop->legal_entity_number ?? '' }}"
                                                class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                        </td>

                                        {{-- Gerai --}}
                                        <td class="border border-gray-300 px-2 py-1 text-center"><input type="checkbox"
                                                name="data[{{ $index }}][sembako]" value="1"></td>
                                        <td class="border border-gray-300 px-2 py-1 text-center"><input type="checkbox"
                                                name="data[{{ $index }}][apotek]" value="1"></td>
                                        <td class="border border-gray-300 px-2 py-1 text-center"><input type="checkbox"
                                                name="data[{{ $index }}][klinik]" value="1"></td>
                                        <td class="border border-gray-300 px-2 py-1 text-center"><input type="checkbox"
                                                name="data[{{ $index }}][unit_simpan_pinjam]" value="1">
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center"><input type="checkbox"
                                                name="data[{{ $index }}][cold_storage]" value="1"></td>
                                        <td class="border border-gray-300 px-2 py-1 text-center"><input type="checkbox"
                                                name="data[{{ $index }}][logistik]" value="1"></td>




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

                    <div class="mt-6 text-right">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                            💾 Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
