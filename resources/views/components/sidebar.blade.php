<aside :class="open ? 'translate-x-0' : '-translate-x-full'"
    class="fixed z-30 inset-y-0 left-0 w-64 bg-green-800 text-white 
           transform transition-transform duration-200 ease-in-out 
           lg:translate-x-0 lg:static lg:inset-0 h-screen flex flex-col">
    <div class="p-6 flex items-center justify-center shrink-0">
        <img src="{{ asset('images/logo-white.png') }}" alt="CC KDKMP POLMAN" class="h-17 w-auto object-contain">
    </div>

    <nav class="flex-1 overflow-y-auto sidebar-scroll">
        <ul class="py-4">
            <li x-data="{ open: {{ request()->routeIs('cooperative-statuses.*', 'business-activities.*', 'districts.*', 'villages.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-3 transition focus:outline-none
                {{ request()->routeIs('cooperative-statuses.*', 'business-activities.*', 'districts.*', 'villages.*') ? 'bg-green-700 text-white' : 'hover:bg-green-700 text-green-100' }}">
                    <div class="flex items-center">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 mr-3"></i>
                        <span class="font-medium">Dashboard</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                <ul x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" class="bg-green-800/50">

                    <li>
                        <a href="{{ route('dashboard') }}" {{-- Pastikan route ini benar --}}
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('dashboard') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar" class="w-3 h-3 mr-2"></i> Tahun 2025
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('dashboard.2026') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('dashboard.2026') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar" class="w-3 h-3 mr-2"></i> Tahun 2026
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rat.2025') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('rat.2025') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar" class="w-3 h-3 mr-2"></i> RAT 2026
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cooperation-members') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('cooperation-members') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar" class="w-3 h-3 mr-2"></i> Anggota Koperasi
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('land-statistics.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('land-statistics.index') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar" class="w-3 h-3 mr-2"></i> Statistik Pembangunan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('administrations') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('administrations') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar" class="w-3 h-3 mr-2"></i> Kelengkapan Administrasi
                        </a>
                    </li>
                </ul>
            </li>
            <li x-data="{ open: {{ request()->routeIs('dashboard.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-3 transition focus:outline-none
                {{ request()->routeIs('dashboard.*') ? 'bg-green-700 text-white' : 'hover:bg-green-700 text-green-100' }}">
                    <div class="flex items-center">
                        <i data-lucide="database" class="w-4 h-4 mr-3"></i>
                        <span class="font-medium">Master Data</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                <ul x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" class="bg-green-800/50">

                    <li>
                        <a href="{{ route('districts.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('districts.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="map" class="w-3 h-3 mr-2"></i> Kecamatan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('villages.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('villages.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="map-pinned" class="w-3 h-3 mr-2"></i> Desa/Kelurahan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cooperative-statuses.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('cooperative-statuses.index') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar" class="w-3 h-3 mr-2"></i> Status Koperasi
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('business-activities.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('business-activities.index') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar" class="w-3 h-3 mr-2"></i> Kegiatan Usaha
                        </a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="{{ route('existing-cooperatives.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('existing-cooperatives.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="earth" class="w-4 h-4 mr-1"></i> Koperasi Existing
                </a>
            </li>
            <li x-data="{ open: {{ request()->routeIs('online-attendances.*', 'forms.2026', 'bussiness-assistants.*', 'cooperations.*', 'polygons.*', 'problems.*', 'contact-managements.*', 'weekly-reports.*', 'link-drives.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-3 transition focus:outline-none
                {{ request()->routeIs('online-attendances.*', 'forms.2026', 'bussiness-assistants.*', 'cooperations.*', 'polygons.*', 'problems.*', 'contact-managements.*', 'weekly-reports.*', 'link-drives.*') ? 'bg-green-700 text-white' : 'hover:bg-green-700 text-green-100' }}">
                    <div class="flex items-center">
                        <i data-lucide="building-2" class="w-4 h-4 mr-3"></i>
                        <span class="font-medium">Koperasi Merah Putih</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"></i>
                </button>

                <ul x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" class="bg-green-800/50">
                    <li>
                        <a href="{{ route('online-attendances.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('online-attendances.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="calendar-check" class="w-3 h-3 mr-2"></i> Absen BA
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('forms.2026') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('forms.2026') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="file-spreadsheet" class="w-3 h-3 mr-2"></i> Form 2026
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bussiness-assistants.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('bussiness-assistants.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="users" class="w-3 h-3 mr-2"></i> Business Assistant
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cooperations.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('cooperations.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="link" class="w-3 h-3 mr-2"></i> Koperasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('polygons.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('polygons.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="land-plot" class="w-3 h-3 mr-2"></i> Polygon
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('problems.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('problems.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="scan-search" class="w-3 h-3 mr-2"></i> Permasalahan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact-managements.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('contact-managements.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="contact" class="w-3 h-3 mr-2"></i> Kontak Pengurus
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('weekly-reports.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('weekly-reports.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="file-text" class="w-3 h-3 mr-2"></i> Laporan Mingguan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('link-drives.index') }}"
                            class="flex items-center pl-14 py-2.5 text-sm transition hover:text-white
                {{ request()->routeIs('link-drives.*') ? 'text-white font-bold bg-green-900/30' : 'text-green-200' }}">
                            <i data-lucide="link" class="w-3 h-3 mr-2"></i> Link Drive
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('articles.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('articles.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="newspaper" class="w-4 h-4 mr-1"></i> Artikel
                </a>
            </li>
            <li>
                <a href="{{ route('announcements.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('announcements.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="megaphone" class="w-4 h-4 mr-1"></i> Pengumuman
                </a>
            </li>
            <li>
                <a href="{{ route('commodities.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('commodities.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="book-image" class="w-4 h-4 mr-1"></i> Komoditi
                </a>
            </li>
        </ul>
    </nav>
</aside>
