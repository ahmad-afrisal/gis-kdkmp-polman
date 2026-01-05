<?php

namespace App\Http\Controllers;

use App\Models\FormSeven;
use App\Models\RecordFormSeven;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordFormSevenController extends Controller
{


    public function storeAllRecord()
    {
        $periode = now()->format('Y-m-d'); // contoh periode bulanan

        // cegah double klik periode yang sama
        $exists = RecordFormSeven::where('periode', $periode)->exists();
        if ($exists) {
            return back()->with('error', 'Periode ini sudah dicatat');
        }

        $records = FormSeven::whereNotNull('number_of_member')
            ->get()
            ->map(function ($item) use ($periode) {
                return [
                    'periode' => $periode,
                    'cooperation_id' => $item->cooperation_id,
                    'number_of_member' => $item->number_of_member,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })
            ->toArray();

        DB::table('record_form_sevens')->insert($records);

        return back()->with('success', 'Snapshot seluruh koperasi berhasil dicatat');
    }
}
