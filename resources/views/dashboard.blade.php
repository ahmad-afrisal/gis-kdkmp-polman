<x-app-layout>

    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>
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
            <script>
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
                            data: 'district',
                            name: 'district',
                        },
                        {
                            data: 'ba',
                            name: 'ba',
                        },
                        {
                            data: 'cooperation',
                            name: 'cooperation',
                        },
                        {
                            data: 'number_of_member',
                            name: 'number_of_member',
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            width: '15%',
                        }
                    ]
                });
            </script>
        </x-slot>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">

            @include('components.header')


            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-green-600">
                            <i data-lucide="home" class="w-4 h-4 mr-1"></i> Home
                        </a>
                        <span>›</span>
                        <span class="text-gray-500">Dashboard</span>
                    </nav>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <!-- Card Petani -->
                        <div
                            class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between hover:scale-105 transition">
                            <div>
                                <div class="text-gray-500 text-sm font-medium">Jumlah Kecamatan</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $districtCount }}</div>
                            </div>
                            <div class="text-emerald-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 01.553-1.382L9 2m0 18l6 2m-6-2V2m6 20l5.447-2.724A2 2 0 0021 17.618V7.382a2 2 0 00-.553-1.382L15 2" />
                                </svg>
                            </div>


                        </div>

                        <div
                            class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between hover:scale-105 transition">
                            <div>
                                <div class="text-gray-500 text-sm font-medium">Jumlah Desa</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $villageTypeDesaCount }}</div>
                            </div>
                            <div class="text-sky-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                            </div>

                        </div>

                        <div
                            class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between hover:scale-105 transition">
                            <div>
                                <div class="text-gray-500 text-sm font-medium">Jumlah Kelurahan</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $villageTypeKelurahanCount }}</div>
                            </div>
                            <div class="text-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 21V3h16v18M9 21v-6h6v6" />
                                </svg>
                            </div>

                        </div>

                        <!-- Card Jenis Sawit -->
                        <div
                            class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between hover:scale-105 transition">
                            <div>
                                <div class="text-gray-500 text-sm font-medium">Jumlah Desa/Keluarahan</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $villageCount }}</div>
                            </div>
                            <div class="text-teal-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 2l9 5-9 5-9-5 9-5zm0 10l9 5-9 5-9-5 9-5z" />
                                </svg>
                            </div>

                        </div>

                        <!-- Card Banyak Lahan -->
                        <div
                            class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between hover:scale-105 transition">
                            <div>
                                <div class="text-gray-500 text-sm font-medium">Bussiness Asisstant</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $bussinessAssistantCount }}</div>
                            </div>
                            <div class="text-amber-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6h4m-7 4h10m-11 0a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2" />
                                </svg>
                            </div>
                        </div>

                        <div
                            class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between hover:scale-105 transition">
                            <div>
                                <div class="text-gray-500 text-sm font-medium">Project Management Officer</div>
                                <div class="text-3xl font-bold text-gray-900">2</div>
                            </div>
                            <div class="text-violet-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5h6a2 2 0 012 2v14H7V7a2 2 0 012-2z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Banyak Lahan -->
                        <div
                            class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between hover:scale-105 transition">
                            <div>
                                <div class="text-gray-500 text-sm font-medium">Jumlah Koperasi</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $cooperationCount }}</div>
                            </div>
                            <div class="text-cyan-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21h18M9 8h6M10 12h4M6 21V5l6-3 6 3v16" />
                                </svg>
                            </div>

                        </div>

                        {{-- Card Jumlah Anggota --}}

                        <div
                            class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between hover:scale-105 transition">
                            <div>
                                <div class="text-gray-500 text-sm font-medium">Jumlah Anggota Koperasi</div>
                                <div class="text-3xl font-bold text-gray-900">{{ $totalMember }}</div>
                            </div>
                            <div class="text-rose-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m3-4a4 4 0 110-8 4 4 0 010 8z" />
                                </svg>
                            </div>
                        </div>


                    </div>

                    <!-- Grid untuk 3 Chart -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-10">
                        <!-- CARD 2 - SIMKOPDES -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kepemilikan SIMKOPDES</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartSIMKOPDES"></canvas>
                            </div>
                        </div>

                        <!-- CARD 6 - Financing -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kelengkapan Simkopdes</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartSimkopdesCompleteness"></canvas>
                            </div>
                        </div>


                        <!-- CARD 6 - Financing -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Data Lahan</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartLand"></canvas>
                            </div>
                        </div>

                        <!-- CARD 6 - Financing -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Proposal Bisnis</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartFinancingProposal"></canvas>
                            </div>
                        </div>

                        <!-- CARD 6 - AKTA BH-->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Akta BH</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartBhDeed"></canvas>
                            </div>
                        </div>

                        <!-- CARD 6 - Financing -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">NIK Koperasi</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartCooperativeNik"></canvas>
                            </div>
                        </div>


                        <!-- CARD 1 - NIB -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kepemilikan NIB</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartNIB"></canvas>
                            </div>
                        </div>



                        <!-- CARD 3 - NPWP -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kepemilikan NPWP</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartNPWP"></canvas>
                            </div>
                        </div>

                        <!-- CARD 4 - Rekening Bank -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Rekening Bank</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartRekeningBank"></canvas>
                            </div>
                        </div>

                        <!-- CARD 5 - Business Plan -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Rencana Kegiatan Bisnis</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartBusinessPlan"></canvas>
                            </div>
                        </div>



                        <!-- CARD 5 - Business Plan -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Belanja Modal (Capex)</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartCapex"></canvas>
                            </div>
                        </div>

                        <!-- CARD 5 - Business Plan -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Belanja Operasional (Opex)</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartOpex"></canvas>
                            </div>
                        </div>

                        <!-- CARD 5 - Business Plan -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kelengkapan Lain</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartOtherEquipment"></canvas>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">

                        <!-- Line Chart Jumlah Anggota -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Perkembangan Jumlah Anggota</h3>
                            <canvas id="lineMember"></canvas>
                        </div>

                        <!-- Line Chart Dokumen -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Perkembangan Dokumen & Kegiatan</h3>
                            <canvas id="lineDocuments"></canvas>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6 my-10">

                        <!-- Line Chart Jumlah Anggota -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h2 class="text-center font-semibold mb-2">Jumlah Anggota per Kecamatan</h2>

                            {{-- <div class="h-[220px]"> --}}
                            <canvas id="districtBarChart"></canvas>
                        </div>
                    </div>

                    <div class="shadow overflow-hidden sm-rounded-md">

                        <div class="px-4 py-5 bg-white sm:p-6">

                            <table id="crudTable" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Nama BA</th>
                                        <th>Nama KDKMP</th>
                                        <th>Jumlah Anggota</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>




                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700">Laporan Rekapitulasi KDKMP Berdasarkan
                                    Kabupaten/Kota</h3>
                            </div>

                            <div class="p-6 overflow-x-auto">

                                <table class="w-full border-collapse text-sm">
                                    <thead>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th class="p-2">No.</th>
                                            <th class="p-2">Nama Kecamatan</th>
                                            <th class="p-2">Jumlah Desa/Kelurahan</th>
                                            <th class="p-2">Jumlah KDKMP</th>
                                            <th class="p-2">Jumlah SK AHU Koperasi</th>
                                            <th class="p-2">Jumlah NIB</th>
                                            <th class="p-2">Jumlah NIK</th>
                                        </tr>
                                        <tr class="bg-blue-500 text-white text-center">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                            <th>7</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reportOnes as $index => $r)
                                            <tr class="text-center border-b">
                                                <td class="p-2">{{ $index + 1 }}</td>
                                                <td class="p-2">{{ $r['district'] }}</td>
                                                <td class="p-2">{{ $r['total_villages'] }}</td>
                                                <td class="p-2">{{ $r['total_kdkmp'] }}</td>
                                                <td class="p-2">{{ $r['total_sk_ahu'] }}</td>
                                                <td class="p-2">{{ $r['total_nib'] }}</td>
                                                <td class="p-2">{{ $r['total_nik'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                            <a href="{{ route('bussiness-assistants.form-two.export') }}">Export</a>
                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700">Laporan Rekapitulasi Bisnis Proses
                                    KDKMP
                                </h3>
                            </div>

                            <div class="p-6 overflow-x-auto">

                                <table class="w-full border-collapse text-sm">
                                    <thead>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th rowspan="3" class="p-2">No.</th>
                                            <th rowspan="3" class="p-2">Nama Kecamatan</th>
                                            <th rowspan="3" class="p-2">Jumlah Desa/Kelurahan</th>
                                            <th rowspan="3" class="p-2">Jumlah KDKMP</th>
                                            <th colspan="12" class="p-2">Jumlah Gerai</th>

                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th colspan="2" class="p-2">Gerai Sembako</th>
                                            <th colspan="2" class="p-2">Gerai Apotik</th>
                                            <th colspan="2" class="p-2">Gerai Klinik</th>
                                            <th colspan="2" class="p-2">Gerai Simpan Pinjam</th>
                                            <th colspan="2" class="p-2">Gerai Pergudangan</th>
                                            <th colspan="2" class="p-2">Gerai Usaha Lain</th>
                                        </tr class="bg-blue-600 text-white text-center">
                                        <tr>
                                            <th class="p-2">Ada Rencana Bisnis</th>
                                            <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                            <th class="p-2">Ada Rencana Bisnis</th>
                                            <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                            <th class="p-2">Ada Rencana Bisnis</th>
                                            <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                            <th class="p-2">Ada Rencana Bisnis</th>
                                            <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                            <th class="p-2">Ada Rencana Bisnis</th>
                                            <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                            <th class="p-2">Ada Rencana Bisnis</th>
                                            <th class="p-2">Tidak Ada Rencana Bisnis</th>

                                        </tr>
                                        <tr class="bg-blue-500 text-white text-center">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                            <th>10</th>
                                            <th>11</th>
                                            <th>12</th>
                                            <th>13</th>
                                            <th>14</th>
                                            <th>15</th>
                                            <th>16</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reportTwos as $index => $r)
                                            <tr class="text-center">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $r['district'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td> {{-- jika KDKMP sama dengan jumlah desa --}}

                                                <td>{{ $r['basic_yes'] }}</td>
                                                <td>{{ $r['basic_no'] }}</td>

                                                <td>{{ $r['pharmacy_yes'] }}</td>
                                                <td>{{ $r['pharmacy_no'] }}</td>

                                                <td>{{ $r['clinic_yes'] }}</td>
                                                <td>{{ $r['clinic_no'] }}</td>

                                                <td>{{ $r['loan_yes'] }}</td>
                                                <td>{{ $r['loan_no'] }}</td>

                                                <td>{{ $r['storage_yes'] }}</td>
                                                <td>{{ $r['storage_no'] }}</td>

                                                <td>{{ $r['other_yes'] }}</td>
                                                <td>{{ $r['other_no'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700">Laporan Rekapitulasi Gerai Koperasi
                                    KDKMP
                                    Yang
                                    Sudah Berjalan </h3>
                            </div>

                            <div class="p-6 overflow-x-auto">

                                <table class="w-full border-collapse text-sm" border="1">
                                    <thead>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Nama Kecamatan</th>
                                            <th rowspan="2">Jumlah Desa/Kelurahan</th>
                                            <th rowspan="2">Jumlah KDKMP</th>
                                            <th rowspan="2">Nama Gerai</th>
                                            <th colspan="4">Volume Gerai</th>
                                        </tr>

                                        <tr class="bg-blue-500 text-white text-center">
                                            <th>Jumlah Omset</th>
                                            <th>Jumlah Aset</th>
                                            <th>Jumlah Laba</th>
                                            <th>Jumlah Rugi</th>
                                        </tr>

                                        <tr class="bg-blue-500 text-white text-center">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reportThrees as $index => $r)
                                            @foreach ($r['rows'] as $rowIndex => $row)
                                                <tr class="text-center">

                                                    @if ($rowIndex == 0)
                                                        <td rowspan="6">{{ $index + 1 }}</td>
                                                        <td rowspan="6">{{ $r['district'] }}</td>
                                                        <td rowspan="6">{{ $r['total_villages'] }}</td>
                                                        <td rowspan="6">{{ $r['total_kdkmp'] }}</td>
                                                    @endif

                                                    <td class="text-left px-2">{{ $row['branch_type'] }}</td>
                                                    <td>{{ number_format($row['business_volume']) }}</td>
                                                    <td>{{ number_format($row['total_assets']) }}</td>
                                                    <td>{{ number_format($row['profit']) }}</td>
                                                    <td>{{ number_format($row['loss']) }}</td>

                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr class="font-bold">
                                            <td colspan="5" class="text-center">TOTAL</td>

                                            <td>{{ number_format($reportThrees->flatMap->rows->sum('business_volume')) }}
                                            </td>
                                            <td>{{ number_format($reportThrees->flatMap->rows->sum('total_assets')) }}
                                            </td>
                                            <td>{{ number_format($reportThrees->flatMap->rows->sum('profit')) }}</td>
                                            <td>{{ number_format($reportThrees->flatMap->rows->sum('loss')) }}</td>
                                        </tr>
                                    </tfoot>

                                </table>

                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700">Laporan Rekapitulasi Gerai Koperasi
                                    KDKMP
                                    Yang
                                    Sudah Berjalan </h3>
                            </div>

                            <div class="p-6 overflow-x-auto">

                                <table class="w-full border-collapse text-sm">
                                    <thead>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th rowspan="3" class="p-2">No.</th>
                                            <th rowspan="3" class="p-2">Nama Kecamatan</th>
                                            <th rowspan="3" class="p-2">Jumlah Desa/Kelurahan</th>
                                            <th rowspan="3" class="p-2">Jumlah KDKMP</th>
                                            <th colspan="6" class="p-2">Jumlah Yang Sudah Berjalan</th>

                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th class="p-2">Gerai Sembako</th>
                                            <th class="p-2">Gerai Apotik</th>
                                            <th class="p-2">Gerai Klinik</th>
                                            <th class="p-2">Gerai Simpan Pinjam</th>
                                            <th class="p-2">Gerai Pergudangan</th>
                                            <th class="p-2">Gerai Usaha Lain</th>
                                        </tr class="bg-blue-600 text-white text-center">
                                        <tr>
                                            <th class="p-2"></th>
                                            <th class="p-2"></th>
                                            <th class="p-2"></th>
                                            <th class="p-2"></th>
                                            <th class="p-2"></th>
                                            <th class="p-2"></th>
                                        </tr>
                                        <tr class="bg-blue-500 text-white text-center">
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                            <th>10</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reportFours as $index => $r)
                                            <tr class="text-center">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $r['district'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td> {{-- jika KDKMP sama dengan jumlah desa --}}

                                                <td>{{ $r['basic_yes'] }}</td>

                                                <td>{{ $r['pharmacy_yes'] }}</td>

                                                <td>{{ $r['clinic_yes'] }}</td>

                                                <td>{{ $r['loan_yes'] }}</td>

                                                <td>{{ $r['logistics_yes'] }}</td>

                                                <td>{{ $r['other_yes'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>



                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

                    <script>
                        Chart.register(ChartDataLabels);
                        // Data dari database
                        const totalDesa = {{ $totalDesa }};
                        const desaNIB = {{ $desaNIB }};
                        const desaBelumNIB = {{ $desaBelumNIB }};
                        const simkopdesYa = {{ $simkopdesYa }};
                        const simkopdesTidak = {{ $simkopdesTidak }};

                        const bhDeedYes = {{ $bhDeedYes }};
                        const bhDeedNo = {{ $bhDeedNo }};

                        const cooperativeNikYes = {{ $cooperativeNikYes }};
                        const cooperativeNikNo = {{ $cooperativeNikNo }};

                        const capexYes = {{ $capexYes }};
                        const capexNo = {{ $capexNo }};

                        const opexYes = {{ $opexYes }};
                        const opexNo = {{ $opexNo }};

                        const otherEquipmentYes = {{ $otherEquipmentYes }};
                        const otherEquipmentNo = {{ $otherEquipmentNo }};

                        const simkopdesCompletenesYes = {{ $simkopdesCompletenesYes }};
                        const simkopdesCompletenesNo = {{ $simkopdesCompletenesNo }};

                        const landYes = {{ $landYes }};
                        const landNo = {{ $landNo }};

                        const npwpYa = {{ $npwpYa }};
                        const npwpTidak = {{ $npwpTidak }};
                        const bankYa = {{ $bankYa }};
                        const bankTidak = {{ $bankTidak }};
                        const businessPlanYes = {{ $businessPlanYes }};
                        const businessPlanNo = {{ $businessPlanNo }};
                        const financingProposalYes = {{ $financingProposalYes }};
                        const financingProposalNo = {{ $financingProposalNo }};


                        const memberData = @json($memberData);


                        const labels = @json($labels);
                        const rawDatasets = @json($datasets);
                        const datasets = Object.keys(rawDatasets).map(label => ({
                            label: label,
                            data: rawDatasets[label],
                            tension: 0.4,
                            borderWidth: 2,
                            fill: false
                        }));

                        new Chart(document.getElementById('lineDocuments'), {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                interaction: {
                                    mode: 'index',
                                    intersect: false
                                },
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                }
                            }
                        });



                        // Line Chart Jumlah Anggota
                        new Chart(document.getElementById('lineMember'), {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah Anggota',
                                    data: memberData,
                                    tension: 0.4,
                                    fill: false,
                                    borderWidth: 3
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });



                        const options = {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: "65%",
                            plugins: {
                                legend: {
                                    position: "bottom"
                                },
                                datalabels: {
                                    color: "#000",
                                    font: {
                                        weight: "bold",
                                        size: 14
                                    },
                                    formatter: (value, ctx) => {
                                        const total = ctx.chart._metasets[0].total;
                                        return ((value / total) * 100).toFixed(1) + "%";
                                    }
                                }
                            }
                        };

                        // Chart 1 - NIB
                        new Chart(document.getElementById("chartNIB"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah NIB", "Belum NIB"],
                                datasets: [{
                                    data: [desaNIB, desaBelumNIB],
                                    backgroundColor: ["#36A2EB", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Kelengkapan Simkopdes
                        new Chart(document.getElementById("chartSimkopdesCompleteness"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Lengkap", "Belum"],
                                datasets: [{
                                    data: [simkopdesCompletenesYes, simkopdesCompletenesNo],
                                    backgroundColor: ["#FF007F", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Data Lahan
                        new Chart(document.getElementById("chartLand"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [landYes, landNo],
                                    backgroundColor: ["#B1740F", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        new Chart(document.getElementById("chartBhDeed"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [bhDeedYes, bhDeedNo],
                                    backgroundColor: ["#B3FFFC", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        new Chart(document.getElementById("chartCooperativeNik"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [cooperativeNikYes, cooperativeNikNo],
                                    backgroundColor: ["#FF4242", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 2 - SIMKOPDES
                        new Chart(document.getElementById("chartSIMKOPDES"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [simkopdesYa, simkopdesTidak],
                                    backgroundColor: ["#4CAF50", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 3 - NPWP
                        new Chart(document.getElementById("chartNPWP"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [npwpYa, npwpTidak],
                                    backgroundColor: ["#FF9800", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 4 - Rekening Bank 
                        new Chart(document.getElementById("chartRekeningBank"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [bankYa, bankTidak],
                                    backgroundColor: ["#C0392B", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank 
                        new Chart(document.getElementById("chartBusinessPlan"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [businessPlanYes, businessPlanNo],
                                    backgroundColor: ["#30321C", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank 
                        new Chart(document.getElementById("chartFinancingProposal"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [financingProposalYes, financingProposalNo],
                                    backgroundColor: ["#4A4B2F", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank 
                        new Chart(document.getElementById("chartCapex"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [capexYes, capexNo],
                                    backgroundColor: ["#6B654B", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank 
                        new Chart(document.getElementById("chartOpex"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [opexYes, opexNo],
                                    backgroundColor: ["#D4DF9E", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank 
                        new Chart(document.getElementById("chartOtherEquipment"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [otherEquipmentYes, otherEquipmentNo],
                                    backgroundColor: ["#9B59B6", "#E0E0E0"]
                                }]
                            },
                            options,

                        });



                        // Tren Anggota Per Kecamatan Bar Chart
                        new Chart(document.getElementById('districtBarChart'), {
                            type: 'bar',
                            data: {
                                labels: @json($labelMembers),
                                datasets: [{
                                    label: 'Jumlah Anggota Koperasi per Kecamatan',
                                    data: @json($valueMembers)
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    datalabels: {
                                        anchor: 'end',
                                        align: 'top',
                                        font: {
                                            weight: 'bold'
                                        },
                                        formatter: function(value) {
                                            return value.toLocaleString(); // 1.250
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>





                    <!-- Peta Semua Lahan -->
                    <div id="map"></div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
