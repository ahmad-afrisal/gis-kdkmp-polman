<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $query = Cooperation::with([
                'village:id,name,district_id',
                'village.district:id,name',
                'bussinessAssistant:id,name',
            ]);

            return DataTables::of($query)
                ->addColumn('ba', fn($item) => $item->bussinessAssistant->name ?? '-')
                ->addColumn('district', fn($item) => $item->village->district->name ?? '-')

                ->make(true);
        }

        $districts = District::select('id', 'name')->get();
        $assistants = BussinessAssistant::select('id', 'name')->get();

        // Ambil data titik untuk peta
        $locations = Cooperation::select('name', 'latitude', 'longtitude', 'full_address',  'subdomain')->whereNotNull('latitude')->get();

        $villages = Village::select('id', 'type', 'name', 'geojson')->get();

        $districts = District::select('id', 'name', 'geojson')->get();

        return view('welcome', compact('districts', 'assistants', 'locations', 'villages'));
    }

    public function filter(Request $request)
    {
        $type = $request->type;
        $id = $request->id;

        $data = [];

        if ($type === 'kecamatan') {
            $district = District::find($id);
            if ($district && $district->geojson) {
                $data = json_decode($district->geojson);
            }
        } elseif ($type === 'desa') {
            $village = Village::find($id);
            if ($village && $village->geojson) {
                $data = json_decode($village->geojson);
            }
        } elseif ($type === 'ba') {
            $villages = Village::where('business_assistant_id', $id)->get();
            $features = [];
            foreach ($villages as $village) {
                if ($village->geojson) {
                    $features[] = json_decode($village->geojson);
                }
            }
            $data = [
                'type' => 'FeatureCollection',
                'features' => $features,
            ];
        }

        return response()->json($data);
    }

    public function articles()
    {
        // Mengambil data artikel dengan relasi koperasi, diurutkan dari yang terbaru
        $articles = Article::with('cooperation')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('articles', compact('articles'));
    }

    public function announcements()
    {
        // Mengambil pengumuman terbaru beserta data koperasi
        $announcements = Announcement::orderBy('created_at', 'desc')
            ->get();

        return view('announcements', compact('announcements'));
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function contact()
    {
        return view('contact');
    }

    public function performance($id)
    {
        $assistant = BussinessAssistant::findOrFail($id);
        return view('performance', compact('assistant'));
    }
}
