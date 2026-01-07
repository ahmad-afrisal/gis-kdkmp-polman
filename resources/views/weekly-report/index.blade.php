<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

        <x-slot name="script">

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

            <script>
                new Chart(document.getElementById('districtChart'), {
                    type: 'line',
                    data: {
                        labels: @json($labels),
                        datasets: @json($datasets)
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

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


        <!-- Main Content -->
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
                        <span class="text-gray-500">Laporan Mingguan</span>
                    </nav>

                    {{-- Tombol aksi --}}
                    <div class="mb-10 flex flex-col sm:flex-row gap-4">

                        {{-- Tombol Buat Laporan --}}
                        <a href="{{ route('weekly-reports.create') }}"
                            class="inline-flex items-center justify-center
               bg-green-500 hover:bg-green-700
               text-white font-bold
               py-3 px-4 rounded shadow-lg
               transition">
                            + Buat Laporan
                        </a>

                        {{-- Tombol Catat Riwayat --}}
                        <form action="{{ route('form-seven.record.all') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center
                   bg-green-600 hover:bg-green-800
                   text-white font-bold
                   py-3 px-4 rounded shadow-lg
                   transition w-full sm:w-auto">
                                Catat Riwayat Anggota
                            </button>
                        </form>

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

                    <div class="grid grid-cols-1  gap-6 mt-10">

                        <!-- Line Chart Dokumen -->
                        <div class="bg-white shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Perkembangan Anggota Berdasrkan Kecamatan
                            </h3>
                            <form method="GET" class="mb-6">
                                <select name="district_id" class="border rounded px-3 py-2"
                                    onchange="this.form.submit()">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}" @selected(request('district_id') == $district->id)>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>

                            <canvas id="districtChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </main>

    </div>
</x-app-layout>
