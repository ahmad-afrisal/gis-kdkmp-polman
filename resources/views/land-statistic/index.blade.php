<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>



        <x-slot name="style">

            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
            <style>
                #map {
                    width: 100%;
                    height: 80vh;
                }
            </style>
        </x-slot>

        <x-slot name="script">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
            <script>
                Chart.register(ChartDataLabels);

                // AJAX DataTable

                var datatable = $('#crudTable').DataTable({
                    // responsive: true, // <--- aktifkan fitur ini
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
                            data: 'picture_land',
                            name: 'picture_land',
                        },
                        // {
                        //     data: 'coordinate',
                        //     name: 'coordinate',
                        // },
                        // {
                        //     data: 'width_land',
                        //     name: 'width_land',
                        // },
                        // {
                        //     data: 'long_land',
                        //     name: 'long_land',
                        // },
                        // {
                        //     data: 'letter_land',
                        //     name: 'letter_land',
                        // },
                        // {
                        //     data: 'road_condition',
                        //     name: 'road_condition',
                        // },
                        // {
                        //     data: 'asset',
                        //     name: 'asset',
                        // },
                        {
                            data: 'is_build',
                            name: 'is_build',
                        },
                        {
                            data: 'persentase',
                            name: 'persentase',
                        },
                        {
                            data: 'progress',
                            name: 'progress',
                        },
                        {
                            data: 'description',
                            name: 'description',
                        },
                        // {
                        //     data: 'distance',
                        //     name: 'distance',
                        // },
                        // {
                        //     data: 'internet_access',
                        //     name: 'internet_access',
                        // },
                        // {
                        //     data: 'water_access',
                        //     name: 'water_access',
                        // },
                        // {
                        //     data: 'electricity_access',
                        //     name: 'electricity_access',
                        // },
                        // {
                        //     data: 'action',
                        //     name: 'action',
                        //     orderable: false,
                        //     searchable: false,
                        //     width: '15%',
                        // }
                    ]
                })

                const districtStats = @json($districtStats);

                new Chart(document.getElementById('districtChart'), {
                    type: 'bar',
                    data: {
                        labels: Object.keys(districtStats),
                        datasets: [{
                            label: 'Jumlah Lahan (asset terisi)',
                            data: Object.values(districtStats),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // <- penting di mobile
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


                const ctxDistrict = document.getElementById('districtBuildChart');
                new Chart(ctxDistrict, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($districtBuildLabels) !!}, // Mengubah array PHP ke JSON
                        datasets: [{
                            label: 'Jumlah Pembangunan',
                            data: {!! json_encode($districtBuildValues) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // <- penting di mobile
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

                const ctxBa = document.getElementById('assistantChart');
                new Chart(ctxBa, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($assistantLabels) !!}, // Mengubah array PHP ke JSON
                        datasets: [{
                            label: 'Jumlah Pembangunan',
                            data: {!! json_encode($assistantValues) !!},
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // <- penting di mobile
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


                function createDoughnutChart(canvasId, labels, data) {
                    new Chart(document.getElementById(canvasId), {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                borderWidth: 1
                            }]
                        }
                    });
                }

                // Kirim data dari Laravel ke JS
                const chartData = @json($data);

                createDoughnutChart(
                    'assetChart',
                    Object.keys(chartData.asset),
                    Object.values(chartData.asset)
                );

                createDoughnutChart(
                    'internetChart',
                    Object.keys(chartData.internet_access),
                    Object.values(chartData.internet_access)
                );

                createDoughnutChart(
                    'waterChart',
                    Object.keys(chartData.water_access),
                    Object.values(chartData.water_access)
                );

                createDoughnutChart(
                    'electricityChart',
                    Object.keys(chartData.electricity_access),
                    Object.values(chartData.electricity_access)
                );
            </script>

            <script>
                // Inisialisasi peta
                var map = L.map('map').setView([-3.4126, 119.3435], 10);



                // Google Hybrid Layer
                var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(map);

                // Ambil semua data polygon dari controller
                var lahanData = @json($lands);

                lahanData.forEach(function(lahan) {

                    if (lahan.geojson) {
                        var geojson = (typeof lahan.geojson === "string") ?
                            JSON.parse(lahan.geojson) :
                            lahan.geojson;

                        // Style polygon tetap sama untuk semua
                        L.geoJSON(geojson, {
                                style: {
                                    color: "#1E90FF", // biru
                                    weight: 2,
                                    fillOpacity: 0.4
                                }
                            })
                            .bindPopup(`
                <b>KDKMP:</b> ${lahan.cooperation ? lahan.cooperation.name : '-'}
            `)
                            .addTo(map);
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
                        <span class="text-gray-500">Statistik Pembangunan</span>
                    </nav>
                    {{-- Pembangunan --}}
                    <div class="bg-white shadow-lg rounded-2xl mb-6 p-6">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-lg font-bold text-gray-700">Progress Pembangunan Gerai KDKMP</h3>
                                <p class="text-sm text-gray-500">Total KDKMP yang sudah melakukan Pembangunan</p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-green-600">{{ $totalBuild }}</span>
                                <span class="text-gray-400">/ {{ $totalCooperation }}</span>
                            </div>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-green-500 h-4 rounded-full transition-all duration-500 shadow-sm"
                                style="width: {{ $percentage }}%">
                            </div>
                        </div>

                        <div class="mt-2 text-right">
                            <span class="text-sm font-medium text-green-700">{{ number_format($percentage, 1) }}%
                                Tercapai</span>
                        </div>
                    </div>


                    {{-- Lahan --}}
                    <div class="bg-white shadow-lg rounded-2xl mb-6 p-6">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-lg font-bold text-gray-700">Progress Kesediaan Lahan</h3>
                                <p class="text-sm text-gray-500">Total KDKMP yang telah memiliki lahan</p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-cyan-600">{{ $totalLand }}</span>
                                <span class="text-gray-400">/ {{ $totalCooperation }}</span>
                            </div>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-cyan-500 h-4 rounded-full transition-all duration-500 shadow-sm"
                                style="width: {{ $percentageLand }}%">
                            </div>
                        </div>

                        <div class="mt-2 text-right">
                            <span class="text-sm font-medium text-cyan-700">{{ number_format($percentage, 1) }}%
                                Tercapai</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pb-6">

                        {{-- ASSET --}}
                        <div class="bg-white shadow-lg rounded-2xl p-5">
                            <h2 class="text-center font-semibold mb-2">Tipe Asset</h2>
                            <canvas id="assetChart"></canvas>
                        </div>

                        {{-- INTERNET ACCESS --}}
                        <div class="bg-white shadow-lg rounded-2xl p-5">
                            <h2 class="text-center font-semibold mb-2">Akses Internet</h2>
                            <canvas id="internetChart"></canvas>
                        </div>

                        {{-- WATER ACCESS --}}
                        <div class="bg-white shadow-lg rounded-2xl p-5">
                            <h2 class="text-center font-semibold mb-2">Akses Air</h2>
                            <canvas id="waterChart"></canvas>
                        </div>

                        {{-- ELECTRICITY ACCESS --}}
                        <div class="bg-white shadow-lg rounded-2xl p-5">
                            <h2 class="text-center font-semibold mb-2">Akses Listrik</h2>
                            <canvas id="electricityChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Pembangunan per Kecamatan</h2>

                        <div class="h-[220px]">
                            <canvas id="districtBuildChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Pembanguna per BA</h2>

                        <div class="h-[220px]">
                            <canvas id="assistantChart"></canvas>
                        </div>
                    </div>


                    <div class="bg-white shadow-lg rounded-2xl mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Lahan per Kecamatan</h2>

                        <div class="h-[220px]">
                            <canvas id="districtChart"></canvas>
                        </div>
                    </div>







                    <a href="{{ route('land-statistic.export') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded shadow-lg">Export</a>
                    <div class="shadow overflow-hidden sm-rounded-md">

                        <div class="px-4 py-5 bg-white sm:p-6">

                            <table id="crudTable" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Nama BA</th>
                                        <th>Nama KDKMP</th>
                                        <th>Foto Lahan</th>
                                        {{-- <th>Titik Kordinat</th> --}}
                                        {{-- <th>Lebar</th>
                                        <th>Panjang</th>
                                        <th>Surat Lahan</th>
                                        <th>Kondisi Jalan</th>
                                        <th>Tipe Aset</th> --}}
                                        <th>Pembangunan</th>
                                        <th>Persentase</th>
                                        <th>Keterangan Progress</th>
                                        {{-- <th>Jarak dari permukiman (m)</th>
                                        <th>Akses Internet</th>
                                        <th>Akses Air</th> --}}
                                        {{-- <th>Akses Listrik</th> --}}
                                        <th>Keterangan</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="max-w-7xl mx-auto my-8 px-4">
                        <div id="map" class="w-full h-[600px] rounded-lg shadow"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
