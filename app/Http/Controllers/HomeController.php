<?php

namespace App\Http\Controllers;

use App\Models\BussinessAssistant;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $districts = District::select('id', 'name')->get();
        $assistants = BussinessAssistant::select('id', 'name')->get();

        return view('welcome', compact('districts', 'assistants'));
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
}
