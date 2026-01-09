<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


        <x-slot name="style">
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        </x-slot>
        <x-slot name="script">
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        </x-slot>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">

            @include('components.header')

            <div class="py-12">

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-7">
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-green-600">
                            <i data-lucide="home" class="w-4 h-4 mr-1"></i> Home
                        </a>
                        <span>›</span>
                        <span class="text-gray-500">Artikel</span>
                        <span>›</span>
                        <span class="text-gray-500">Edit</span>
                        <span>›</span>
                        <span class="text-gray-500">1</span>
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

                    <form action="{{ route('articles.update', $data->id) }}" method="post"
                        enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama KDKMP</label>
                            <select name="cooperation_id" id="cooperation_id"
                                class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                                <option value="">-- Pilih KDKMP--</option>
                                @foreach ($cooperations as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('cooperation_id', $data->cooperation_id) == $id ? 'selected' : '' }}>
                                        {{ $id }} - {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Judul Artikel</label>
                            <input type="text" name="title" value="{{ old('title') ?? $data->title }}"
                                class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Link</label>
                            <textarea name="link" class="w-full border rounded p-2 mb-4">{{ old('link') ?? $data->link }}</textarea>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block mb-2 font-medium">
                                    Status
                                </label>
                                <div class="flex items-center gap-8"> <!-- gunakan gap-8 agar jarak lebih lebar -->
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="1"
                                            class="form-radio text-green-600"
                                            {{ old('status', $data->status ?? 1) == 1 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Aktif</span>
                                    </label>

                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="0"
                                            class="form-radio text-red-600"
                                            {{ old('status', $data->status ?? 1) == 0 ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Tidak Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="flex space-x-2">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Simpan
                            </button>
                            <a href="{{ route('articles.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

</x-app-layout>
