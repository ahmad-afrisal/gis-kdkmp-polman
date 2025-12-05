<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePolygonRequest;
use App\Http\Requests\UpdatePolygonRequest;
use App\Models\Cooperation;
use App\Models\Polygon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PolygonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->ajax()) {
            $query = Polygon::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('cooperation', function ($item) {
                    return $item->cooperation ? $item->cooperation->name : '-';
                })
                ->addColumn('action', function ($item) {
                    return view('polygon.partials.action-buttons', compact('item'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $lands = Polygon::with('cooperation')->get();


        return view('polygon.index', compact('lands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cooperations = Cooperation::pluck('name', 'id');

        return view('polygon.create', [
            'cooperations' => $cooperations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePolygonRequest $request)
    {
        $data = $request->validated();
        Polygon::create($data);

        return redirect()->route('polygons.index')->with('success', 'Polygon berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Polygon $polygon)
    {
        $cooperations = Cooperation::pluck('name', 'id');

        return view('polygon.show', [
            'data' => $polygon,
            'cooperations' => $cooperations,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Polygon $polygon)
    {
        $cooperations = Cooperation::pluck('name', 'id');


        return view('polygon.edit', [
            'data' => $polygon,
            'cooperations' => $cooperations,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePolygonRequest $request, Polygon $polygon)
    {
        $data = $request->validated();
        $polygon->update($data);

        return redirect()->route('polygons.index')->with('success', 'Lahan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Land $land)
    {
        // Hapus lahan
        $land->delete();

        return to_route('lands.index')->with('success', 'Data lahan berhasil dihapus.');
    }
}
