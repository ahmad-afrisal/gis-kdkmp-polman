<?php

namespace App\Http\Controllers;

use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard dengan jumlah data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $districtCount = District::count();

        $villageCount = Village::count();

        $bussinessAssistantCount = BussinessAssistant::count();

        $cooperationCount = Cooperation::count();

        // Mengirimkan data ke view
        return view('dashboard', [
            'districtCount' => $districtCount,
            'villageCount' => $villageCount,
            'bussinessAssistantCount' => $bussinessAssistantCount,
            'cooperationCount' => $cooperationCount,
            // 'lands' => Land::with(['user', 'oilPalmType'])->get(),
        ]);
    }
}
