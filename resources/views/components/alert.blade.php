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
        <div class="border border-t-0 border-green-400 rounded-b bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    </div>
@endif
