<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Business Assistant &raquo; Tambah
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

            <form action="{{ route('contact-managements.store') }}" method="post" enctype="multipart/form-data"
                class="bg-white p-6 rounded-lg shadow-md">
                @csrf

                <label class="block mb-2 font-medium">Nama : </label>
                <input type="text" name="leader_name" value="{{ old('leader_name') }}"
                    class="w-full border
                    rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Nomor Handphone : </label>
                <input type="text" name="leader_phone_number" value="{{ old('leader_phone_number') }}"
                    class="w-full border
                    rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Alamat : </label>
                <input type="text" name="name_of_deputy_member" value="{{ old('name_of_deputy_member') }}"
                    class="w-full border
                    rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Tanggal Lahir : </label>
                <input type="date" name="deputy_member_phone_number" value="{{ old('deputy_member_phone_number') }}"
                    class="w-full border
                    rounded p-2 mb-4">

                <label class="block mb-2 font-medium">Foto : </label>
                <input type="file" name="name_of_deputy_business" value="{{ old('name_of_deputy_business') }}"
                    class="w-full border
                    rounded p-2 mb-4">


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
