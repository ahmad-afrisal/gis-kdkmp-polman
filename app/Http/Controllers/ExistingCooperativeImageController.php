<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExistingCooperativeImageStoreRequest;
use App\Models\ExistingCooperative;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ExistingCooperativeImageController extends Controller
{
    public function index(string $existingCooperativeId)
    {
        $cooperative = ExistingCooperative::with('images')->findOrFail($existingCooperativeId);

        return view('existing-cooperative.images', compact('cooperative'));
    }

    public function store(ExistingCooperativeImageStoreRequest $request, string $existingCooperativeId)
    {
        $cooperative = ExistingCooperative::findOrFail($existingCooperativeId);

        foreach ($request->validated('images') as $image) {
            $path = $image->store("existing-cooperatives/{$cooperative->id}/images", 'public');

            if ($path === false) {
                throw new RuntimeException('Gambar koperasi gagal disimpan.');
            }

            $cooperative->images()->create(['path' => $path]);
        }

        return redirect()->route('existing-cooperatives.images.index', $cooperative)
            ->with('success', 'Gambar koperasi berhasil ditambahkan.');
    }

    public function destroy(string $existingCooperativeId, string $imageId)
    {
        $cooperative = ExistingCooperative::findOrFail($existingCooperativeId);
        $image = $cooperative->images()->findOrFail($imageId);

        if (Storage::disk('public')->exists($image->path)
            && ! Storage::disk('public')->delete($image->path)) {
            throw new RuntimeException('Gambar koperasi gagal dihapus dari penyimpanan.');
        }

        $image->delete();

        return redirect()->route('existing-cooperatives.images.index', $cooperative)
            ->with('success', 'Gambar koperasi berhasil dihapus.');
    }
}
