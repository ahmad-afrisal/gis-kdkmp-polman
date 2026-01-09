<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkDriveStoreRequest;
use App\Http\Requests\LinkDriveUpdateRequest;
use App\Models\LinkDrive;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LinkDriveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = LinkDrive::orderBy('updated_at', 'desc');
            // $query = Problem::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('link', function ($item) {
                    return '<a href="' . $item->link . '" 
                    target="_blank"
                    class="text-blue-600 hover:underline">
                    ' . $item->link . '
                </a>';
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 1) {
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
            <a href="' . route('link-drives.edit', $item->id) . '" 
                class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                Edit
            </a>
        ';
                })
                ->rawColumns(['link', 'status', 'action'])
                ->make(true);
        }


        return view('link-drive.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('link-drive.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkDriveStoreRequest $request)
    {
        $data = $request->validated();
        LinkDrive::create($data);

        return redirect()->route('link-drives.index')->with('success', 'Link Drive berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LinkDrive $linkDrive)
    {

        return view(
            'link-drive.edit',
            [
                'data' => $linkDrive,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkDriveUpdateRequest $request, LinkDrive $linkDrive)
    {
        $data = $request->validated();

        $linkDrive->update($data);
        return to_route('link-drives.index')->with('success', 'Link Drive berhasil diupdate');
    }
}
