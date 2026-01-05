<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

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



        $districtId = request('district_id');

        $records = DB::table('record_form_sevens')
            ->join('cooperations', 'record_form_sevens.cooperation_id', '=', 'cooperations.id')
            ->join('villages', 'cooperations.village_id', '=', 'villages.id')
            ->join('districts', 'villages.district_id', '=', 'districts.id')
            ->when($districtId, function ($q) use ($districtId) {
                $q->where('districts.id', $districtId);
            })
            ->select(
                'cooperations.id as coop_id',
                'cooperations.name as coop_name',
                'record_form_sevens.periode',
                'record_form_sevens.number_of_member'
            )
            ->orderBy('record_form_sevens.periode')
            ->get();

        $periods = $records->pluck('periode')->unique()->values();

        $datasets = $records
            ->groupBy('coop_name')
            ->map(function ($items, $coopName) use ($periods) {

                $data = $periods->map(function ($periode) use ($items) {
                    return optional(
                        $items->firstWhere('periode', $periode)
                    )->number_of_member ?? null;
                });

                return [
                    'label' => $coopName,
                    'data' => $data,
                    'tension' => 0.3,
                ];
            })
            ->values();

        return view('weekly-report.index', [
            'districts' => District::orderBy('name')->get(),
            'labels' => $periods,
            'datasets' => $datasets,
        ]);
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
