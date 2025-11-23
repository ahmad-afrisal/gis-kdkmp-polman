<x-app-layout>
    <x-slot name="style">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Dokumentasi Kegiatan PMO -->
            <!-- Dokumentasi Kegiatan PMO -->
            <div class="mt-12">
                <h2 class="text-xl font-semibold mb-6">Dokumentasi Kegiatan PMO</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                    <!-- CARD TEMPLATE -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300"
                        data-aos="fade-up">

                        <!-- FOTO -->
                        <img src="{{ asset('pmo-documentation/survey-lahan.jpg') }}" class="w-full h-56 object-cover"
                            alt="Foto Kegiatan">

                        <!-- CONTENT -->
                        <div class="p-5">

                            <!-- TANGGAL -->
                            <div class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold mb-3"
                                style="background: linear-gradient(90deg, #16a34a, #4ade80);">
                                10 November 2025
                            </div>

                            <!-- JUDUL -->
                            <h3 class="font-bold text-xl text-gray-900 mb-2">
                                Survey Lahan
                            </h3>

                            <!-- LOKASI -->
                            <div class="text-sm font-medium text-green-700 mb-2">
                                <span class="text-gray-700">Desa Kebunsari</span>
                            </div>

                            <!-- DESKRIPSI -->
                            <p class="text-gray-600 leading-relaxed text-sm">
                                Survey lahan untk pembagunan gerai kdkmp kebunsari
                            </p>
                        </div>
                    </div>


                    <!-- CARD 2 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300"
                        data-aos="fade-up" data-aos-delay="100">

                        <img src="{{ asset('pmo-documentation/muskelsus-pappang.jpg') }}"
                            class="w-full h-56 object-cover">


                        <div class="p-5">

                            <div class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold mb-3"
                                style="background: linear-gradient(90deg, #2563eb, #60a5fa);">
                                10 November 2025
                            </div>

                            <h3 class="font-bold text-xl text-gray-900 mb-2">
                                Musyawarah Kelurahan Pappang
                            </h3>

                            <div class="text-sm font-medium text-blue-700 mb-2">
                                <span class="text-gray-700">Kantor Keluarahan Pappang</span>
                            </div>

                            <p class="text-gray-600 leading-relaxed text-sm">
                                Musyawarah Khusus Pengembalian Dana.
                            </p>
                        </div>
                    </div>


                    <!-- CARD 3 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300"
                        data-aos="fade-up" data-aos-delay="200">

                        <img src="{{ asset('pmo-documentation/dinas-1.jpeg') }}" class="w-full h-56 object-cover">

                        <div class="p-5">

                            <div class="inline-block px-3 py-1 rounded-full text-white text-xs font-semibold mb-3"
                                style="background: linear-gradient(90deg, #d97706, #fbbf24);">
                                11 November 2025
                            </div>

                            <h3 class="font-bold text-xl text-gray-900 mb-2">
                                Kunjungan ke Bumimulyo
                            </h3>

                            <div class="text-sm font-medium text-yellow-700 mb-2">
                                Bumimulyo
                            </div>

                            <p class="text-gray-600 leading-relaxed text-sm">
                                Kunjungan Ke Bumimulyo
                        </div>

                    </div>
                </div>
            </div>
        </div>

</x-app-layout>
