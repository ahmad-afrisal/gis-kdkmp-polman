<x-app-layout>

    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>


        <x-slot name="script">

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
                        <span class="text-gray-500">Kontak Pengurus</span>
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

                    <form action="{{ route('contact-managements.store') }}" method="post" enctype="multipart/form-data"
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

                        <label class="block mb-2 font-medium">Ketua : </label>
                        <input type="text" name="leader_name" value="{{ old('leader_name') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Kontak Ketua : </label>
                        <input type="text" name="leader_phone_number" value="{{ old('leader_phone_number') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Wakil Ketua Bidang Anggota : </label>
                        <input type="text" name="name_of_deputy_member" value="{{ old('name_of_deputy_member') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Kontak Wakil Ketua Bidang Anggota : </label>
                        <input type="text" name="deputy_member_phone_number"
                            value="{{ old('deputy_member_phone_number') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Wakil Ketua Bidang Usaha : </label>
                        <input type="text" name="name_of_deputy_business"
                            value="{{ old('name_of_deputy_business') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Kontak Wakil Ketua Bidang Usaha : </label>
                        <input type="text" name="deputy_business_phone_number"
                            value="{{ old('deputy_business_phone_number') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Sekretaris : </label>
                        <input type="text" name="name_of_secretary" value="{{ old('name_of_secretary') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Kontak Sekretaris: </label>
                        <input type="text" name="secretary_phone_number" value="{{ old('secretary_phone_number') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Bendahara : </label>
                        <input type="text" name="name_of_treasurer" value="{{ old('name_of_treasurer') }}"
                            class="w-full border
                    rounded p-2 mb-4">

                        <label class="block mb-2 font-medium">Kontak Bendahara: </label>
                        <input type="text" name="treasurer_phone_number" value="{{ old('treasurer_phone_number') }}"
                            class="w-full border
                    rounded p-2 mb-4">



                        <div class="flex space-x-2">
                            <button type="submit"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                                Simpan
                            </button>
                            <a href="{{ route('contact-managements.index') }}"
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
