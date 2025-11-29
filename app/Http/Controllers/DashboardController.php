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

        $totalDesa = Village::count();

        // NIB
        $desaNIB = Village::whereHas('cooperation.formThree', function ($q) {
            $q->whereNotNull('nib')->where('nib', '!=', '');
        })->count();


        $desaBelumNIB = $totalDesa - $desaNIB;

        // SIMKOPDES
        $simkopdesYa = Village::whereHas('cooperation', function ($q) {
            $q->where('microsite_account', 1); // sesuaikan field
        })->count();

        $simkopdesTidak = $totalDesa - $simkopdesYa;

        // NPWP
        $bankYa = Village::whereHas('cooperation.formThree', function ($q) {
            $q->whereNotNull('cooperative_bank_account')->where('cooperative_bank_account', '!=', '');
        })->count();

        $bankTidak = $totalDesa - $bankYa;

        $npwpYa = Village::whereHas('cooperation.formThree', function ($q) {
            $q->whereNotNull('npwp')->where('npwp', '!=', '');
        })->count();

        $npwpTidak = $totalDesa - $npwpYa;

        $districts = District::with(['villages.cooperation', 'villages.cooperation.formTwo'])->get();

        $reportOnes = $districts->map(function ($district) {

            $villages = $district->villages;

            return [
                'district'        => $district->name,
                'total_villages'  => $villages->count(),
                'total_kdkmp'     => $villages->whereNotNull('cooperation.name')->count(),
                'total_sk_ahu'    => $villages->whereNotNull('cooperation.legal_entity_number')->count(),
                'total_nib'       => $villages->where('cooperation.formThree.nib', 1)->count(),
                'total_nik'       => $villages->where('cooperation.formThree.cooperative_nik', 1)->count(),
            ];
        });

        $reportTwos = $districts->map(function ($district) {

            $villages = $district->villages;

            $coops = $villages->pluck('cooperation')->filter();

            return [
                'district' => $district->name,
                'total_villages' => $villages->count(),

                // Sembako
                'basic_yes' => $coops->where('formTwo.basic_necessities_exist', 1)->count(),
                'basic_no'  => $coops->where('formTwo.basic_necessities_exist', 0)->count(),

                // Apotik
                'pharmacy_yes' => $coops->where('formTwo.pharmacy_exist', 1)->count(),
                'pharmacy_no'  => $coops->where('formTwo.pharmacy_exist', 0)->count(),

                // Klinik
                'clinic_yes' => $coops->where('formTwo.clinic_exist', 1)->count(),
                'clinic_no'  => $coops->where('formTwo.clinic_exist', 0)->count(),

                // Simpan Pinjam
                'loan_yes' => $coops->where('formTwo.savings_and_loan_exist', 1)->count(),
                'loan_no'  => $coops->where('formTwo.savings_and_loan_exist', 0)->count(),

                // Pergudangan (logistics)
                'logistics_yes' => $coops->where('formTwo.logistics_exist', 1)->count(),
                'logistics_no'  => $coops->where('formTwo.logistics_exist', 0)->count(),

                // Gudang Penyimpanan (storage)
                'storage_yes' => $coops->where('formTwo.storage_exist', 1)->count(),
                'storage_no'  => $coops->where('formTwo.storage_exist', 0)->count(),

                // Usaha Lain
                'other_yes' => $coops->where('formTwo.other_businesses_exist', 1)->count(),
                'other_no'  => $coops->where('formTwo.other_businesses_exist', 0)->count(),
            ];
        });

        $reportThrees = $districts->map(function ($district) {

            $villages = $district->villages;
            $coops = $villages->pluck('cooperation')->filter();

            // template row gerai
            $types = [
                'Sembako',
                'Apotik',
                'Klinik',
                'Simpan Pinjam',
                'Pergudangan',
                'Usaha Lain'
            ];

            $rows = [];

            foreach ($types as $type) {

                $forms = collect();

                foreach ($coops as $coop) {
                    $forms = $forms->merge(
                        optional($coop->formFives)
                            ->where('branch_type', $type) ?? []
                    );
                }

                $rows[] = [
                    'branch_type' => $type,
                    'business_volume' => $forms->sum('business_volume'),
                    'total_assets' => $forms->sum('total_assets'),
                    'profit' => $forms->where('profit_loss', '>', 0)->sum('profit_loss'),
                    'loss' => $forms->where('profit_loss', '<', 0)->sum('profit_loss') * -1,
                ];
            }

            return [
                'district' => $district->name,
                'total_villages' => $villages->count(),
                'total_kdkmp' => $coops->count(), // atau field Anda sendiri
                'rows' => $rows
            ];
        });

        // return view('reports.report-three', compact('reportThrees'));

        $reportFours = $districts->map(function ($district) {

            $villages = $district->villages;

            $coops = $villages->pluck('cooperation')->filter();

            return [
                'district' => $district->name,
                'total_villages' => $villages->count(),

                // Sembako
                'basic_yes' => $coops->where('formTwo.basic_necessities_running', 1)->count(),
                'basic_no'  => $coops->where('formTwo.basic_necessities_running', 0)->count(),

                // Apotik
                'pharmacy_yes' => $coops->where('formTwo.pharmacy_running', 1)->count(),
                'pharmacy_no'  => $coops->where('formTwo.pharmacy_running', 0)->count(),

                // Klinik
                'clinic_yes' => $coops->where('formTwo.clinic_running', 1)->count(),
                'clinic_no'  => $coops->where('formTwo.clinic_running', 0)->count(),

                // Simpan Pinjam
                'loan_yes' => $coops->where('formTwo.savings_and_loan_running', 1)->count(),
                'loan_no'  => $coops->where('formTwo.savings_and_loan_running', 0)->count(),

                // Pergudangan (logistics)
                'logistics_yes' => $coops->where('formTwo.logistics_running', 1)->count(),
                'logistics_no'  => $coops->where('formTwo.logistics_running', 0)->count(),

                // Gudang Penyimpanan (storage)
                'storage_yes' => $coops->where('formTwo.storage_running', 1)->count(),
                'storage_no'  => $coops->where('formTwo.storage_running', 0)->count(),

                // Usaha Lain
                'other_yes' => $coops->where('formTwo.other_businesses_running', 1)->count(),
                'other_no'  => $coops->where('formTwo.other_businesses_running', 0)->count(),
            ];
        });

        // return view('reports.districts', compact('reports'));

        // Mengirimkan data ke view
        return view('dashboard', [
            'districtCount' => $districtCount,
            'villageCount' => $villageCount,
            'bussinessAssistantCount' => $bussinessAssistantCount,
            'cooperationCount' => $cooperationCount,
            'reportOnes' => $reportOnes,
            'reportTwos' => $reportTwos,
            'reportThrees' => $reportThrees,
            'reportFours' => $reportFours,
            'totalDesa' => $totalDesa,
            'desaNIB' => $desaNIB,
            'desaBelumNIB' => $desaBelumNIB,
            'simkopdesYa' => $simkopdesYa,
            'simkopdesTidak' => $simkopdesTidak,
            'npwpYa' => $npwpYa,
            'npwpTidak' => $npwpTidak,
            'bankYa' => $bankYa,
            'bankTidak' => $bankTidak,
            // 'lands' => Land::with(['user', 'oilPalmType'])->get(),
        ]);
    }
}
