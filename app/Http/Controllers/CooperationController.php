<?php

namespace App\Http\Controllers;

use App\Http\Requests\CooperationStoreRequest;
use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CooperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Cooperation::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('cooperations.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                    <form class="inline-block" action="' . route('cooperations.destroy', $item->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')">
                        ' . csrf_field() . method_field('delete') . '
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 mx-3 rounded shadow-lg">
                            Hapus
                        </button>
                    </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Ambil data titik untuk peta
        $locations = Cooperation::select('name', 'latitude', 'longtitude', 'full_address',  'subdomain')->whereNotNull('latitude')->get();

        $villages = Village::select('id', 'type', 'name', 'geojson')->get();

        $districts = District::select('id', 'name', 'geojson')->get();


        return view('cooperation.index', compact('locations', 'villages', 'districts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villages = Village::pluck('name', 'id');
        $bussinessAssistants = BussinessAssistant::pluck('name', 'id');

        return view('cooperation.create', compact('villages', 'bussinessAssistants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CooperationStoreRequest $request)
    {
        Cooperation::create($request->validated());

        return redirect()->route('cooperations.index')
            ->with('success', 'Data koperasi berhasil disimpan.');
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
    public function edit(Cooperation $cooperation)
    {
        return view('cooperation.edit', compact('cooperation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
