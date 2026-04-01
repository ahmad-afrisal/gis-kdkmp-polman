<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        @include('components.sidebar')

        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

        <x-slot name="style">
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <style>
                .cke_notifications_area {
                    display: none !important;
                }
            </style>
        </x-slot>

        <x-slot name="script">
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace('description');

                function previewImage(input) {
                    const previewContainer = document.getElementById('preview-container');
                    const previewImage = document.getElementById('image-preview');
                    const placeholderText = document.getElementById('placeholder-text');

                    if (input.files && input.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewContainer.classList.remove('hidden');
                            if (placeholderText) placeholderText.classList.add('opacity-0');
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
        </x-slot>


        <main class="flex-1 overflow-y-auto">

            @include('components.header')

            <div class="py-12">

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-7">
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-green-600">
                            <i data-lucide="home" class="w-4 h-4 mr-1"></i> Home
                        </a>
                        <span>›</span>
                        <a href="{{ route('commodities.index') }}" class="hover:text-green-600">Komoditas</a>
                        <span>›</span>
                        <span class="text-gray-500">Edit</span>
                    </nav>

                    @if ($errors->any())
                        <div class="mb-5" role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                Terdapat kesalahan
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('commodities.update', $commodity->id) }}" method="post"
                        enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <div class="order-first md:order-last">
                                <label class="block text-gray-700 font-bold mb-2">Ikon Marker</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="image-upload"
                                        class="flex flex-col items-center justify-center w-full h-48 md:h-full min-h-[200px] border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-100 hover:bg-gray-200 focus-within:border-green-500 transition-all overflow-hidden relative">

                                        <div id="preview-container"
                                            class="absolute inset-0 {{ $commodity->image ? '' : 'hidden' }}">
                                            <img id="image-preview"
                                                src="{{ $commodity->image ? asset('storage/' . $commodity->image) : '' }}"
                                                class="w-full h-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                                <span class="text-white text-sm font-semibold">Ganti Gambar</span>
                                            </div>
                                        </div>

                                        @if (!$commodity->image)
                                            <div id="placeholder-text"
                                                class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-2">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="text-sm text-gray-500 font-bold">Upload Gambar</p>
                                                <p class="text-xs text-gray-400">PNG, JPG (Maks. 2MB)</p>
                                            </div>
                                        @endif

                                        <input id="image-upload" type="file" name="image" class="hidden"
                                            accept="image/*" onchange="previewImage(this)">
                                    </label>
                                </div>
                                @error('image')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col justify-between">
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Komoditas</label>
                                    <input type="text" name="name" value="{{ old('name', $commodity->name) }}"
                                        autofocus
                                        class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500"
                                        placeholder="Contoh: Lidah Mertua">
                                    @error('name')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-2 font-bold text-gray-700">Status</label>
                                    <div
                                        class="flex items-center gap-8 bg-gray-100 p-3 rounded-lg border border-gray-300">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="is_active" value="1"
                                                class="form-radio text-green-600"
                                                {{ old('is_active', $commodity->is_active) == 1 ? 'checked' : '' }}>
                                            <span class="ml-2 text-gray-700">Aktif</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="is_active" value="0"
                                                class="form-radio text-red-600"
                                                {{ old('is_active', $commodity->is_active) == 0 ? 'checked' : '' }}>
                                            <span class="ml-2 text-gray-700">Tidak Aktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block mb-2 font-bold text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" placeholder="Masukkan deskripsi komoditas..." rows="4"
                                class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">{{ old('description', $commodity->description) }}</textarea>
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition">
                                Perbarui Data
                            </button>
                            <a href="{{ route('commodities.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition">
                                Kembali
                            </a>
                        </div>
                    </form>


                </div>
            </div>
        </main>
    </div>

</x-app-layout>
