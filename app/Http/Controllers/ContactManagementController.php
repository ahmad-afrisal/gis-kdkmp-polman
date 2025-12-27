<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactManagementStoreRequest;
use App\Http\Requests\ContactManagementUpdateRequest;
use App\Models\ContactManagement;
use App\Models\Cooperation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = ContactManagement::orderBy('updated_at', 'desc');
            // $query = Problem::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('contact-managements.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                ';
                })
                ->addColumn('cooperation', function ($item) {
                    return $item->cooperation ? $item->cooperation->name : '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('contact-management.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cooperations = Cooperation::pluck('name', 'id');

        return view(
            'contact-management.create',
            [
                'cooperations' => $cooperations,
            ]
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
