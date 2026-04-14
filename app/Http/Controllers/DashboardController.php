<?php

namespace App\Http\Controllers;

use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\District;
use App\Models\FormEight;
use App\Models\FormSeven;
use App\Models\FormTen;
use App\Models\Village;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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

        $totalMember = FormSeven::sum('number_of_member');

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

        // SIMKOPDES
        $simkopdesYa = Village::whereHas('cooperation', function ($q) {
            $q->where('microsite_account', 1); // sesuaikan field
        })->count();

        $simkopdesTidak = $totalDesa - $simkopdesYa;

        $simkopdesCompletenesYes = Cooperation::whereHas('simkopdesCompletenes', function ($q) {
            $q->where('is_complete', 1);
        })->count();

        $simkopdesCompletenesNo = $cooperationCount - $simkopdesCompletenesYes;


        $landYes = Cooperation::whereHas('formSix', function ($q) {
            $q->whereNotNull('asset');
        })->count();

        $landNo = $cooperationCount - $landYes;

        // NPWP
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

        $weeklyReports = WeeklyReport::orderBy('created_at')->get();

        $labels = $weeklyReports->map(function ($item) {
            return Carbon::parse($item->created_at)->translatedFormat('d M Y');
        });

        $memberData = $weeklyReports->pluck('number_of_member');

        // Setiap dokumen jadi dataset sendiri
        $datasets = [
            'SIMKOPDES' => $weeklyReports->pluck('simkopdes'),
            'NIB' => $weeklyReports->pluck('nib'),
            'NPWP' => $weeklyReports->pluck('npwp'),
            'Rekening Bank' => $weeklyReports->pluck('bank_account'),
            'Rencana Kegiatan Bisnis' => $weeklyReports->pluck('business_activity_plan'),
            'Proposal Pembiayaan' => $weeklyReports->pluck('financing_proposal'),
            'ODS Mandiri' => $weeklyReports->pluck('ods'),
        ];




        // Anggota Perkecamtana

        $dataMember = DB::table('form_sevens')
            ->join('cooperations', 'form_sevens.cooperation_id', '=', 'cooperations.id')
            ->join('villages', 'cooperations.village_id', '=', 'villages.id')
            ->join('districts', 'villages.district_id', '=', 'districts.id')
            ->whereNotNull('form_sevens.number_of_member')
            ->select(
                'districts.name as district_name',
                DB::raw('SUM(form_sevens.number_of_member) as total_member')
            )
            ->groupBy('districts.name')
            ->orderBy('districts.name')
            ->get();

        $labelMembers = $dataMember->pluck('district_name');
        $valueMembers = $dataMember->pluck('total_member');


        // Anggota Tabel

        if (request()->ajax()) {
            $query = FormSeven::with([
                'cooperation:id,name,bussiness_assistant_id,village_id',
                'cooperation.village:id,name,district_id',
                'cooperation.village.district:id,name',
                'cooperation.bussinessAssistant:id,name',
            ]);

            return DataTables::of($query)
                ->addColumn('cooperation', fn($item) => $item->cooperation->name ?? '-')
                ->addColumn('ba', fn($item) => $item->cooperation->bussinessAssistant->name ?? '-')
                ->addColumn('district', fn($item) => $item->cooperation->village->district->name ?? '-')

                ->addColumn('action', function ($item) {
                    return '
                <a href="' . route('land-statistics.edit', $item->id) . '" 
                    class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                    Edit
                </a>
            ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        // Mengirimkan data ke view
        return view('dashboard', [
            'districtCount' => $districtCount,
            'villageCount' => $villageCount,
            'villageTypeDesaCount' => $villageTypeDesaCount,
            'villageTypeKelurahanCount' => $villageTypeKelurahanCount,
            'bussinessAssistantCount' => $bussinessAssistantCount,
            'cooperationCount' => $cooperationCount,
            'reportOnes' => $reportOnes,
            'reportTwos' => $reportTwos,
            'reportThrees' => $reportThrees,
            'reportFours' => $reportFours,
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
            'simkopdesCompletenesYes' => $simkopdesCompletenesYes,
            'simkopdesCompletenesNo' => $simkopdesCompletenesNo,
            'simkopdesYa' => $simkopdesYa,
            'simkopdesTidak' => $simkopdesTidak,
            'npwpYa' => $npwpYa,
            'npwpTidak' => $npwpTidak,
            'bankYa' => $bankYa,
            'bankTidak' => $bankTidak,
            'businessPlanYes' => $businessPlanYes,
            'businessPlanNo' => $businessPlanNo,
            'financingProposalYes' => $financingProposalYes,
            'financingProposalNo' => $financingProposalNo,
            'labels' => $labels,
            'datasets' => $datasets,
            'memberData' => $memberData,
            'totalMember' => $totalMember,
            'labelMembers' => $labelMembers,
            'valueMembers' => $valueMembers,
            // 'lands' => Land::with(['user', 'oilPalmType'])->get(),
        ]);
    }

    public function dashboard2026() {

        
        // Data Untuk Donut Chart
        $cooperationCount = Cooperation::count();

        // Update Simkopdes
        $profileUpdateYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('profile_update', 1);
        })->count();
        $profileUpdateNo = $cooperationCount - $profileUpdateYes;

        // Village Potential
        $villagePotentialYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('village_potential', 1);
        })->count();
        $villagePotentialNo = $cooperationCount - $villagePotentialYes;

        // Donut RAT
        $ratYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('rat', 1);
        })->count();
        $ratNo = $cooperationCount - $ratYes;
        

        $landReadinessYes = Cooperation::whereHas('formEight', function ($q) {
            $q->where('land_readiness', 1);
        })->count();
        $landReadinessNo = $cooperationCount - $landReadinessYes;

        $vehicleYes = Cooperation::whereHas('formEight', function ($q) {
            $q->where('vehicle', 1);
        })->count();
        $vehicleNo = $cooperationCount - $vehicleYes;

        $computerYes = Cooperation::whereHas('formEight', function ($q) {
            $q->where('computer', 1);
        })->count();
        $computerNo = $cooperationCount - $computerYes;

        $tableAndChairYes = Cooperation::whereHas('formEight', function ($q) {
            $q->where('table_and_chair', 1);
        })->count();
        $tableAndChairNo = $cooperationCount - $tableAndChairYes;

        $displayCaseYes = Cooperation::whereHas('formEight', function ($q) {
            $q->where('display_case', 1);
        })->count();
        $displayCaseNo = $cooperationCount - $displayCaseYes;

        $storeDevelopmentYes = Cooperation::whereHas('formEight', function ($q) {
            $q->where('store_development', 0);
        })->count();
        $storeDevelopmentOn = Cooperation::whereHas('formEight', function ($q) {
            $q->where('store_development', 1);
        })->count();
        $storeDevelopmentNo = $cooperationCount - ($storeDevelopmentYes+$storeDevelopmentOn);


        // Status Gerai
        $outletStatusYes = Cooperation::whereHas('formNine', function ($q) {
            $q->where('outlet_status', 2);
        })->count();
        $outletStatusOn = Cooperation::whereHas('formNine', function ($q) {
            $q->where('outlet_status', 1);
        })->count();
        $outletStatusNo = $cooperationCount - ($outletStatusYes+$outletStatusOn);

        // Panduan Operational
        $operationalGuideYes = Cooperation::whereHas('formNine', function ($q) {
            $q->where('outlet_operations_guide', 1);
        })->count();
        $operationalGuideNo = $cooperationCount - $operationalGuideYes;

        // Output Kesepakatan PKS
        // $outputYes = Cooperation::whereHas('formElevens', function ($q) {
        //     $q->where('output', 1);
        // })->count();
        $outputYes = 0;
        $outputNo = $cooperationCount - $outputYes;


        // Gerai yang ada
        // Gorcery
        $groceryOutletYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('grocery_outlet', 1);
        })->count();
        $groceryOutletNo = $cooperationCount - $groceryOutletYes;

        $pharmacyOutletYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('pharmacy_outlet', 1);
        })->count();
        $pharmacyOutletNo = $cooperationCount - $pharmacyOutletYes;

        $warehousingOutletYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('warehousing_outlet', 1);
        })->count();
        $warehousingOutletNo = $cooperationCount - $warehousingOutletYes;

        $clinicOutletYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('clinic_outlet', 1);
        })->count();
        $clinicOutletNo = $cooperationCount - $clinicOutletYes;

        $logisticsOutletYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('logistics_outlet', 1);
        })->count();
        $logisticsOutletNo = $cooperationCount - $logisticsOutletYes;

        $uspOutletYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('usp_outlet', 1);
        })->count();
        $uspOutletNo = $cooperationCount - $uspOutletYes;

        $otherBusinessessOutletYes = Cooperation::whereHas('formTen', function ($q) {
            $q->where('other_businesses_outlet', 1);
        })->count();
        $otherBusinessessOutletNo = $cooperationCount - $otherBusinessessOutletYes;

        // Data Report
        $districts = District::with(['villages.cooperation.formEight'])->get(); // Pastikan formEight di-load

        $reportOnes = $districts->map(function ($district) {
            $villages = $district->villages;
            
            // Flatten agar mendapatkan semua data cooperation dalam satu list
            $coops = $villages->pluck('cooperation')->filter(); 

            return [
                'district'       => $district->name,
                'total_villages' => $villages->count(),

                // Kesiapan Lahan (Gunakan filter agar lebih presisi menangani relasi null)
                'land_readiness_yes' => $coops->filter(fn($c) => optional($c->formEight)->land_readiness == 1)->count(),
                'land_readiness_no'  => $coops->filter(fn($c) => optional($c->formEight)->land_readiness == 0)->count(),

                // Pembangunan Toko
                'store_development_yes' => $coops->filter(fn($c) => optional($c->formEight)->store_development === 0)->count(),
                'store_development_on'  => $coops->filter(fn($c) => optional($c->formEight)->store_development === 1)->count(),
                'store_development_no'  => $coops->filter(fn($c) => optional($c->formEight)->store_development === 2)->count(),

                // Vehicle
                'vehicle_yes' => $coops->filter(fn($c) => optional($c->formEight)->vehicle == 1)->count(),
                'vehicle_no'  => $coops->filter(fn($c) => optional($c->formEight)->vehicle == 0)->count(),

                // Kursi dan Meja
                'table_and_chair_yes' => $coops->filter(fn($c) => optional($c->formEight)->table_and_chair == 1)->count(),
                'table_and_chair_no'  => $coops->filter(fn($c) => optional($c->formEight)->table_and_chair == 0)->count(),

                // Etalase
                'display_case_yes' => $coops->filter(fn($c) => optional($c->formEight)->display_case == 1)->count(),
                'display_case_no'  => $coops->filter(fn($c) => optional($c->formEight)->display_case == 0)->count(),

                // Komputer
                'computer_yes' => $coops->filter(fn($c) => optional($c->formEight)->computer == 1)->count(),
                'computer_no'  => $coops->filter(fn($c) => optional($c->formEight)->computer == 0)->count(),
            ];
        });

        $reportTwos = $districts->map(function ($district) {

            $villages = $district->villages;

            $coops = $villages->pluck('cooperation')->filter();

            return [
                'district' => $district->name,
                'total_villages' => $villages->count(),


                // Status Gerai
                'outlet_status_no'  => $coops->where('formNine.outlet_status', 0)->count(), // belum
                'outlet_status_on' => $coops->where('formNine.outlet_status', 1)->count(), // selesai
                'outlet_status_yes'  => $coops->where('formNine.outlet_status', 2)->count(), // tidak terbangun

                //  jumlah karyawan 2025
                'number_of_employees_2025' => $coops->sum(function ($coop) {
                    return $coop->formNine->number_of_employees_2025 ?? 0;
                }),

                // jumlah karyawan 2026
                'number_of_employees_2026' => $coops->sum(function ($coop) {
                    return $coop->formNine->number_of_employees_2026 ?? 0;
                }),

                // Panduan Operasional
                'outlet_operations_guide_yes' => $coops->where('formNine.outlet_operations_guide', 1)->count(),
                'outlet_operations_guide_no'  => $coops->where('formNine.outlet_operations_guide', 0)->count(),


            ];
        });

        $reportThrees = $districts->map(function ($district) {

            $villages = $district->villages;

            $coops = $villages->pluck('cooperation')->filter();

            return [
                'district' => $district->name,
                'total_villages' => $villages->count(),


                // Profile Update
                'profile_update_yes'  => $coops->where('formTen.profile_update', 1)->count(), 
                'profile_update_no' => $coops->where('formTen.profile_update', 0)->count(), 

                // Status Gerai
                'village_potential_yes'  => $coops->where('formTen.village_potential', 1)->count(), 
                'village_potential_no' => $coops->where('formTen.village_potential', 0)->count(), 

                // Gerai yang ada
                'grocery_outlet' => $coops->where('formTen.grocery_outlet', 1)->count(),
                'pharmacy_outlet' => $coops->where('formTen.pharmacy_outlet', 1)->count(),
                'warehousing_outlet' => $coops->where('formTen.warehousing_outlet', 1)->count(),
                'clinic_outlet' => $coops->where('formTen.clinic_outlet', 1)->count(),
                'logistics_outlet' => $coops->where('formTen.logistics_outlet', 1)->count(),
                'usp_outlet' => $coops->where('formTen.usp_outlet', 1)->count(),
                'other_businesses_outlet' => $coops->where('formTen.other_businesses_outlet', 1)->count(),

                // RAT
                'rat_yes'  => $coops->where('formTen.rat', 1)->count(), 
                'rat_no' => $coops->where('formTen.rat', 0)->count(), 


                //  jumlah karyawan 2025
                'initial_membership' => $coops->sum(function ($coop) {
                    return $coop->formTen->initial_membership ?? 0;
                }),

                // jumlah karyawan 2026
                'addition_of_members' => $coops->sum(function ($coop) {
                    return $coop->formTen->addition_of_members ?? 0;
                }),

            ];
        });

        $reportFours = $districts->map(function ($district) {

            $villages = $district->villages;

            $coops = $villages->pluck('cooperation')->filter();

            return [
                'district' => $district->name,
                'total_villages' => $villages->count(),


                // Profile Update
                'potential_partners_bumn'  => $coops->where('formEleven.potential_partners', 1)->count(), 
                'potential_partners_non_bumn' => $coops->where('formEleven.potential_partners', 0)->count(), 

                // Kesiapan Lahan
                'partnership_status_no'  => $coops->where('formEleven.partnership_status', 0)->count(), // belum
                'partnership_status_on' => $coops->where('formEleven.partnership_status', 1)->count(), // selesai
                'partnership_status_yes'  => $coops->where('formEleven.partnership_status', 2)->count(), // tidak terbangun

                'output_yes'  => $coops->where('formEleven.output', 1)->count(), 
                'output_no' => $coops->where('formEleven.output', 0)->count(), 


                

            ];
        });


        // Form Delapan

        return view('dashboard-2026', compact(
            'ratYes', 
            'ratNo', 
            'profileUpdateYes', 
            'profileUpdateNo', 
            'villagePotentialYes', 
            'villagePotentialNo', 
            'landReadinessYes', 
            'landReadinessNo', 
            'operationalGuideYes', 
            'operationalGuideNo', 
            'displayCaseYes', 
            'displayCaseNo',
            'vehicleYes', 
            'vehicleNo',
            'tableAndChairYes', 
            'tableAndChairNo',
            'computerYes', 
            'computerNo',
            'outputYes', 
            'outputNo',
            'storeDevelopmentYes', 
            'storeDevelopmentOn',
            'storeDevelopmentNo',
            'outletStatusYes', 
            'outletStatusOn',
            'outletStatusNo',
            'groceryOutletYes', 
            'groceryOutletNo',
            'pharmacyOutletYes', 
            'pharmacyOutletNo',
            'warehousingOutletYes', 
            'warehousingOutletNo',
            'clinicOutletYes', 
            'clinicOutletNo',
            'logisticsOutletYes', 
            'logisticsOutletNo',
            'uspOutletYes', 
            'uspOutletNo',
            'otherBusinessessOutletYes', 
            'otherBusinessessOutletNo',
            'reportOnes', 'reportTwos', 'reportThrees', 'reportFours'));
    }

    public function formEight() {
        if (request()->ajax()) {
            $query = Cooperation::with([
                   'formEight',
                    'bussinessAssistant',
                    'village.district']);


            return DataTables::of($query)
                ->addColumn('land_readiness', function ($item) {

                    if (optional($item->formEight)->land_readiness) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Ada
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Tidak
                    </span>';
                })
                ->addColumn('store_development', function ($item) {
                    $value = optional($item->formEight)->store_development;

                    $status = [
                        0 => ['text' => 'Selesai', 'color' => 'green'],
                        1 => ['text' => 'Belum', 'color' => 'yellow'],
                        2 => ['text' => 'Tidak Terbangun', 'color' => 'red'],
                    ];

                    if (!isset($status[$value])) {
                        return '-';
                    }

                    return '<span class="bg-' . $status[$value]['color'] . '-500 text-white px-2 py-1 rounded">
                        ' . $status[$value]['text'] . '
                    </span>';
                })
                ->addColumn('business_assistant', function ($item) {
                    return $item->bussinessAssistant->name ?? '-';
                })

                ->addColumn('district', function ($item) {
                    return $item->village->district->name ?? '-';
                })
                ->addColumn('vehicle', function ($item) {
                    if (optional($item->formEight)->vehicle) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Ada
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Tidak
                    </span>';
                })
                ->addColumn('table_and_chair', function ($item) {
                    if (optional($item->formEight)->table_and_chair) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Ada
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Tidak
                    </span>';
                })
                ->addColumn('display_case', function ($item) {
                    if (optional($item->formEight)->display_case) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Ada
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Tidak
                    </span>';
                })
                ->addColumn('computer', function ($item) {
                    if (optional($item->formEight)->computer) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Ada
                        </span>';
                    }
                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Tidak
                    </span>';
                })
                ->addColumn('problem', function ($item) {
                    return optional($item->formEight)->problem ?? '-';
                })
                ->addColumn('information', function ($item) {
                    return optional($item->formEight)->information ?? '-';
                })

                ->rawColumns(['land_readiness', 'store_development', 'business_assistant', 'district', 'vehicle', 'table_and_chair', 'display_case', 'computer', 'problem', 'information'   ])
                ->make(true);
        }
    }

    public function formNine() {
        if (request()->ajax()) {
            $query = Cooperation::with([
                    'formNine',
                    'bussinessAssistant',
                    'village.district']);


            return DataTables::of($query)
                
                ->addColumn('business_assistant', function ($item) {
                    return $item->bussinessAssistant->name ?? '-';
                })

                ->addColumn('district', function ($item) {
                    return $item->village->district->name ?? '-';
                })
                ->addColumn('outlet_operations_guide', function ($item) {

                    if (optional($item->formNine)->outlet_operations_guide) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Ada
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Tidak
                    </span>';
                })
                ->addColumn('number_of_employees_2025', function ($item) {
                    return optional($item->formNine)->number_of_employees_2025 ?? '-';
                })
                ->addColumn('number_of_employees_2026', function ($item) {
                    return optional($item->formNine)->number_of_employees_2026 ?? '-';
                })
                ->addColumn('outlet_status', function ($item) {

                    $status = [
                        0 => ['text' => 'Belum Ada', 'color' => 'yellow'],
                        1 => ['text' => 'Belum Buka', 'color' => 'blue'],
                        2 => ['text' => 'Operasional', 'color' => 'green'],
                    ];

                    if (!isset($status[optional($item->formNine)->outlet_status])) {
                        return '-';
                    }

                    return '<span class="bg-' . $status[optional($item->formNine)->outlet_status]['color'] . '-500 text-white px-2 py-1 rounded">
                        ' . $status[optional($item->formNine)->outlet_status]['text'] . '
                    </span>';
                })

                ->addColumn('problem', function ($item) {
                    return optional($item->formNine)->problem ?? '-';
                })
                ->addColumn('information', function ($item) {
                    return optional($item->formNine)->information ?? '-';
                })

                ->rawColumns([ 'business_assistant', 'district', 'outlet_operations_guide', 'number_of_employees_2025', 'number_of_employees_2026', 'outlet_status', 'problem', 'information'   ])
                ->make(true);
        }
    }

    public function formTen() {
        if (request()->ajax()) {
            $query = Cooperation::with([
                    'formTen',
                    'bussinessAssistant',
                    'village.district']);


            return DataTables::of($query)
                
                ->addColumn('business_assistant', function ($item) {
                    return $item->bussinessAssistant->name ?? '-';
                })

                ->addColumn('district', function ($item) {
                    return $item->village->district->name ?? '-';
                })

                ->addColumn('profile_update', function ($item) {

                    if (optional($item->formTen)->profile_update) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('village_potential', function ($item) {

                    if (optional($item->formTen)->village_potential) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('grocery_outlet', function ($item) {

                    if (optional($item->formTen)->grocery_outlet) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('pharmacy_outlet', function ($item) {

                    if (optional($item->formTen)->pharmacy_outlet) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('warehousing_outlet', function ($item) {

                    if (optional($item->formTen)->warehousing_outlet) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                 ->addColumn('clinic_outlet', function ($item) {

                    if (optional($item->formTen)->clinic_outlet) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('logistics_outlet', function ($item) {

                    if (optional($item->formTen)->logistics_outlet) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('usp_outlet', function ($item) {
                    if (optional($item->formTen)->usp_outlet) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('other_businesses_outlet', function ($item) {
                    if (optional($item->formTen)->other_businesses_outlet) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('rat', function ($item) {

                    if (optional($item->formTen)->rat) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })
                ->addColumn('initial_membership', function ($item) {
                    return optional($item->formTen)->initial_membership ?? '-';
                })
                ->addColumn('addition_of_members', function ($item) {
                    return optional($item->formTen)->addition_of_members ?? '-';
                })

                ->addColumn('problem', function ($item) {
                    return optional($item->formTen)->problem ?? '-';
                })
                ->addColumn('information', function ($item) {
                    return optional($item->formTen)->information ?? '-';
                })

                ->rawColumns([ 'business_assistant', 'grocery_outlet', 'pharmacy_outlet', 'warehousing_outlet', 'clinic_outlet', 'logistics_outlet', 'usp_outlet',  'other_businesses_outlet', 'district', 'profile_update', 'village_potential', 'rat', 'problem', 'information'   ])
                ->make(true);
        }
    }

    public function rat2025(){

         if (request()->ajax()) {
            $query = FormTen::with([
                'cooperation:id,name,bussiness_assistant_id,village_id',
                'cooperation.village:id,name,district_id',
                'cooperation.village.district:id,name',
                'cooperation.bussinessAssistant:id,name',
            ]);

            return DataTables::of($query)
                ->addColumn('cooperation', fn($item) => $item->cooperation->name ?? '-')
                ->addColumn('ba', fn($item) => $item->cooperation->bussinessAssistant->name ?? '-')
                ->addColumn('district', fn($item) => $item->cooperation->village->district->name ?? '-')

                  ->addColumn('rat', function ($item) {

                    if ($item->rat) {
                        return '<span class="bg-green-500 text-white px-2 py-1 rounded">
                            Sudah
                        </span>';
                    }

                    return '<span class="bg-red-500 text-white px-2 py-1 rounded">
                        Belum
                    </span>';
                })

                ->rawColumns(['rat'])
                ->make(true);
        }

        // Contoh di Controller
        $totalCooperation = Cooperation::count(); // Total semua KDKMP
        $totalRat = FormTen::where('rat', 1)->count(); // Sesuaikan dengan field DB Anda
        $percentage = $totalCooperation > 0 ? ($totalRat / $totalCooperation) * 100 : 0;

        // 1. Ambil data Statistik Kecamatan
    // Berdasarkan Kecamatan (Sekarang sudah bisa panggil cooperations)
        $districtStats = District::withCount(['cooperations as total_rat' => function ($query) {
            $query->whereHas('formTen', function ($q) {
                $q->where('rat', true);
            });
        }])->get();
    

        // 2. Ambil data Statistik Business Assistant
            $assistantData = BussinessAssistant::withCount(['cooperations as total_rat' => function ($query) {
                $query->whereHas('formTen', fn($q) => $q->where('rat', true));
            }])->get();

        return view('rat-2025', [
            // $districtStats => 'districtStats',
            'totalCooperation' => $totalCooperation, 
            'totalRat' => $totalRat, 
            'percentage' => $percentage,

            // Data untuk Chart Kecamatan
            'districtLabels' => $districtStats->pluck('name'),
            'districtValues' => $districtStats->pluck('total_rat'),

                // Data untuk Chart Business Assistant
            'assistantLabels' => $assistantData->pluck('name'),
            'assistantValues' => $assistantData->pluck('total_rat'),

        ]);

    }

    public function cooperationMember()
    {
        if (request()->ajax()) {
            $query = FormTen::with([
                'cooperation:id,name,bussiness_assistant_id,village_id',
                'cooperation.village:id,name,district_id',
                'cooperation.village.district:id,name',
                'cooperation.bussinessAssistant:id,name',
            ]);

            return DataTables::of($query)
                ->addColumn('cooperation', fn($item) => $item->cooperation->name ?? '-')
                ->addColumn('ba', fn($item) => $item->cooperation->bussinessAssistant->name ?? '-')
                ->addColumn('district', fn($item) => $item->cooperation->village->district->name ?? '-')
                ->rawColumns([])
                ->make(true);
        }

        // Data Card
                $totalStats = FormTen::select(
            DB::raw('SUM(initial_membership) as total_initial'),
            DB::raw('SUM(addition_of_members) as total_addition')
        )->first();

       // 1. Ambil data Statistik Kecamatan & Total Anggota
        $districtStats = District::withSum(['cooperations as total_members' => function ($query) {
        $query->join('form_tens', 'cooperations.id', '=', 'form_tens.cooperation_id') // Sesuaikan foreign key-nya
                ->select(DB::raw('SUM(COALESCE(form_tens.initial_membership, 0) + COALESCE(form_tens.addition_of_members, 0))'));
        }], 'id') // Parameter kedua diisi 'id' saja sebagai placeholder
        ->get();

        // 2. Ambil data Statistik Business Assistant & Total Anggota
        $assistantData = BussinessAssistant::withSum(['cooperations as total_members' => function ($query) {
        $query->join('form_tens', 'cooperations.id', '=', 'form_tens.cooperation_id')
                ->select(DB::raw('SUM(COALESCE(form_tens.initial_membership, 0) + COALESCE(form_tens.addition_of_members, 0))'));
        }], 'id')
        ->get();

        return view('cooperation-member', [

            // Data untuk Card
            'cardInitial' => $totalStats->total_initial ?? 0,
            'cardAddition' => $totalStats->total_addition ?? 0,
            'totalMember' => $totalStats->total_initial + $totalStats->total_addition,

            // Data untuk Chart Kecamatan
            'districtLabels' => $districtStats->pluck('name'),
            'districtValues' => $districtStats->pluck('total_members'),

            // Data untuk Chart Business Assistant
            'assistantLabels' => $assistantData->pluck('name'),
            'assistantValues' => $assistantData->pluck('total_members'),
        ]);
    }

    public function forms2026(){
        return view('forms-2026');
    }
}
