<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bussiness Assistant') }} &raquo; Koperasi Dampingan
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // AJAX DataTable

            var datatable = $('#crudTable').DataTable({
                responsive: true, // <--- aktifkan fitur ini
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '10%'
                    },

                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'legal_entity_number',
                        name: 'legal_entity_number',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '15%',
                    }
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
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



            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable" class="display cell-border">
                        <thead>
                            <tr>
                                <th>ID BA</th>
                                <th>Nama</th>
                                <th>SK AHU</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
