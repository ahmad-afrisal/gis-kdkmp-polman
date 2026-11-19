<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExistingCooperativeStoreRequest;
use App\Http\Requests\ExistingCooperativeUpdateRequest;
use App\Models\BusinessActivity;
use App\Models\CooperativeStatus;
use App\Models\District;
use App\Models\ExistingCooperative;
use App\Models\Village;
use Yajra\DataTables\Facades\DataTables;

class ExistingCooperativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = ExistingCooperative::with('village');

            return DataTables::of($query)
                ->addColumn('village', fn ($item) => $item->village->name)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('existing-cooperatives.edit', $item->id) . '"
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                    <form action="' . route('existing-cooperatives.destroy', $item->id) . '" method="POST" class="inline-block"
                        onsubmit="return confirm(\'Hapus data koperasi ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                            Hapus
                        </button>
                    </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('existing-cooperative.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('existing-cooperative.create', [
            'cooperativeStatuses' => CooperativeStatus::pluck('name', 'id'),
            'businessActivities' => BusinessActivity::pluck('name', 'id'),
            'districts' => District::pluck('name', 'id'),
            'villages' => collect(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExistingCooperativeStoreRequest $request)
    {
        ExistingCooperative::create($request->validated());

        return redirect()->route('existing-cooperatives.index')
            ->with('success', 'Data koperasi berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        $data = ExistingCooperative::findOrFail($id);

        return view('existing-cooperative.create', [
            'data' => $data,
            'cooperativeStatuses' => CooperativeStatus::pluck('name', 'id'),
            'businessActivities' => BusinessActivity::pluck('name', 'id'),
            'districts' => District::pluck('name', 'id'),
            'villages' => collect(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExistingCooperativeUpdateRequest $request, string $id)
    {
        $cooperative = ExistingCooperative::findOrFail($id);
        $cooperative->update($request->validated());

        return redirect()->route('existing-cooperatives.index')
            ->with('success', 'Data koperasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cooperative = ExistingCooperative::findOrFail($id);
        $cooperative->delete();

        return redirect()->route('existing-cooperatives.index')
            ->with('success', 'Data koperasi berhasil dihapus.');
    }

    public function getVillages($district)
    {
        $villages = Village::where('district_id', $district)
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');

        return response()->json($villages);
    }
}
