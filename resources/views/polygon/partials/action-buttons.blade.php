<a href="{{ route('polygons.edit', $item->id) }}"
    class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
    Edit
</a>
<a href="{{ route('polygons.show', $item->id) }}"
    class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded shadow-lg">
    Detail
</a>

<form class="inline-block" action="{{ route('polygons.destroy', $item->id) }}" method="POST">
    @method('delete')
    @csrf
    <button
        class="inline-flex items-center justify-center bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded shadow-lg">
        Hapus
    </button>
</form>
