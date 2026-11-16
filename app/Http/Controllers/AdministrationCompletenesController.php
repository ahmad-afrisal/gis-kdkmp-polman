<?php

namespace App\Http\Controllers;

use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\District;
use App\Models\FormThree;
use App\Models\Village;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdministrationCompletenesController extends Controller
{
    public function index()
    {
        $districtCount = District::count();

        $villageCount = Village::count();

        $villageTypeDesaCount = Village::where('type', 'Desa')->count();
        $villageTypeKelurahanCount = Village::where('type', 'Kelurahan')->count();


        $bussinessAssistantCount = BussinessAssistant::count();

        $cooperationCount = Cooperation::count();

        $totalDesa = Village::count();

        $bhDeedYes = Cooperation::whereHas('formThree', function ($q) {
            $q->where('bh_deed', 1);
        })->count();

        $bhDeedNo = $cooperationCount - $bhDeedYes;

        $cooperativeNikYes = Cooperation::whereHas('formThree', function ($q) {
            $q->where('cooperative_nik', 1);
        })->count();
        $cooperativeNikNo = $cooperationCount - $cooperativeNikYes;

        // NIB
        $desaNIB = Village::whereHas('cooperation.formThree', function ($q) {
            $q->whereNotNull('nib')->where('nib', '!=', '');
        })->count();


        $desaBelumNIB = $totalDesa - $desaNIB;


        $landYes = Cooperation::whereHas('formSix', function ($q) {
            $q->whereNotNull('asset');
        })->count();

        $landNo = $cooperationCount - $landYes;


        $bankYa = Village::whereHas('cooperation.formThree', function ($q) {
            $q->whereNotNull('cooperative_bank_account')->where('cooperative_bank_account', '!=', '');
        })->count();

        $bankTidak = $totalDesa - $bankYa;

        $npwpYa = Village::whereHas('cooperation.formThree', function ($q) {
            $q->whereNotNull('npwp')->where('npwp', '!=', '');
        })->count();

        $npwpTidak = $totalDesa - $npwpYa;

        $businessPlanYes = Village::whereHas('cooperation.formThree', function ($q) {
            $q->whereNotNull('business_activity_plan')->where('business_activity_plan', '!=', '');
        })->count();

        $businessPlanNo = $totalDesa - $businessPlanYes;

        $financingProposalYes = Village::whereHas('cooperation.formFour', function ($q) {
            $q->whereNotNull('financing_proposal')->where('financing_proposal', '!=', '');
        })->count();

        $financingProposalNo = $totalDesa - $financingProposalYes;

        $capexYes = Cooperation::whereHas('formThree', function ($q) {
            $q->where('capex', 1);
        })->count();

        $capexNo = $cooperationCount - $capexYes;

        $opexYes = Cooperation::whereHas('formThree', function ($q) {
            $q->where('opex', 1);
        })->count();

        $opexNo = $cooperationCount - $opexYes;

        $otherEquipmentYes = Cooperation::whereHas('formThree', function ($q) {
            $q->where('other_equipment', 1);
        })->count();

        $otherEquipmentNo = $cooperationCount - $otherEquipmentYes;



        // Statistik per Business Assistant
        $nibData = BussinessAssistant::withCount([
            'cooperations as total_nib' => function ($query) {
                $query->whereHas('formThree', function ($q) {
                    $q->whereNotNull('nib')
                        ->where('nib', '!=', '');
                });
            }
        ])->get();



        /*
        |--------------------------------------------------------------------------
        | DATA CHART PER BUSINESS ASSISTANT
        |--------------------------------------------------------------------------
        */

        $nibChart = $this->getDocumentChart('nib');

        $npwpChart = $this->getDocumentChart('npwp');

        $bankChart = $this->getDocumentChart('cooperative_bank_account');

        $bankChart = $this->getDocumentChart('cooperative_bank_account');

        $businessPlanChart = $this->getDocumentChart('business_activity_plan');
        $capexChart = $this->getDocumentChart('capex');
        $opexChart = $this->getDocumentChart('opex');








        // Anggota Tabel

        if (request()->ajax()) {
            $query = FormThree::with([
                'cooperation:id,name,bussiness_assistant_id,village_id',
                'cooperation.village:id,name,district_id',
                'cooperation.village.district:id,name',
                'cooperation.bussinessAssistant:id,name',
            ]);

            return DataTables::of($query)
                ->addColumn('cooperation', fn($item) => $item->cooperation->name ?? '-')
                ->addColumn('ba', fn($item) => $item->cooperation->bussinessAssistant->name ?? '-')
                ->addColumn('district', fn($item) => $item->cooperation->village->district->name ?? '-')

                ->editColumn('nib', fn($item) => $this->formatStatus($item->nib ?? false))
                ->editColumn('bh_deed', fn($item) => $this->formatStatus($item->bh_deed ?? false))
                ->editColumn('cooperative_nik', fn($item) => $this->formatStatus($item->cooperative_nik ?? false))
                ->editColumn('cooperative_bank_account', fn($item) => $this->formatStatus($item->cooperative_bank_account ?? false))
                ->editColumn('npwp', fn($item) => $this->formatStatus($item->npwp ?? false))
                ->editColumn('business_activity_plan', fn($item) => $this->formatStatus($item->business_activity_plan ?? false))
                ->editColumn('capex', fn($item) => $this->formatStatus($item->capex ?? false))
                ->editColumn('opex', fn($item) => $this->formatStatus($item->opex ?? false))
                ->editColumn('other_equipment', fn($item) => $this->formatStatus($item->other_equipment ?? false))


                ->rawColumns([
                    'nib',
                    'bh_deed',
                    'cooperative_nik',
                    'cooperative_bank_account',
                    'npwp',
                    'business_activity_plan',
                    'capex',
                    'opex',
                    'other_equipment'
                ])
                ->make(true);
        }


        // Mengirimkan data ke view
        return view('administration', [
            'districtCount' => $districtCount,
            'villageCount' => $villageCount,
            'villageTypeDesaCount' => $villageTypeDesaCount,
            'villageTypeKelurahanCount' => $villageTypeKelurahanCount,
            'bussinessAssistantCount' => $bussinessAssistantCount,
            'cooperationCount' => $cooperationCount,

            'totalDesa' => $totalDesa,
            'desaNIB' => $desaNIB,
            'desaBelumNIB' => $desaBelumNIB,
            'bhDeedYes' => $bhDeedYes,
            'bhDeedNo' => $bhDeedNo,
            'cooperativeNikYes' => $cooperativeNikYes,
            'cooperativeNikNo' => $cooperativeNikNo,
            'capexYes' => $capexYes,
            'capexNo' => $capexNo,
            'opexYes' => $opexYes,
            'opexNo' => $opexNo,
            'otherEquipmentYes' => $otherEquipmentYes,
            'otherEquipmentNo' => $otherEquipmentNo,
            'landYes' => $landYes,
            'landNo' => $landNo,

            'npwpYa' => $npwpYa,
            'npwpTidak' => $npwpTidak,
            'bankYa' => $bankYa,
            'bankTidak' => $bankTidak,
            'businessPlanYes' => $businessPlanYes,
            'businessPlanNo' => $businessPlanNo,
            'financingProposalYes' => $financingProposalYes,
            'financingProposalNo' => $financingProposalNo,

            // Bar Chart Data

            /*
            |--------------------------------------------------------------------------
            | CHART NIB
            |--------------------------------------------------------------------------
            */

            'nibLabels' => $nibChart['labels'],
            'nibValues' => $nibChart['values'],


            /*
            |--------------------------------------------------------------------------
            | CHART NPWP
            |--------------------------------------------------------------------------
            */

            'npwpLabels' => $npwpChart['labels'],
            'npwpValues' => $npwpChart['values'],


            /*
            |--------------------------------------------------------------------------
            | CHART REKENING
            |--------------------------------------------------------------------------
            */

            'bankLabels' => $bankChart['labels'],
            'bankValues' => $bankChart['values'],


            'capexLabels' => $capexChart['labels'],
            'capexValues' => $capexChart['values'],

            'opexLabels' => $opexChart['labels'],
            'opexValues' => $opexChart['values'],

            'businessPlanLabels' => $businessPlanChart['labels'],
            'businessPlanValues' => $businessPlanChart['values'],



        ]);
    }

    /**
     * Helper Privat untuk menyeragamkan badge status
     */
    private function formatStatus($status)
    {
        $color = $status ? 'green' : 'red';
        $label = $status ? 'Sudah' : 'Belum';
        return '<span class="bg-' . $color . '-500 text-white px-2 py-1 rounded text-xs">' . $label . '</span>';
    }

    /**
     * Helper untuk mengambil data chart dokumen per BA
     */
    private function getDocumentChart($field)
    {
        $data = BussinessAssistant::withCount([
            'cooperations as total_document' => function ($query) use ($field) {

                $query->whereHas('formThree', function ($q) use ($field) {

                    $q->whereNotNull($field)
                        ->where($field, '!=', '');
                });
            }
        ])->get();

        return [
            'labels' => $data->pluck('name'),
            'values' => $data->pluck('total_document'),
        ];
    }
}
