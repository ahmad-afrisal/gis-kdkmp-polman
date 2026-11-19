<?php

namespace App\Http\Controllers;

use App\Http\Requests\CooperationImageStoreRequest;
use App\Models\Cooperation;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class CooperationImageController extends Controller
{
    public function index(string $cooperationId)
    {
        $cooperation = Cooperation::with('images')->findOrFail($cooperationId);

        return view('cooperation.images', compact('cooperation'));
    }

    public function store(CooperationImageStoreRequest $request, string $cooperationId)
    {
        $cooperation = Cooperation::findOrFail($cooperationId);

        foreach ($request->validated('images') as $image) {
            $path = $image->store("cooperations/{$cooperation->id}/images", 'public');

            if ($path === false) {
                throw new RuntimeException('Gambar koperasi gagal disimpan.');
            }

            $cooperation->images()->create(['path' => $path]);
        }

        return redirect()->route('cooperations.images.index', $cooperation)
            ->with('success', 'Gambar koperasi berhasil ditambahkan.');
    }

    public function destroy(string $cooperationId, string $imageId)
    {
        $cooperation = Cooperation::findOrFail($cooperationId);
        $image = $cooperation->images()->findOrFail($imageId);

        if (Storage::disk('public')->exists($image->path)
            && ! Storage::disk('public')->delete($image->path)) {
            throw new RuntimeException('Gambar koperasi gagal dihapus dari penyimpanan.');
        }

        $image->delete();

        return redirect()->route('cooperations.images.index', $cooperation)
            ->with('success', 'Gambar koperasi berhasil dihapus.');
    }
}
