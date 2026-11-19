<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

        {{-- LEAFLET CSS --}}
        <x-slot name="style">
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <style>
                #map {
                    width: 100%;
                    height: 500px;
                    margin-top: 20px;
                    border-radius: 8px;
                    overflow: hidden;
                }
            </style>
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
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'village',
                            name: 'village.name'
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
                        <span class="text-gray-500">Master Data</span>
                        <span>›</span>
                        <span class="text-gray-500">Koperasi Existing</span>

                    </nav>

                    <div class="mb-8 flex flex-wrap items-center gap-3">
                        <a href="{{ route('existing-cooperatives.create') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">
                            + Tambah Koperasi Existing
                        </a>
                        <a href="{{ route('existing-cooperatives.template') }}"
                            class="rounded bg-blue-600 px-4 py-3 font-bold text-white shadow-lg hover:bg-blue-700">
                            Download Template Excel
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-800" role="status">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-800" role="alert">
                            <p>{{ session('error') }}</p>
                            @if (session('importErrors'))
                                <ul class="mt-2 list-disc pl-5">
                                    @foreach (session('importErrors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 rounded-lg bg-red-100 p-4 text-red-800" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('existing-cooperatives.import') }}" method="POST"
                        enctype="multipart/form-data"
                        class="mb-8 flex flex-wrap items-end gap-3 rounded-lg bg-white p-4 shadow">
                        @csrf
                        <div class="min-w-[16rem] flex-1">
                            <label for="file_excel" class="mb-2 block font-semibold text-gray-700">
                                Upload data dari Excel
                            </label>
                            <input id="file_excel" type="file" name="file_excel" accept=".xlsx,.xls,.csv" required
                                class="block w-full rounded border border-gray-300 p-2 text-sm">
                            <p class="mt-1 text-xs text-gray-500">
                                Gunakan template dan isi ID sesuai sheet Referensi. Bentuk: Primer/Sekunder;
                                model: Konvensional/Syariah. Latitude (-90 sampai 90) dan longitude (-180 sampai 180)
                                bersifat opsional, tetapi isi keduanya jika digunakan. Maksimal file 20 MB.
                            </p>
                        </div>
                        <button type="submit"
                            class="rounded bg-indigo-600 px-4 py-2.5 font-bold text-white hover:bg-indigo-700">
                            Upload Excel
                        </button>
                    </form>

                    {{-- DATA TABLE --}}
                    <div class="shadow overflow-hidden sm-rounded-md bg-white p-4">
                        <table id="crudTable" class="display cell-border">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NIK</th>
                                    <th>Nama Koperasi</th>
                                    <th>Desa/Kelurahan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>


                </div>
            </div>
        </main>
    </div>
</x-app-layout>
