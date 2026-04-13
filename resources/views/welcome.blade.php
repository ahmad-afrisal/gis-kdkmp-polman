{{-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Wilayah Pendampingan</title>

    <script src="https://cdn.tailwindcss.com"></script>

 
</head>

<body class="bg-gray-50 min-h-screen">




</body>

</html> --}}

<x-guest-layout>

    <x-slot name="style">

        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
        <style>
            /*Form fields*/
            .dataTables_wrapper select,
            .dataTables_wrapper .dataTables_filter input {
                color: #4a5568;
                /*text-gray-700*/
                padding-left: 1rem;
                /*pl-4*/
                padding-right: 1rem;
                /*pl-4*/
                padding-top: .5rem;
                /*pl-2*/
                padding-bottom: .5rem;
                /*pl-2*/
                line-height: 1.25;
                /*leading-tight*/
                border-width: 2px;
                /*border-2*/
                border-radius: .25rem;
                border-color: #edf2f7;
                /*border-gray-200*/
                background-color: #edf2f7;
                /*bg-gray-200*/
            }

            /*Row Hover*/
            table.dataTable.hover tbody tr:hover,
            table.dataTable.display tbody tr:hover {
                background-color: #ebf4ff;
                /*bg-indigo-100*/
            }

            /*Pagination Buttons*/
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                font-weight: 700;
                /*font-bold*/
                border-radius: .25rem;
                /*rounded*/
                border: 1px solid transparent;
                /*border border-transparent*/
            }

            /*Pagination Buttons - Current selected */
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                color: #fff !important;
                /*text-white*/
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
                /*shadow*/
                font-weight: 700;
                /*font-bold*/
                border-radius: .25rem;
                /*rounded*/
                background: #667eea !important;
                /*bg-indigo-500*/
                border: 1px solid transparent;
                /*border border-transparent*/
            }

            /*Pagination Buttons - Hover */
            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                color: #fff !important;
                /*text-white*/
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
                /*shadow*/
                font-weight: 700;
                /*font-bold*/
                border-radius: .25rem;
                /*rounded*/
                background: #667eea !important;
                /*bg-indigo-500*/
                border: 1px solid transparent;
                /*border border-transparent*/
            }

            /*Add padding to bottom border */
            table.dataTable.no-footer {
                border-bottom: 1px solid #e2e8f0;
                /*border-b-1 border-gray-300*/
                margin-top: 0.75em;
                margin-bottom: 0.75em;
            }

            /*Change colour of responsive icon*/
            table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
            table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
                background-color: #667eea !important;
                /*bg-indigo-500*/
            }

            #map {
                width: 100%;
                height: 600px;
                border-radius: 12px;
                overflow: hidden;
            }

            /* Style untuk efek shadow pada card tim, menyesuaikan dengan gambar */
            .team-card {
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .team-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            /* Untuk memastikan font header mirip dengan gambar (gunakan default serif) */
            .team-header {
                font-size: 2.25rem;
                font-weight: 900;
                font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
            }
        </style>

    </x-slot>

    <x-slot name="script">
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

        <script>
            // ==== INISIALISASI PETA ====
            var map = L.map('map').setView([-3.4126, 119.3435], 10);

            // ==== BASEMAPS ====
            var googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            var googleStreets = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            });

            var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            });

            var baseMaps = {
                "OpenStreetMap": osm,
                "Google Streets": googleStreets,
                "Google Hybrid": googleHybrid,
            };

            // ==== DATA DARI BACKEND ====
            var cooperations = @json($locations);
            var villages = @json($villages);
            var districts = @json($districts);

            // ==== LAYER SEBARAN KOPERASI ====
            var coopLayer = L.layerGroup();

            var customIcon = L.icon({
                iconUrl: '/images/icon-marker.png',
                iconSize: [80, 60],
                iconAnchor: [40, 60],
                popupAnchor: [0, -32]
            });

            cooperations.forEach(function(coop) {
                if (coop.latitude && coop.longtitude) {
                    var lat = parseFloat(coop.latitude);
                    var lng = parseFloat(coop.longtitude);
                    var mapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;
                    var imageUrl = 'https://placehold.co/600x400.png';

                    var popupContent = `
                <div class="max-w-[260px] bg-white shadow-lg rounded-xl overflow-hidden">
                    <img src="${imageUrl}" alt="${coop.name}" class="w-full h-32 object-cover">
                    <div class="p-3 max-h-48 overflow-y-auto">
                        <h3 class="text-lg font-semibold mb-1">${coop.name}</h3>
                        <p class="text-sm text-gray-600 mb-1"><b>Ketua:</b> ${coop.leader_name ?? '-'}</p>
                        <p class="text-sm text-gray-600 mb-1"><b>Alamat:</b> ${coop.full_address}</p>
                        <p class="text-sm text-gray-600 mb-1"><b>Telepon:</b> ${coop.legal_entity_number ?? '-'}</p>
                        <p class="text-sm text-gray-600 mb-1"><b>Email:</b> ${coop.email ?? '-'}</p>
                        <p class="text-sm text-gray-600 mb-1"><b>NIB:</b> ${coop.nib ? 'Ada' : 'Tidak Ada'}</p>
                        <div class="mt-2 flex justify-between">
                            <a href="${coop.subdomain}" target="_blank" class="text-blue-600 text-xs font-semibold hover:underline">Detail</a>
                            <a href="${mapsUrl}" target="_blank" class="text-green-600 text-xs font-semibold hover:underline">Kunjungi di Maps</a>
                        </div>
                    </div>
                </div>`;

                    L.marker([lat, lng], {
                            icon: customIcon
                        })
                        .bindPopup(popupContent)
                        .addTo(coopLayer);
                }
            });

            // ==== LAYER GEOJSON DESA ====
            var villageLayer = L.layerGroup();

            villages.forEach(function(v) {
                if (v.geojson) {
                    try {
                        var gj = JSON.parse(v.geojson);
                        var layer = L.geoJSON(gj, {
                            style: {
                                color: '#1E90FF',
                                weight: 1,
                                fillColor: '#ADD8E6',
                                fillOpacity: 0.3
                            }
                        }).bindPopup(`<strong>${v.type} ${v.name}</strong>`);
                        layer.addTo(villageLayer);
                    } catch (e) {
                        console.error("GeoJSON tidak valid untuk desa:", v.name);
                    }
                }
            });

            // ==== LAYER GEOJSON KECAMATAN ====
            var districtLayer = L.layerGroup();

            districts.forEach(function(d) {
                if (d.geojson) {
                    try {
                        var gj = JSON.parse(d.geojson);
                        var layer = L.geoJSON(gj, {
                            style: {
                                color: '#FF6600',
                                weight: 2,
                                fillColor: '#FFA500',
                                fillOpacity: 0.1
                            }
                        }).bindPopup(`<strong>Kecamatan ${d.name}</strong>`);
                        layer.addTo(districtLayer);
                    } catch (e) {
                        console.error("GeoJSON tidak valid untuk kecamatan:", d.name);
                    }
                }
            });

            // ==== TAMBAHKAN KE PETA ====
            coopLayer.addTo(map);
            // villageLayer.addTo(map);
            // districtLayer.addTo(map);

            // ==== CONTROL LAYERS ====
            var overlayMaps = {
                "Sebaran Koperasi": coopLayer,
                "Batas Desa": villageLayer,
                "Batas Kecamatan": districtLayer
            };

            L.control.layers(baseMaps, overlayMaps, {
                collapsed: false
            }).addTo(map);

            // ==== FIT BOUNDS ====
            var validCoords = cooperations
                .filter(c => c.latitude && c.longtitude)
                .map(c => [parseFloat(c.latitude), parseFloat(c.longtitude)]);

            if (validCoords.length > 0) {
                map.fitBounds(L.latLngBounds(validCoords));
            } else {
                map.setView([-3.4126, 119.3435], 10);
            }

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
                        data: 'name',
                        name: 'name',
                    },


                ]
            })
        </script>
    </x-slot>
    <!-- HERO SECTION -->
    <section
        class="relative min-h-screen flex items-center justify-center overflow-hidden
           bg-gradient-to-br from-green-50 via-green-100 to-green-50">

        <!-- CLOUD PATTERN -->
        <div
            class="absolute inset-0 bg-[radial-gradient(white_2px,transparent_2px)]
               [background-size:120px_120px] opacity-30">
        </div>

        <!-- CLOUD SHAPES -->
        <div class="absolute top-20 left-10 w-96 h-40 bg-white rounded-full blur-3xl opacity-40"></div>
        <div class="absolute bottom-32 right-10 w-96 h-40 bg-white rounded-full blur-3xl opacity-30"></div>
        <div class="absolute top-1/2 left-1/3 w-72 h-32 bg-white rounded-full blur-3xl opacity-20"></div>

        <!-- CONTENT -->
        <div class="relative z-10 text-center px-6 max-w-4xl">

            <!-- LOGO + TAGLINE -->
            <div class="inline-flex items-center gap-4 bg-white px-2 py-2 rounded-full shadow-md mb-8">
                <img src="/images/logo.png" alt="Logo KDKMP" class="rounded-full w-10 h-10 object-contain">
                <div class="text-left">
                    <p class="text-sm font-semibold text-gray-700">
                        Menguatkan Koperasi, Menyongsong Masa Depan
                    </p>

                </div>
            </div>

            <!-- MAIN TITLE -->
            <h1 class="text-4xl md:text-6xl font-extrabold text-green-800 mb-4 leading-tight">
                COMMAND CENTER KDKMP
            </h1>

            <!-- SUB TITLE -->
            <h2 class="text-xl md:text-2xl font-semibold text-green-700 mb-6">
                Kabupaten Polewali Mandar
            </h2>

            <!-- DESCRIPTION -->
            <p class="text-green-800/80 max-w-2xl mx-auto text-lg leading-relaxed">
                Sistem pusat kendali digital untuk memantau, menganalisis, dan
                memvisualisasikan perkembangan Koperasi Desa/Kelurahan Merah Putih
                secara terpadu, akurat, dan berbasis data.
            </p>

        </div>
    </section>


    <!-- FLOATING STATS CARD -->
    <div class="relative z-30 -mt-24 px-6">
        <div
            class="max-w-5xl mx-auto bg-white rounded-3xl shadow-xl
               grid grid-cols-2 md:grid-cols-4 gap-6 py-8 px-6">

            <!-- ITEM -->
            <div class="text-center">
                <p class="text-4xl font-extrabold text-green-700">23</p>
                <p class="text-sm font-semibold text-gray-600 mt-1">KKMP</p>
            </div>

            <div class="text-center">
                <p class="text-4xl font-extrabold text-green-700">144</p>
                <p class="text-sm font-semibold text-gray-600 mt-1">KDMP</p>
            </div>

            <div class="text-center">
                <p class="text-4xl font-extrabold text-green-700">17</p>
                <p class="text-sm font-semibold text-gray-600 mt-1">BA</p>
            </div>

            <div class="text-center">
                <p class="text-4xl font-extrabold text-green-700">167</p>
                <p class="text-sm font-semibold text-gray-600 mt-1">
                    Desa / Kelurahan
                </p>
            </div>

        </div>
    </div>




    {{-- <section class="relative py-32 overflow-hidden">

        <!-- dotted background -->
        <div
            class="absolute inset-0 bg-[radial-gradient(#c7d2fe_1px,transparent_1px)] [background-size:20px_20px] opacity-40">
        </div>

        <div class="relative max-w-7xl mx-auto flex items-center justify-between px-10">

            <!-- LEFT CARD -->
            <div class="bg-white rounded-2xl shadow-xl p-6 w-72">
                <h3 class="text-sm font-semibold text-gray-600 mb-4">Your Customers</h3>
                <div class="grid grid-cols-3 gap-3">
                    <img class="rounded-xl" src="https://i.pravatar.cc/100?img=1" />
                    <img class="rounded-xl" src="https://i.pravatar.cc/100?img=2" />
                    <img class="rounded-xl" src="https://i.pravatar.cc/100?img=3" />
                    <img class="rounded-xl" src="https://i.pravatar.cc/100?img=4" />
                    <img class="rounded-xl" src="https://i.pravatar.cc/100?img=5" />
                    <div class="rounded-xl bg-gray-100"></div>
                </div>
            </div>

            <!-- CENTER FLOW -->
            <div class="relative flex flex-col items-center">
                <div class="flex items-center space-x-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">🎧</div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">🤖</div>
                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">📊</div>
                </div>

                <div class="my-6 px-6 py-2 rounded-full bg-blue-600 text-white font-semibold shadow-lg">
                    TrustLine
                </div>

                <div class="w-32 h-px bg-blue-300"></div>
            </div>


            <!-- RIGHT CARD -->
            <div class="bg-white rounded-2xl shadow-xl p-6 w-full md:w-80">

                <h3 class="text-sm font-semibold text-gray-600 mb-6 text-center">
                    Your CX Team
                </h3>

                <!-- WRAPPER -->
                <div class="relative mx-auto w-full max-w-xs h-64 hidden md:block">

                    <!-- CENTER ICON -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center text-xl shadow">
                            🎯
                        </div>
                    </div>

                    <!-- TOP -->
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 text-center">
                        <img src="https://i.pravatar.cc/80?img=6" class="w-12 h-12 rounded-full mx-auto">
                        <span class="text-xs mt-1 block">Team 1</span>
                    </div>

                    <!-- LEFT -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 text-center">
                        <img src="https://i.pravatar.cc/80?img=7" class="w-12 h-12 rounded-full mx-auto">
                        <span class="text-xs mt-1 block">Team 2</span>
                    </div>

                    <!-- RIGHT -->
                    <div class="absolute right-0 top-1/2 -translate-y-1/2 text-center">
                        <img src="https://i.pravatar.cc/80?img=8" class="w-12 h-12 rounded-full mx-auto">
                        <span class="text-xs mt-1 block">Team 3</span>
                    </div>

                    <!-- BOTTOM ICONS -->
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 flex gap-6">
                        <div class="text-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                🤖
                            </div>
                            <span class="text-xs mt-1 block">AI</span>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                🧠
                            </div>
                            <span class="text-xs mt-1 block">Brain</span>
                        </div>
                    </div>
                </div>

                <!-- MOBILE VERSION -->
                <div class="grid grid-cols-2 gap-4 md:hidden text-center">
                    <div>
                        <img src="https://i.pravatar.cc/80?img=6" class="w-12 h-12 rounded-full mx-auto">
                        <span class="text-xs block mt-1">Team 1</span>
                    </div>
                    <div>
                        <img src="https://i.pravatar.cc/80?img=7" class="w-12 h-12 rounded-full mx-auto">
                        <span class="text-xs block mt-1">Team 2</span>
                    </div>
                    <div>
                        <img src="https://i.pravatar.cc/80?img=8" class="w-12 h-12 rounded-full mx-auto">
                        <span class="text-xs block mt-1">Team 3</span>
                    </div>
                    <div>
                        <div class="w-10 h-10 bg-yellow-100 rounded-full mx-auto flex items-center justify-center">
                            🎯
                        </div>
                        <span class="text-xs block mt-1">Core</span>
                    </div>
                </div>

            </div>


        </div>
    </section> --}}





    <section class="max-w-7xl mx-auto px-6 mt-10 mb-10">
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div id="map"></div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 mt-10 mb-10">
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="shadow overflow-hidden sm-rounded-md">

                <div class="px-4 py-5 bg-white sm:p-6">

                    <table id="crudTable" class="display cell-border">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kecamatan</th>
                                <th>Nama BA</th>
                                <th>Nama KDKMP</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>



    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="team-header text-gray-800 mb-4">
                Tim Inti Kami
            </h2>
            {{-- <p class="text-gray-500 max-w-3xl mx-auto mb-12">
                Pimpinan dan Koordinator Program KDKMP yang berkomitmen dalam membangun potensi daerah.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto mb-16">
                <div class="team-card bg-white p-6 rounded-2xl flex flex-col items-center text-center">
                    <img src="https://i.pravatar.cc/150?img=1" alt="Eleanor Pena"
                        class="w-24 h-24 rounded-full object-cover mb-4 ring-4 ring-blue-500 shadow-lg" />
                    <h3 class="text-xl font-bold text-gray-800 mt-2">Eleanor Pena</h3>
                    <p class="text-md font-semibold text-blue-600">Direktur Utama</p>
                </div>

                <div class="team-card bg-white p-6 rounded-2xl flex flex-col items-center text-center">
                    <img src="https://i.pravatar.cc/150?img=2" alt="Savannah Nguyen"
                        class="w-24 h-24 rounded-full object-cover mb-4 ring-4 ring-blue-500 shadow-lg" />
                    <h3 class="text-xl font-bold text-gray-800 mt-2">Savannah Nguyen</h3>
                    <p class="text-md font-semibold text-blue-600">Kepala Operasional</p>
                </div>

                <div class="team-card bg-white p-6 rounded-2xl flex flex-col items-center text-center">
                    <img src="https://i.pravatar.cc/150?img=3" alt="Courtney Henry"
                        class="w-24 h-24 rounded-full object-cover mb-4 ring-4 ring-blue-500 shadow-lg" />
                    <h3 class="text-xl font-bold text-gray-800 mt-2">Courtney Henry</h3>
                    <p class="text-md font-semibold text-blue-600">Kepala Strategi</p>
                </div>
            </div> --}}

            <h3 class="text-2xl font-bold text-gray-700 mb-8 mt-12">
                Project Management Officer
            </h3>
            <div class="flex justify-center gap-8 max-w-6xl mx-auto mb-16 flex-wrap">
                <a href="https://ahmad-afrisal.github.io/portfolio/" target="_blank">
                    <div
                        class="team-card bg-white p-6 rounded-2xl flex flex-col items-center text-center w-full sm:w-56">
                        <img src="{{ asset('images/foto-ba/isal.jpeg') }}" alt="Robert Fox"
                            class="w-40 h-40 rounded-full object-cover mb-4 ring-2 ring-gray-300 shadow-md" />
                        <h3 class="text-lg font-bold text-gray-800 mt-1">Ahmad Afrisal</h3>
                        <p class="text-sm text-gray-600">Project Management Officer</p>
                    </div>
                </a>
                <a href="#">

                    <div
                        class="team-card bg-white p-6 rounded-2xl flex flex-col items-center text-center w-full sm:w-56">
                        <img src="{{ asset('images/foto-ba/adhi.png') }}" alt="Darrell Steward"
                            class="w-40 h-40 rounded-full object-cover mb-4 ring-2 ring-gray-300 shadow-md" />
                        <h3 class="text-lg font-bold text-gray-800 mt-1">Safriadi Adhi</h3>
                        <p class="text-sm text-gray-600">Project Management Officer</p>
                    </div>
                </a>
            </div>

            <h3 class="text-2xl font-bold text-gray-700 mb-8 mt-12">
                Tim Business Assistant
            </h3>
            <div
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-4 gap-y-8 max-w-7xl mx-auto">

                @foreach ($assistants as $assistant)
                    <a href="{{ route('performance', $assistant->id) }}" target="_blank">
                        <div class="flex flex-col items-center text-center p-2">
                            <img src="{{ asset('storage/' . $assistant->picture) }}" alt=""
                                class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                            <p class="text-sm font-semibold text-gray-800 leading-tight">{{ $assistant->name }}</p>
                            <p class="text-xs text-gray-500">Business Assistant</p>
                        </div>
                    </a>
                @endforeach




            </div>
        </div>
    </section>

</x-guest-layout>
