<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommodityStoreRequest;
use App\Models\Commodity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CommodityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Commodity::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('image', function ($item) {
                    if ($item->image) {
                        return '<img src="' . asset('storage/' . $item->image) . '" alt="' . $item->name . '" width="50" height="50">';
                    } else {
                        return 'No Image';
                    }
                })
                ->addColumn('is_active', function ($item) {
                    if ($item->is_active == 1) {
                        return '<span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded">
                        Aktif
                    </span>';
                    } else {
                        return '<span class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">
                        Tidak Aktif
                    </span>';
                    }
                })
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('commodities.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                ';
                })
                ->rawColumns(['image', 'is_active', 'action'])
                ->make(true);
        }

        return view('commodity.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('commodity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommodityStoreRequest $request)
    {
        // 1. Ambil data yang sudah divalidasi
        $data = $request->validated();

        // 2. Cek apakah ada file gambar yang diupload
        if ($request->hasFile('image')) {
            // Simpan file ke folder 'public/plants' (otomatis buat folder jika belum ada)
            // 'public' di sini merujuk ke storage/app/public
            $imagePath = $request->file('image')->store('commodity', 'public');

            // Simpan nama/path file ke dalam array data untuk database
            $data['image'] = $imagePath;
        }

        // 3. Simpan ke database
        Commodity::create($data);

        return redirect()->route('commodities.index')
            ->with('success', 'Komoditi berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commodity $commodity)
    {
        // Laravel secara otomatis mencari data berdasarkan ID jika menggunakan Route Model Binding
        return view('commodity.edit', compact('commodity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommodityStoreRequest $request, Commodity $commodity)
    {
        // 1. Ambil data yang sudah divalidasi
        $data = $request->validated();

        // 2. Cek apakah ada file gambar baru yang diupload
        if ($request->hasFile('image')) {
            
            // Hapus gambar lama jika ada (agar storage tidak penuh)
            if ($commodity->image) {
                Storage::disk('public')->delete($commodity->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('commodity', 'public');
            $data['image'] = $imagePath;
        }

        // 3. Update data di database
        $commodity->update($data);

        return redirect()->route('commodities.index')
            ->with('success', 'Komoditi berhasil diperbarui.');
    }
}
