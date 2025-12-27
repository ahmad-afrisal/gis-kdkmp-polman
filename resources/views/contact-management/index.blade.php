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
                        data: 'cooperation',
                        name: 'cooperation',
                    },
                    {
                        data: 'leader_name',
                        name: 'leader_name'
                    },
                    {
                        data: 'leader_phone_number',
                        name: 'leader_phone_number'
                    },
                    {
                        data: 'name_of_deputy_member',
                        name: 'name_of_deputy_member'
                    },
                    {
                        data: 'deputy_member_phone_number',
                        name: 'deputy_member_phone_number'
                    },
                    {
                        data: 'name_of_deputy_business',
                        name: 'name_of_deputy_business'
                    },
                    {
                        data: 'deputy_business_phone_number',
                        name: 'deputy_business_phone_number'
                    },
                    {
                        data: 'name_of_secretary',
                        name: 'name_of_secretary'
                    },
                    {
                        data: 'secretary_phone_number',
                        name: 'secretary_phone_number'
                    },
                    {
                        data: 'name_of_treasurer',
                        name: 'name_of_treasurer'
                    },
                    {
                        data: 'treasurer_phone_number',
                        name: 'treasurer_phone_number'
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
                            <th>Nama KDKMP</th>
                            <th>Ketua</th>
                            <th>Nomor Ketua</th>
                            <th>Wakil Bidang Anggota</th>
                            <th>Nomor Wakil Bidang Anggota</th>
                            <th>Wakil Bidang Usaha</th>
                            <th>Nomor Wakil Bidang Usaha</th>
                            <th>Sekretaris</th>
                            <th>Nomor Sekretaris</th>
                            <th>Bendahara</th>
                            <th>Nomor Bendahara</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
