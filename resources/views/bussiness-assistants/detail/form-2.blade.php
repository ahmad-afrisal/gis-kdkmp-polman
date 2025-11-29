<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form 2
        </h2>
    </x-slot>

    <x-slot name="script">
        <script></script>
    </x-slot>



    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                    <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="mb-10">
                <a href="{{ route('bussiness-assistants.form-1', $bussinessAssistant->id) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded shadow-lg">+ Form 1</a>

                <a href="{{ route('bussiness-assistants.form-2', $bussinessAssistant->id) }}"
                    class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded shadow-lg">+ Form
                    2</a>

                <a href="{{ route('bussiness-assistants.form-3', $bussinessAssistant->id) }}"
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded shadow-lg">+ Form
                    3</a>

                <a href="{{ route('bussiness-assistants.form-4', $bussinessAssistant->id) }}"
                    class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-3 px-4 rounded shadow-lg">+ Form
                    4</a>

                <a href="{{ route('bussiness-assistants.form-5', $bussinessAssistant->id) }}"
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-3 px-4 rounded shadow-lg">+ Form 5</a>

                <a href="{{ route('bussiness-assistants.form-6', $bussinessAssistant->id) }}"
                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded shadow-lg">+ Form 6</a>

                <a href="{{ route('bussiness-assistants.report', $bussinessAssistant->id) }}" target="_blank"
                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded shadow-lg">+ Laporan</a>

            </div>
            <div class="bg-white shadow-xl rounded-lg p-6">

                <form action="{{ route('bussiness-assistants.form-2.store', $bussinessAssistant->id) }}" method="POST">
                    @csrf

                    {{-- Scroll container --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-300">
                        <table class="min-w-full text-sm text-center border-collapse">

                            <thead>
                                <tr class="bg-green-600 ">
                                    <th rowspan="3" class="border border-gray-300 px-3 py-2">No</th>
                                    <th rowspan="3" class="w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                                        Nama KDKMP
                                    </th>
                                    <th rowspan="3" class="w-[500px] min-w-[300px] border border-gray-300 px-2 py-1">
                                        Rencana Bisnis
                                    </th>
                                    <th colspan="14">Rencana Bisnis Gerai</th>
                                    <th rowspan="3" class="w-[500px] min-w-[300px] border border-gray-300 px-2 py-1">
                                        Keterangan
                                    </th>

                                </tr>
                                <tr class="bg-green-600 ">
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Pengadaan Sembako</th>
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Usaha Simpan Pinjam</th>
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Apotek Desa</th>
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Klinik Desa</th>
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Logistik</th>
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Cold Storage/
                                        Pergudangan</th>
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Kegiatan Usaha Lain</th>
                                </tr>
                                <tr class="bg-green-700 ">
                                    {{-- Pengadaan Sembako --}}
                                    <th class="border border-gray-300 px-3 py-2">Ada/Tidak</th>
                                    <th class="border border-gray-300 px-3 py-2">Berjalan/Belum</th>

                                    {{-- Simpan Pinjam --}}
                                    <th class="border border-gray-300 px-3 py-2">Ada/Tidak</th>
                                    <th class="border border-gray-300 px-3 py-2">Berjalan/Belum</th>

                                    {{-- Apotek Desa --}}
                                    <th class="border border-gray-300 px-3 py-2">Ada/Tidak</th>
                                    <th class="border border-gray-300 px-3 py-2">Berjalan/Belum</th>

                                    {{-- Klinik Desa --}}
                                    <th class="border border-gray-300 px-3 py-2">Ada/Tidak</th>
                                    <th class="border border-gray-300 px-3 py-2">Berjalan/Belum</th>

                                    {{-- Logistik --}}
                                    <th class="border border-gray-300 px-3 py-2">Ada/Tidak</th>
                                    <th class="border border-gray-300 px-3 py-2">Berjalan/Belum</th>

                                    {{-- Cold Storage/Pergudangan --}}
                                    <th class="border border-gray-300 px-3 py-2">Ada/Tidak</th>
                                    <th class="border border-gray-300 px-3 py-2">Berjalan/Belum</th>

                                    {{-- Kegiatan Usaha Lain --}}
                                    <th class="border border-gray-300 px-3 py-2">Ada/Tidak</th>
                                    <th class="border border-gray-300 px-3 py-2">Berjalan/Belum</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-700">
                                @forelse ($cooperations as $index => $coop)
                                    @php
                                        $form = $coop->formTwo; // Bisa null, aman
                                    @endphp
                                    <tr class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">
                                        <td class="border border-gray-300 px-2 py-1 font-medium text-center">
                                            {{ $index + 1 }}
                                        </td>

                                        {{-- Hidden cooperation_id --}}
                                        <input type="hidden" name="data[{{ $index }}][cooperation_id]"
                                            value="{{ $coop->id }}">

                                        {{-- Nama Koperasi --}}
                                        <td class="border border-gray-300 px-2 py-1">
                                            <input type="text" name="data[{{ $index }}][nama]"
                                                value="{{ $coop->name ?? '' }}"
                                                class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1">
                                            <input type="text" name="data[{{ $index }}][bussiness_plan]"
                                                value="{{ $form?->bussiness_plan ?? '' }}"
                                                class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                        </td>


                                        {{-- Pengadaan Sembako --}}
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][basic_necessities_exist]"
                                                value="1" {{ $form?->basic_necessities_exist ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][basic_necessities_running]"
                                                value="1"
                                                {{ $form?->basic_necessities_running ? 'checked' : '' }}>
                                        </td>

                                        {{-- Usaha Simpan Pinjam --}}
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][savings_and_loan_exist]"
                                                value="1" {{ $form?->savings_and_loan_exist ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][savings_and_loan_running]"
                                                value="1"
                                                {{ $form?->savings_and_loan_running ? 'checked' : '' }}>
                                        </td>

                                        {{-- Apotek Desa --}}

                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][pharmacy_exist]" value="1"
                                                {{ $form?->pharmacy_exist ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][pharmacy_running]" value="1"
                                                {{ $form?->pharmacy_running ? 'checked' : '' }}>
                                        </td>

                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][clinic_exist]" value="1"
                                                {{ $form?->clinic_exist ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][clinic_running]" value="1"
                                                {{ $form?->clinic_running ? 'checked' : '' }}>
                                        </td>

                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][logistics_exist]" value="1"
                                                {{ $form?->logistics_exist ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][logistics_running]" value="1"
                                                {{ $form?->logistics_running ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][storage_exist]" value="1"
                                                {{ $form?->storage_exist ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][storage_running]" value="1"
                                                {{ $form?->storage_running ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][other_businesses_exist]"
                                                value="1" {{ $form?->other_businesses_exist ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                name="data[{{ $index }}][other_businesses_running]"
                                                value="1"
                                                {{ $form?->other_businesses_running ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1">
                                            <input type="text" name="data[{{ $index }}][information]"
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
</x-app-layout>
