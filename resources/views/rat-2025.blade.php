<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>



        <x-slot name="style">


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
                            data: 'rat',
                            name: 'rat',
                        },

                    ]
                })

                const ctxDistrict = document.getElementById('districtChart');
                new Chart(ctxDistrict, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($districtLabels) !!}, // Mengubah array PHP ke JSON
                        datasets: [{
                            label: 'Jumlah RAT',
                            data: {!! json_encode($districtValues) !!},
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
                            label: 'Jumlah RAT',
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
                        <span class="text-gray-500">RAT 2025</span>
                    </nav>


                    <div class="bg-white shadow-lg rounded-2xl mb-6 p-6">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h3 class="text-lg font-bold text-gray-700">Progress Penyelesaian RAT</h3>
                                <p class="text-sm text-gray-500">Total KDKMP yang sudah melaksanakan RAT</p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-green-600">{{ $totalRat }}</span>
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
                    <div class="bg-white shadow-lg rounded-2xl mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah RAT per Kecamatan</h2>

                        <div class="h-[220px]">
                            <canvas id="districtChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah RAT per BA</h2>

                        <div class="h-[220px]">
                            <canvas id="assistantChart"></canvas>
                        </div>
                    </div>



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



                    <a href="{{ route('bussiness-assistants.form-rat.export') }}"
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
                                        <th>RAT</th>

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
