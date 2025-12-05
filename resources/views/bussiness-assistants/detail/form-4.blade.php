<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form 4
        </h2>
    </x-slot>

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

                        <div class="mb-10 flex flex-wrap gap-3">
                <a href="{{ route('bussiness-assistants.form-1', $bussinessAssistant->id) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md 
        w-full sm:w-auto text-center">
                    + Form 1
                </a>

                <a href="{{ route('bussiness-assistants.form-2', $bussinessAssistant->id) }}"
                    class="bg-emerald-500 hover:bg-emerald-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md 
        w-full sm:w-auto text-center">
                    + Form 2
                </a>

                <a href="{{ route('bussiness-assistants.form-3', $bussinessAssistant->id) }}"
                    class="bg-indigo-500 hover:bg-indigo-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md 
        w-full sm:w-auto text-center">
                    + Form 3
                </a>

                <a href="{{ route('bussiness-assistants.form-4', $bussinessAssistant->id) }}"
                    class="bg-orange-500 hover:bg-orange-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md 
        w-full sm:w-auto text-center">
                    + Form 4
                </a>

                <a href="{{ route('bussiness-assistants.form-5', $bussinessAssistant->id) }}"
                    class="bg-pink-500 hover:bg-pink-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md 
        w-full sm:w-auto text-center">
                    + Form 5
                </a>

                <a href="{{ route('bussiness-assistants.form-6', $bussinessAssistant->id) }}"
                    class="bg-teal-500 hover:bg-teal-700 text-white font-semibold py-3 px-5 rounded-xl shadow-md 
        w-full sm:w-auto text-center">
                    + Form 6
                </a>

                <a href="{{ route('bussiness-assistants.report', $bussinessAssistant->id) }}" target="_blank"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md 
        w-full sm:w-auto text-center">
                    + Laporan
                </a>
            </div>


            <div class="bg-white shadow-xl rounded-lg p-6">

                <form action="{{ route('bussiness-assistants.form-4.store', $bussinessAssistant->id) }}" method="POST">
                    @csrf

                    {{-- Scroll container --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-300">
                        <table class="min-w-full text-sm text-center border-collapse">

                            <thead>
                                <tr class="bg-green-600 ">
                                    <th rowspan="2" class="border border-gray-300 px-3 py-2">No</th>
                                    <th rowspan="2" class="w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                                        Nama KDKMP
                                    </th>
                                    <th rowspan="2" class="border border-gray-300 px-3 py-2">Mitra Pembiayaan</th>
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Proposal Pembiayaan</th>
                                    <th rowspan="2" class="border border-gray-300 px-3 py-2">Tanggal Pengajuan
                                        Proposal Pembiayaan</th>
                                    <th colspan="2" class="border border-gray-300 px-3 py-2">Status Proposal</th>
                                    <th rowspan="2" class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                                        Jumlah Pembiayaan</th>
                                    <th rowspan="2" class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                                        Keterangan</th>

                                </tr>
                                <tr class="bg-green-700 ">
                                    <th class="border border-gray-300 px-3 py-2">Ada</th>
                                    <th class="border border-gray-300 px-3 py-2">Belum</th>

                                    <th class="border border-gray-300 px-3 py-2">Ditolak</th>
                                    <th class="border border-gray-300 px-3 py-2">Disetujui</th>

                                </tr>
                            </thead>

                            <tbody class="text-gray-700">
                                @forelse ($cooperations as $index => $coop)
                                    @php
                                        $form = $coop->formFour; // Bisa null, aman
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
                                            <input type="text" name="data[{{ $index }}][financing_partner]"
                                                value="{{ $form?->financing_partner ?? '' }}"
                                                class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                        </td>

                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                data-group="{{ $index }}" data-type="ada"
                                                name="data[{{ $index }}][financing_proposal_ada]" value="1"
                                                {{ $form?->financing_proposal ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                data-group="{{ $index }}" data-type="belum"
                                                name="data[{{ $index }}][financing_proposal_belum]"
                                                value="0" {{ !$form?->financing_proposal ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1">
                                            <input type="date"
                                                name="data[{{ $index }}][financing_proposal_submission_date]"
                                                value="{{ $form?->financing_proposal_submission_date ?? '' }}"
                                                class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                        </td>


                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                data-group="bank_{{ $index }}" data-type="ditolak"
                                                name="data[{{ $index }}][proposal_status_rejected]"
                                                value="1" {{ $form?->proposal_status === 0 ? 'checked' : '' }}>
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 text-center">
                                            <input type="checkbox" class="checkbox-status"
                                                data-group="bank_{{ $index }}" data-type="disetujui"
                                                name="data[{{ $index }}][proposal_status_approved]"
                                                value="1" {{ $form?->proposal_status === 1 ? 'checked' : '' }}>
                                        </td>

                                        <td class="border border-gray-300 px-2 py-1">
                                            <input type="number" name="data[{{ $index }}][financing_amount]"
                                                value="{{ $form?->financing_amount ?? '' }}"
                                                class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
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
