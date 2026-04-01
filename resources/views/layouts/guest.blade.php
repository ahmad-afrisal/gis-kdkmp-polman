<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{ $style ?? '' }}


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">


    <!-- HEADER -->
    <header x-data="{ open: false }" class="bg-gradient-to-r from-green-50 to-green-100">

        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img src="/images/logo.png" alt="Logo KDKMP" class="rounded-full w-10 h-10 object-contain">

            </div>

            <!-- Menu Desktop -->
            <nav
                class="hidden md:flex items-center bg-white/70 backdrop-blur px-6 py-2 rounded-full shadow-sm space-x-6 text-sm font-medium text-gray-600">
                <a href="{{ route('welcome') }}" class="hover:text-green-600 transition">Home</a>
                <a href="{{ route('home-articles') }}" class="hover:text-green-600 transition">Artikel</a>
                <a href="{{ route('home-announcements') }}" class="hover:text-green-600 transition">Pengumuman</a>
                <a href="#" class="hover:text-green-600 transition">Galeri</a>
                <a href="#" class="hover:text-green-600 transition">Whistleblowing System</a>
                <a href="{{ route('contacts') }}" class="hover:text-green-600 transition">Kontak</a>
            </nav>

            <!-- CTA Desktop -->
            <div class="hidden md:block">
                <a href="{{ route('login') }}"
                    class="flex items-center gap-2 px-5 py-2 rounded-full bg-green-500 text-white text-sm font-semibold shadow hover:bg-green-600 transition">
                    Login
                    <span class="w-5 h-5 bg-white text-green-600 rounded-full flex items-center justify-center text-xs">
                        →
                    </span>
                </a>
            </div>

            <!-- Mobile Button -->
            <button @click="open = !open" class="md:hidden text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition @click.outside="open = false" class="md:hidden px-6 pb-4">

            <div class="bg-white rounded-2xl shadow p-4 space-y-3 text-gray-700">
                <a href="{{ route('welcome') }}" class="block hover:text-green-600">Home</a>
                <a href="{{ route('home-articles') }}" class="block hover:text-green-600">Artikel</a>
                <a href="{{ route('home-announcements') }}" class="block hover:text-green-600">Pengumuman</a>
                <a href="#" class="block hover:text-green-600">Blog</a>
                <a href="#" class="block hover:text-green-600">Integration</a>
                <a href="{{ route('contacts') }}" class="block hover:text-green-600">Pricing</a>

                <a href="{{ route('login') }}"
                    class="mt-3 flex justify-center items-center gap-2 px-4 py-2 rounded-full bg-green-500 text-white font-semibold">
                    Login →
                </a>
            </div>
        </div>
    </header>

    {{ $slot }}

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    {{ $script ?? '' }}


</body>



</html>
