<x-app-layout>
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

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance') }}
        </h2>
    </x-slot>

    <x-slot name="script">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- CARD NAME-->
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                <h3 class="text-lg font-semibold mb-4">{{ $bussinessAssistant->name }}</h3>

            </div>

            <!-- CARD NAME-->
            <div class="bg-white shadow-md rounded-lg p-6 mt-3 flex flex-col items-center">
                <h3 class="text-lg font-semibold mb-4">Jumlah Anggota : {{ $totalMembers }}</h3>

            </div>
            <div class="bg-white shadow-md rounded-lg p-6 mt-3 flex flex-col items-center">
                <h3 class="text-lg font-semibold mb-4">KPI : {{ $kpi }}
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-3">

                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold text-center">
                        1. Kelengkapan SIMKOPDES
                    </h3>
                    <p class="text-2xl font-bold mt-2">
                        {{ $finalScoreSimkopdesCompleteness }}
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold text-center">
                        2. Dokumen Rencana Bisnis
                    </h3>
                    <p class="text-2xl font-bold mt-2">
                        {{ $finalScoreBusinessActivityPlan }}
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold text-center">
                        3. Dokumen Adminstrasi
                    </h3>
                    <p class="text-2xl font-bold mt-2">
                        {{ $finalScoreDocument }}
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold text-center">
                        4. Proposal Bisnis
                    </h3>
                    <p class="text-2xl font-bold mt-2">
                        {{ $finalScoreFinancingProposal }}
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold text-center">
                        5. Laporan Operasional
                    </h3>
                    <p class="text-2xl font-bold mt-2">
                        5
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold text-center">
                        6. Pendataan Lahan
                    </h3>
                    <p class="text-2xl font-bold mt-2">
                        {{ $finalScoreLand }}
                    </p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold text-center">
                        7. Laporan Bulanan
                    </h3>
                    <p class="text-2xl font-bold mt-2">
                        {{ $finalScoreMonthlyReport }}
                    </p>
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
                    <h3 class="text-lg font-semibold mb-4">Proposal Bisnis</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartFinancingProposal"></canvas>
                    </div>
                </div>

                <!-- CARD 6 - Financing -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-4">Data Lahan</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartLand"></canvas>
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

                <!-- CARD 4 - Rekening Bank -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-4">Rekening Bank</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartRekeningBank"></canvas>
                    </div>
                </div>

                <!-- CARD 3 - NPWP -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-4">Kepemilikan NPWP</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartNPWP"></canvas>
                    </div>
                </div>


                <!-- CARD 1 - NIB -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-4">Kepemilikan NIB</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartNIB"></canvas>
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

            <div class="grid grid-cols-1  gap-6 mt-10">

                <!-- Line Chart Dokumen -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Perkembangan Anggota</h3>
                    <canvas id="baGrowthChart"></canvas>
                </div>

            </div>





            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

            <script>
                const cooperationCount = {{ $cooperationCount }};

                const landYes = {{ $landYes }};
                const landNo = {{ $cooperationCount - $landYes }};

                const bhDeedYes = {{ $bhDeedYes }};
                const bhDeedNo = {{ $cooperationCount - $bhDeedYes }};

                const cooperativeNikYes = {{ $cooperativeNikYes }};
                const cooperativeNikNo = {{ $cooperationCount - $cooperativeNikYes }};

                const nibYes = {{ $nibYes }};
                const nibNo = {{ $cooperationCount - $nibYes }};

                const simkopdesYes = {{ $simkopdesYes }};
                const simkopdesNo = {{ $cooperationCount - $simkopdesYes }};

                const npwpYes = {{ $npwpYes }};
                const npwpNo = {{ $cooperationCount - $npwpYes }};

                const cooperativeBankAccountYes = {{ $cooperativeBankAccountYes }};
                const cooperativeBankAccountNo = {{ $cooperationCount - $cooperativeBankAccountYes }};

                const businessAcitivtyPlanYes = {{ $businessAcitivtyPlanYes }};
                const businessAcitivtyPlanNo = {{ $cooperationCount - $businessAcitivtyPlanYes }};

                const capexYes = {{ $capexYes }};
                const capexNo = {{ $cooperationCount - $capexYes }};

                const opexYes = {{ $opexYes }};
                const opexNo = {{ $cooperationCount - $opexYes }};

                const otherEquipmentYes = {{ $otherEquipmentYes }};
                const otherEquipmentNo = {{ $cooperationCount - $otherEquipmentYes }};

                const financingProposalYes = {{ $financingProposalYes }};
                const financingProposalNo = {{ $cooperationCount - $financingProposalYes }};

                const simkopdesCompletenesYes = {{ $simkopdesCompletenesYes }};
                const simkopdesCompletenesNo = {{ $cooperationCount - $simkopdesCompletenesYes }};

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
                            data: [nibYes, nibNo],
                            backgroundColor: ["#36A2EB", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                // Chart 2 - SIMKOPDES
                new Chart(document.getElementById("chartSIMKOPDES"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [simkopdesYes, simkopdesNo],
                            backgroundColor: ["#4CAF50", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                new Chart(document.getElementById("chartLand"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [landYes, landNo],
                            backgroundColor: ["#4CAF50", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });


                new Chart(document.getElementById("chartBhDeed"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [bhDeedYes, bhDeedNo],
                            backgroundColor: ["#36A2EB", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                new Chart(document.getElementById("chartCooperativeNik"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [cooperativeNikYes, cooperativeNikNo],
                            backgroundColor: ["#36A2EB", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                // Chart 3 - NPWP
                new Chart(document.getElementById("chartNPWP"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [npwpYes, npwpNo],
                            backgroundColor: ["#FF9800", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                // Chart 4 - Rekening Bank 
                new Chart(document.getElementById("chartRekeningBank"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [cooperativeBankAccountYes, cooperativeBankAccountNo],
                            backgroundColor: ["#C0392B", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                // Chart 5 - Rekening Bank 
                new Chart(document.getElementById("chartBusinessPlan"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [businessAcitivtyPlanYes, businessAcitivtyPlanNo],
                            backgroundColor: ["#9B59B6", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                // Chart 5 - Rekening Bank 
                new Chart(document.getElementById("chartCapex"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [capexYes, capexNo],
                            backgroundColor: ["#9B59B6", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                // Chart 5 - Rekening Bank 
                new Chart(document.getElementById("chartOpex"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [opexYes, opexNo],
                            backgroundColor: ["#9B59B6", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
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
                    plugins: [ChartDataLabels]
                });

                // Chart 5 - Rekening Bank 
                new Chart(document.getElementById("chartFinancingProposal"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [financingProposalYes, financingProposalNo],
                            backgroundColor: ["#FF007F", "#E0E0E0"]
                        }]
                    },
                    options,
                    plugins: [ChartDataLabels]
                });

                // Chart 5 - Rekening Bank 
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
                    plugins: [ChartDataLabels]
                });

                // Line Chart Tren Anggota Koperasi


                const ctx = document.getElementById('baGrowthChart');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($periods),
                        datasets: @json($datasets)
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
</x-app-layout>
