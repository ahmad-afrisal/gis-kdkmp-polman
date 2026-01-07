<aside :class="open ? 'translate-x-0' : '-translate-x-full'"
    class="fixed z-30 inset-y-0 left-0 w-64 bg-green-800 text-white transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
    <div class="p-6 text-2xl font-bold">CC KDKMP POLMAN</div>
    <nav class="flex-1">
        <ul>
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('dashboard') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('land-statistics.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('land-statistics.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="brain-cog" class="w-4 h-4 mr-1"></i> Statistik Lahan
                </a>
            </li>
            <li>
                <a href="{{ route('districts.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('districts.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="brain-cog" class="w-4 h-4 mr-1"></i> Kecamatan
                </a>
            </li>
            <li>
                <a href="{{ route('villages.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('villages.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="brain-cog" class="w-4 h-4 mr-1"></i> Desa/Kelurahan
                </a>
            </li>
            <li>
                <a href="{{ route('bussiness-assistants.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('bussiness-assistants.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="ghost" class="w-4 h-4 mr-1"></i> Business Assistant
                </a>
            </li>
            <li>
                <a href="{{ route('cooperations.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('cooperations.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="link" class="w-4 h-4 mr-1"></i> Koperasi
                </a>
            </li>
            <li>
                <a href="{{ route('polygons.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('polygons.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="scan-search" class="w-4 h-4 mr-1"></i> Polygon
                </a>
            </li>
            <li>
                <a href="{{ route('problems.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('problems.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="scan-search" class="w-4 h-4 mr-1"></i> Permasalahan
                </a>
            </li>

            <li>
                <a href="{{ route('contact-managements.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('contact-managements.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="scan-search" class="w-4 h-4 mr-1"></i> Kontak Pengurus
                </a>
            </li>
            <li>
                <a href="{{ route('weekly-reports.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('weekly-reports.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="scan-search" class="w-4 h-4 mr-1"></i> Laporan Mingguan
                </a>
            </li>
            <li>
                <a href="{{ route('pmo-documentations.index') }}"
                    class="flex items-center px-6 py-3 transition 
                        {{ request()->routeIs('pmo-documentations.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i data-lucide="scan-search" class="w-4 h-4 mr-1"></i> PMO Documentation
                </a>
            </li>
        </ul>
    </nav>
</aside>
