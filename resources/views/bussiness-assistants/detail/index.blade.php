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

            @include('components.button-form')

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
