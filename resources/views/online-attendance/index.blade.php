<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

        <x-slot name="style">
            {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" /> --}}

            <style>
                #crudTable {
                    width: 100% !important;
                }

                #crudTable td {
                    white-space: normal !important;
                    /* Membolehkan teks pindah baris */
                    vertical-align: top;
                    /* Agar teks rapi di atas */
                    word-break: break-word;
                    /* Memutus kata yang sangat panjang */
                }
            </style>
        </x-slot>



        <x-slot name="script">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
            {{-- DataTable JS --}}
            <script>
                Chart.register(ChartDataLabels);

                var datatable = $('#crudTable').DataTable({
                    responsive: true,
                    // autoWidth: false, // MATIKAN autoWidth agar pengaturan kita jalan
                    ajax: {
                        url: '{!! url()->current() !!}',
                        data: function(d) {
                            d.start_date = $('input[name="start_date"]').val();
                            d.end_date = $('input[name="end_date"]').val();
                        }
                    },
                    // Mengatur urutan default: kolom indeks ke-4 (misal updated_at), urutan desc
                    order: [
                        [5, 'desc']
                    ],
                    columns: [{
                            data: null, // Kita gunakan null karena data nomor tidak ada di database
                            name: 'no',
                            render: function(data, type, row, meta) {
                                // meta.row adalah indeks baris (mulai dari 0)
                                // meta.settings._iDisplayStart adalah indeks awal halaman
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            orderable: true,
                            searchable: false,
                            width: '5%' // Opsional: agar kolom nomor tidak terlalu lebar
                        },
                        {
                            data: 'ba',
                            name: 'ba'
                        },
                        {
                            data: 'activity',
                            name: 'activity'
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'check_in',
                            name: 'check_in'
                        },

                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                        }
                    ]
                })


                // Chart Initialization (Bar Chart berdasarkan Nama BA)
                const ctx = document.getElementById('attendanceChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // Diubah menjadi bar
                    data: {
                        labels: {!! json_encode($labels) !!},
                        datasets: [{
                            label: 'Total Kehadiran',
                            data: {!! json_encode($values) !!},
                            backgroundColor: 'rgba(16, 185, 129, 0.6)', // Hijau transparan
                            borderColor: '#10b981', // Hijau solid
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1 // Karena jumlah orang/kehadiran pasti bulat
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Kehadiran'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Nama Business Assistant'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false // Sembunyikan label dataset karena sudah jelas
                            }
                        }
                    }
                });
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
                        <span class="text-gray-500">Absen BA</span>
                    </nav>

                    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                        <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-end gap-4">
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
                                <input type="date" name="start_date" value="{{ $startInput }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                                <input type="date" name="end_date" value="{{ $endInput }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Filter</button>
                                <a href="{{ route('online-attendances.index') }}"
                                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-700">Grafik Kehadiran</h3>
                        <div class="h-64">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>


                    {{-- Tombol tambah --}}
                    <div class="mb-10 flex space-x-2">
                        <a href="{{ route('online-attendances.create') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg">
                            + Tambah Kehadiran
                        </a>
                        {{-- <a href="{{ route('problems.export') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded shadow-lg">
                            <i class="fa fa-file-excel mr-2"></i> Export Excel
                        </a> --}}
                    </div>

                    {{-- DATA TABLE --}}
                    <div class="shadow overflow-hidden sm-rounded-md bg-white p-4">
                        <table id="crudTable" class="display cell-border">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>BA</th>
                                    <th>Kegiatan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Tanggal Update</th>
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
