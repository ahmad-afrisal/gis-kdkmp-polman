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
            {{ __('Dashboard') }}
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Card Petani -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">Jumlah Kecamatan</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $districtCount }}</div>
                    </div>
                    <div class="text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A9 9 0 1118.364 4.561 9 9 0 015.121 17.804zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Card Jenis Sawit -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">Jumlah Desa/Keluarahan</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $villageCount }}</div>
                    </div>
                    <div class="text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2c1.657 0 3 1.79 3 4h-6c0-2.21 1.343-4 3-4zm-7 8c1.657 0 3-1.79 3-4H2c0 2.21 1.343 4 3 4zm14 0c1.657 0 3-1.79 3-4h-6c0 2.21 1.343 4 3 4zm-7 2c-3.866 0-7 2.91-7 6.5V22h14v-3.5c0-3.59-3.134-6.5-7-6.5z" />
                        </svg>
                    </div>
                </div>

                <!-- Card Banyak Lahan -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">Bussiness Asisstant</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $bussinessAssistantCount }}</div>
                    </div>
                    <div class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 01.553-1.382L9 2m0 18l6 2m-6-2V2m6 20l5.447-2.724A2 2 0 0021 17.618V7.382a2 2 0 00-.553-1.382L15 2m0 20V2m0 0L9 2" />
                        </svg>
                    </div>
                </div>

                <!-- Card Banyak Lahan -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">Jumlah Koperasi</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $cooperationCount }}</div>
                    </div>
                    <div class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 01.553-1.382L9 2m0 18l6 2m-6-2V2m6 20l5.447-2.724A2 2 0 0021 17.618V7.382a2 2 0 00-.553-1.382L15 2m0 20V2m0 0L9 2" />
                        </svg>
                    </div>
                </div>

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

            </div>


            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

            <script>
                // --- Data Chart ---
                const totalDesa = 167;

                // NIB
                const desaNIB = 50;
                const desaBelumNIB = totalDesa - desaNIB;

                // SIMKOPDES
                const simkopdesYa = 167;
                const simkopdesTidak = 0;

                // NPWP
                const npwpYa = 79;
                const npwpTidak = totalDesa - npwpYa;

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
                    plugins: [ChartDataLabels]
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
                    plugins: [ChartDataLabels]
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
                    plugins: [ChartDataLabels]
                });
            </script>




            <!-- Peta Semua Lahan -->
            <div id="map"></div>
        </div>
    </div>
</x-app-layout>
