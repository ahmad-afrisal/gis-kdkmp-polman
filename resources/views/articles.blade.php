<x-guest-layout>
    <x-slot name="style">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <style>
            /* Custom soft animation untuk background */
            .bg-blob {
                filter: blur(80px);
                opacity: 0.6;
                z-index: 0;
            }
        </style>
    </x-slot>

    <div class="relative min-h-screen overflow-hidden bg-slate-50 py-16 sm:py-24">

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-[10%] -left-[5%] w-[40%] h-[40%] rounded-full bg-green-200/50 bg-blob"></div>
            <div class="absolute top-[20%] -right-[10%] w-[35%] h-[35%] rounded-full bg-emerald-100/60 bg-blob"></div>
            <div class="absolute -bottom-[10%] left-[20%] w-[50%] h-[50%] rounded-full bg-teal-50/80 bg-blob"></div>

            <svg class="absolute top-10 right-10 opacity-30 text-green-300" width="150" height="150"
                fill="currentColor" viewBox="0 0 100 100">
                <circle cx="5" cy="5" r="2" />
                <circle cx="25" cy="5" r="2" />
                <circle cx="45" cy="5" r="2" />
                <circle cx="5" cy="25" r="2" />
                <circle cx="25" cy="25" r="2" />
                <circle cx="45" cy="25" r="2" />
                <circle cx="5" cy="45" r="2" />
                <circle cx="25" cy="45" r="2" />
                <circle cx="45" cy="45" r="2" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-down">
                <span class="text-green-600 font-bold tracking-widest uppercase text-xs">Informasi Terkini</span>
                <h2 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                    Daftar <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-500">Artikel</span>
                </h2>
                <div class="mt-4 flex justify-center">
                    <div class="h-1 w-20 bg-green-500 rounded-full"></div>
                </div>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Update berita dan edukasi terbaru langsung dari koperasi mitra kami.
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $index => $article)
                    <article data-aos="fade-up" data-aos-delay="{{ $index * 150 }}"
                        class="group relative bg-white/80 backdrop-blur-sm p-8 rounded-[2rem] shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 border border-white flex flex-col justify-between overflow-hidden">
                        <div
                            class="absolute -inset-y-0 -inset-x-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <div class="relative z-10">
                            <div
                                class="inline-flex items-center px-4 py-1 rounded-xl text-xs font-bold bg-green-100 text-green-700 uppercase tracking-wide mb-5">
                                {{ $article->cooperation->name }}
                            </div>

                            <h3
                                class="text-2xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-300 leading-tight">
                                <a href="#">
                                    {{ Str::limit($article->title, 70) }}
                                </a>
                            </h3>

                            <p class="mt-4 text-gray-500 text-sm leading-relaxed line-clamp-3">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                        </div>

                        <div class="relative z-10 mt-8 flex items-center justify-between border-t border-gray-100 pt-5">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-400 uppercase font-semibold">Rilis Pada</span>
                                <span class="text-xs font-medium text-gray-600">
                                    {{ $article->created_at->format('d M, Y') }}
                                </span>
                            </div>

                            <div
                                class="h-11 w-11 rounded-full bg-green-50 flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transform transition-all duration-300 shadow-sm group-hover:shadow-green-200 shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 transform group-hover:translate-x-1 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>

                        <div
                            class="absolute inset-0 border-2 border-transparent group-hover:border-green-400/30 rounded-[2rem] pointer-events-none transition-all duration-500">
                        </div>
                    </article>
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
                easing: 'ease-out-back'
            });
        </script>
    </x-slot>
</x-guest-layout>
