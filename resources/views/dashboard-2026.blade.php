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

            <script>
                Chart.register(ChartDataLabels);

                const ratYes = {{ $ratYes }};
                const ratNo = {{ $ratNo }};

                const profileUpdateYes = {{ $profileUpdateYes }};
                const profileUpdateNo = {{ $profileUpdateNo }};

                const villagePotentialYes = {{ $villagePotentialYes }};
                const villagePotentialNo = {{ $villagePotentialNo }};

                const landReadinessYes = {{ $landReadinessYes }};
                const landReadinessNo = {{ $landReadinessNo }};

                const operationalGuideYes = {{ $operationalGuideYes }};
                const operationalGuideNo = {{ $operationalGuideNo }};

                const vehicleYes = {{ $vehicleYes }};
                const vehicleNo = {{ $vehicleNo }};

                const displayCaseYes = {{ $displayCaseYes }};
                const displayCaseNo = {{ $displayCaseNo }};

                const computerYes = {{ $computerYes }};
                const computerNo = {{ $computerNo }};

                const tableAndChairYes = {{ $tableAndChairYes }};
                const tableAndChairNo = {{ $tableAndChairNo }};

                const outputYes = {{ $outputYes }};
                const outputNo = {{ $outputNo }};

                const storeDevelopmentYes = {{ $storeDevelopmentYes }};
                const storeDevelopmentOn = {{ $storeDevelopmentOn }};
                const storeDevelopmentNo = {{ $storeDevelopmentNo }};

                const outletStatusYes = {{ $outletStatusYes }}; // Operational
                const outletStatusOn = {{ $outletStatusOn }}; // Belum Buka
                const outletStatusNo = {{ $outletStatusNo }}; // Belum Ada


                const groceryOutletYes = {{ $groceryOutletYes }};
                const groceryOutletNo = {{ $groceryOutletNo }};

                const pharmacyOutletYes = {{ $pharmacyOutletYes }};
                const pharmacyOutletNo = {{ $pharmacyOutletNo }};

                const warehousingOutletYes = {{ $warehousingOutletYes }};
                const warehousingOutletNo = {{ $warehousingOutletNo }};

                const clinicOutletYes = {{ $clinicOutletYes }};
                const clinicOutletNo = {{ $clinicOutletNo }};

                const logisticsOutletYes = {{ $logisticsOutletYes }};
                const logisticsOutletNo = {{ $logisticsOutletNo }};

                const uspOutletYes = {{ $uspOutletYes }};
                const uspOutletNo = {{ $uspOutletNo }};

                const otherBusinessessOutletYes = {{ $otherBusinessessOutletYes }};
                const otherBusinessessOutletNo = {{ $otherBusinessessOutletNo }};

                // Penting Bagian dari Donut Chart
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

                // Chart 1 - RAT
                new Chart(document.getElementById("chartRat"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [ratYes, ratNo],
                            backgroundColor: ["#36A2EB", "#E0E0E0"]
                        }]
                    },
                    options,

                });

                // Profile Update
                new Chart(document.getElementById("chartProfileUpdate"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [profileUpdateYes, profileUpdateNo],
                            backgroundColor: ["#FF007F", "#E0E0E0"]
                        }]
                    },
                    options,

                });

                // Data Potensi Desa
                new Chart(document.getElementById("chartVillagePotential"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [villagePotentialYes, villagePotentialNo],
                            backgroundColor: ["#B1740F", "#E0E0E0"]
                        }]
                    },
                    options,

                });

                // Data Kesiapan Lahan
                new Chart(document.getElementById("chartLandReadiness"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [landReadinessYes, landReadinessNo],
                            backgroundColor: ["#B3FFFC", "#E0E0E0"]
                        }]
                    },
                    options,
                });


                // Data Panduan Operational
                new Chart(document.getElementById("chartOperationalGuide"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [operationalGuideYes, operationalGuideNo],
                            backgroundColor: ["#FF4242", "#E0E0E0"]
                        }]
                    },
                    options,

                });

                // Data Vehicle
                new Chart(document.getElementById("chartVehicle"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [vehicleYes, vehicleNo],
                            backgroundColor: ["#4CAF50", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Display Case
                new Chart(document.getElementById("chartDisplayCase"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [displayCaseYes, displayCaseNo],
                            backgroundColor: ["#FF9800", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Display Case
                new Chart(document.getElementById("chartComputer"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [computerYes, computerNo],
                            backgroundColor: ["#C0392B", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Display Case
                new Chart(document.getElementById("chartTableAndChair"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [tableAndChairYes, tableAndChairNo],
                            backgroundColor: ["#30321C", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Display Case
                new Chart(document.getElementById("chartOutput"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah", "Belum"],
                        datasets: [{
                            data: [outputYes, outputNo],
                            backgroundColor: ["#9B59B6", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Display Case
                new Chart(document.getElementById("chartStoreDevelopment"), {
                    type: "doughnut",
                    data: {
                        labels: ["Selesai", "Belum", "Tidak"],
                        datasets: [{
                            data: [storeDevelopmentYes, storeDevelopmentOn, storeDevelopmentNo],
                            backgroundColor: ["#D4DF9E", "#9B59B6", "#E0E0E0"]
                        }]
                    },
                    options,
                });


                // Data Display Case
                new Chart(document.getElementById("chartOutletStatus"), {
                    type: "doughnut",
                    data: {
                        labels: ["Operational", "Belum Buka", "Belum Ada"],
                        datasets: [{
                            data: [outletStatusYes, outletStatusOn, outletStatusNo],
                            backgroundColor: ["#D4DF9E", "#9B59B6", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Grocery Outlet
                new Chart(document.getElementById("chartGroceryOutlet"), {
                    type: "doughnut",
                    data: {
                        labels: ["Operational", "Belum"],
                        datasets: [{
                            data: [groceryOutletYes, groceryOutletNo],
                            backgroundColor: ["#D4DF9E", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Pharmacy Outlet
                new Chart(document.getElementById("chartPharmacyOutlet"), {
                    type: "doughnut",
                    data: {
                        labels: ["Operational", "Belum"],
                        datasets: [{
                            data: [pharmacyOutletYes, pharmacyOutletNo],
                            backgroundColor: ["#D4DF9E", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Warehousing Outlet
                new Chart(document.getElementById("chartWarehousingOutlet"), {
                    type: "doughnut",
                    data: {
                        labels: ["Operational", "Belum"],
                        datasets: [{
                            data: [warehousingOutletYes, warehousingOutletNo],
                            backgroundColor: ["#D4DF9E", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Clinic Outlet
                new Chart(document.getElementById("chartClinicOutlet"), {
                    type: "doughnut",
                    data: {
                        labels: ["Operational", "Belum"],
                        datasets: [{
                            data: [clinicOutletYes, clinicOutletNo],
                            backgroundColor: ["#D4DF9E", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data Logistic Outlet
                new Chart(document.getElementById("chartLogisticsOutlet"), {
                    type: "doughnut",
                    data: {
                        labels: ["Operational", "Belum"],
                        datasets: [{
                            data: [logisticsOutletYes, logisticsOutletNo],
                            backgroundColor: ["#D4DF9E", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data usp Outlet
                new Chart(document.getElementById("chartUspOutlet"), {
                    type: "doughnut",
                    data: {
                        labels: ["Operational", "Belum"],
                        datasets: [{
                            data: [uspOutletYes, uspOutletNo],
                            backgroundColor: ["#D4DF9E", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                // Data other_businesses_outlet
                new Chart(document.getElementById("chartOtherBusinessessOutlet"), {
                    type: "doughnut",
                    data: {
                        labels: ["Operational", "Belum"],
                        datasets: [{
                            data: [otherBusinessessOutletYes, otherBusinessessOutletNo],
                            backgroundColor: ["#D4DF9E", "#E0E0E0"]
                        }]
                    },
                    options,
                });

                var datatable = $('#formEight').DataTable({
                    responsive: true, // <--- aktifkan fitur ini
                    ajax: {
                        url: "{{ route('dashboard.form-eight') }}"
                    },
                    columns: [{
                            data: 'business_assistant',
                            name: 'business_assistant',
                        },
                        {
                            data: 'district',
                            name: 'district',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'land_readiness',
                            name: 'land_readiness',
                        },
                        {
                            data: 'store_development',
                            name: 'store_development',
                        },
                        {
                            data: 'vehicle',
                            name: 'vehicle',
                        },
                        {
                            data: 'table_and_chair',
                            name: 'table_and_chair',
                        },
                        {
                            data: 'display_case',
                            name: 'display_case',
                        },
                        {
                            data: 'computer',
                            name: 'computer',
                        },
                        {
                            data: 'problem',
                            name: 'problem',
                        },
                        {
                            data: 'information',
                            name: 'information',
                        },

                    ]
                })

                var datatable = $('#formNine').DataTable({
                    responsive: true, // <--- aktifkan fitur ini
                    ajax: {
                        url: "{{ route('dashboard.form-nine') }}"
                    },
                    columns: [{
                            data: 'business_assistant',
                            name: 'business_assistant',
                        },
                        {
                            data: 'district',
                            name: 'district',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'outlet_status',
                            name: 'outlet_status',
                        },

                        {
                            data: 'number_of_employees_2025',
                            name: 'number_of_employees_2025',
                        },
                        {
                            data: 'number_of_employees_2026',
                            name: 'number_of_employees_2026',
                        },
                        {
                            data: 'outlet_operations_guide',
                            name: 'outlet_operations_guide',
                        },

                        {
                            data: 'problem',
                            name: 'problem',
                        },
                        {
                            data: 'information',
                            name: 'information',
                        },

                    ]
                })

                var datatable = $('#formTen').DataTable({
                    responsive: true, // <--- aktifkan fitur ini
                    ajax: {
                        url: "{{ route('dashboard.form-ten') }}"
                    },
                    columns: [{
                            data: 'business_assistant',
                            name: 'business_assistant',
                        },
                        {
                            data: 'district',
                            name: 'district',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'profile_update',
                            name: 'profile_update',
                        },
                        {
                            data: 'village_potential',
                            name: 'village_potential',
                        },
                        {
                            data: 'grocery_outlet',
                            name: 'grocery_outlet',
                        },
                        {
                            data: 'pharmacy_outlet',
                            name: 'pharmacy_outlet',
                        },
                        {
                            data: 'warehousing_outlet',
                            name: 'warehousing_outlet',
                        },
                        {
                            data: 'clinic_outlet',
                            name: 'clinic_outlet',
                        },
                        {
                            data: 'logistics_outlet',
                            name: 'logistics_outlet',
                        },
                        {
                            data: 'usp_outlet',
                            name: 'usp_outlet',
                        },
                        {
                            data: 'other_businesses_outlet',
                            name: 'other_businesses_outlet',
                        },
                        {
                            data: 'rat',
                            name: 'rat',
                        },
                        {
                            data: 'initial_membership',
                            name: 'initial_membership',
                        },
                        {
                            data: 'addition_of_members',
                            name: 'addition_of_members',
                        },
                        {
                            data: 'problem',
                            name: 'problem',
                        },
                        {
                            data: 'information',
                            name: 'information',
                        },

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
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-4">
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-green-600">
                            <i data-lucide="home" class="w-4 h-4 mr-1"></i> Home
                        </a>
                        <span>›</span>
                        <span class="text-gray-500">Dashboard</span>
                    </nav>

                    {{-- Donut Charts --}}

                    <!-- Grid untuk 3 Chart -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mt-10">
                        <!-- CARD 1 - RAT-->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">RAT</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartRat"></canvas>
                            </div>
                        </div>

                        <!-- CARD 6 - Update Profile Simkopdes -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Profile Simkopdes</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartProfileUpdate"></canvas>
                            </div>
                        </div>

                        <!-- CARD 3 - Potensi Desa -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Potensi Desa</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartVillagePotential"></canvas>
                            </div>
                        </div>

                        <!-- CARD 6 - Kesiapan Lokasi -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kesiapan Lokasi</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartLandReadiness"></canvas>
                            </div>
                        </div>

                        <!-- CARD 6 - Panduan Operasional-->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Panduan Operasional</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartOperationalGuide"></canvas>
                            </div>
                        </div>

                        <!-- CARD 1 - NIB -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Sarpras : Etalase</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartDisplayCase"></canvas>
                            </div>
                        </div>

                        <!-- CARD 3 - NPWP -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Sarpras : Komputer</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartComputer"></canvas>
                            </div>
                        </div>

                        <!-- CARD 4 - Rekening Bank -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Sarpras : Meja Kursi</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartTableAndChair"></canvas>
                            </div>
                        </div>

                        <!-- CARD 5 - Business Plan -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Sarpras: Kendaraan</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartVehicle"></canvas>
                            </div>
                        </div>

                        <!-- CARD 6 - Financing -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kesepakatan</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartOutput"></canvas>
                            </div>
                        </div>

                        <!-- CARD 5 - Business Plan -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Pembangunan Gerai</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartStoreDevelopment"></canvas>
                            </div>
                        </div>

                        <!-- CARD 5 - Business Plan -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Status Gerai</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartOutletStatus"></canvas>
                            </div>
                        </div>

                        <!-- Gerai Sembako -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Gerai Sembako</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartGroceryOutlet"></canvas>
                            </div>
                        </div>

                        <!-- Gerai Sembako -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Gerai Apotek</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartPharmacyOutlet"></canvas>
                            </div>
                        </div>

                        <!-- Gerai Sembako -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Gerai Pergudangan</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartWarehousingOutlet"></canvas>
                            </div>
                        </div>

                        <!-- Gerai Sembako -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Gerai Klinik</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartClinicOutlet"></canvas>
                            </div>
                        </div>

                        <!-- Gerai Sembako -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Gerai Logistik</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartLogisticsOutlet"></canvas>
                            </div>
                        </div>

                        <!-- Gerai Sembako -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Gerai USP</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartUspOutlet"></canvas>
                            </div>
                        </div>

                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Gerai Usaha Lain</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartOtherBusinessessOutlet"></canvas>
                            </div>
                        </div>

                    </div>

                    {{-- Form 1  --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700">Laporan asistensi pengelolaan tata
                                    kelola gerai KDKMP
                                </h3>
                            </div>

                            <div class="p-6 overflow-x-auto">

                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th rowspan="3" class="p-2">No.</th>
                                            <th rowspan="3" class="p-2">Nama Kecamatan</th>
                                            <th rowspan="3" class="p-2">Jumlah Desa/Kelurahan</th>
                                            <th rowspan="3" class="p-2">Jumlah KDKMP</th>
                                            <th rowspan="2" colspan="2" class="p-2">Kesiapan Lokasi/Lahan
                                            </th>
                                            <th rowspan="2" colspan="3" class="p-2">Pembagunan Gerai </th>
                                            <th colspan="12" class="p-2">Saranan & Prasarana</th>

                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">

                                            <th colspan="2" class="p-2">Kendaraan</th>
                                            <th colspan="2" class="p-2">Meja & Kursi</th>
                                            <th colspan="2" class="p-2">Etalase</th>
                                            <th colspan="2" class="p-2">Komputer</th>

                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th class="p-2">Ada</th>
                                            <th class="p-2">Tidak</th>
                                            <th class="p-2">Selesai</th>
                                            <th class="p-2">Belum</th>
                                            <th class="p-2">Tidak Dibangun</th>
                                            <th class="p-2">Ada</th>
                                            <th class="p-2">Tidak</th>
                                            <th class="p-2">Ada</th>
                                            <th class="p-2">Tidak</th>
                                            <th class="p-2">Ada</th>
                                            <th class="p-2">Tidak</th>
                                            <th class="p-2">Ada</th>
                                            <th class="p-2">Tidak</th>


                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
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
                                            <th>17</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reportOnes as $index => $r)
                                            <tr class="text-center">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $r['district'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td> {{-- jika KDKMP sama dengan jumlah desa --}}

                                                {{-- Kesiapan Lahan --}}
                                                <td>{{ $r['land_readiness_yes'] }}</td>
                                                <td>{{ $r['land_readiness_no'] }}</td>

                                                {{-- Pembagunan Gerai --}}
                                                <td>{{ $r['store_development_yes'] }}</td>
                                                <td>{{ $r['store_development_on'] }}</td>
                                                <td>{{ $r['store_development_no'] }}</td>

                                                {{-- Kendaraan --}}
                                                <td>{{ $r['vehicle_yes'] }}</td>
                                                <td>{{ $r['vehicle_no'] }}</td>

                                                {{-- Kursi dan Meja --}}
                                                <td>{{ $r['table_and_chair_yes'] }}</td>
                                                <td>{{ $r['table_and_chair_no'] }}</td>

                                                {{-- Etalase --}}
                                                <td>{{ $r['display_case_yes'] }}</td>
                                                <td>{{ $r['display_case_no'] }}</td>

                                                {{-- Komputer --}}
                                                <td>{{ $r['computer_yes'] }}</td>
                                                <td>{{ $r['computer_no'] }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                    {{-- Form 2  --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700">Laporan Monitoring Persiapan Gerai
                                    KDKMP
                                </h3>
                            </div>

                            <div class="p-6 overflow-x-auto">

                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th rowspan="2" class="p-2">No.</th>
                                            <th rowspan="2" class="p-2">Nama Kecamatan</th>
                                            <th rowspan="2" class="p-2">Jumlah Desa/Kelurahan</th>
                                            <th rowspan="2" class="p-2">Jumlah KDKMP</th>
                                            <th colspan="3" class="p-2">Status Gerai </th>
                                            <th colspan="2" class="p-2">Jumlah Karyawan/Pengelola
                                            </th>
                                            <th colspan="2" class="p-2">Panduan Operasional Gerai
                                            </th>

                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th class="p-2">Belum Ada</th>
                                            <th class="p-2">Belum Buka</th>
                                            <th class="p-2">Operasional</th>
                                            <th class="p-2">Jumlah 2025</th>
                                            <th class="p-2">Jumlah 2026</th>
                                            <th class="p-2">Ada</th>
                                            <th class="p-2">Tidak</th>



                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
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
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reportTwos as $index => $r)
                                            <tr class="text-center">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $r['district'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td> {{-- jika KDKMP sama dengan jumlah desa --}}

                                                {{-- Status Gerai --}}
                                                <td>{{ $r['outlet_status_no'] }}</td>
                                                <td>{{ $r['outlet_status_on'] }}</td>
                                                <td>{{ $r['outlet_status_yes'] }}</td>

                                                {{-- Jumlah Karyawan --}}
                                                <td>{{ $r['number_of_employees_2025'] }}</td>
                                                <td>{{ $r['number_of_employees_2026'] }}</td>

                                                {{-- Panduan Operasional --}}
                                                <td>{{ $r['outlet_operations_guide_yes'] }}</td>
                                                <td>{{ $r['outlet_operations_guide_no'] }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                    {{-- Form 3  --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700">Laporan Pemutakhiran Data di Simkopdes
                                </h3>
                            </div>

                            <div class="p-6 overflow-x-auto">

                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th rowspan="2" class="p-2">No.</th>
                                            <th rowspan="2" class="p-2">Nama Kecamatan</th>
                                            <th rowspan="2" class="p-2">Jumlah Desa/Kelurahan</th>
                                            <th rowspan="2" class="p-2">Jumlah KDKMP</th>
                                            <th colspan="2" class="p-2">Update Profil
                                                Koperasi
                                                Desa/Kelurahan
                                                Merah Putih </th>
                                            <th colspan="2" class="p-2">Potensi Desa
                                            </th>
                                            <th colspan="7" class="p-2">Gerai yang Ada
                                            </th>
                                            <th colspan="2" class="p-2">RAT
                                            </th>
                                            <th colspan="2" class="p-2">Jumlah Anggota
                                            </th>

                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th class="p-2">Sudah</th>
                                            <th class="p-2">Belum</th>
                                            <th class="p-2">Sudah</th>
                                            <th class="p-2">Belum</th>
                                            <th class="p-2">Sembako</th>
                                            <th class="p-2">Apotek</th>
                                            <th class="p-2">Pergudangan</th>
                                            <th class="p-2">Klinik</th>
                                            <th class="p-2">Logistik/Distribusi</th>
                                            <th class="p-2">USP</th>
                                            <th class="p-2">Usaha Lain</th>
                                            <th class="p-2">Sudah</th>
                                            <th class="p-2">Belum</th>
                                            <th class="p-2">Jumlah Anggota Awal</th>
                                            <th class="p-2">Penambahan Anggota</th>



                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
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
                                            <th>17</th>
                                            <th>18</th>
                                            <th>19</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reportThrees as $index => $r)
                                            <tr class="text-center">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $r['district'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td> {{-- jika KDKMP sama dengan jumlah desa --}}

                                                {{-- Profile Update --}}
                                                <td>{{ $r['profile_update_yes'] }}</td>
                                                <td>{{ $r['profile_update_no'] }}</td>

                                                {{-- Potential Village --}}
                                                <td>{{ $r['village_potential_yes'] }}</td>
                                                <td>{{ $r['village_potential_no'] }}</td>

                                                <td>{{ $r['grocery_outlet'] }}</td>
                                                <td>{{ $r['pharmacy_outlet'] }}</td>
                                                <td>{{ $r['warehousing_outlet'] }}</td>
                                                <td>{{ $r['clinic_outlet'] }}</td>
                                                <td>{{ $r['logistics_outlet'] }}</td>
                                                <td>{{ $r['usp_outlet'] }}</td>
                                                <td>{{ $r['other_businesses_outlet'] }}</td>

                                                {{-- RAT --}}
                                                <td>{{ $r['rat_yes'] }}</td>
                                                <td>{{ $r['rat_no'] }}</td>

                                                <td>{{ $r['initial_membership'] }}</td>
                                                <td>{{ $r['addition_of_members'] }}</td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                    {{-- Form 4  --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-700">Laporan Mendorong terbangunnya
                                    kemitraan Koperasi Desa/Kelurahan Merah Putih dalam rangka penguatan dan
                                    pengembangan
                                    usaha
                                </h3>
                            </div>

                            <div class="p-6 overflow-x-auto">

                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th rowspan="2" class="p-2">No.</th>
                                            <th rowspan="2" class="p-2">Nama Kecamatan</th>
                                            <th rowspan="2" class="p-2">Jumlah Desa/Kelurahan</th>
                                            <th rowspan="2" class="p-2">Jumlah KDKMP</th>
                                            <th colspan="2" class="p-2">Calon Mitra /
                                                Mitra </th>
                                            <th rowspan="2" class="p-2">Pola
                                                Kemitraan
                                                /Kerja
                                                Sama
                                            </th>
                                            <th rowspan="2" class="p-2">Komoditas
                                            </th>
                                            <th rowspan="2" class="p-2">Kapasitas
                                            </th>
                                            <th colspan="3" class="p-2">Status Kemitraan
                                            </th>
                                            <th colspan="2" class="p-2">Output (PKS/Kesepakatan)
                                            </th>

                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
                                            <th class="p-2">BUMN</th>
                                            <th class="p-2">
                                                Non
                                                BUMN</th>
                                            <th class="p-2">Pengajuan</th>
                                            <th class="p-2">Proses</th>
                                            <th class="p-2">Perjanjian/
                                                Perintah Kerja</th>
                                            <th class="p-2">Ada</th>
                                            <th class="p-2">Tidak</th>



                                        </tr>
                                        <tr class="bg-blue-600 text-white text-center">
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


                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($reportFours as $index => $r)
                                            <tr class="text-center">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $r['district'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td>
                                                <td>{{ $r['total_villages'] }}</td> {{-- jika KDKMP sama dengan jumlah desa --}}

                                                {{-- Kesiapan Lahan --}}
                                                <td>{{ $r['potential_partners_bumn'] }}</td>
                                                <td>{{ $r['potential_partners_non_bumn'] }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ $r['partnership_status_no'] }}</td>
                                                <td>{{ $r['partnership_status_on'] }}</td>
                                                <td>{{ $r['partnership_status_yes'] }}</td>

                                                <td>{{ $r['output_yes'] }}</td>
                                                <td>{{ $r['output_no'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                    {{-- Form Delapan --}}
                    <div class="shadow overflow-hidden sm-rounded-md mt-5">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <table id="formEight" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>Nama BA</th>
                                        <th>Kecamatan</th>
                                        <th>Nama KDKMP</th>
                                        <th>Kesiapan Lokasi/Lahan</th>
                                        <th>Pembangunan Gerai</th>
                                        <th>Kendaraan</th>
                                        <th>Meja & Kursi</th>
                                        <th>Etalase</th>
                                        <th>Komputer</th>
                                        <th>Kendala</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Form Sembilan --}}
                    <div class="shadow overflow-hidden sm-rounded-md mt-5">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <table id="formNine" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>Nama BA</th>
                                        <th>Kecamatan</th>
                                        <th>Nama KDKMP</th>

                                        <th>Status Gerai</th>
                                        <th>Jumlah Karyawan 2025</th>
                                        <th>Jumlah Karyawan 2026</th>
                                        <th>Panduan Operasional Gerai</th>
                                        <th>Kendala</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Form sepuluh --}}
                    <div class="shadow overflow-hidden sm-rounded-md mt-5">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <table id="formTen" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>Nama BA</th>
                                        <th>Kecamatan</th>
                                        <th>Nama KDKMP</th>
                                        <th>Update Profil KDKMP</th>
                                        <th>Potensi Desa</th>
                                        <th>Gerai Sembako</th>
                                        <th>Gerai Apotek</th>
                                        <th>Gerai Pergudangan</th>
                                        <th>Gerai Klinik</th>
                                        <th>Gerai Logistik</th>
                                        <th>Gerai USP</th>
                                        <th>Gerai Usaha Lain</th>
                                        <th>RAT</th>
                                        <th>Jumlah Anggota Awal</th>
                                        <th>Penambahan Anggota</th>
                                        <th>Kendala</th>
                                        <th>Keterangan</th>
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
