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
                            data: 'initial_membership',
                            name: 'initial_membership',
                        },
                        {
                            data: 'addition_of_members',
                            name: 'addition_of_members',
                        },



                    ]
                })

                const ctxDistrict = document.getElementById('districtChart');
                new Chart(ctxDistrict, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($districtLabels) !!}, // Mengubah array PHP ke JSON
                        datasets: [{
                            label: 'Jumlah Anggota',
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
                            label: 'Jumlah Anggota',
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
                        <span class="text-gray-500">Anggota Koperasi 2026</span>
                    </nav>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div
                            class="relative overflow-hidden group bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-md transition-all">
                            <div
                                class="absolute top-0 right-0 -mr-10 -mt-10 w-24 h-24 bg-emerald-50 rounded-full group-hover:bg-emerald-100 transition-colors">
                            </div>
                            <div class="relative flex items-center space-x-4">
                                <div class="p-3 bg-emerald-500 rounded-xl text-white shadow-lg shadow-emerald-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="ms-4">
                                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Anggota Awal
                                    </p>
                                    <h3 class="text-3xl font-extrabold text-gray-800">
                                        {{ number_format($cardInitial, 0, ',', '.') }}</h3>
                                    <p class="text-xs text-gray-500 mt-1 font-light italic">*Data awal pembentukan</p>

                                </div>
                            </div>
                        </div>

                        <div
                            class="relative overflow-hidden group bg-white p-6 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition-all">
                            <div
                                class="absolute top-0 right-0 -mr-10 -mt-10 w-24 h-24 bg-emerald-50 rounded-full group-hover:bg-emerald-100 transition-colors">
                            </div>
                            <div class="relative flex items-center space-x-4">
                                <div class="p-3 bg-green-600 rounded-xl text-white shadow-lg shadow-green-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div class="ms-4">
                                    <p class="text-xs font-bold text-green-600 uppercase tracking-widest">Penambahan</p>
                                    <h3 class="text-3xl font-extrabold text-gray-800">
                                        {{ number_format($cardAddition, 0, ',', '.') }}</h3>
                                    <p class="text-xs text-gray-500 mt-1 font-light italic text-green-600">+ Meningkat
                                        periode ini</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="relative overflow-hidden group bg-white p-6 rounded-2xl shadow-sm border border-green-100 hover:shadow-md transition-all">
                            <div
                                class="absolute top-0 right-0 -mr-10 -mt-10 w-24 h-24 bg-emerald-50 rounded-full group-hover:bg-emerald-100 transition-colors">
                            </div>
                            <div class="relative flex items-center space-x-4">
                                <div class="p-3 bg-green-900 rounded-xl text-white shadow-lg shadow-green-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ms-4">
                                    <p class="text-xs font-bold text-green-600 uppercase tracking-widest">Total Anggota
                                    </p>
                                    <h3 class="text-3xl font-extrabold text-gray-800">
                                        {{ number_format($totalMember, 0, ',', '.') }}</h3>
                                    <p class="text-xs text-gray-500 mt-1 font-light italic text-green-600">+ Keseluruhan
                                        Anggota</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Anggota per Kecamatan</h2>

                        <div class="h-[220px]">
                            <canvas id="districtChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Anggota per BA</h2>

                        <div class="h-[220px]">
                            <canvas id="assistantChart"></canvas>
                        </div>
                    </div>




                    {{-- <a href="{{ route('bussiness-assistants.form-rat.export') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded shadow-lg">Export</a> --}}
                    <div class="shadow overflow-hidden sm-rounded-md">

                        <div class="px-4 py-5 bg-white sm:p-6">

                            <table id="crudTable" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kecamatan</th>
                                        <th>Nama BA</th>
                                        <th>Nama KDKMP</th>
                                        <th>Anggota Awal</th>
                                        <th>Penambahan Anggota</th>
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
