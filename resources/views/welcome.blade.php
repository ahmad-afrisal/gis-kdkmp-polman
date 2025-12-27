<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peta Wilayah Pendampingan</title>

    <script src="https://cdn.tailwindcss.com"></script>

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
</head>

<body class="bg-gray-50 min-h-screen">
    {{-- <header class="relative bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-white py-10 shadow-xl">

        <div class="absolute top-5 right-6">
            <a href="{{ route('login') }}"
                class="px-4 py-2 bg-white/20 backdrop-blur-lg text-white rounded-lg border border-white/30 hover:bg-white/30 transition duration-200">
                Login
            </a>
        </div>

        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl font-extrabold tracking-wide drop-shadow-md">
                🌍 Peta Sebaran KDKMP Kabupaten Polewali Mandar
            </h1>
            <p class="text-blue-100 mt-3 text-lg">
                {{-- Filter dan lihat data wilayah berdasarkan Kecamatan, Desa, atau Business Assistant --}}
    {{-- </p>

    <div class="mt-4 flex justify-center">
        <span class="block w-24 h-1 bg-white/50 rounded-full"></span>
    </div>
    </div>

    </header> --}}

    <!-- HEADER -->
    <header class="w-full bg-white/80 backdrop-blur-xl border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="w-6 h-6 bg-gradient-to-br from-yellow-400 to-pink-500 rounded-full"></div>
                <span class="text-xl font-bold text-gray-800">KDKMP POLMAN</span>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-8 text-gray-700 font-medium">
                <a href="{{ route('welcome') }}" class="hover:text-gray-900 transition">Home</a>
                <a href="{{ route('galleries') }}" class="hover:text-gray-900 transition">Galeri</a>
                {{-- <a href="#" class="hover:text-gray-900 transition">Blog</a>
                <a href="#" class="hover:text-gray-900 transition">Features</a>
                <a href="#" class="hover:text-gray-900 transition">How It Works</a>
                <a href="#" class="hover:text-gray-900 transition">Contact</a> --}}
            </nav>

            <!-- CTA -->
            <div class="hidden md:block">
                <a href="{{ route('login') }}"
                    class="px-5 py-2 rounded-full bg-white shadow-md border border-gray-200
                       hover:shadow-lg transition font-semibold">
                    Login
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden p-2 text-gray-700" id="mobileMenuBtn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden flex-col space-y-4 px-6 pb-4 text-gray-700 font-medium">
            <a href="{{ route('welcome') }}" class="block">Home</a>
            <a href="{{ route('galleries') }}" class="block">Gallery</a>
            {{-- <a href="#" class="block">Blog</a>
            <a href="#" class="block">Features</a>
            <a href="#" class="block">How It Works</a>
            <a href="#" class="block">Contact</a> --}}

            <a href="{{ route('login') }}"
                class="px-5 py-2 rounded-full bg-white shadow-md border border-gray-200
                   hover:shadow-lg transition font-semibold w-max">
                Login
            </a>
        </div>
    </header>

    <script>
        const btn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');
        btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    </script>

    <!-- HERO SECTION -->
    <section class="relative bg-white py-24 overflow-hidden">

        <!-- Gradient Decorations -->
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-yellow-300 to-pink-500 rounded-full blur-3xl opacity-30">
        </div>
        <div
            class="absolute bottom-10 left-0 w-64 h-64 bg-gradient-to-br from-pink-300 to-orange-400 rounded-full blur-3xl opacity-20">
        </div>

        <div class="max-w-5xl mx-auto text-center relative z-20">

            {{-- <!-- Breadcrumb -->
            <div class="flex justify-center items-center space-x-2 text-sm text-gray-500 mb-6">
                <a href="#" class="hover:text-gray-700">Home</a>
                <span>/</span>
                <span class="text-gray-700 font-medium">About Us</span>
            </div> --}}

            <!-- Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                Peta Digital Koperasi Desa/Kelurahan Merah Putih Polewali Mandar
                {{-- Temukan Gerai KDKMP di Seluruh Polman --}}
            </h1>

            <!-- Subtitle -->
            <p class="text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform pemetaan interaktif untuk mengetahui posisi gerai, potensi desa, serta perkembangan program
                secara visual dan menarik..
            </p>

            <!-- Buttons -->
            {{-- <div class="flex justify-center gap-4">
                <a href="#"
                    class="px-6 py-3 rounded-full bg-gradient-to-r from-yellow-400 to-pink-500 text-white font-semibold shadow-md hover:shadow-xl transition">
                    Download The Theme
                </a>

                <a href="#"
                    class="px-6 py-3 rounded-full border border-gray-400 text-gray-700 font-semibold hover:bg-gray-50 transition">
                    Learn More
                </a>
            </div>
        </div> --}}
    </section>

    <!-- COUNTER SECTION -->
    <section class="py-10">
        <div class="max-w-6xl mx-auto px-6">
            <div class="bg-white shadow-xl rounded-3xl py-10 px-6 grid grid-cols-2 md:grid-cols-4 gap-10 text-center">

                <div>
                    <p class="text-3xl font-bold text-gray-900">167</p>
                    <p class="text-gray-500">Desa/Kelurahan</p>
                </div>

                <div>
                    <p class="text-3xl font-bold text-gray-900">167</p>
                    <p class="text-gray-500">KDKMP</p>
                </div>

                <div>
                    <p class="text-3xl font-bold text-gray-900">167</p>
                    <p class="text-gray-500">Akun Simkopdes</p>
                </div>

                <div>
                    <p class="text-3xl font-bold text-gray-900">167</p>
                    <p class="text-gray-500">NIK</p>
                </div>

            </div>
        </div>
    </section>




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
                <div class="team-card bg-white p-6 rounded-2xl flex flex-col items-center text-center w-full sm:w-56">
                    <img src="{{ asset('images/foto-ba/isal.jpeg') }}" alt="Robert Fox"
                        class="w-40 h-40 rounded-full object-cover mb-4 ring-2 ring-gray-300 shadow-md" />
                    <h3 class="text-lg font-bold text-gray-800 mt-1">Ahmad Afrisal</h3>
                    <p class="text-sm text-gray-600">Project Management Officer</p>
                </div>

                <div class="team-card bg-white p-6 rounded-2xl flex flex-col items-center text-center w-full sm:w-56">
                    <img src="{{ asset('images/foto-ba/adhi.png') }}" alt="Darrell Steward"
                        class="w-40 h-40 rounded-full object-cover mb-4 ring-2 ring-gray-300 shadow-md" />
                    <h3 class="text-lg font-bold text-gray-800 mt-1">Safriadi Adhi</h3>
                    <p class="text-sm text-gray-600">Project Management Officer</p>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-700 mb-8 mt-12">
                Tim Business Assistant
            </h3>
            <div
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-4 gap-y-8 max-w-7xl mx-auto">



                <a href="{{ route('performance', 14) }}" target="_blank">
                    <div class="flex flex-col items-center text-center p-2">
                        <img src="{{ asset('images/foto-ba/rahmadani.jpg') }}" alt=""
                            class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                        <p class="text-sm font-semibold text-gray-800 leading-tight">Rahmadani</p>
                        <p class="text-xs text-gray-500">Business Assistant</p>
                    </div>
                </a>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/husnawati.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Husnawati</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/mardiana.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Mardiana H</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/asthy.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Asty Esha Nadia</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/arasy.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Muh Arasy</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/hasana2.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Hasana</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/hernida.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Hernida</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/asyam.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Alwi Syam</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/irdah.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Irdah</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/ulya.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Nurul Ulya</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/aslam.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Muhammad Aslam</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/rezky.png') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Rezky Amalia Sari</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/pratiwi.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Nurul Pratiwi</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/adham.png') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Adam</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/amalia.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Amalia Fadini</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>
                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/hendra.jpg') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Hendra Wahid</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>

                <div class="flex flex-col items-center text-center p-2">
                    <img src="{{ asset('images/foto-ba/yusuf.png') }}" alt=""
                        class="w-24 h-24 rounded-full object-cover mb-2 ring-1 ring-gray-200" />
                    <p class="text-sm font-semibold text-gray-800 leading-tight">Muhammad Yusuf</p>
                    <p class="text-xs text-gray-500">Business Assistant</p>
                </div>


            </div>
        </div>
    </section>

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
</body>

</html>
