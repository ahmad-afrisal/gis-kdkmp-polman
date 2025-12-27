<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Permasalahan &raquo; Tambah
        </h2>
    </x-slot>

    <x-slot name="script">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                            <option value="{{ $id }}" {{ old('cooperation_id') == $id ? 'selected' : '' }}>
                                {{ $id }} - {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Permasalahan</label>
                    <textarea name="problem" class="w-full border rounded p-2 mb-4">{{ old('problem') }}</textarea>
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

</x-app-layout>
