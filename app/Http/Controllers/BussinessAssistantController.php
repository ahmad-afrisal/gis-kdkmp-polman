<?php

namespace App\Http\Controllers;

use App\Exports\FormTenExport;
use App\Exports\FormTwoExport;
use App\Http\Requests\BussinessAssistantUpdateRequest;
use App\Models\BussinessAssistant;
use App\Models\Commodity;
use App\Models\Cooperation;
use App\Models\FormFive;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BussinessAssistantController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = BussinessAssistant::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('status', function ($item) {
                    if ($item->is_active) {
                        return '<span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded">
                        Aktif
                        </span>';
                    } else {
                        return '<span class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">
                        Tidak Aktif
                        </span>';
                    }
                })
                ->addColumn('picture', function ($item) {
                    return '<img src="' . asset('storage/' . $item->picture) . '" alt="Picture" class="w-10 h-10 rounded-full">';
                })
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('bussiness-assistants.performance', $item->id) . '" 
                        class="inline-block bg-orange-500 hover:bg-orange-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Performa
                    </a>
                    <a href="' . route('bussiness-assistants.show', $item->id) . '" 
                        class="inline-block bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Koperasi
                    </a>
                    <a href="' . route('bussiness-assistants.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>

                ';
                })
                ->rawColumns(['status', 'picture', 'action'])
                ->make(true);
        }

        return view('bussiness-assistants.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bussiness-assistants.create');
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
     * Display the specified resource.
     */
    public function show(BussinessAssistant $bussinessAssistant)
    {
        if (request()->ajax()) {
            $query = Cooperation::where('bussiness_assistant_id', $bussinessAssistant->id)->orderBy('order', 'asc');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('cooperations.show', $item->id) . '" 
                        class="inline-block bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Detail
                    </a>
                    <a href="' . route('cooperations.edit', $item->id) . '" 
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>

                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('bussiness-assistants.detail.index', compact('bussinessAssistant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BussinessAssistant $bussinessAssistant)
    {


        return view(
            'bussiness-assistants.edit',
            [
                'data' => $bussinessAssistant,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BussinessAssistantUpdateRequest $request, BussinessAssistant $bussinessAssistant)
    {
        $data = $request->validated();

         // Upload image baru
        // =========================
        if ($request->hasFile('picture')) {

            // hapus gambar lama jika ada
            if ($bussinessAssistant->picture && Storage::disk('public')->exists($bussinessAssistant->picture)) {
                Storage::disk('public')->delete($bussinessAssistant->picture);
            }

            // simpan gambar baru
            $data['picture'] = $request->file('picture')->store('bussiness-assistants', 'public');
        }

        $bussinessAssistant->update($data);
        return to_route('bussiness-assistants.index')->with('success', 'Business Assistant berhasil diupdate');
    }



    public function form1(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-1', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormOne(Request $request, BussinessAssistant $bussinessAssistant)
    {
        foreach ($request->data as $row) {

            $validated = validator($row, [
                'id' => 'required|exists:cooperations,id',
                'sudah_terdaftar' => 'nullable|boolean',
                'belum_terdaftar' => 'nullable|boolean',
                'bussiness_plan' => 'nullable|string',
                'grocery_outlet' => 'nullable|boolean',
                'village_pharmacy_outlet' => 'nullable|boolean',
                'village_clinic_outlet' => 'nullable|boolean',
                'savings_and_loan_outlet' => 'nullable|boolean',
                'cold_storage_outlet' => 'nullable|boolean',
                'logistics_outlet' => 'nullable|boolean',
                'tersedia_akun' => 'nullable|boolean',
                'belum_tersedia_akun' => 'nullable|boolean',
                'ba_musdes' => 'nullable|boolean',
                'ba_rapat_anggota' => 'nullable|boolean',
                'legal_entity_number' => 'nullable|string',
                'potential' => 'nullable|string',
            ])->validate();

            // Checkbox tidak dicentang = 0
            foreach (
                [
                    'grocery_outlet',
                    'village_pharmacy_outlet',
                    'village_clinic_outlet',
                    'savings_and_loan_outlet',
                    'cold_storage_outlet',
                    'logistics_outlet',

                ] as $field
            ) {
                $validated[$field] = $row[$field] ?? 0;
            }

            // tentukan nilai akhir
            $validated['bank_account'] = isset($row['tersedia_akun']) ? 1 : 0;
            $validated['microsite_account'] = isset($row['sudah_terdaftar']) ? 1 : 0;

            // Ambil cooperation → update langsung
            $cooperation = Cooperation::find($validated['id']);

            $cooperation->update([
                'microsite_account' => $validated['microsite_account'],
                'grocery_outlet' => $validated['grocery_outlet'],
                'village_pharmacy_outlet' => $validated['village_pharmacy_outlet'],
                'village_clinic_outlet' => $validated['village_clinic_outlet'],
                'savings_and_loan_outlet' => $validated['savings_and_loan_outlet'],
                'cold_storage_outlet' => $validated['cold_storage_outlet'],
                'logistics_outlet' => $validated['logistics_outlet'],
                'bank_account' => $validated['bank_account'],
                'ba_musdes' => $validated['ba_musdes'],
                'ba_rapat_anggota' => $validated['ba_rapat_anggota'],
                'legal_entity_number' => $validated['legal_entity_number'],
                'potential' => $validated['potential'],
            ]);
        }

        return back()->with('success', 'Form 1 berhasil disimpan.');
    }

    public function form2(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formTwo')->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-2', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormTwo(Request $request, BussinessAssistant $bussinessAssistant)
    {
        foreach ($request->data as $row) {

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'bussiness_plan' => 'nullable|string',
                'basic_necessities_exist' => 'nullable|boolean',
                'basic_necessities_running' => 'nullable|boolean',
                'savings_and_loan_exist' => 'nullable|boolean',
                'savings_and_loan_running' => 'nullable|boolean',
                'pharmacy_exist' => 'nullable|boolean',
                'pharmacy_running' => 'nullable|boolean',
                'clinic_exist' => 'nullable|boolean',
                'clinic_running' => 'nullable|boolean',
                'logistics_exist' => 'nullable|boolean',
                'logistics_running' => 'nullable|boolean',
                'storage_exist' => 'nullable|boolean',
                'storage_running' => 'nullable|boolean',
                'other_businesses_exist' => 'nullable|boolean',
                'other_businesses_running' => 'nullable|boolean',
                'information' => 'nullable|string',
            ])->validate();

            // Checkbox tidak dicentang = 0
            foreach (
                [
                    'basic_necessities_exist',
                    'basic_necessities_running',
                    'savings_and_loan_exist',
                    'savings_and_loan_running',
                    'pharmacy_exist',
                    'pharmacy_running',
                    'clinic_exist',
                    'clinic_running',
                    'storage_exist',
                    'storage_running',
                    'other_businesses_exist',
                    'other_businesses_running',
                ] as $field
            ) {
                $validated[$field] = $row[$field] ?? 0;
            }

            $cooperation = Cooperation::find($validated['cooperation_id']);

            // Cek apakah FormThree sudah ada
            $formTwo = $cooperation->formTwo;

            if ($formTwo) {
                $formTwo->update($validated);
            } else {
                $cooperation->formTwo()->create($validated);
            }
        }

        return back()->with('success', 'Form 2 berhasil disimpan.');
    }

    public function form3(BussinessAssistant $bussinessAssistant)
    {
        $cooperations = $bussinessAssistant->cooperations()->with('formThree')->orderBy('order', 'asc')->get();

        return view('bussiness-assistants.detail.form-3', compact(
            'bussinessAssistant',
            'cooperations'
        ));
    }

    public function storeOrUpdateFormThree(Request $request, BussinessAssistant $bussinessAssistant)
    {
        foreach ($request->data as $row) {

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'financing_partner' => 'nullable|string',
                'bh_deed' => 'nullable|boolean',
                'cooperative_nik' => 'nullable|boolean',
                'cooperative_bank_account' => 'nullable|boolean',
                'npwp' => 'nullable|boolean',
                'nib' => 'nullable|boolean',
                'business_activity_plan' => 'nullable|boolean',
                'capex' => 'nullable|boolean',
                'opex' => 'nullable|boolean',
                'other_equipment' => 'nullable|boolean',
                'information' => 'nullable|string',
            ])->validate();

            // Checkbox tidak dicentang = 0
            foreach (
                [
                    'bh_deed',
                    'cooperative_nik',
                    'cooperative_bank_account',
                    'npwp',
                    'nib',
                    'business_activity_plan',
                    'capex',
                    'opex',
                    'other_equipment'
                ] as $field
            ) {
                $validated[$field] = $row[$field] ?? 0;
            }

            $cooperation = Cooperation::find($validated['cooperation_id']);

            // Cek apakah FormThree sudah ada
            $formThree = $cooperation->formThree;

            if ($formThree) {
                $formThree->update($validated);
            } else {
                $cooperation->formThree()->create($validated);
            }
        }

        return back()->with('success', 'Form 3 berhasil disimpan.');
    }



    public function form4(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formFour')->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-4', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormFour(Request $request, BussinessAssistant $bussinessAssistant)
    {
        foreach ($request->data as $row) {

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'financing_partner' => 'nullable|string',
                'financing_proposal_ada' => 'nullable|boolean',
                'financing_proposal_belum' => 'nullable|boolean',
                'financing_proposal_submission_date' => 'nullable|date',
                'proposal_status_rejected' => 'nullable|boolean',
                'proposal_status_approved' => 'nullable|boolean',
                'financing_amount' => 'nullable|numeric',
                'information' => 'nullable|string',
            ])->validate();

            // tentukan nilai akhir
            $validated['financing_proposal'] = isset($row['financing_proposal_ada']) ? 1 : 0;

            // financing_proposal → NULL jika tidak dicentang
            $validated['financing_proposal'] = $row['financing_proposal_ada'] ?? null;

            // proposal_status → 1 = approved, 0 = rejected, NULL = tidak ada pilihan
            if (isset($row['proposal_status_approved'])) {
                $validated['proposal_status'] = 1;
            } elseif (isset($row['proposal_status_rejected'])) {
                $validated['proposal_status'] = 0;
            } else {
                $validated['proposal_status'] = null;
            }

            // Ambil cooperation → update langsung
            $cooperation = Cooperation::find($validated['cooperation_id']);

            // Cek apakah FormThree sudah ada
            $formFour = $cooperation->formFour;

            if ($formFour) {
                $formFour->update([
                    'financing_partner' => $validated['financing_partner'],
                    'financing_proposal' => $validated['financing_proposal'],
                    'financing_proposal_submission_date' => $validated['financing_proposal_submission_date'],
                    'proposal_status' => $validated['proposal_status'],
                    'financing_amount' => $validated['financing_amount'],
                    'information' => $validated['information'],

                ]);
            } else {
                $cooperation->formFour()->create([
                    'financing_partner' => $validated['financing_partner'],
                    'financing_proposal' => $validated['financing_proposal'],
                    'financing_proposal_submission_date' => $validated['financing_proposal_submission_date'],
                    'proposal_status' => $validated['proposal_status'],
                    'financing_amount' => $validated['financing_amount'],
                    'information' => $validated['information'],

                ]);
            }
        }

        return back()->with('success', 'Form 1 berhasil disimpan.');
    }

    public function form5(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formFives')->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-5', compact('bussinessAssistant', 'cooperations'));
    }


    public function storeOrUpdateFormFive(Request $request, BussinessAssistant $bussinessAssistant)
    {
        // dd($request->data);

        $data = $request->data;

        if (!$data || !is_array($data)) {
            return back()->with('error', 'Data kosong!');
        }

        // Ambil semua cooperation_id unik dari input
        $coopIds = collect($data)
            ->pluck('cooperation_id')
            ->filter()
            ->unique()
            ->values();

        // Hapus semua gerai lama
        FormFive::whereIn('cooperation_id', $coopIds)->delete();

        // Masukkan ulang semua data
        foreach ($data as $row) {

            // Skip row kosong tanpa cooperation_id
            if (empty($row['cooperation_id'])) continue;

            // Validasi
            $validated = validator($row, [
                'cooperation_id'  => 'required|exists:cooperations,id',
                'branch_type'     => 'nullable|string',
                'business_volume' => 'nullable|numeric',
                'total_assets'    => 'nullable|numeric',
                'profit_loss'     => 'nullable|numeric',
                'information'     => 'nullable|string',
            ])->validate();

            // Create baru (tidak pakai update/updateOrCreate lagi)
            FormFive::create($validated);
        }

        return back()->with('success', 'Data Form 5 berhasil disimpan ulang!');
    }

    public function form6(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formSix')->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-6', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormSix(Request $request, BussinessAssistant $bussinessAssistant)
    {

        // return dd($request->all());
        foreach ($request->data as $index => $row) {

            // Ambil file gambar jika ada
            $file = $request->file("data.$index.picture_land");

            // Pastikan is_build menjadi boolean yang benar
         $isBuild = filter_var($row['is_build'] ?? false, FILTER_VALIDATE_BOOLEAN);

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                // 'picture_land' => 'nullable|string',
                'latitude' => 'nullable|string',
                'longitude' => 'nullable|string',
                'width_land' => 'nullable|numeric',
                'long_land' => 'nullable|numeric',
                'letter_land' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'road_condition' => 'nullable|string',
                'asset' => 'nullable|string',
                'distance' => 'nullable|numeric',
                'internet_access' => 'nullable|string',
                'water_access' => 'nullable|string',
                'electricity_access' => 'nullable|string',
                'is_build' => 'nullable|boolean',
                'persentase' => 'nullable|numeric',
                'progress' => 'nullable|string',
                'description' => 'nullable|string',
            ])->validate();

            // Timpa nilai hasil validasi dengan boolean asli
            $validated['is_build'] = $isBuild;

            // Jika ada file upload → simpan file
            if ($file) {
                $path = $file->store('form-six/picture-land', 'public');
                $validated['picture_land'] = $path;
            }



            // Ambil cooperation → update langsung
            $cooperation = Cooperation::find($validated['cooperation_id']);

            // Cek apakah FormThree sudah ada
            $formSix = $cooperation->formSix;

            // UPLOAD GAMBAR (Surat Tanah)
            // =====================
            if (isset($row['letter_land']) && $row['letter_land'] instanceof \Illuminate\Http\UploadedFile) {

                // Hapus file lama jika ada
                if ($formSix && $formSix->letter_land && Storage::disk('public')->exists($formSix->letter_land)) {
                    Storage::disk('public')->delete($formSix->letter_land);
                }

                // Simpan file baru
                $validated['letter_land'] = $row['letter_land']->store('form-six/letter', 'public');
            }

            if ($formSix) {
                $formSix->update($validated);
            } else {
                $cooperation->formSix()->create($validated);
            }
        }

        return back()->with('success', 'Form 6 berhasil disimpan.');
    }

    public function form7(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formSix')->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-7', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormSeven(Request $request, BussinessAssistant $bussinessAssistant)
    {
        $request->validate([
            'data' => 'required|array',
        ]);

        foreach ($request->data as $row) {

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'number_of_member' => 'nullable|numeric',
            ])->validate();

            $cooperation = Cooperation::findOrFail($validated['cooperation_id']);

            $dataFormSeven = [
                'number_of_member' => $validated['number_of_member'] ?? null,
            ];

            $formSeven = $cooperation->formSeven;

            if ($formSeven) {
                $formSeven->update($dataFormSeven);
            } else {
                $cooperation->formSeven()->create($dataFormSeven);
            }
        }

        return back()->with('success', 'Form 7 berhasil disimpan.');
    }

    public function form8(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formEight')->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-8', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormEight(Request $request, BussinessAssistant $bussinessAssistant)
    {
        // Validasi Awal Pastikan datanya array
        $request->validate([
            'data' => 'required|array',
        ]);



        foreach ($request->data as $row) {

            // Validasi Perdata
            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'land_readiness' => 'nullable|boolean',
                'store_development' => 'nullable|numeric',
                'vehicle' => 'nullable|boolean',
                'table_and_chair' => 'nullable|boolean',
                'display_case' => 'nullable|boolean',
                'computer' => 'nullable|boolean',
                'problem' => 'nullable|string',
                'information' => 'nullable|string',
            ])->validate();

            
            $validated['land_readiness'] = isset($row['land_readiness_ada']) ? 1 : 0;
            
            // store development → 1 = approved, 0 = rejected, 2 = tidak dibangun
            if (isset($row['store_development_approved'])) {
                $validated['store_development'] = 1;
            } elseif (isset($row['store_development_rejected'])) {
                $validated['store_development'] = 0;
            } else {
                $validated['store_development'] = 2;
            }

            $validated['vehicle'] = isset($row['vehicle_ada']) ? 1 : 0;
            $validated['table_and_chair'] = isset($row['table_and_chair_ada']) ? 1 : 0;
            $validated['display_case'] = isset($row['display_case_ada']) ? 1 : 0;
            $validated['computer'] = isset($row['computer_ada']) ? 1 : 0;

            
            
            $dataFormEight = [
                'land_readiness' => $validated['land_readiness'] ?? null,
                'store_development' => $validated['store_development'] ?? null,
                'vehicle' => $validated['vehicle'] ?? null,
                'table_and_chair' => $validated['table_and_chair'] ?? null,
                'display_case' => $validated['display_case'] ?? null,
                'computer' => $validated['computer'] ?? null,
                'problem' => $validated['problem'] ?? null,
                'information' => $validated['information'] ?? null,
            ];
            
            $cooperation = Cooperation::findOrFail($validated['cooperation_id']);

            $formEight = $cooperation->formEight;

            if ($formEight) {
                $formEight->update($dataFormEight);
            } else {
                $cooperation->formEight()->create($dataFormEight);
            }
        }

        return back()->with('success', 'Form 1 2026 berhasil disimpan.');
    }

    public function form9(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formNine')->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-9', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormNine(Request $request, BussinessAssistant $bussinessAssistant)
    {
        $request->validate([
            'data' => 'required|array',
        ]);

        // dd($request->data);


        foreach ($request->data as $row) {

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'outlet_status' => 'nullable|boolean',
                'number_of_employees_2025' => 'nullable|numeric',
                'number_of_employees_2026' => 'nullable|numeric',
                'outlet_operations_guide' => 'nullable|boolean',
                'problem' => 'nullable|string',
                'information' => 'nullable|string',
            ])->validate();

            
            // store development → 1 = approved, 0 = rejected, 2 = tidak dibangun
            if (isset($row['outlet_status_ada'])) {
                $validated['outlet_status'] = 1;
            } elseif (isset($row['outlet_status_belum'])) {
                $validated['outlet_status'] = 0;
            } else {
                $validated['outlet_status'] = 2;
            }

            $validated['outle_operations_guide'] = isset($row['outle_operations_guide_yes']) ? 1 : 0;


            $cooperation = Cooperation::findOrFail($validated['cooperation_id']);

            $dataFormNine = [
                'outlet_status' => $validated['outlet_status'] ?? null,
                'number_of_employees_2025' => $validated['number_of_employees_2025'] ?? null,
                'number_of_employees_2026' => $validated['number_of_employees_2026'] ?? null,
                'outlet_operations_guide' => $validated['outlet_operations_guide'] ?? null,
                'problem' => $validated['problem'] ?? null,
                'information' => $validated['information'] ?? null,
            ];

            $formNine = $cooperation->formNine;

            if ($formNine) {
                $formNine->update($dataFormNine);
            } else {
                $cooperation->formNine()->create($dataFormNine);
            }
        }

        return back()->with('success', 'Form 3 2026 berhasil disimpan.');
    }

       public function form10(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formTen')->orderBy('order', 'asc')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-10', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormTen(Request $request, BussinessAssistant $bussinessAssistant)
    {
        $request->validate([
            'data' => 'required|array',
        ]);


        foreach ($request->data as $row) {

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'profile_update' => 'nullable|boolean',
                'village_potential' => 'nullable|boolean',
                'grocery_outlet' => 'nullable|boolean',
                'pharmacy_outlet' => 'nullable|boolean',
                'warehousing_outlet' => 'nullable|boolean',
                'clinic_outlet' => 'nullable|boolean',
                'logistics_outlet' => 'nullable|boolean',
                'usp_outlet' => 'nullable|boolean',
                'other_businesses_outlet' => 'nullable|boolean',
                'rat' => 'nullable|boolean',
                'initial_membership' => 'nullable|numeric',
                'addition_of_members' => 'nullable|numeric',
                'problem' => 'nullable|string',
                'information' => 'nullable|string',
            ])->validate();

            $validated['profile_update'] = isset($row['profile_update_ada']) ? 1 : 0;
            $validated['village_potential'] = isset($row['village_potential_ada']) ? 1 : 0;
            $validated['rat'] = isset($row['rat_ada']) ? 1 : 0;
            
            $cooperation = Cooperation::findOrFail($validated['cooperation_id']);

            $dataFormTen = [
                'profile_update' => $validated['profile_update'] ?? null,
                'village_potential' => $validated['village_potential'] ?? null,
                'grocery_outlet' => $validated['grocery_outlet'] ?? null,
                'pharmacy_outlet' => $validated['pharmacy_outlet'] ?? null,
                'warehousing_outlet' => $validated['warehousing_outlet'] ?? null,
                'clinic_outlet' => $validated['clinic_outlet'] ?? null,
                'logistics_outlet' => $validated['logistics_outlet'] ?? null,
                'usp_outlet' => $validated['usp_outlet'] ?? null,
                'other_businesses_outlet' => $validated['other_businesses_outlet'] ?? null,
                'rat' => $validated['rat'] ?? null,
                'initial_membership' => $validated['initial_membership'] ?? null,
                'addition_of_members' => $validated['addition_of_members'] ?? null,
                'problem' => $validated['problem'] ?? null,
                'information' => $validated['information'] ?? null,
            ];

            $formTen = $cooperation->formTen;

            if ($formTen) {
                $formTen->update($dataFormTen);
            } else {
                $cooperation->formTen()->create($dataFormTen);
            }
        }

        return back()->with('success', 'Form 4 2026 berhasil disimpan.');
    }


    
       public function form11(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('formTen')->orderBy('order', 'asc')->get();

        $commodities = Commodity::pluck('name', 'id');


        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-11', compact('bussinessAssistant', 'commodities', 'cooperations'));
    }

    public function storeOrUpdateFormEleven(Request $request, BussinessAssistant $bussinessAssistant)
    {
        $request->validate([
            'data' => 'required|array',
        ]);

        // dd($request->data);

        foreach ($request->data as $row) {

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'potential_partners' => 'nullable|boolean',
                'partnership_pattern' => 'nullable|string',
                'commodity_id' => 'nullable|numeric',
                'capacity' => 'nullable|string', 
                'partnership_status' => 'nullable|numeric',
                'output' => 'nullable|boolean',
                'problem' => 'nullable|string',
                'information' => 'nullable|string',
            ])->validate();

            $validated['potential_partners'] = isset($row['potential_partners_bumn']) ? 1 : 0;

            // store development → 1 = approved, 0 = rejected, 2 = tidak dibangun
            if (isset($row['partnership_status_belum_ada'])) {
                $validated['partnership_status'] = 0;
            } elseif (isset($row['partnership_status_belum_buka'])) {
                $validated['partnership_status'] = 1;
            } else {
                $validated['partnership_status'] = 2;
            }

            $validated['output'] = isset($row['output_approved']) ? 1 : 0;

            $cooperation = Cooperation::findOrFail($validated['cooperation_id']);

            $dataFormEleven = [
                'potential_partners' => $validated['potential_partners'] ?? null,
                'partnership_pattern' => $validated['partnership_pattern'] ?? null,
                'commodity_id' => $validated['commodity_id'] ?? null,
                'capacity' => $validated['capacity'] ?? null, 
                'partnership_status' => $validated['partnership_status'] ?? null,
                'output' => $validated['output'] ?? null,
                'problem' => $validated['problem'] ?? null,
                'information' => $validated['information'] ?? null,
            ];

            $formEleven = $cooperation->formEleven;

            if ($formEleven) {
                $formEleven->update($dataFormEleven);
            } else {
                $cooperation->formEleven()->create($dataFormEleven);
            }
        }

        return back()->with('success', 'Form 10 2026 berhasil disimpan.');
    }



    public function simkopdesCompletenes(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->with('simkopdesCompletenes')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.simkopdes-complete', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateSimkopdesComplete(Request $request, BussinessAssistant $bussinessAssistant)
    {
        $request->validate([
            'data' => 'required|array',
        ]);

        foreach ($request->data as $row) {

            $validated = validator($row, [
                'cooperation_id' => 'required|exists:cooperations,id',
                'is_complete' => 'nullable|numeric',
            ])->validate();

            $cooperation = Cooperation::findOrFail($validated['cooperation_id']);

            $dataSimkopdesComplete = [
                'is_complete' => $validated['is_complete'] ?? null,
            ];

            $simkopdesComplete = $cooperation->simkopdesCompletenes;

            if ($simkopdesComplete) {
                $simkopdesComplete->update($dataSimkopdesComplete);
            } else {
                $cooperation->simkopdesCompletenes()->create($dataSimkopdesComplete);
            }
        }

        return back()->with('success', 'Kelengkapan Simkopdes berhasil disimpan.');
    }


    public function generateReport(BussinessAssistant $bussinessAssistant)
    {

        $cooperations = $bussinessAssistant->cooperations()->with('formTwo')->get();


        $pdf = Pdf::loadView('bussiness-assistants.detail.report', [
            'cooperations' => $cooperations,
            'bussinessAssistant' => $bussinessAssistant,
        ])->setPaper('a4', 'landscape');;

        return $pdf->download('itsolutionstuff.pdf');
    }

    public function performance($id)
    {
        $bussinessAssistant = BussinessAssistant::findOrFail($id);
        $cooperations = $bussinessAssistant->cooperations()->get();

        // Hitung cooperation milik BA
        $cooperationCount = $bussinessAssistant->cooperations()->count();

        $nibYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('nib', 1);
            })->count();

        $simkopdesYes = Cooperation::where('bussiness_assistant_id', $id)->where('microsite_account', 1)->count();


        $npwpYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('npwp', 1);
            })->count();

        $bhDeedYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('bh_deed', 1);
            })->count();

        $cooperativeNikYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('cooperative_nik', 1);
            })->count();

        $cooperativeBankAccountYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('cooperative_bank_account', 1);
            })->count();

        $businessAcitivtyPlanYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('business_activity_plan', 1);
            })->count();

        $capexYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('capex', 1);
            })->count();

        $opexYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('opex', 1);
            })->count();

        $otherEquipmentYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formThree', function ($q) {
                $q->where('other_equipment', 1);
            })->count();

        $financingProposalYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formFour', function ($q) {
                $q->where('financing_proposal', 1);
            })->count();

        $simkopdesCompletenesYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('simkopdesCompletenes', function ($q) {
                $q->where('is_complete', 1);
            })->count();

        $landYes = Cooperation::where('bussiness_assistant_id', $id)
            ->whereHas('formSix', function ($q) {
                $q->whereNotNull('asset');
            })->count();

        $totalMembers = Cooperation::where('bussiness_assistant_id', $id)
            ->withSum('formSeven as total_member', 'number_of_member')
            ->get()
            ->sum('total_member');

        $scoreSimkopdesCompleteness = $cooperationCount > 0 ? ($simkopdesCompletenesYes / $cooperationCount) * 100 : 0;
        $finalScoreSimkopdesCompleteness = round(
            ($scoreSimkopdesCompleteness / 100) * 10,
            2
        );

        $scoreBusinessActivityPlan = $cooperationCount > 0 ? ($businessAcitivtyPlanYes / $cooperationCount) * 100 : 0;
        $finalScoreBusinessActivityPlan = round(
            ($scoreBusinessActivityPlan / 100) * 15,
            2
        );

        $requiredDocumentsPerCoop = 9;
        $completedDocumentsCount = $nibYes +
            $bhDeedYes +
            $cooperativeNikYes +
            $cooperativeBankAccountYes +
            $npwpYes +
            $businessAcitivtyPlanYes +
            $capexYes +
            $opexYes +
            $otherEquipmentYes;

        $totalRequiredDocuments = $cooperationCount * $requiredDocumentsPerCoop;

        $finalScoreDocument = $totalRequiredDocuments > 0
            ? round(($completedDocumentsCount / $totalRequiredDocuments) * 15, 2)
            : 0;



        $scoreBusinessActivityPlan = $cooperationCount > 0 ? ($businessAcitivtyPlanYes / $cooperationCount) * 100 : 0;
        $finalScoreBusinessActivityPlan = round(
            ($scoreBusinessActivityPlan / 100) * 15,
            2
        );

        $scoreFinancingProposal = $cooperationCount > 0 ? ($financingProposalYes / $cooperationCount) * 100 : 0;
        $finalScoreFinancingProposal = round(
            ($scoreFinancingProposal / 100) * 15,
            2
        );

        $scoreLand = $cooperationCount > 0 ? ($landYes / $cooperationCount) * 100 : 0;
        $finalScoreLand = round(
            ($scoreLand / 100) * 20,
            2
        );

        $finalScoreMonthlyReport = 10; // nilai tetap 10 untuk laporan bulanan

        $kpi = $finalScoreSimkopdesCompleteness +
            $finalScoreBusinessActivityPlan +
            $finalScoreDocument +
            $finalScoreFinancingProposal +
            $finalScoreLand +
            $finalScoreMonthlyReport + 5;

        // Tren Perkembangan Anggota Koperasi


        $baId = $id;

        $records = DB::table('record_form_sevens')
            ->join('cooperations', 'record_form_sevens.cooperation_id', '=', 'cooperations.id')
            ->where('cooperations.bussiness_assistant_id', $baId)
            ->select(
                'cooperations.id as coop_id',
                'cooperations.name as coop_name',
                'record_form_sevens.periode',
                'record_form_sevens.number_of_member'
            )
            ->orderBy('record_form_sevens.periode')
            ->get();

        $periods = $records->pluck('periode')->unique()->values();

        $datasets = $records
            ->groupBy('coop_name')
            ->map(function ($items, $coopName) use ($periods) {

                // mapping agar tiap koperasi punya data lengkap per periode
                $dataPerPeriod = $periods->map(function ($periode) use ($items) {
                    return optional(
                        $items->firstWhere('periode', $periode)
                    )->number_of_member ?? 0;
                });

                return [
                    'label' => $coopName,
                    'data'  => $dataPerPeriod,
                    'tension' => 0.3,
                ];
            })
            ->values();



        return view('bussiness-assistants.performance', compact(
            'bussinessAssistant',
            'cooperations',
            'landYes',
            'capexYes',
            'opexYes',
            'nibYes',
            'bhDeedYes',
            'cooperativeNikYes',
            'otherEquipmentYes',
            'simkopdesYes',
            'npwpYes',
            'cooperativeBankAccountYes',
            'financingProposalYes',
            'businessAcitivtyPlanYes',
            'cooperationCount',
            'simkopdesCompletenesYes',
            'finalScoreSimkopdesCompleteness',
            'finalScoreBusinessActivityPlan',
            'finalScoreDocument',
            'finalScoreFinancingProposal',
            'finalScoreLand',
            'finalScoreMonthlyReport',
            'kpi',
            'totalMembers',
            // Tren Anggota Koperasi
            'periods',
            'datasets',
        ));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function formTwoExport()
    {
        return Excel::download(new FormTwoExport, 'data-rencana-gerai.xlsx');
    }

    public function formRatExport() 
    {
        return Excel::download(new FormTenExport, 'laporan-form-rat.xlsx');
    }
}
