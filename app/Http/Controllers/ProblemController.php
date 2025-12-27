<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProblemStoreRequest;
use App\Models\Cooperation;
use App\Models\Problem;
use Illuminate\Http\Request;
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
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('problems.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                    <form class="inline-block" action="' . route('problems.destroy', $item->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')">
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
