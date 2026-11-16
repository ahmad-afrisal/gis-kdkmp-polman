<x-app-layout>

    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>
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


        <x-slot name="script">
            <script>
                var datatable = $('#crudTable').DataTable({
                    responsive: true, // <--- aktifkan fitur ini
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
                            data: 'bh_deed',
                            name: 'bh_deed',
                        },
                        {
                            data: 'cooperative_nik',
                            name: 'cooperative_nik',
                        },
                        {
                            data: 'nib',
                            name: 'nib',
                        },
                        {
                            data: 'npwp',
                            name: 'npwp',
                        },
                        {
                            data: 'cooperative_bank_account',
                            name: 'cooperative_bank_account',
                        },
                        {
                            data: 'business_activity_plan',
                            name: 'business_activity_plan',
                        },
                        {
                            data: 'capex',
                            name: 'capex',
                        },
                        {
                            data: 'opex',
                            name: 'opex',
                        },
                        {
                            data: 'other_equipment',
                            name: 'other_equipment',
                        }



                    ]
                });
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
                        <span class="text-gray-500">Kelengkapan Administrasi</span>
                    </nav>


                    <!-- Grid untuk 3 Chart -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-10">


                        <!-- CARD 6 - Financing -->
                        {{-- <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Proposal Bisnis</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartFinancingProposal"></canvas>
                            </div>
                        </div> --}}

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


                        <!-- CARD 1 - NIB -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kepemilikan NIB</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartNIB"></canvas>
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

                        {{-- <!-- CARD 5 - Business Plan -->
                        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center">
                            <h3 class="text-lg font-semibold mb-4">Kelengkapan Lain</h3>
                            <div class="w-48 h-48">
                                <canvas id="chartOtherEquipment"></canvas>
                            </div>
                        </div> --}}

                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mt-5  mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Kepemilikan NIB berdasakan BA</h2>
                        <div class="h-[220px]">
                            <canvas id="nibChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mt-5  mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Kepemilikan NPWP berdasakan BA</h2>
                        <div class="h-[220px]">
                            <canvas id="npwpChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mt-5  mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Kepemilikan Rekening Bank berdasakan BA</h2>
                        <div class="h-[220px]">
                            <canvas id="bankChart"></canvas>
                        </div>
                    </div>


                    <div class="bg-white shadow-lg rounded-2xl mt-5  mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Kepemilikan Rencana Bisnis berdasakan BA
                        </h2>
                        <div class="h-[220px]">
                            <canvas id="businessPlanChart"></canvas>
                        </div>
                    </div>


                    <div class="bg-white shadow-lg rounded-2xl mt-5  mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Kepemilikan Belanja Modal (Capex) berdasakan
                            BA</h2>
                        <div class="h-[220px]">
                            <canvas id="capexChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-2xl mt-5  mb-5 p-5 min-h-[280px]">
                        <h2 class="text-center font-semibold mb-2">Jumlah Kepemilikan Belanja Operasional (Opex)
                            berdasakan BA</h2>
                        <div class="h-[220px]">
                            <canvas id="opexChart"></canvas>
                        </div>
                    </div>


                    <a href="{{ route('dashboard.form-three.export') }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Export Excel
                    </a>

                    <div class="shadow overflow-hidden sm-rounded-md">

                        <div class="px-4 py-5 mt-5 bg-white sm:p-6">

                            <table id="crudTable" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kecamatan</th>
                                        <th>BA</th>
                                        <th>KDKMP</th>
                                        <th>AKTA BH</th>
                                        <th>NIK Koperasi</th>
                                        <th>NIB</th>
                                        <th>NPWP</th>
                                        <th>Rekening Bank</th>
                                        <th>Rencana Kegiatan Bisnis</th>
                                        <th>Belanja Modal (Capex)</th>
                                        <th>Belanja Operasional (Opex)</th>
                                        <th>Kelengkapan Lain</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>






                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

                    <script>
                        Chart.register(ChartDataLabels);
                        // Data dari database
                        const totalDesa = {{ $totalDesa }};
                        const desaNIB = {{ $desaNIB }};
                        const desaBelumNIB = {{ $desaBelumNIB }};


                        const bhDeedYes = {{ $bhDeedYes }};
                        const bhDeedNo = {{ $bhDeedNo }};

                        const cooperativeNikYes = {{ $cooperativeNikYes }};
                        const cooperativeNikNo = {{ $cooperativeNikNo }};

                        const capexYes = {{ $capexYes }};
                        const capexNo = {{ $capexNo }};

                        const opexYes = {{ $opexYes }};
                        const opexNo = {{ $opexNo }};

                        const otherEquipmentYes = {{ $otherEquipmentYes }};
                        const otherEquipmentNo = {{ $otherEquipmentNo }};


                        const npwpYa = {{ $npwpYa }};
                        const npwpTidak = {{ $npwpTidak }};
                        const bankYa = {{ $bankYa }};
                        const bankTidak = {{ $bankTidak }};
                        const businessPlanYes = {{ $businessPlanYes }};
                        const businessPlanNo = {{ $businessPlanNo }};
                        const financingProposalYes = {{ $financingProposalYes }};
                        const financingProposalNo = {{ $financingProposalNo }};


                        const nibLabels = @json($nibLabels);
                        const nibValues = @json($nibValues);

                        new Chart(document.getElementById('nibChart'), {
                            type: 'bar',
                            data: {
                                labels: nibLabels,
                                datasets: [{
                                    label: 'Jumlah NIB',
                                    data: nibValues,
                                    backgroundColor: ["#36A2EB"]

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

                        const npwpLabels = @json($npwpLabels);
                        const npwpValues = @json($npwpValues);

                        new Chart(document.getElementById('npwpChart'), {
                            type: 'bar',
                            data: {
                                labels: npwpLabels,
                                datasets: [{
                                    label: 'Jumlah NPWP',
                                    data: npwpValues,
                                    backgroundColor: ["#FF9800"]

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


                        const bankLabels = @json($bankLabels);
                        const bankValues = @json($bankValues);

                        new Chart(document.getElementById('bankChart'), {
                            type: 'bar',
                            data: {
                                labels: bankLabels,
                                datasets: [{
                                    label: 'Jumlah Rekening Bank',
                                    data: bankValues,
                                    backgroundColor: ["#C0692B"]

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

                        const businessPlanLabels = @json($businessPlanLabels);
                        const businessPlanValues = @json($businessPlanValues);

                        new Chart(document.getElementById('businessPlanChart'), {
                            type: 'bar',
                            data: {
                                labels: businessPlanLabels,
                                datasets: [{
                                    label: 'Jumlah Business Plan',
                                    data: businessPlanValues,
                                    backgroundColor: ["#B4DF9E"]

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


                        const capexLabels = @json($capexLabels);
                        const capexValues = @json($capexValues);

                        new Chart(document.getElementById('capexChart'), {
                            type: 'bar',
                            data: {
                                labels: capexLabels,
                                datasets: [{
                                    label: 'Jumlah CAPEX',
                                    data: capexValues,
                                    backgroundColor: ["#eB654B"]

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

                        const opexLabels = @json($opexLabels);
                        const opexValues = @json($opexValues);

                        new Chart(document.getElementById('opexChart'), {
                            type: 'bar',
                            data: {
                                labels: opexLabels,
                                datasets: [{
                                    label: 'Jumlah opex',
                                    data: opexValues,
                                    backgroundColor: ["#D4DF9E"]

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

                        });

                        // Chart 1 - Akta BH
                        new Chart(document.getElementById("chartBhDeed"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [bhDeedYes, bhDeedNo],
                                    backgroundColor: ["#B3FFFC", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        new Chart(document.getElementById("chartCooperativeNik"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [cooperativeNikYes, cooperativeNikNo],
                                    backgroundColor: ["#FF4242", "#E0E0E0"]
                                }]
                            },
                            options,

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

                        });

                        // Chart 4 - Rekening Bank
                        new Chart(document.getElementById("chartRekeningBank"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [bankYa, bankTidak],
                                    backgroundColor: ["#C0392B", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank
                        new Chart(document.getElementById("chartBusinessPlan"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [businessPlanYes, businessPlanNo],
                                    backgroundColor: ["#30321C", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank
                        new Chart(document.getElementById("chartFinancingProposal"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [financingProposalYes, financingProposalNo],
                                    backgroundColor: ["#4A4B2F", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank
                        new Chart(document.getElementById("chartCapex"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [capexYes, capexNo],
                                    backgroundColor: ["#6B654B", "#E0E0E0"]
                                }]
                            },
                            options,

                        });

                        // Chart 5 - Rekening Bank
                        new Chart(document.getElementById("chartOpex"), {
                            type: "doughnut",
                            data: {
                                labels: ["Sudah Memiliki", "Belum"],
                                datasets: [{
                                    data: [opexYes, opexNo],
                                    backgroundColor: ["#D4DF9E", "#E0E0E0"]
                                }]
                            },
                            options,

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

                        });
                    </script>




                </div>
            </div>
        </main>
    </div>
</x-app-layout>
