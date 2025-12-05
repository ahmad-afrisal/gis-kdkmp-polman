<?php

namespace App\Http\Controllers;

use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
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

    public function gallery()
    {
        return view('gallery');
    }

    public function performance($id)
    {
        $assistant = BussinessAssistant::findOrFail($id);
        return view('performance', compact('assistant'));
    }
}
