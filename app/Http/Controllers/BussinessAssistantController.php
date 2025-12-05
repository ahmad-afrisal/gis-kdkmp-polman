<?php

namespace App\Http\Controllers;

use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\FormFive;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                    <a href="' . route('bussiness-assistants.show', $item->id) . '" 
                        class="inline-block bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Koperasi
                    </a>
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

    /**
     * Display the specified resource.
     */
    public function show(BussinessAssistant $bussinessAssistant)
    {
        if (request()->ajax()) {
            $query = Cooperation::where('bussiness_assistant_id', $bussinessAssistant->id);

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
                    <form class="inline-block" action="' . route('cooperations.destroy', $item->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')">
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

        return view('bussiness-assistants.detail.index', compact('bussinessAssistant'));
    }

    public function form1(BussinessAssistant $bussinessAssistant)
    {
        // Ambil semua koperasi yang dimiliki oleh Business Assistant ini
        $cooperations = $bussinessAssistant->cooperations()->get();

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
        $cooperations = $bussinessAssistant->cooperations()->with('formTwo')->get();

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
        $cooperations = $bussinessAssistant->cooperations()->with('formThree')->get();

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
        $cooperations = $bussinessAssistant->cooperations()->with('formFour')->get();

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
        $cooperations = $bussinessAssistant->cooperations()->with('formFives')->get();

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
        $cooperations = $bussinessAssistant->cooperations()->with('formSix')->get();

        // Kirim ke view form-1.blade.php
        return view('bussiness-assistants.detail.form-6', compact('bussinessAssistant', 'cooperations'));
    }

    public function storeOrUpdateFormSix(Request $request, BussinessAssistant $bussinessAssistant)
    {

        // return dd($request->all());
        foreach ($request->data as $index => $row) {

            // Ambil file gambar jika ada
            $file = $request->file("data.$index.picture_land");

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
                'description' => 'nullable|string',
            ])->validate();

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

    public function generateReport(BussinessAssistant $bussinessAssistant)
    {

        $cooperations = $bussinessAssistant->cooperations()->with('formTwo')->get();


        $pdf = Pdf::loadView('bussiness-assistants.detail.report', [
            'cooperations' => $cooperations,
            'bussinessAssistant' => $bussinessAssistant,
        ])->setPaper('a4', 'landscape');;

        return $pdf->download('itsolutionstuff.pdf');
    }
}
