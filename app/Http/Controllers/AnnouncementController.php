<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementStoreRequest;
use App\Http\Requests\AnnouncementUpdateRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Announcement::orderBy('updated_at', 'desc');
            // $query = Problem::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('file', function ($item) {
                    if (!$item->file) {
                        return '<span class="text-gray-400 italic">Tidak ada file</span>';
                    }

                    return '
            <a href="' . asset('storage/' . $item->file) . '" 
               target="_blank"
               class="text-blue-600 hover:underline">
               Lihat File
            </a>
        ';
                })->addColumn('content', function ($item) {
                    return $item->content; // HTML
                })
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
            <a href="' . route('announcements.edit', $item->id) . '" 
                class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                Edit
            </a>
        ';
                })
                ->rawColumns(['content', 'file', 'is_active', 'action'])
                ->make(true);
        }


        return view('announcement.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementStoreRequest $request)
    {
        $data = $request->validated();

        // 🔹 Cek apakah ada file
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Simpan ke storage/app/public/announcements
            $path = $file->store('announcements', 'public');

            // Simpan path ke database
            $data['file'] = $path;
        }

        Announcement::create($data);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {

        return view(
            'announcement.edit',
            [
                'data' => $announcement,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnnouncementUpdateRequest $request, Announcement $announcement)
    {
        $data = $request->validated();

        $announcement->update($data);
        return to_route('announcements.index')->with('success', 'Pengumuman berhasil diupdate');
    }
}
