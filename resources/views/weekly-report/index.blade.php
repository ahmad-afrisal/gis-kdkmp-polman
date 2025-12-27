<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kontak Pengurus') }}
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
                        data: 'simkopdes',
                        name: 'simkopdes'
                    },
                    {
                        data: 'nib',
                        name: 'nib'
                    },
                    {
                        data: 'npwp',
                        name: 'npwp'
                    },
                    {
                        data: 'bank_account',
                        name: 'bank_account'
                    },
                    {
                        data: 'business_activity_plan',
                        name: 'business_activity_plan'
                    },
                    {
                        data: 'financing_proposal',
                        name: 'financing_proposal'
                    },

                    {
                        data: 'ods',
                        name: 'ods'
                    },
                    {
                        data: 'number_of_member',
                        name: 'number_of_member'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
                <a href="{{ route('contact-managements.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">
                    + Tambah Kontak Pengurus
                </a>
            </div>

            {{-- DATA TABLE --}}
            <div class="shadow overflow-hidden sm-rounded-md bg-white p-4">
                <table id="crudTable" class="display cell-border">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SIMKOPDES</th>
                            <th>NIB</th>
                            <th>NPWP</th>
                            <th>Rekening BANK</th>
                            <th>Rencana Kegiatan Bisnis </th>
                            <th>Proposal Pembiayaan</th>
                            <th>ODS Mandiri</th>
                            <th>Jumlah Anggota</th>
                            <th>Tanggal</th>

                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
