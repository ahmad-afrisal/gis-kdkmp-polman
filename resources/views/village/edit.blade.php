<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Petani &raquo; Edit &raquo; {{ $data->id }}
        </h2>
    </x-slot>


    <x-slot name="script">
        <script>
            const picker = document.getElementById('colorPicker');
            const preview = document.getElementById('colorPreview');

            picker.addEventListener('input', function() {
                preview.style.backgroundColor = this.value;
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-5" role="alert">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        Terdapat kesalahan
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        <p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </p>
                    </div>
                </div>
            @endif
            <form action="{{ route('villages.update', $data->id) }}" class="w-full" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Nama
                            Petani</label>
                        <input type="text" value="{{ old('name') ?? $data->name }}" name="name"
                            placeholder="Nama Petani"
                            class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Password
                        </label>
                        <select name="type" id="type"
                            class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                            <option value="">-- Pilih Petani --</option>
                            <option value="Kelurahan" {{ old('type', $data->type) == 'Kelurahan' ? 'selected' : '' }}>
                                Kelurahan</option>
                            <option value="Desa" {{ old('type', $data->type) == 'Desa' ? 'selected' : '' }}>Desa
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Upload GeoJSON
                        </label>
                        <input type="file" name="file_json" accept=".json"
                            class="block w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Warna
                        </label>

                        <div class="flex items-center gap-4">
                            <!-- Input Warna -->
                            <input type="color" id="colorPicker" value="{{ old('color', $data->color) }}"
                                name="color"
                                class="block bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4
                       leading-tight focus:outline-none focus:bg-white focus:border-gray-500">

                            <!-- Preview -->
                            <div id="colorPreview" class="w-10 h-10 rounded border border-gray-400"
                                style="background-color: {{ old('color', $data->color) }}">
                            </div>
                        </div>
                    </div>
                </div>




                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                            Update
                        </button>
                        <a href="{{ route('villages.index') }}"
                            class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                            Kembali
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

</x-app-layout>
