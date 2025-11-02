<?php

namespace App\Http\Controllers;

use App\Models\BussinessAssistant;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BussinessAssistantController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = BussinessAssistant::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('bussiness-assistants.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                    <form class="inline-block" action="' . route('bussiness-assistants.destroy', $item->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')">
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

        return view('bussiness-assistants.index');
    }

    
}
