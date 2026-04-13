<?php

namespace App\Http\Controllers;

use App\Exports\FormSixExport;
use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\District;
use App\Models\FormSix;
use App\Models\Polygon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class LandStatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = FormSix::whereNotNull('asset')->with([
                'cooperation:id,name,bussiness_assistant_id,village_id',
                'cooperation.village:id,name,district_id',
                'cooperation.village.district:id,name',
                'cooperation.bussinessAssistant:id,name',
            ]);

            return DataTables::of($query)
                ->addColumn('cooperation', fn($item) => $item->cooperation->name ?? '-')
                ->addColumn('ba', fn($item) => $item->cooperation->bussinessAssistant->name ?? '-')
                ->addColumn('district', fn($item) => $item->cooperation->village->district->name ?? '-')
                ->addColumn('picture_land', function ($item) {
                    if ($item->picture_land) {
                        $url = asset('storage/' . $item->picture_land);
                        return "<img src='{$url}' class='w-14 h-14 object-cover rounded-md border' />";
                    }
                    return "<span class='text-gray-400'>-</span>";
                })
                ->addColumn('letter_land', function ($item) {
                    if ($item->letter_land) {
                        $url = asset('storage/' . $item->letter_land);
                        return "<img src='{$url}' class='w-14 h-14 object-cover rounded-md border' />";
                    }
                    return "<span class='text-gray-400'>-</span>";
                })
                ->addColumn('coordinate', function ($item) {
                    if ($item->latitude && $item->longitude) {
                        return $item->latitude . ', ' . $item->longitude;
                    }
                    return "<span class='text-gray-400'>-</span>";
                })
                    ->addColumn('is_build', function ($item) {

                    if ($item->is_build) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            YA
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Tidak
                    </span>';
                })
                ->addColumn('action', function ($item) {
                    return '
                <a href="' . route('land-statistics.edit', $item->id) . '" 
                    class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                    Edit
                </a>
            ';
                })
                ->rawColumns(['action', 'is_build', 'picture_land', 'letter_land', 'coordinate'])
                ->make(true);
        }


        // AMBIL HANYA DATA YANG asset-nya TERISI
        $validData = FormSix::whereNotNull('asset')->get();

        // Hitung statistik berdasarkan data yang asset-nya terisi
        $data = [
            'asset' => $validData->pluck('asset')
                ->groupBy(fn($item) => $item)
                ->map->count(),

            'internet_access' => $validData->pluck('internet_access')
                ->groupBy(fn($item) => $item)
                ->map->count(),

            'water_access' => $validData->pluck('water_access')
                ->groupBy(fn($item) => $item)
                ->map->count(),

            'electricity_access' => $validData->pluck('electricity_access')
                ->groupBy(fn($item) => $item)
                ->map->count(),
        ];

         // Contoh di Controller
        $totalCooperation = Cooperation::count(); // Total semua KDKMP
        $totalBuild = FormSix::where('is_build', 1)->count(); // Sesuaikan dengan field DB Anda
        $percentage = $totalCooperation > 0 ? ($totalBuild / $totalCooperation) * 100 : 0;

        
        $totalLand = FormSix::whereNotNull('asset')->count(); // Sesuaikan dengan field DB Anda
        $percentageLand = $totalCooperation > 0 ? ($totalLand / $totalCooperation) * 100 : 0;

        $districtStats = District::with(['villages.cooperation.formSix'])
            ->get()
            ->mapWithKeys(function ($district) {

                // Hitung lahan di kecamatan ini
                $count = FormSix::whereNotNull('asset')
                    ->whereHas('cooperation.village', function ($q) use ($district) {
                        $q->where('district_id', $district->id);
                    })
                    ->count();

                return [
                    $district->name => $count  // <-- Label kecamatan
                ];
            });

        $lands = Polygon::with('cooperation')->get();

        $districtBuildStats = District::withCount(['cooperations as district_total_build' => function ($query) {
            $query->whereHas('formSix', function ($q) {
                $q->where('is_build', true);
            });
        }])->get();

        // 2. Ambil data Statistik Business Assistant
        $assistantData = BussinessAssistant::withCount(['cooperations as total_build' => function ($query) {
            $query->whereHas('formSix', fn($q) => $q->where('is_build', 1));
        }])->get();


        // dd($assistantData);


        return view('land-statistic.index', [      
        // Data untuk Chart Business Assistant
            'assistantLabels' => $assistantData->pluck('name'),
            'assistantValues' => $assistantData->pluck('total_build'),
            'districtBuildLabels' => $districtBuildStats->pluck('name'),
            'districtBuildValues' => $districtBuildStats->pluck('district_total_build'),
            'totalCooperation' => $totalCooperation, 
            'totalBuild' => $totalBuild, 
            'totalLand' => $totalLand, 
            'percentage' => $percentage, 
            'percentageLand' => $percentageLand, 
            'data' => $data, 
            'districtStats' => $districtStats, 
            'lands' => $lands
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new FormSixExport, 'data-lahan.xlsx');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
