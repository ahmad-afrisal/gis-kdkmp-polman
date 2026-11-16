<?php

namespace App\Http\Controllers;

use App\Http\Requests\CooperativeStatusStoreRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\CooperativeStatus;


class CooperativeStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = CooperativeStatus::query();

            return DataTables::of($query)
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
                    <a href="' . route('categories.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                ';
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('cooperative-status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cooperative-status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CooperativeStatusStoreRequest $request)
    {
        $data = $request->validated();

        CooperativeStatus::create($data);

        return redirect()->route('cooperative-statuses.index')->with('success', 'Status Koperasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view(
            'category.edit',
            [
                'data' => $category,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $data = $request->validated();

        // return $data;
        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
