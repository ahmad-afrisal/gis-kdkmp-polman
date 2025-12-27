<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permasalahan') }}
        </h2>
    </x-slot>


    <x-slot name="script">
        {{-- DataTable JS --}}
        <script>
            var datatable = $('#crudTable').DataTable({
                responsive: true,
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '10%'
                    },
                    {
                        data: 'problem',
                        name: 'problem'
                    },
                    {
                        data: 'solution',
                        name: 'solution'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '15%'
                    }
                ]
            })
        </script>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol tambah --}}
            <div class="mb-10">
                <a href="{{ route('problems.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">
                    + Tambah Permasalahan
                </a>
            </div>

            {{-- DATA TABLE --}}
            <div class="shadow overflow-hidden sm-rounded-md bg-white p-4">
                <table id="crudTable" class="display cell-border">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Permasalahan</th>
                            <th>Solusi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
