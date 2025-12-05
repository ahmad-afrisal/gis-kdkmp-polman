<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abstract Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <div class="min-h-screen py-16">

        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Galeri Kegiatan</h1>
            <p class="text-gray-500">Abstract clean gallery untuk dokumentasi kegiatan KDKMP Polman.</p>
        </div>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            <!-- CARD 1 -->
            <div class="group relative rounded-3xl overflow-hidden bg-white shadow-md">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-yellow-300/40 via-pink-300/40 to-red-300/40
                blur-3xl scale-125 opacity-40 group-hover:opacity-60 transition-all">
                </div>

                <img src="{{ asset('images/gallery/1.jpg') }}"
                    class="relative w-full h-72 object-cover rounded-3xl group-hover:scale-110 transition">
            </div>

            <!-- CARD 2 taller -->
            <div class="group relative rounded-3xl overflow-hidden bg-white shadow-md">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-300/40 via-purple-300/40 to-pink-200/40
                blur-3xl scale-125 opacity-40 group-hover:opacity-60 transition-all">
                </div>

                <img src="https://source.unsplash.com/random/800x1100?people"
                    class="relative w-full h-96 object-cover rounded-3xl group-hover:scale-110 transition">
            </div>

            <!-- CARD 3 wide -->
            <div class="group relative rounded-3xl overflow-hidden bg-white shadow-md">
                <div
                    class="absolute inset-0 bg-gradient-to-tr from-green-300/40 via-yellow-300/40 to-orange-300/40
                blur-3xl scale-125 opacity-40 group-hover:opacity-60 transition-all">
                </div>

                <img src="https://source.unsplash.com/random/900x700?city"
                    class="relative w-full h-60 object-cover rounded-3xl group-hover:scale-110 transition">
            </div>

            <!-- CARD 4 medium -->
            <div class="group relative rounded-3xl overflow-hidden bg-white shadow-md">
                <div
                    class="absolute inset-0 bg-gradient-to-bl from-pink-300/40 via-red-200/40 to-yellow-200/40
                blur-3xl scale-125 opacity-40 group-hover:opacity-60 transition-all">
                </div>

                <img src="https://source.unsplash.com/random/800x850?community"
                    class="relative w-full h-72 object-cover rounded-3xl group-hover:scale-110 transition">
            </div>

            <!-- CARD 5 tall -->
            <div class="group relative rounded-3xl overflow-hidden bg-white shadow-md">
                <div
                    class="absolute inset-0 bg-gradient-to-tl from-purple-300/40 via-blue-300/40 to-teal-200/40
                blur-3xl scale-125 opacity-40 group-hover:opacity-60 transition-all">
                </div>

                <img src="https://source.unsplash.com/random/800x1200?village"
                    class="relative w-full h-[30rem] object-cover rounded-3xl group-hover:scale-110 transition">
            </div>

            <!-- CARD 6 smaller -->
            <div class="group relative rounded-3xl overflow-hidden bg-white shadow-md">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-orange-300/40 via-pink-300/40 to-purple-200/40
                blur-3xl scale-125 opacity-40 group-hover:opacity-60 transition-all">
                </div>

                <img src="https://source.unsplash.com/random/800x600?training"
                    class="relative w-full h-56 object-cover rounded-3xl group-hover:scale-110 transition">
            </div>

        </div>

    </div>

</body>

</html>
