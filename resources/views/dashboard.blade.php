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

                <!-- CARD 4 - Rekening Bank -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                    <h3 class="text-lg font-semibold mb-4">Rekening Bank</h3>
                    <div class="w-48 h-48">
                        <canvas id="chartRekeningBank"></canvas>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

                    <div class="px-6 py-4 border-b bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-700">Laporan Rekapitulasi KDKMP Berdasarkan
                            Kabupaten/Kota</h3>
                    </div>

                    <div class="p-6 overflow-x-auto">

                        <table class="w-full border-collapse text-sm">
                            <thead>
                                <tr class="bg-blue-600 text-white text-center">
                                    <th class="p-2">No.</th>
                                    <th class="p-2">Nama Kecamatan</th>
                                    <th class="p-2">Jumlah Desa/Kelurahan</th>
                                    <th class="p-2">Jumlah KDKMP</th>
                                    <th class="p-2">Jumlah SK AHU Koperasi</th>
                                    <th class="p-2">Jumlah NIB</th>
                                    <th class="p-2">Jumlah NIK</th>
                                </tr>
                                <tr class="bg-blue-500 text-white text-center">
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                    <th>7</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reportOnes as $index => $r)
                                    <tr class="text-center border-b">
                                        <td class="p-2">{{ $index + 1 }}</td>
                                        <td class="p-2">{{ $r['district'] }}</td>
                                        <td class="p-2">{{ $r['total_villages'] }}</td>
                                        <td class="p-2">{{ $r['total_kdkmp'] }}</td>
                                        <td class="p-2">{{ $r['total_sk_ahu'] }}</td>
                                        <td class="p-2">{{ $r['total_nib'] }}</td>
                                        <td class="p-2">{{ $r['total_nik'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

                    <div class="px-6 py-4 border-b bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-700">Laporan Rekapitulasi Bisnis Proses KDKMP</h3>
                    </div>

                    <div class="p-6 overflow-x-auto">

                        <table class="w-full border-collapse text-sm">
                            <thead>
                                <tr class="bg-blue-600 text-white text-center">
                                    <th rowspan="3" class="p-2">No.</th>
                                    <th rowspan="3" class="p-2">Nama Kecamatan</th>
                                    <th rowspan="3" class="p-2">Jumlah Desa/Kelurahan</th>
                                    <th rowspan="3" class="p-2">Jumlah KDKMP</th>
                                    <th colspan="12" class="p-2">Jumlah Gerai</th>

                                </tr>
                                <tr class="bg-blue-600 text-white text-center">
                                    <th colspan="2" class="p-2">Gerai Sembako</th>
                                    <th colspan="2" class="p-2">Gerai Apotik</th>
                                    <th colspan="2" class="p-2">Gerai Klinik</th>
                                    <th colspan="2" class="p-2">Gerai Simpan Pinjam</th>
                                    <th colspan="2" class="p-2">Gerai Pergudangan</th>
                                    <th colspan="2" class="p-2">Gerai Usaha Lain</th>
                                </tr class="bg-blue-600 text-white text-center">
                                <tr>
                                    <th class="p-2">Ada Rencana Bisnis</th>
                                    <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                    <th class="p-2">Ada Rencana Bisnis</th>
                                    <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                    <th class="p-2">Ada Rencana Bisnis</th>
                                    <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                    <th class="p-2">Ada Rencana Bisnis</th>
                                    <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                    <th class="p-2">Ada Rencana Bisnis</th>
                                    <th class="p-2">Tidak Ada Rencana Bisnis</th>
                                    <th class="p-2">Ada Rencana Bisnis</th>
                                    <th class="p-2">Tidak Ada Rencana Bisnis</th>

                                </tr>
                                <tr class="bg-blue-500 text-white text-center">
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
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reportTwos as $index => $r)
                                    <tr class="text-center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $r['district'] }}</td>
                                        <td>{{ $r['total_villages'] }}</td>
                                        <td>{{ $r['total_villages'] }}</td> {{-- jika KDKMP sama dengan jumlah desa --}}

                                        <td>{{ $r['basic_yes'] }}</td>
                                        <td>{{ $r['basic_no'] }}</td>

                                        <td>{{ $r['pharmacy_yes'] }}</td>
                                        <td>{{ $r['pharmacy_no'] }}</td>

                                        <td>{{ $r['clinic_yes'] }}</td>
                                        <td>{{ $r['clinic_no'] }}</td>

                                        <td>{{ $r['loan_yes'] }}</td>
                                        <td>{{ $r['loan_no'] }}</td>

                                        <td>{{ $r['logistics_yes'] }}</td>
                                        <td>{{ $r['logistics_no'] }}</td>

                                        <td>{{ $r['other_yes'] }}</td>
                                        <td>{{ $r['other_no'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

                    <div class="px-6 py-4 border-b bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-700">Laporan Rekapitulasi Gerai Koperasi KDKMP Yang
                            Sudah Berjalan </h3>
                    </div>

                    <div class="p-6 overflow-x-auto">

                        <table class="w-full border-collapse text-sm" border="1">
                            <thead>
                                <tr class="bg-blue-600 text-white text-center">
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Nama Kecamatan</th>
                                    <th rowspan="2">Jumlah Desa/Kelurahan</th>
                                    <th rowspan="2">Jumlah KDKMP</th>
                                    <th rowspan="2">Nama Gerai</th>
                                    <th colspan="4">Volume Gerai</th>
                                </tr>

                                <tr class="bg-blue-500 text-white text-center">
                                    <th>Jumlah Omset</th>
                                    <th>Jumlah Aset</th>
                                    <th>Jumlah Laba</th>
                                    <th>Jumlah Rugi</th>
                                </tr>

                                <tr class="bg-blue-500 text-white text-center">
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th>6</th>
                                    <th>7</th>
                                    <th>8</th>
                                    <th>9</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reportThrees as $index => $r)
                                    @foreach ($r['rows'] as $rowIndex => $row)
                                        <tr class="text-center">

                                            @if ($rowIndex == 0)
                                                <td rowspan="6">{{ $index + 1 }}</td>
                                                <td rowspan="6">{{ $r['district'] }}</td>
                                                <td rowspan="6">{{ $r['total_villages'] }}</td>
                                                <td rowspan="6">{{ $r['total_kdkmp'] }}</td>
                                            @endif

                                            <td class="text-left px-2">{{ $row['branch_type'] }}</td>
                                            <td>{{ number_format($row['business_volume']) }}</td>
                                            <td>{{ number_format($row['total_assets']) }}</td>
                                            <td>{{ number_format($row['profit']) }}</td>
                                            <td>{{ number_format($row['loss']) }}</td>

                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="font-bold">
                                    <td colspan="5" class="text-center">TOTAL</td>

                                    <td>{{ number_format($reportThrees->flatMap->rows->sum('business_volume')) }}</td>
                                    <td>{{ number_format($reportThrees->flatMap->rows->sum('total_assets')) }}</td>
                                    <td>{{ number_format($reportThrees->flatMap->rows->sum('profit')) }}</td>
                                    <td>{{ number_format($reportThrees->flatMap->rows->sum('loss')) }}</td>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">

                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">

                    <div class="px-6 py-4 border-b bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-700">Laporan Rekapitulasi Gerai Koperasi KDKMP Yang
                            Sudah Berjalan </h3>
                    </div>

                    <div class="p-6 overflow-x-auto">

                        <table class="w-full border-collapse text-sm">
                            <thead>
                                <tr class="bg-blue-600 text-white text-center">
                                    <th rowspan="3" class="p-2">No.</th>
                                    <th rowspan="3" class="p-2">Nama Kecamatan</th>
                                    <th rowspan="3" class="p-2">Jumlah Desa/Kelurahan</th>
                                    <th rowspan="3" class="p-2">Jumlah KDKMP</th>
                                    <th colspan="6" class="p-2">Jumlah Yang Sudah Berjalan</th>

                                </tr>
                                <tr class="bg-blue-600 text-white text-center">
                                    <th class="p-2">Gerai Sembako</th>
                                    <th class="p-2">Gerai Apotik</th>
                                    <th class="p-2">Gerai Klinik</th>
                                    <th class="p-2">Gerai Simpan Pinjam</th>
                                    <th class="p-2">Gerai Pergudangan</th>
                                    <th class="p-2">Gerai Usaha Lain</th>
                                </tr class="bg-blue-600 text-white text-center">
                                <tr>
                                    <th class="p-2"></th>
                                    <th class="p-2"></th>
                                    <th class="p-2"></th>
                                    <th class="p-2"></th>
                                    <th class="p-2"></th>
                                    <th class="p-2"></th>
                                </tr>
                                <tr class="bg-blue-500 text-white text-center">
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

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($reportFours as $index => $r)
                                    <tr class="text-center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $r['district'] }}</td>
                                        <td>{{ $r['total_villages'] }}</td>
                                        <td>{{ $r['total_villages'] }}</td> {{-- jika KDKMP sama dengan jumlah desa --}}

                                        <td>{{ $r['basic_yes'] }}</td>

                                        <td>{{ $r['pharmacy_yes'] }}</td>

                                        <td>{{ $r['clinic_yes'] }}</td>

                                        <td>{{ $r['loan_yes'] }}</td>

                                        <td>{{ $r['logistics_yes'] }}</td>

                                        <td>{{ $r['other_yes'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>



            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

            <script>
                // Data dari database
                const totalDesa = {{ $totalDesa }};
                const desaNIB = {{ $desaNIB }};
                const desaBelumNIB = {{ $desaBelumNIB }};
                const simkopdesYa = {{ $simkopdesYa }};
                const simkopdesTidak = {{ $simkopdesTidak }};
                const npwpYa = {{ $npwpYa }};
                const npwpTidak = {{ $npwpTidak }};
                const bankYa = {{ $bankYa }};
                const bankTidak = {{ $bankTidak }};


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

                // Chart 4 - Rekening Bank 
                new Chart(document.getElementById("chartRekeningBank"), {
                    type: "doughnut",
                    data: {
                        labels: ["Sudah Memiliki", "Belum"],
                        datasets: [{
                            data: [bankYa, bankTidak],
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
