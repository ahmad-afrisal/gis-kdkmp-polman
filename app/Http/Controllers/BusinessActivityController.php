<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessActivityStoreRequest;
use App\Http\Requests\BusinessActivityUpdateRequest;
use App\Models\BusinessActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BusinessActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = BusinessActivity::query();

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
                    <a href="' . route('business-activities.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                ';
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }
        $businessActivities = BusinessActivity::select('name')->get();

        return view('business-activity.index', compact('businessActivities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('business-activity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BusinessActivityStoreRequest $request)
    {
        $data = $request->validated();
        BusinessActivity::create($data);

        return redirect()->route('business-activities.index')->with('success', 'Kegiatan Usaha berhasil ditambahkan.');
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
    public function edit(BusinessActivity $businessActivity)
    {
        return view('business-activity.edit', [
            'data' => $businessActivity,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BusinessActivityUpdateRequest $request, BusinessActivity $businessActivity)
    {
        $data = $request->validated();

        // return $data;
        $businessActivity->update($data);

        return redirect()->route('business-activities.index')->with('success', 'Kegiatan Usaha berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
