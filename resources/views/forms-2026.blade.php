<x-app-layout>

    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>
        <x-slot name="style">

        </x-slot>


        <x-slot name="script">


            <script>
                var datatable = $('#formEight').DataTable({
                    responsive: true, // <--- aktifkan fitur ini
                    ajax: {
                        url: "{{ route('dashboard.form-eight') }}"
                    },
                    columns: [{
                            data: 'business_assistant',
                            name: 'business_assistant',
                        },
                        {
                            data: 'district',
                            name: 'district',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'land_readiness',
                            name: 'land_readiness',
                        },
                        {
                            data: 'store_development',
                            name: 'store_development',
                        },
                        {
                            data: 'vehicle',
                            name: 'vehicle',
                        },
                        {
                            data: 'table_and_chair',
                            name: 'table_and_chair',
                        },
                        {
                            data: 'display_case',
                            name: 'display_case',
                        },
                        {
                            data: 'computer',
                            name: 'computer',
                        },
                        {
                            data: 'problem',
                            name: 'problem',
                        },
                        {
                            data: 'information',
                            name: 'information',
                        },

                    ]
                })

                var datatable = $('#formNine').DataTable({
                    responsive: true, // <--- aktifkan fitur ini
                    ajax: {
                        url: "{{ route('dashboard.form-nine') }}"
                    },
                    columns: [{
                            data: 'business_assistant',
                            name: 'business_assistant',
                        },
                        {
                            data: 'district',
                            name: 'district',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'outlet_status',
                            name: 'outlet_status',
                        },

                        {
                            data: 'number_of_employees_2025',
                            name: 'number_of_employees_2025',
                        },
                        {
                            data: 'number_of_employees_2026',
                            name: 'number_of_employees_2026',
                        },
                        {
                            data: 'outlet_operations_guide',
                            name: 'outlet_operations_guide',
                        },

                        {
                            data: 'problem',
                            name: 'problem',
                        },
                        {
                            data: 'information',
                            name: 'information',
                        },

                    ]
                })

                var datatable = $('#formTen').DataTable({
                    responsive: true, // <--- aktifkan fitur ini
                    ajax: {
                        url: "{{ route('dashboard.form-ten') }}"
                    },
                    columns: [{
                            data: 'business_assistant',
                            name: 'business_assistant',
                        },
                        {
                            data: 'district',
                            name: 'district',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'profile_update',
                            name: 'profile_update',
                        },
                        {
                            data: 'village_potential',
                            name: 'village_potential',
                        },
                        {
                            data: 'grocery_outlet',
                            name: 'grocery_outlet',
                        },
                        {
                            data: 'pharmacy_outlet',
                            name: 'pharmacy_outlet',
                        },
                        {
                            data: 'warehousing_outlet',
                            name: 'warehousing_outlet',
                        },
                        {
                            data: 'clinic_outlet',
                            name: 'clinic_outlet',
                        },
                        {
                            data: 'logistics_outlet',
                            name: 'logistics_outlet',
                        },
                        {
                            data: 'usp_outlet',
                            name: 'usp_outlet',
                        },
                        {
                            data: 'other_businesses_outlet',
                            name: 'other_businesses_outlet',
                        },
                        {
                            data: 'rat',
                            name: 'rat',
                        },
                        {
                            data: 'initial_membership',
                            name: 'initial_membership',
                        },
                        {
                            data: 'addition_of_members',
                            name: 'addition_of_members',
                        },
                        {
                            data: 'problem',
                            name: 'problem',
                        },
                        {
                            data: 'information',
                            name: 'information',
                        },

                    ]
                })
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
                        <span class="text-gray-500">Dashboard</span>
                    </nav>



                    {{-- Form Delapan --}}
                    <div class="shadow overflow-hidden sm-rounded-md mt-5">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <table id="formEight" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>Nama BA</th>
                                        <th>Kecamatan</th>
                                        <th>Nama KDKMP</th>
                                        <th>Kesiapan Lokasi/Lahan</th>
                                        <th>Pembangunan Gerai</th>
                                        <th>Kendaraan</th>
                                        <th>Meja & Kursi</th>
                                        <th>Etalase</th>
                                        <th>Komputer</th>
                                        <th>Kendala</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Form Sembilan --}}
                    <div class="shadow overflow-hidden sm-rounded-md mt-5">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <table id="formNine" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>Nama BA</th>
                                        <th>Kecamatan</th>
                                        <th>Nama KDKMP</th>

                                        <th>Status Gerai</th>
                                        <th>Jumlah Karyawan 2025</th>
                                        <th>Jumlah Karyawan 2026</th>
                                        <th>Panduan Operasional Gerai</th>
                                        <th>Kendala</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Form sepuluh --}}
                    <div class="shadow overflow-hidden sm-rounded-md mt-5">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <table id="formTen" class="display cell-border">
                                <thead>
                                    <tr>
                                        <th>Nama BA</th>
                                        <th>Kecamatan</th>
                                        <th>Nama KDKMP</th>
                                        <th>Update Profil KDKMP</th>
                                        <th>Potensi Desa</th>
                                        <th>Gerai Sembako</th>
                                        <th>Gerai Apotek</th>
                                        <th>Gerai Pergudangan</th>
                                        <th>Gerai Klinik</th>
                                        <th>Gerai Logistik</th>
                                        <th>Gerai USP</th>
                                        <th>Gerai Usaha Lain</th>
                                        <th>RAT</th>
                                        <th>Jumlah Anggota Awal</th>
                                        <th>Penambahan Anggota</th>
                                        <th>Kendala</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>
        </main>
    </div>
</x-app-layout>
