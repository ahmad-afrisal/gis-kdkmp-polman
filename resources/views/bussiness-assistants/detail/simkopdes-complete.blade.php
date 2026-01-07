<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Overlay (mobile only) -->
        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

        <x-slot name="style">
            <style>
                /* Hilangkan input file asli */
                .hidden-file-input {
                    display: none;
                }
            </style>
        </x-slot>

        <x-slot name="script">

        </x-slot>

        <main class="flex-1 overflow-y-auto">

            @include('components.header')
            <div class="py-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Breadcrumb -->
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-7">
                        <a href="{{ route('dashboard') }}" class="flex items-center hover:text-green-600">
                            <i data-lucide="home" class="w-4 h-4 mr-1"></i> Home
                        </a>
                        <span>›</span>
                        <span class="text-gray-500">Business Assitant</span>
                        <span>›</span>
                        <span class="text-gray-500">Kelengkapan Simkopdes</span>
                    </nav>
                    @if (session('error'))
                        <div class="mb-5" role="alert">
                            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                Error
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-5" role="alert">
                            <div class="bg-green-500 text-white font-bold rounded-t px-4 py-2">
                                Berhasil
                            </div>
                            <div
                                class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @include('components.button-form')

                    <div class="bg-white shadow-xl rounded-lg p-6">

                        <form
                            action="{{ route('bussiness-assistants.simkopdes-completeness.store', $bussinessAssistant->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Scroll container --}}
                            <div class="overflow-x-auto rounded-lg border border-gray-300">
                                <table class="min-w-full text-sm text-center border-collapse">

                                    <thead>
                                        <tr class="bg-green-600 ">
                                            <th class="border border-gray-300 px-3 py-2">No</th>
                                            <th class="w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                                                Nama KDKMP
                                            </th>
                                            <th class=" min-w-[130px] border border-gray-300 px-3 py-2">Link Profile
                                            </th>
                                            <th class=" min-w-[130px] border border-gray-300 px-3 py-2">Status</th>

                                        </tr>

                                    </thead>

                                    <tbody class="text-gray-700">
                                        @forelse ($cooperations as $index => $coop)
                                            @php
                                                $form = $coop->simkopdesCompletenes; // Bisa null, aman
                                            @endphp
                                            <tr class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">
                                                <td class="border border-gray-300 px-2 py-1 font-medium text-center">
                                                    {{ $index + 1 }}
                                                </td>

                                                {{-- Nama Koperasi --}}
                                                <td class="border border-gray-300 px-2 py-1">
                                                    <input type="text" name="data[{{ $index }}][nama]"
                                                        value="{{ $coop->name ?? '' }}"
                                                        class="w-full border-gray-300 rounded-lg text-sm p-2 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                                </td>
                                                <td class="border border-gray-300 px-2 py-1">
                                                    <a href="{{ $coop->subdomain ?? '' }}"
                                                        target="_blank">{{ $coop->subdomain ?? '' }}</a>
                                                </td>

                                                {{-- Profil Koperasi --}}
                                                <td class="border border-gray-300 px-2 py-1 text-center">
                                                    <input type="checkbox" class="checkbox-status"
                                                        name="data[{{ $index }}][is_complete]" value="1"
                                                        {{ $form?->is_complete ? 'checked' : '' }}>
                                                </td>
                                                {{-- Hidden cooperation_id --}}
                                                <input type="hidden" name="data[{{ $index }}][cooperation_id]"
                                                    value="{{ $coop->id }}">


                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="17"
                                                    class="border border-gray-300 px-4 py-3 text-center text-gray-500 italic">
                                                    Tidak ada data koperasi untuk BA ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>


                            <div class="mt-6 text-right space-x-2">
                                <a href="{{ route('bussiness-assistants.show', $bussinessAssistant->id) }}"
                                    class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg shadow transition text-center">
                                    Kembali
                                </a>

                                <button type="submit"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition text-center">
                                    💾 Simpan Data
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
