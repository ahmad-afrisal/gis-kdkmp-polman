<x-guest-layout>
    <x-slot name="style">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <style>


        </style>
    </x-slot>

    <div class="relative min-h-screen overflow-hidden bg-[#f0f9f4] py-16 sm:py-24">

        <div class="absolute inset-0 pointer-events-none">



            <svg class="absolute top-1/2 right-0 opacity-10 text-green-800" width="200" height="400"
                fill="currentColor">
                <defs>
                    <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="2" />
                    </pattern>
                </defs>
                <rect width="200" height="400" fill="url(#dots)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-down">
                <div
                    class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-white/80 border border-green-100 shadow-sm mb-6">
                    <span class="relative flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-green-800 text-xs font-bold uppercase tracking-widest">Update Terkini</span>
                </div>
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-6xl">
                    Pengumuman <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-500">Koperasi</span>
                </h2>
                <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-600 leading-relaxed">
                    Akses cepat informasi resmi, laporan tahunan, dan pengumuman penting bagi seluruh anggota koperasi.
                </p>
            </div>

            <div class="grid gap-6 max-w-4xl mx-auto">
                @foreach ($announcements as $index => $announcement)
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 150 }}"
                        class="group relative bg-white/70 backdrop-blur-xl p-6 rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-green-900/5 transition-all duration-500 border border-white flex flex-col md:flex-row md:items-center justify-between">

                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-[2rem]">
                        </div>

                        <div
                            class="relative z-10 flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-8 w-full">
                            <div
                                class="flex-shrink-0 w-20 h-20 rounded-[1.5rem] bg-gradient-to-br from-green-500 to-emerald-600 text-white flex flex-col items-center justify-center shadow-lg shadow-green-200 group-hover:scale-110 transition-transform duration-500">
                                <span
                                    class="text-2xl text-green-500 font-black leading-none">{{ $announcement->created_at->format('d') }}</span>
                                <span
                                    class="text-[10px] text-green-500 uppercase font-bold tracking-tighter">{{ $announcement->created_at->format('F') }}</span>
                            </div>

                            <div class="flex-grow mt-3 mb-5">

                                <h3
                                    class="text-xl font-bold text-gray-800 group-hover:text-green-700 transition-colors">
                                    {{ $announcement->title }}
                                </h3>
                                <p class="text-sm text-gray-500 line-clamp-2 mt-2 leading-snug">
                                    {{ Str::limit(strip_tags($announcement->content), 120) }}
                                </p>
                            </div>

                            <div class="flex items-center space-x-3 relative z-20">
                                @if ($announcement->file)
                                    <a href="{{ asset('storage/' . $announcement->file) }}" target="_blank" download
                                        class="flex items-center justify-center space-x-2 px-6 py-3 rounded-2xl bg-green-600 text-white hover:bg-green-700 transition-all duration-300 shadow-md shadow-green-200 font-bold text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-bounce"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span>Download File</span>
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                once: true,
                duration: 1000,
                easing: 'ease-out-expo'
            });
        </script>
    </x-slot>
</x-guest-layout>
