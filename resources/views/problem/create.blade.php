<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


        <x-slot name="style">
            <!-- CSS Select2 -->
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


        </x-slot>

        <x-slot name="script">
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#cooperation_id').select2({
                        width: '100%',
                        height: '40px',
                        placeholder: "-- Pilih KDKMP --",
                        allowClear: true
                    });
                });
            </script>
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
                        <span class="text-gray-500">Permasalahan</span>
                        <span>›</span>
                        <span class="text-gray-500">Tambah</span>
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

                    <form action="{{ route('problems.store') }}" method="post" enctype="multipart/form-data"
                        class="bg-white p-6 rounded-lg shadow-md">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Pilih KDKMP</label>
                            <select name="cooperation_id" id="cooperation_id"
                                class="select2 block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                                <option value="">-- Pilih KDKMP --</option>
                                @foreach ($cooperations as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('cooperation_id') == $id ? 'selected' : '' }}>
                                        {{ $id }} - {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Permasalahan</label>
                            <textarea name="problem" class="w-full border rounded p-2 mb-4">{{ old('problem') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Sejak Kapan Terjadi</label>
                            <input type="date" name="date_problem" value="{{ old('date_problem') }}"
                                class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                        </div>


                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Tingkat Permasalahan</label>
                            <select name="priority" id="priority"
                                class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                                <option value="">-- Pilih Tinkat Permasalahan --</option>
                                <option value="Rendah" {{ old('priority') == 'Rendah' ? 'selected' : '' }}>Rendah
                                </option>
                                <option value="Sedang" {{ old('priority') == 'Sedang' ? 'selected' : '' }}>Sedang
                                </option>
                                <option value="Tinggi" {{ old('priority') == 'Tinggi' ? 'selected' : '' }}>Tinggi
                                </option>
                            </select>
                        </div>


                        <div class="flex space-x-2">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Simpan
                            </button>
                            <a href="{{ route('problems.index') }}"
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
