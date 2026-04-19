<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

        <x-slot name="style">
            <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
            <style>
                .contribution-wrapper {
                    display: flex;
                    align-items: flex-start;
                    font-family: ui-sans-serif, system-ui, sans-serif;
                }

                /* Label Hari di Sisi Kiri */
                .day-labels {
                    display: grid;
                    grid-template-rows: repeat(7, 12px);
                    gap: 3px;
                    margin-right: 8px;
                    margin-top: 25px;
                    /* Sesuaikan dengan tinggi label bulan */
                }

                .day-label {
                    font-size: 9px;
                    color: #71717a;
                    line-height: 12px;
                    height: 12px;
                }

                .contribution-container {
                    position: relative;
                }

                /* Label Bulan di Atas */
                .month-labels {
                    display: flex;
                    font-size: 10px;
                    color: #71717a;
                    margin-bottom: 5px;
                    height: 20px;
                }

                .month-label {
                    position: absolute;
                }

                .contribution-grid {
                    display: grid;
                    grid-template-rows: repeat(7, 12px);
                    grid-auto-flow: column;
                    gap: 3px;
                }

                .sq {
                    width: 12px;
                    height: 12px;
                    border-radius: 2px;
                    transition: transform 0.1s;
                }

                .sq:hover {
                    transform: scale(1.3);
                    z-index: 10;
                }

                .c-0 {
                    background-color: #ebedf0;
                }

                .c-1 {
                    background-color: #9be9a8;
                }

                .c-2 {
                    background-color: #40c463;
                }

                .c-3 {
                    background-color: #216e39;
                }

                .c-missed {
                    background-color: #fee2e2;
                    border: 1px solid #ef4444;
                }
            </style>
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
            <script src="https://unpkg.com/@popperjs/core@2"></script>
            <script src="https://unpkg.com/tippy.js@6"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    tippy('[data-tippy-content]');
                });
            </script>
            {{-- DataTable JS --}}
            <script>
                Chart.register(ChartDataLabels);

                var datatable = $('#crudTable').DataTable({
                    responsive: true,
                    // autoWidth: false, // MATIKAN autoWidth agar pengaturan kita jalan
                    ajax: {
                        url: '{!! url()->current() !!}'
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

            <script>
                function updateFileName(input) {
                    const preview = document.getElementById('file-preview');
                    const fileName = document.getElementById('file-name');

                    if (input.files && input.files[0]) {
                        fileName.textContent = input.files[0].name;
                        preview.classList.remove('hidden');
                    } else {
                        preview.classList.add('hidden');
                    }
                }
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

                    <div class="mt-8 bg-white p-6 rounded-lg shadow overflow-x-auto">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Visualisasi Kontribusi BA</h3>
                                <p class="text-sm text-gray-500">Aktivitas absen dalam 1 tahun terakhir</p>
                            </div>
                            <form method="GET" action="{{ url()->current() }}">
                                <select name="ba_id" onchange="this.form.submit()"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">-- Pilih Business Assistant --</option>
                                    @foreach ($businessAssistants as $ba)
                                        <option value="{{ $ba->id }}"
                                            {{ request('ba_id') == $ba->id ? 'selected' : '' }}>
                                            {{ $ba->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        @if (request('ba_id'))
                            <div class="contribution-wrapper pb-4">
                                <div class="day-labels">
                                    <div class="day-label">Senin</div>
                                    <div class="day-label"></div>
                                    <div class="day-label">Rabu</div>
                                    <div class="day-label"></div>
                                    <div class="day-label">Jumat</div>
                                    <div class="day-label"></div>
                                    <div class="day-label"></div>
                                </div>

                                <div class="contribution-container">
                                    @php
                                        $start = now()->subYear()->startOfWeek();
                                        $end = now();
                                        $currentMonth = '';
                                    @endphp

                                    <div class="month-labels">
                                        @php
                                            $tempDate = $start->copy();
                                            $colIndex = 0;
                                        @endphp
                                        @while ($tempDate->lte($end))
                                            @if ($tempDate->format('M') != $currentMonth)
                                                @php $currentMonth = $tempDate->format('M'); @endphp
                                                <div class="month-label" style="left: {{ $colIndex * 15 }}px">
                                                    {{ $currentMonth }}
                                                </div>
                                            @endif
                                            @php
                                                $tempDate->addWeek();
                                                $colIndex++;
                                            @endphp
                                        @endwhile
                                    </div>

                                    <div class="contribution-grid">
                                        @for ($date = $start->copy(); $date->lte($end); $date->addDay())
                                            @php
                                                $dateStr = $date->format('Y-m-d');
                                                $count = $contributions[$dateStr] ?? 0;
                                                $isWeekend = $date->isWeekend();

                                                $colorClass = 'c-0';
                                                if ($count > 0) {
                                                    if ($count <= 2) {
                                                        $colorClass = 'c-1';
                                                    } elseif ($count <= 5) {
                                                        $colorClass = 'c-2';
                                                    } else {
                                                        $colorClass = 'c-3';
                                                    }
                                                } elseif ($isWeekend) {
                                                    $colorClass = 'c-missed';
                                                }
                                            @endphp

                                            <div class="sq {{ $colorClass }}"
                                                data-tippy-content="{{ $date->translatedFormat('d F Y') }} {{ $count }} Absensi">
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-4 flex items-center text-[10px] text-gray-400 gap-1.5 justify-end uppercase tracking-wider">
                                <span>Kurang</span>
                                <div class="sq c-0"></div>
                                <div class="sq c-1"></div>
                                <div class="sq c-2"></div>
                                <div class="sq c-3"></div>
                                <span>Banyak</span>
                                <span class="mx-2">|</span>
                                <div class="sq c-missed"></div>
                                <span>Tanpa Keterangan Weekend</span>
                            </div>
                        @else
                            <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <i data-lucide="user-check" class="w-12 h-12 mx-auto text-gray-300 mb-3"></i>
                                <p class="text-gray-500 font-medium">Pilih Business Assistant untuk melihat performa
                                    kehadiran</p>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('attendances.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-4">
                            <div class="flex items-center justify-center w-full">
                                <label for="file_excel"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-300">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-12 h-12 mb-4 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 font-semibold">Klik untuk upload atau
                                            drag and drop</p>
                                        <p class="text-xs text-gray-400 text-center px-4">XLSX, XLS, atau CSV (Maks.
                                            10MB)<br>Pastikan format kolom sesuai dengan template laporan.</p>
                                    </div>
                                    <input id="file_excel" name="file_excel" type="file" class="hidden"
                                        accept=".xlsx, .xls, .csv" onchange="updateFileName(this)" />
                                </label>
                            </div>

                            <div id="file-preview"
                                class="hidden flex items-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z">
                                    </path>
                                </svg>
                                <span id="file-name" class="text-sm text-blue-700 truncate"></span>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md transition duration-200 ease-in-out transform hover:-translate-y-0.5 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Proses Impor Data
                            </button>
                        </div>
                    </form>

                    <div class="max-w-xl mx-auto mt-6 p-6 bg-white rounded-xl shadow-md border border-red-100">
                        <div class="flex items-center mb-4 text-red-600">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <h3 class="text-lg font-bold">Hapus Data Per Bulan</h3>
                        </div>

                        <form action="{{ route('attendances.deleteByMonth') }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA data BA ini pada bulan terpilih? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Business
                                        Assistant</label>
                                    <select name="bussiness_assistant_id" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                        <option value="">-- Pilih BA --</option>
                                        @foreach ($businessAssistants as $ba)
                                            <option value="{{ $ba->id }}">{{ $ba->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Bulan &
                                        Tahun</label>
                                    <input type="month" name="month" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                </div>
                            </div>

                            <button type="submit"
                                class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                Hapus Data Permanen
                            </button>
                        </form>
                    </div>
                </div>


            </div>
        </main>

    </div>
</x-app-layout>
