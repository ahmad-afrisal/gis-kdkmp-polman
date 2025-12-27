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
        {{-- <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            var map = L.map('map').setView([-2.5489, 118.0149], 5);

            // Pake Esri Satellite (biar mirip Google Earth)
            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 20,
                attribution: 'Tiles © Esri — Source: Esri, Maxar, Earthstar Geographics'
            }).addTo(map);

            // Data lahan dari backend
            var lands = @json($lands);

            lands.forEach(function(land) {
                if (land.geojson) {
                    var geojson = JSON.parse(land.geojson);

                    var layer = L.geoJSON(geojson).addTo(map);

                    // Bikin popup info
                    var popupContent = `
                        <div class="text-sm">
                            <strong>Petani:</strong> ${land.user?.name ?? 'N/A'}<br>
                            <strong>Jenis Sawit:</strong> ${land.oil_palm_type?.name ?? 'N/A'}<br>
                            <strong>Luas:</strong> ${land.land_area} Ha<br>
                            <strong>Tahun Tanam:</strong> ${land.planting_year}
                        </div>
                    `;

                    layer.bindPopup(popupContent);
                }
            });
        </script> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- CARD NAME-->
            <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                <h3 class="text-lg font-semibold mb-4">{{ $bussinessAssistant->name }}</h3>

            </div>


            <!-- Grid untuk 3 Chart -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">

                <!-- CARD 1 - NIB -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-4">Kepemilikan NIB</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartNIB"></canvas>
                    </div>
                </div>

                <!-- CARD 2 - SIMKOPDES -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-4">Kepemilikan SIMKOPDES</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartSIMKOPDES"></canvas>
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

                <!-- CARD 6 - Financing -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-4">Proposal Bisnis</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartFinancingProposal"></canvas>
                    </div>
                </div>

            </div>





            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

            <script>
                const cooperationCount = {{ $cooperationCount }};
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

                const financingProposalYes = {{ $financingProposalYes }};
                const financingProposalNo = {{ $cooperationCount - $financingProposalYes }};

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
            </script>





            <!-- Peta Semua Lahan -->
            <div id="map"></div>
        </div>
    </div>
</x-app-layout>
