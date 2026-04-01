<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

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
                            data: 'address',
                            name: 'address',
                        },
                        {
                            data: 'phone_number',
                            name: 'phone_number',
                        },
                        {
                            data: 'date_of_birth',
                            name: 'date_of_birth',
                        },
                        {
                            data: 'picture',
                            name: 'picture',
                        },
                        {
                            data: 'status',
                            name: 'status',
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
        <main class="flex-1 overflow-y-auto">

            @include('components.header')

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-7">
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-green-600">
                            <i data-lucide="home" class="w-4 h-4 mr-1"></i> Home
                        </a>
                        <span>›</span>
                        <span class="text-gray-500">Business Assitant</span>
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
                    <div class="mb-10">
                        <a href="{{ route('bussiness-assistants.create') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">+
                            Bussiness
                            Assistant</a>
                    </div>



                    <div class="shadow overflow-hidden sm-rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <table id="crudTable" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>ID BA</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No. Telepon</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Foto</th>
                                        <th>Status</th>
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
        </main>
    </div>
</x-app-layout>
