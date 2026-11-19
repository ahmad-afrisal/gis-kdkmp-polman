<x-app-layout>
    <div x-data="{ open: false }" class="flex h-screen bg-gray-100">
        @include('components.sidebar')

        <div x-show="open" @click="open=false" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>

        <main class="flex-1 overflow-y-auto">
            @include('components.header')

            <div class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <nav class="flex items-center text-sm text-gray-600 space-x-2 mb-6">
                        <a href="{{ route('dashboard') }}" class="hover:text-green-600">Home</a>
                        <span>›</span>
                        <a href="{{ route('cooperations.index') }}" class="hover:text-green-600">Koperasi</a>
                        <span>›</span>
                        <span class="text-green-600">Kelola Gambar</span>
                    </nav>

                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">Gambar {{ $cooperation->name }}</h1>
                        <p class="mt-1 text-sm text-gray-600">Tambahkan satu atau beberapa gambar untuk koperasi ini.</p>
                    </div>

                    @if (session('success'))
                        <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-800" role="status">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 rounded-lg border border-red-300 bg-red-100 p-4 text-red-700" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cooperations.images.store', $cooperation->id) }}"
                        method="POST" enctype="multipart/form-data"
                        class="mb-8 rounded-xl bg-white p-6 shadow-md">
                        @csrf
                        <label for="images" class="mb-2 block font-semibold text-gray-700">Pilih gambar</label>
                        <input id="images" type="file" name="images[]" accept=".jpg,.jpeg,.png,.webp"
                            multiple required
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-700">
                        <p class="mt-2 text-sm text-gray-500">Format JPG, JPEG, PNG, WEBP. Maksimal 10 MB per gambar.</p>
                        <button type="submit"
                            class="mt-4 rounded-lg bg-green-600 px-5 py-2 font-semibold text-white hover:bg-green-700">
                            Tambah Gambar
                        </button>
                    </form>

                    <section class="rounded-xl bg-white p-6 shadow-md">
                        <h2 class="mb-4 text-lg font-bold text-gray-800">
                            Gambar tersimpan ({{ $cooperation->images->count() }})
                        </h2>

                        @if ($cooperation->images->isEmpty())
                            <p class="text-gray-500">Belum ada gambar untuk koperasi ini.</p>
                        @else
                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($cooperation->images as $image)
                                    <article class="overflow-hidden rounded-lg border border-gray-200">
                                        <a href="{{ asset('storage/' . $image->path) }}" target="_blank" rel="noopener">
                                            <img src="{{ asset('storage/' . $image->path) }}"
                                                alt="Gambar {{ $cooperation->name }}"
                                                class="h-56 w-full object-cover">
                                        </a>
                                        <div class="flex items-center justify-between p-3">
                                            <span class="text-sm text-gray-500">
                                                {{ $image->created_at->format('d/m/Y H:i') }}
                                            </span>
                                            <form action="{{ route('cooperations.images.destroy', [$cooperation->id, $image->id]) }}"
                                                method="POST" onsubmit="return confirm('Hapus gambar ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-semibold text-red-600 hover:text-red-800">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </section>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
