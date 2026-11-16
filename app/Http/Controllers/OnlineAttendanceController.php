<?php

namespace App\Http\Controllers;

use App\Http\Requests\OnlineAttendanceStoreRequest;
use App\Http\Requests\OnlineAttendanceUpdateRequest;
use App\Imports\OnlineAttendanceImport;
use App\Models\BussinessAssistant;
use App\Models\OnlineAttendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OnlineAttendanceController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $startInput = $request->get('start_date');
        $endInput = $request->get('end_date');

        // Query untuk Chart: Hitung kehadiran per Nama BA
        $chartQuery = OnlineAttendance::join('bussiness_assistants', 'online_attendances.bussiness_assistant_id', '=', 'bussiness_assistants.id')
            ->select(
                'bussiness_assistants.name',
                DB::raw('count(*) as total')
            );

        if ($startInput && $endInput) {
            $chartQuery->whereBetween('online_attendances.date', [$startInput, $endInput]);
        }

        $attendanceData = $chartQuery->groupBy('bussiness_assistants.name')
                                    ->orderBy('total', 'DESC')
                                    ->get();

        // Data untuk Chart.js
        $labels = $attendanceData->pluck('name'); // Nama-nama BA
        $values = $attendanceData->pluck('total'); // Jumlah kehadirannya

        if (request()->ajax()) {
            $query = OnlineAttendance::orderBy('updated_at', 'desc');
            // $query = Problem::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('ba', fn($item) => $item->bussinessAssistant->name ?? '-')
                ->addColumn('action', function ($item) {
                        return '
                        <a href="' . route('online-attendances.edit', $item->id) . '" 
                            class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                            Edit
                        </a>
                    ';
                    })

                    ->editColumn('date', function ($row) {
                    // Contoh: 02 April 2026
                    return $row->date 
                        ? Carbon::parse($row->date)->locale('id')->translatedFormat('d F Y') 
                        : '-';

                    
                })
                ->editColumn('check_in', function ($row) {
                    // Contoh: 02 April 2026
                    return $row->check_in
                        ? Carbon::parse($row->check_in)->locale('id')->translatedFormat('H:i') 
                        : '-';
                    })

                ->editColumn('updated_at', function ($row) {
                    // Contoh: Kamis, 02 April 2026 14:30
                    return Carbon::parse($row->updated_at)->locale('id')->translatedFormat('l, d F Y H:i');
                })
                ->rawColumns(['action', 'date', 'updated_at'])
                ->make(true);
        }

          $startInput = $request->get('start_date');
        $endInput = $request->get('end_date');

        return view('online-attendance.index', compact('labels', 'values', 'startInput', 'endInput'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businessAssistants = BussinessAssistant::pluck('name', 'id');

        return view(
            'online-attendance.create',
            [
                'businessAssistants' => $businessAssistants,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OnlineAttendanceStoreRequest $request)
    {
        $data = $request->validated();
        OnlineAttendance::create($data);

        return redirect()->route('online-attendances.index')->with('success', 'Kehadiran berhasil ditambahkan.');
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
    public function edit(OnlineAttendance $onlineAttendance)
    {
        $businessAssistants = BussinessAssistant::pluck('name', 'id');


        return view(
            'online-attendance.edit',
            [
                'onlineAttendance' => $onlineAttendance,
                'businessAssistants' => $businessAssistants,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OnlineAttendanceUpdateRequest $request, OnlineAttendance $onlineAttendance)
    {
        $data = $request->validated();
        $onlineAttendance->update($data);

        return redirect()->route('online-attendances.index')->with('success', 'kehadiran berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Problem $problem)
    {
        $problem->delete();

        return redirect()->route('problems.index')->with('success', 'Problem berhasil dihapus.');
    }

    // public function exportExcel() 
    // {
    //     $fileName = 'Laporan_Permasalahan_' . date('Y-m-d_H-i') . '.xlsx';
    //     return Excel::download(new ProblemsExport, $fileName);
    // }

    public function import(Request $request) 
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new OnlineAttendanceImport, $request->file('file_excel'));
            return back()->with('success', 'Data Absensi Berhasil Diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteByMonth(Request $request)
    {
        $request->validate([
            'bussiness_assistant_id' => 'required|exists:bussiness_assistants,id',
            'month' => 'required' // Format: YYYY-MM
        ]);

        // Pecah format YYYY-MM
        [$year, $month] = explode('-', $request->month);

        $deletedCount = \App\Models\OnlineAttendance::where('bussiness_assistant_id', $request->bussiness_assistant_id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->delete();

        if ($deletedCount > 0) {
            return back()->with('success', "$deletedCount data absensi berhasil dihapus.");
        }

        return back()->with('error', "Tidak ada data yang ditemukan untuk periode tersebut.");
    }
}
