<?php

namespace App\Http\Controllers;

use App\Exports\ProblemsExport;
use App\Http\Requests\ProblemStoreRequest;
use App\Http\Requests\ProblemUpdateRequest;
use App\Models\Cooperation;
use App\Models\Problem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Problem::orderBy('updated_at', 'desc');
            // $query = Problem::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('ba', fn($item) => $item->cooperation->bussinessAssistant->name ?? '-')
                ->addColumn('district', fn($item) => $item->cooperation->village->district->name ?? '-')
                ->addColumn('action', function ($item) {
                        return '
                        <a href="' . route('problems.edit', $item->id) . '" 
                            class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                            Edit
                        </a>

                    ';
                    })
                    ->editColumn('cooperation_id', function ($row) {
                        return $row->cooperation->name;
                    })
                    ->editColumn('date_problem', function ($row) {
                    // Contoh: 02 April 2026
                    return $row->date_problem 
                        ? Carbon::parse($row->date_problem)->locale('id')->translatedFormat('d F Y') 
                        : '-';
                })
                ->editColumn('updated_at', function ($row) {
                    // Contoh: Kamis, 02 April 2026 14:30
                    return Carbon::parse($row->updated_at)->locale('id')->translatedFormat('l, d F Y H:i');
                })
                ->rawColumns(['action', 'date_problem', 'updated_at'])
                ->make(true);
        }


        return view('problem.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cooperations = Cooperation::pluck('name', 'id');

        return view(
            'problem.create',
            [
                'cooperations' => $cooperations,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProblemStoreRequest $request)
    {
        $data = $request->validated();
        Problem::create($data);

        return redirect()->route('problems.index')->with('success', 'Problem berhasil ditambahkan.');
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
    public function edit(Problem $problem)
    {
        $cooperations = Cooperation::pluck('name', 'id');

        return view(
            'problem.edit',
            [
                'problem' => $problem,
                'cooperations' => $cooperations,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProblemUpdateRequest $request, Problem $problem)
    {
        $data = $request->validated();
        $problem->update($data);

        return redirect()->route('problems.index')->with('success', 'Problem berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Problem $problem)
    {
        $problem->delete();

        return redirect()->route('problems.index')->with('success', 'Problem berhasil dihapus.');
    }

    public function exportExcel() 
    {
        $fileName = 'Laporan_Permasalahan_' . date('Y-m-d_H-i') . '.xlsx';
        return Excel::download(new ProblemsExport, $fileName);
    }
}
