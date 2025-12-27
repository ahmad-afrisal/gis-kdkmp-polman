<?php

namespace App\Http\Controllers;

use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class WeeklyReportController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = WeeklyReport::orderBy('updated_at', 'desc');
            // $query = Problem::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->translatedFormat('d M Y, H:i');
                })
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('weekly-reports.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('weekly-report.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view(
            'weekly-report.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactManagementStoreRequest $request)
    {
        $data = $request->validated();
        ContactManagement::create($data);

        return redirect()->route('contact-managements.index')->with('success', 'Contact Management berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactManagement $contactManagement)
    {
        $cooperations = Cooperation::pluck('name', 'id');


        return view(
            'contact-management.edit',
            [
                'data' => $contactManagement,
                'cooperations' => $cooperations,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactManagementUpdateRequest $request, ContactManagement $contactManagement)
    {
        $data = $request->validated();

        $contactManagement->update($data);
        return to_route('contact-managements.index')->with('success', 'Kontak Pengurus berhasil diupdate');
    }
}
