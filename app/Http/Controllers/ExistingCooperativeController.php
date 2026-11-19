<?php

namespace App\Http\Controllers;

use App\Exports\ExistingCooperativeTemplateExport;
use App\Http\Requests\ExistingCooperativeStoreRequest;
use App\Http\Requests\ExistingCooperativeUpdateRequest;
use App\Imports\ExistingCooperativeImport;
use App\Models\BusinessActivity;
use App\Models\CooperativeStatus;
use App\Models\District;
use App\Models\ExistingCooperative;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ExistingCooperativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = ExistingCooperative::with('village');

            return DataTables::of($query)
                ->addColumn('village', fn ($item) => $item->village->name)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('existing-cooperatives.images.index', $item->id) . '"
                        class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Kelola Gambar
                    </a>
                    <a href="' . route('existing-cooperatives.edit', $item->id) . '"
                        class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                        Edit
                    </a>
                    <form action="' . route('existing-cooperatives.destroy', $item->id) . '" method="POST" class="inline-block"
                        onsubmit="return confirm(\'Hapus data koperasi ini?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                            Hapus
                        </button>
                    </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('existing-cooperative.index');
    }

    public function downloadTemplate()
    {
        return Excel::download(
            new ExistingCooperativeTemplateExport(),
            'template-existing-cooperative.xlsx'
        );
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:20480'],
        ]);

        $import = new ExistingCooperativeImport();
        Excel::import($import, $request->file('file_excel'));

        $rows = $import->rows()->filter(function ($row) {
            foreach ($row as $value) {
                if ($value !== null && trim((string) $value) !== '') {
                    return true;
                }
            }

            return false;
        })->values();

        if ($rows->isEmpty()) {
            return redirect()->route('existing-cooperatives.index')
                ->with('error', 'File Excel tidak berisi data koperasi.');
        }

        $columnMap = [
            'nik' => 'nik',
            'nama_koperasi' => 'name',
            'nomor_badan_hukum' => 'legal_entity_number',
            'bentuk_koperasi' => 'form_of_cooperative',
            'jenis_koperasi' => 'type_of_cooperative',
            'model_pengelolaan' => 'management_model',
            'status_koperasi_id' => 'cooperative_status_id',
            'kegiatan_usaha_id' => 'business_activity_id',
            'kelompok_koperasi' => 'cooperative_group',
            'kecamatan_id' => 'district_id',
            'desa_kelurahan_id' => 'village_id',
            'alamat' => 'address',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'kode_pos' => 'postal_code',
            'nomor_telepon' => 'phone_number',
            'email' => 'email',
            'jumlah_anggota' => 'number_of_members',
            'nama_ketua' => 'chairperson_name',
            'nama_sekretaris' => 'secretary_name',
            'nama_bendahara' => 'treasurer_name',
            'nama_wakil_ketua_bidang_keanggotaan' => 'vice_chairperson_membership_name',
            'nama_wakil_ketua_bidang_usaha' => 'vice_chairperson_business_operations_name',
            'nama_ketua_pengawas' => 'head_supervisory_board_name',
            'nama_anggota_pengawas_i' => 'member_supervisory_board_i_name',
            'nama_anggota_pengawas_ii' => 'member_supervisory_board_ii_name',
        ];
        $textFields = [
            'nik',
            'name',
            'legal_entity_number',
            'form_of_cooperative',
            'type_of_cooperative',
            'management_model',
            'cooperative_group',
            'address',
            'latitude',
            'longitude',
            'postal_code',
            'phone_number',
            'email',
            'chairperson_name',
            'secretary_name',
            'treasurer_name',
            'vice_chairperson_membership_name',
            'vice_chairperson_business_operations_name',
            'head_supervisory_board_name',
            'member_supervisory_board_i_name',
            'member_supervisory_board_ii_name',
        ];
        $validationAttributes = [
            'nik' => 'NIK',
            'name' => 'nama koperasi',
            'legal_entity_number' => 'nomor badan hukum',
            'form_of_cooperative' => 'bentuk koperasi',
            'type_of_cooperative' => 'jenis koperasi',
            'management_model' => 'model pengelolaan',
            'cooperative_status_id' => 'ID status koperasi',
            'business_activity_id' => 'ID kegiatan usaha',
            'cooperative_group' => 'kelompok koperasi',
            'district_id' => 'ID kecamatan',
            'village_id' => 'ID desa/kelurahan',
            'address' => 'alamat',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'postal_code' => 'kode pos',
            'phone_number' => 'nomor telepon',
            'email' => 'email',
            'number_of_members' => 'jumlah anggota',
            'chairperson_name' => 'nama ketua',
            'secretary_name' => 'nama sekretaris',
            'treasurer_name' => 'nama bendahara',
            'vice_chairperson_membership_name' => 'nama wakil ketua bidang keanggotaan',
            'vice_chairperson_business_operations_name' => 'nama wakil ketua bidang usaha',
            'head_supervisory_board_name' => 'nama ketua pengawas',
            'member_supervisory_board_i_name' => 'nama anggota pengawas I',
            'member_supervisory_board_ii_name' => 'nama anggota pengawas II',
        ];
        $idFields = ['cooperative_status_id', 'business_activity_id', 'district_id', 'village_id'];
        $records = [];
        $errors = [];
        $seenUniqueValues = ['nik' => [], 'legal_entity_number' => []];

        foreach ($rows as $index => $row) {
            $row = $row->toArray();
            $attributes = [];

            foreach ($columnMap as $column => $field) {
                $value = $row[$column] ?? null;
                $attributes[$field] = is_string($value) ? trim($value) : $value;
                if ($attributes[$field] === '') {
                    $attributes[$field] = null;
                }
            }

            foreach ($textFields as $field) {
                if ($attributes[$field] !== null) {
                    $attributes[$field] = (string) $attributes[$field];
                }
            }

            foreach ([...$idFields, 'number_of_members'] as $field) {
                $value = $attributes[$field];
                if (is_numeric($value) && (float) $value === floor((float) $value)) {
                    $attributes[$field] = (int) $value;
                }
            }

            $validator = Validator::make(
                $attributes,
                [
                    'nik' => ['required', 'string', 'max:255', 'unique:existing_cooperatives,nik'],
                    'name' => ['required', 'string', 'max:255'],
                    'legal_entity_number' => ['required', 'string', 'max:255', 'unique:existing_cooperatives,legal_entity_number'],
                    'form_of_cooperative' => ['required', Rule::in(['Primer', 'Sekunder'])],
                    'type_of_cooperative' => ['required', 'string', 'max:255'],
                    'management_model' => ['required', Rule::in(['Konvensional', 'Syariah'])],
                    'cooperative_status_id' => ['required', 'integer', 'exists:cooperative_statuses,id'],
                    'business_activity_id' => ['required', 'integer', 'exists:business_activities,id'],
                    'cooperative_group' => ['required', 'string', 'max:255'],
                    'district_id' => ['required', 'integer', 'exists:districts,id'],
                    'village_id' => [
                        'required',
                        'integer',
                        Rule::exists('villages', 'id')->where('district_id', $attributes['district_id']),
                    ],
                    'address' => ['required', 'string'],
                    'latitude' => ['nullable', 'required_with:longitude', 'numeric', 'between:-90,90'],
                    'longitude' => ['nullable', 'required_with:latitude', 'numeric', 'between:-180,180'],
                    'postal_code' => ['required', 'string', 'max:255'],
                    'phone_number' => ['nullable', 'string', 'max:255'],
                    'email' => ['nullable', 'email', 'max:255'],
                    'number_of_members' => ['required', 'integer', 'min:0'],
                    'chairperson_name' => ['nullable', 'string', 'max:255'],
                    'secretary_name' => ['nullable', 'string', 'max:255'],
                    'treasurer_name' => ['nullable', 'string', 'max:255'],
                    'vice_chairperson_membership_name' => ['nullable', 'string', 'max:255'],
                    'vice_chairperson_business_operations_name' => ['nullable', 'string', 'max:255'],
                    'head_supervisory_board_name' => ['nullable', 'string', 'max:255'],
                    'member_supervisory_board_i_name' => ['nullable', 'string', 'max:255'],
                    'member_supervisory_board_ii_name' => ['nullable', 'string', 'max:255'],
                ],
                [
                    'required' => 'Kolom :attribute wajib diisi.',
                    'string' => 'Kolom :attribute harus berupa teks.',
                    'max' => 'Kolom :attribute maksimal :max karakter.',
                    'unique' => 'Nilai :attribute sudah digunakan.',
                    'in' => 'Nilai :attribute tidak sesuai pilihan.',
                    'exists' => 'ID :attribute tidak ditemukan pada sheet Referensi.',
                    'integer' => 'Kolom :attribute harus berupa angka bulat.',
                    'email' => 'Format :attribute tidak valid.',
                    'min' => 'Kolom :attribute minimal :min.',
                ],
                $validationAttributes
            );

            $rowNumber = $index + 2;
            $rowErrors = $validator->errors()->all();

            foreach (['nik', 'legal_entity_number'] as $field) {
                $value = $attributes[$field];
                if ($value === null) {
                    continue;
                }

                $key = strtolower($value);
                if (isset($seenUniqueValues[$field][$key])) {
                    $rowErrors[] = "Nilai {$validationAttributes[$field]} duplikat dengan baris {$seenUniqueValues[$field][$key]}.";
                } else {
                    $seenUniqueValues[$field][$key] = $rowNumber;
                }
            }

            if ($rowErrors !== []) {
                foreach ($rowErrors as $message) {
                    if (count($errors) < 30) {
                        $errors[] = "Baris {$rowNumber}: {$message}";
                    }
                }

                continue;
            }

            $records[] = $attributes;
        }

        if ($errors !== []) {
            return redirect()->route('existing-cooperatives.index')
                ->with('error', 'Tidak ada data yang diimpor karena terdapat kesalahan:')
                ->with('importErrors', $errors);
        }

        DB::transaction(function () use ($records) {
            foreach ($records as $record) {
                ExistingCooperative::create($record);
            }
        });

        return redirect()->route('existing-cooperatives.index')
            ->with('success', count($records) . ' data koperasi berhasil diimpor.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('existing-cooperative.create', [
            'cooperativeStatuses' => CooperativeStatus::pluck('name', 'id'),
            'businessActivities' => BusinessActivity::pluck('name', 'id'),
            'districts' => District::pluck('name', 'id'),
            'villages' => collect(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExistingCooperativeStoreRequest $request)
    {
        ExistingCooperative::create($request->validated());

        return redirect()->route('existing-cooperatives.index')
            ->with('success', 'Data koperasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ExistingCooperative::findOrFail($id);

        return view('existing-cooperative.create', [
            'data' => $data,
            'cooperativeStatuses' => CooperativeStatus::pluck('name', 'id'),
            'businessActivities' => BusinessActivity::pluck('name', 'id'),
            'districts' => District::pluck('name', 'id'),
            'villages' => collect(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExistingCooperativeUpdateRequest $request, string $id)
    {
        $cooperative = ExistingCooperative::findOrFail($id);
        $cooperative->update($request->validated());

        return redirect()->route('existing-cooperatives.index')
            ->with('success', 'Data koperasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cooperative = ExistingCooperative::findOrFail($id);
        $cooperative->delete();

        return redirect()->route('existing-cooperatives.index')
            ->with('success', 'Data koperasi berhasil dihapus.');
    }

    public function getVillages($district)
    {
        $villages = Village::where('district_id', $district)
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');

        return response()->json($villages);
    }
}
