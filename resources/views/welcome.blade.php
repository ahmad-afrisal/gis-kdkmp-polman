<x-guest-layout>
    <x-slot name="style">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            #command-map {
                height: min(68vh, 680px);
                min-height: 420px;
                border-radius: 1rem;
                z-index: 0;
            }

            #command-map:fullscreen {
                width: 100vw;
                height: 100vh !important;
                max-height: 100vh;
                border-radius: 0;
            }

            .leaflet-bar[aria-label*="layar penuh"] {
                display: grid;
                place-items: center;
                padding: 0;
                border: 0;
                color: #0f172a;
                box-shadow: 0 1px 5px rgba(15, 23, 42, .45);
            }

            .leaflet-popup-content {
                margin: 12px;
            }

            @media (max-width: 640px) {
                #command-map {
                    height: 58vh;
                    min-height: 360px;
                }
            }
        </style>
    </x-slot>

    <x-slot name="script">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            (() => {
                const cooperationPoints = @js($cooperationPoints);
                const existingPoints = @js($existingCooperativePoints);
                const cooperationStats = @js($cooperationStats);
                const existingStats = @js($existingCooperativeStats);
                const activityStats = @js($businessActivityStats);
                const villageBoundaries = @js($villages);
                const districtBoundaries = @js($districts);
                const cooperationMarkerUrl = @js(asset('images/icon-marker.png'));
                const cooperativeLogoUrl = @js(asset('images/logo.png'));
                const existingLogoUrl = @js(asset('images/icon-existing-cooperative.png'));
                const center = [-3.4126, 119.3435];
                const map = L.map('command-map', {
                    zoomControl: true,
                    scrollWheelZoom: true
                }).setView(center, 10);

                const googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                    attribution: '&copy; Google'
                });
                const googleStreets = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                    attribution: '&copy; Google'
                });
                const openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                });
                const baseLayers = {
                    'Google Hybrid': googleHybrid,
                    'Google Streets': googleStreets,
                    'OpenStreetMap': openStreetMap
                };
                googleHybrid.addTo(map);

                const cooperationLayer = L.layerGroup();
                const existingLayer = L.layerGroup();
                const villageLayer = L.layerGroup();
                const districtLayer = L.layerGroup();
                const cooperationIcon = L.icon({
                    iconUrl: cooperationMarkerUrl,
                    iconSize: [42, 48],
                    iconAnchor: [21, 46],
                    popupAnchor: [0, -42]
                });
                const existingIcon = L.icon({
                    iconUrl: existingLogoUrl,
                    iconSize: [32, 40],
                    iconAnchor: [16, 40],
                    popupAnchor: [0, -40]
                });

                const FullscreenControl = L.Control.extend({
                    options: {
                        position: 'topleft'
                    },
                    onAdd() {
                        const button = L.DomUtil.create('button', 'leaflet-bar');
                        button.type = 'button';
                        button.setAttribute('aria-label', 'Tampilkan peta layar penuh');
                        button.title = 'Tampilkan peta layar penuh';
                        button.style.width = '34px';
                        button.style.height = '34px';
                        button.style.backgroundColor = '#fff';
                        button.style.cursor = 'pointer';
                        button.style.borderRadius = '4px';
                        button.innerHTML =
                            '<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path d="M4 9V4h5M15 4h5v5M20 15v5h-5M9 20H4v-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

                        L.DomEvent.disableClickPropagation(button);
                        L.DomEvent.on(button, 'click', event => {
                            L.DomEvent.preventDefault(event);
                            const mapElement = map.getContainer();

                            if (document.fullscreenElement === mapElement) {
                                document.exitFullscreen().catch(error => {
                                    console.error('Gagal keluar dari mode layar penuh peta.',
                                        error);
                                });
                            } else if (document.fullscreenEnabled && mapElement.requestFullscreen) {
                                mapElement.requestFullscreen().catch(error => {
                                    console.error('Gagal menampilkan peta layar penuh.', error);
                                });
                            } else {
                                console.error('Mode layar penuh tidak didukung oleh browser ini.');
                            }
                        });

                        document.addEventListener('fullscreenchange', () => {
                            const isFullscreen = document.fullscreenElement === map.getContainer();
                            button.setAttribute(
                                'aria-label',
                                isFullscreen ? 'Keluar dari layar penuh' : 'Tampilkan peta layar penuh'
                            );
                            button.title = isFullscreen ? 'Keluar dari layar penuh' :
                                'Tampilkan peta layar penuh';
                            window.setTimeout(() => map.invalidateSize(), 100);
                        });

                        return button;
                    }
                });
                new FullscreenControl().addTo(map);

                function validCoordinates(point) {
                    if (
                        point.latitude === null || point.latitude === '' ||
                        point.longitude === null || point.longitude === ''
                    ) {
                        return null;
                    }

                    const latitude = Number(point.latitude);
                    const longitude = Number(point.longitude);

                    if (
                        !Number.isFinite(latitude) || !Number.isFinite(longitude) ||
                        latitude < -90 || latitude > 90 ||
                        longitude < -180 || longitude > 180
                    ) {
                        return null;
                    }

                    return [latitude, longitude];
                }

                function createPopup(point, rows, coordinates) {
                    const popup = document.createElement('div');
                    popup.className = 'w-64 overflow-hidden rounded-xl bg-white';

                    const photos = Array.isArray(point.photos) && point.photos.length ?
                        point.photos :
                        [cooperativeLogoUrl];
                    const imageFrame = document.createElement('div');
                    imageFrame.className = 'relative h-36 bg-gray-100';
                    const image = document.createElement('img');
                    image.className = 'h-full w-full object-cover';
                    image.addEventListener('error', () => {
                        image.src = cooperativeLogoUrl;
                    }, {
                        once: true
                    });
                    imageFrame.appendChild(image);

                    if (photos.length > 1) {
                        let activePhoto = 0;
                        const photoCount = document.createElement('span');
                        photoCount.className =
                            'absolute bottom-2 right-2 rounded-full bg-black/60 px-2 py-1 text-xs font-semibold text-white';

                        const showPhoto = () => {
                            image.src = photos[activePhoto];
                            image.alt = `Foto ${point.name || 'koperasi'} ${activePhoto + 1} dari ${photos.length}`;
                            photoCount.textContent = `${activePhoto + 1} / ${photos.length}`;
                        };

                        const createPhotoButton = (label, symbol, position, step) => {
                            const button = document.createElement('button');
                            button.type = 'button';
                            button.setAttribute('aria-label', label);
                            button.className =
                                'absolute top-1/2 grid h-8 w-8 -translate-y-1/2 place-items-center rounded-full bg-white/90 text-lg font-bold text-slate-800 shadow hover:bg-white';
                            button.style[position] = '0.5rem';
                            button.textContent = symbol;
                            button.addEventListener('click', () => {
                                activePhoto = (activePhoto + step + photos.length) % photos.length;
                                showPhoto();
                            });
                            imageFrame.appendChild(button);
                        };

                        createPhotoButton('Gambar sebelumnya', '‹', 'left', -1);
                        createPhotoButton('Gambar berikutnya', '›', 'right', 1);
                        imageFrame.appendChild(photoCount);
                        showPhoto();
                    } else {
                        image.src = photos[0];
                        image.alt = `Foto ${point.name || 'koperasi'}`;
                    }

                    popup.appendChild(imageFrame);

                    const content = document.createElement('div');
                    content.className = 'p-3';
                    const title = document.createElement('h3');
                    title.className = 'mb-2 text-base font-bold text-gray-900';
                    title.textContent = point.name || 'Nama koperasi belum diisi';
                    content.appendChild(title);

                    rows.forEach(([label, value]) => {
                        const row = document.createElement('p');
                        row.className = 'mb-1 text-xs leading-relaxed text-gray-600';
                        const strong = document.createElement('strong');
                        strong.textContent = `${label}: `;
                        const displayValue = value === null || value === undefined || value === '' ?
                            '-' :
                            String(value);
                        row.append(strong, document.createTextNode(displayValue));
                        content.appendChild(row);
                    });

                    const mapsLink = document.createElement('a');
                    mapsLink.href = `https://www.google.com/maps?q=${coordinates[0]},${coordinates[1]}`;
                    mapsLink.target = '_blank';
                    mapsLink.rel = 'noopener noreferrer';
                    mapsLink.className = 'mt-3 inline-flex text-xs font-semibold text-green-700 hover:underline';
                    mapsLink.textContent = 'Buka lokasi di Google Maps';
                    content.appendChild(mapsLink);
                    popup.appendChild(content);

                    return popup;
                }

                function addCooperationMarkers() {
                    cooperationPoints.forEach(point => {
                        const coordinates = validCoordinates(point);
                        if (!coordinates) return;

                        const popup = createPopup(point, [
                            ['Ketua Pengurus', point.leader],
                            ['Desa', point.village],
                            ['Kecamatan', point.district],
                            ['Alamat', point.address]
                        ], coordinates);

                        L.marker(coordinates, {
                                icon: cooperationIcon
                            })
                            .bindPopup(popup)
                            .addTo(cooperationLayer);
                    });
                }

                function addExistingMarkers() {
                    existingPoints.forEach(point => {
                        const coordinates = validCoordinates(point);
                        if (!coordinates) return;

                        const popup = createPopup(point, [
                            ['Ketua Pengurus', point.chairperson],
                            ['Status Koperasi', point.status],
                            ['Jenis Koperasi', point.type],
                            ['Jumlah Anggota', point.members],
                            ['Kegiatan Usaha', point.businessActivity],
                            ['Alamat', point.address],
                            ['Desa / Kecamatan', [point.village, point.district].filter(Boolean).join(
                                ' / ')]
                        ], coordinates);

                        L.marker(coordinates, {
                                icon: existingIcon
                            })
                            .bindPopup(popup)
                            .addTo(existingLayer);
                    });
                }

                function addBoundaryLayer(records, targetLayer, style, getLabel) {
                    records.forEach(record => {
                        if (!record.geojson) return;

                        try {
                            const geojson = typeof record.geojson === 'string' ?
                                JSON.parse(record.geojson) :
                                record.geojson;
                            const popup = document.createElement('span');
                            popup.textContent = getLabel(record);

                            L.geoJSON(geojson, {
                                    style
                                })
                                .bindPopup(popup)
                                .addTo(targetLayer);
                        } catch (error) {
                            console.error(`GeoJSON batas wilayah ${record.name} tidak valid.`, error);
                        }
                    });
                }

                addBoundaryLayer(
                    villageBoundaries,
                    villageLayer, {
                        color: '#2563eb',
                        weight: 1,
                        fillColor: '#93c5fd',
                        fillOpacity: 0.16
                    },
                    village => `${village.type || 'Desa/Kelurahan'} ${village.name}`
                );
                addBoundaryLayer(
                    districtBoundaries,
                    districtLayer, {
                        color: '#f97316',
                        weight: 2,
                        fillColor: '#fdba74',
                        fillOpacity: 0.08
                    },
                    district => `Kecamatan ${district.name}`
                );

                L.control.layers(baseLayers, {
                    'Batas Desa / Kelurahan': villageLayer,
                    'Batas Kecamatan': districtLayer
                }, {
                    collapsed: false
                }).addTo(map);

                function statisticCard(label, value, icon, color) {
                    return `
                        <article class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-slate-500">${label}</p>
                                    <p class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">${Number(value || 0).toLocaleString('id-ID')}</p>
                                </div>
                                <span class="grid h-11 w-11 place-items-center rounded-xl ${color} text-lg">${icon}</span>
                            </div>
                        </article>`;
                }

                const statsContainer = document.getElementById('statistics-grid');
                const activitySection = document.getElementById('activity-breakdown');
                const statusSection = document.getElementById('status-breakdown');
                const activeModeLabel = document.getElementById('active-mode-label');
                const activeModeLabelCopy = document.getElementById('active-mode-label-copy');
                const mapCount = document.getElementById('map-count');
                const toggleButtons = document.querySelectorAll('[data-map-mode]');

                function renderStatistics(mode) {
                    const isExisting = mode === 'existing';
                    const stats = isExisting ? existingStats : cooperationStats;
                    const cards = isExisting ? [
                        ['Total Koperasi Existing', stats.total, '▦', 'bg-emerald-50 text-emerald-700'],
                        ['Titik Terpetakan', stats.mapped, '⌖', 'bg-blue-50 text-blue-700'],
                        ['Total Anggota', stats.members, '♙', 'bg-violet-50 text-violet-700'],
                        ['Kecamatan', stats.districts, '⌂', 'bg-amber-50 text-amber-700']
                    ] : [
                        ['Total Koperasi Merah Putih', stats.total, '▦', 'bg-rose-50 text-rose-700'],
                        ['Titik Terpetakan', stats.mapped, '⌖', 'bg-blue-50 text-blue-700'],
                        ['Kecamatan', stats.districts, '⌂', 'bg-amber-50 text-amber-700'],
                        ['Desa / Kelurahan', stats.villages, '◫', 'bg-violet-50 text-violet-700']
                    ];

                    statsContainer.innerHTML = cards
                        .map(card => statisticCard(...card))
                        .join('');
                    activeModeLabel.textContent = isExisting ?
                        'Koperasi Existing' :
                        'Koperasi Merah Putih';
                    activeModeLabelCopy.textContent = activeModeLabel.textContent;
                    mapCount.textContent = `${Number(stats.mapped || 0).toLocaleString('id-ID')} titik`;
                    activitySection.classList.toggle('hidden', !isExisting);
                    statusSection.classList.toggle('hidden', !isExisting);

                    if (isExisting) {
                        document.getElementById('healthy-count').textContent =
                            Number(stats.healthy || 0).toLocaleString('id-ID');
                        document.getElementById('active-count').textContent =
                            Number(stats.active || 0).toLocaleString('id-ID');
                        document.getElementById('inactive-count').textContent =
                            Number(stats.inactive || 0).toLocaleString('id-ID');
                        const activityList = document.getElementById('activity-list');
                        activityList.replaceChildren();

                        if (activityStats.length) {
                            activityStats.forEach(activity => {
                                const item = document.createElement('li');
                                item.className = 'flex items-center justify-between gap-3 py-2';
                                const name = document.createElement('span');
                                name.className = 'truncate text-sm text-slate-600';
                                name.textContent = activity.name;
                                const count = document.createElement('span');
                                count.className =
                                    'rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700';
                                count.textContent = Number(activity.count).toLocaleString('id-ID');
                                item.append(name, count);
                                activityList.appendChild(item);
                            });
                        } else {
                            const emptyMessage = document.createElement('li');
                            emptyMessage.className = 'py-2 text-sm text-slate-500';
                            emptyMessage.textContent = 'Belum ada data kegiatan usaha.';
                            activityList.appendChild(emptyMessage);
                        }
                    }
                }

                function showMode(mode) {
                    toggleButtons.forEach(button => {
                        const selected = button.dataset.mapMode === mode;
                        button.setAttribute('aria-pressed', String(selected));
                        button.classList.toggle('bg-slate-900', selected);
                        button.classList.toggle('text-white', selected);
                        button.classList.toggle('shadow', selected);
                        button.classList.toggle('text-slate-600', !selected);
                    });

                    const activeLayer = mode === 'existing' ? existingLayer : cooperationLayer;
                    const inactiveLayer = mode === 'existing' ? cooperationLayer : existingLayer;
                    if (map.hasLayer(inactiveLayer)) map.removeLayer(inactiveLayer);
                    if (!map.hasLayer(activeLayer)) map.addLayer(activeLayer);

                    const coordinates = (mode === 'existing' ? existingPoints : cooperationPoints)
                        .map(validCoordinates)
                        .filter(Boolean);

                    if (coordinates.length) {
                        map.fitBounds(L.latLngBounds(coordinates), {
                            padding: [32, 32],
                            maxZoom: 12
                        });
                    } else {
                        map.setView(center, 10);
                    }

                    renderStatistics(mode);
                    window.setTimeout(() => map.invalidateSize(), 50);
                }

                addCooperationMarkers();
                addExistingMarkers();
                toggleButtons.forEach(button => {
                    button.addEventListener('click', () => showMode(button.dataset.mapMode));
                });
                showMode('cooperation');
            })();
        </script>
    </x-slot>

    <main class="min-h-screen bg-slate-50">
        <section class="relative overflow-hidden bg-slate-950 text-white">
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-700/40 via-slate-950 to-slate-950">
            </div>
            <div class="relative mx-auto max-w-7xl px-5 py-10 sm:px-8 lg:py-14">
                <div class="flex flex-col gap-7 md:flex-row md:items-end md:justify-between">
                    <div class="max-w-3xl">
                        <div
                            class="mb-4 inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-400/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-200">
                            <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
                            Pusat kendali data koperasi
                        </div>
                        <h1 class="text-3xl font-black tracking-tight sm:text-5xl">
                            Command Center
                            <span class="block text-emerald-300">Koperasi Polewali Mandar</span>
                        </h1>
                        <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                            Pantau sebaran, status, dan perkembangan Koperasi Merah Putih serta Koperasi Existing dalam
                            satu peta interaktif.
                        </p>
                    </div>
                    <div
                        class="flex shrink-0 items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3 backdrop-blur">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Command Center KDKMP"
                            class="h-12 w-12 rounded-xl bg-emerald-800 object-contain p-1">
                        <div>
                            <p class="text-sm font-bold">KDKMP Polman</p>
                            <p class="text-xs text-slate-300">Dashboard pemantauan wilayah</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
            <section class="relative -mt-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-lg sm:p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-slate-400">Pilih dataset</p>
                        <p class="mt-1 text-sm text-slate-600">Statistik dan titik peta mengikuti pilihan koperasi.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2 rounded-xl bg-slate-100 p-1.5" role="group"
                        aria-label="Pilih jenis koperasi">
                        <button type="button" data-map-mode="cooperation" aria-pressed="true"
                            class="rounded-lg bg-slate-900 px-4 py-3 text-sm font-bold text-white shadow transition">
                            Koperasi Merah Putih
                        </button>
                        <button type="button" data-map-mode="existing" aria-pressed="false"
                            class="rounded-lg px-4 py-3 text-sm font-bold text-slate-600 transition hover:bg-white">
                            Koperasi Existing
                        </button>
                    </div>
                </div>
            </section>

            <section class="mt-7" aria-labelledby="statistics-heading">
                <div class="mb-4 flex flex-wrap items-end justify-between gap-2">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-emerald-700">Ringkasan statistik
                        </p>
                        <h2 id="statistics-heading" class="mt-1 text-xl font-extrabold text-slate-900">
                            Statistik <span id="active-mode-label">Koperasi Merah Putih</span>
                        </h2>
                    </div>
                    <span class="text-xs text-slate-500">Dihitung dari data koperasi tersimpan</span>
                </div>
                <div id="statistics-grid" class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4"></div>
            </section>

            <section class="mt-7 grid grid-cols-1 gap-6 xl:grid-cols-12">
                <div class="xl:col-span-8">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div
                            class="flex flex-col gap-4 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">Peta Sebaran Koperasi</h2>
                                <p class="mt-1 text-sm text-slate-500">
                                    Menampilkan <span id="map-count" class="font-bold text-slate-700">0 titik</span>
                                    untuk <span id="active-mode-label-copy" class="font-semibold">dataset
                                        terpilih</span>
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2 text-xs font-semibold">
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-3 py-2 text-rose-800">
                                    <img src="{{ asset('images/icon-marker.png') }}" alt=""
                                        class="h-5 w-5 object-contain">
                                    Merah Putih
                                </span>
                                <span
                                    class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 text-emerald-800">
                                    <img src="{{ asset('images/icon-existing-cooperative.png') }}" alt=""
                                        class="h-5 w-5 rounded-full object-contain">
                                    Existing
                                </span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div id="command-map" role="application" aria-label="Peta interaktif sebaran koperasi">
                            </div>
                        </div>
                        <div
                            class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-5 py-3 text-xs text-slate-500">
                            <span>Klik penanda untuk melihat detail koperasi.</span>
                            <span>Data tanpa koordinat tidak ditampilkan pada peta.</span>
                        </div>
                    </div>
                </div>

                <aside class="space-y-6 xl:col-span-4">
                    <section id="status-breakdown"
                        class="hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="mb-4">
                            <p class="text-xs font-bold uppercase tracking-[0.15em] text-emerald-700">Status koperasi
                            </p>
                            <h3 class="mt-1 text-lg font-extrabold text-slate-900">Kondisi Koperasi Existing</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-4 py-3">
                                <span class="flex items-center gap-2 text-sm font-semibold text-emerald-900">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span> Aktif &amp; Sehat
                                </span>
                                <strong id="healthy-count" class="text-lg text-emerald-800">0</strong>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-blue-50 px-4 py-3">
                                <span class="flex items-center gap-2 text-sm font-semibold text-blue-900">
                                    <span class="h-2.5 w-2.5 rounded-full bg-blue-600"></span> Aktif
                                </span>
                                <strong id="active-count" class="text-lg text-blue-800">0</strong>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-slate-100 px-4 py-3">
                                <span class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                    <span class="h-2.5 w-2.5 rounded-full bg-slate-500"></span> Tidak Aktif
                                </span>
                                <strong id="inactive-count" class="text-lg text-slate-800">0</strong>
                            </div>
                        </div>
                    </section>

                    <section id="activity-breakdown"
                        class="hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="mb-3">
                            <p class="text-xs font-bold uppercase tracking-[0.15em] text-emerald-700">Komposisi data</p>
                            <h3 class="mt-1 text-lg font-extrabold text-slate-900">Kegiatan Usaha Teratas</h3>
                        </div>
                        <ul id="activity-list" class="divide-y divide-slate-100"></ul>
                    </section>

                    <section class="rounded-2xl bg-slate-900 p-5 text-white shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-emerald-300">Petunjuk peta</p>
                        <h3 class="mt-2 text-lg font-extrabold">Jelajahi sebaran</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-300">
                            Gunakan tombol dataset untuk mengganti sebaran dan ringkasan. Zoom peta untuk melihat titik
                            yang berdekatan, lalu pilih penanda untuk membuka detail.
                        </p>
                        <div class="mt-4 flex items-center gap-2 text-xs text-slate-300">
                            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                            <span>Data statistik mengikuti seluruh data tersimpan.</span>
                        </div>
                    </section>
                </aside>
            </section>

            <footer class="mt-8 border-t border-slate-200 py-5 text-center text-xs text-slate-500">
                Command Center KDKMP Kabupaten Polewali Mandar
            </footer>
        </div>
    </main>
</x-guest-layout>
