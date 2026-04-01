<?php

namespace App\Exports;

use App\Models\FormSix;
use App\Models\FormTwo;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class FormTwoExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = FormTwo::with('cooperation')->get();
        $no = 1;
        return $data->map(function ($item) use (&$no) {
            return [
                'no' => $no++,
                'district' => $item->cooperation->village->district->name,
                'village' => $item->cooperation->village->name,
                'name' => $item->cooperation->name,
                'bussiness_plan' => $item->bussiness_plan,
                'basic_necessities_exist' => $item->basic_necessities_exist,
                'basic_necessities_running' => $item->basic_necessities_running,
                'savings_and_loan_exist' => $item->savings_and_loan_exist,
                'savings_and_loan_running' => $item->savings_and_loan_running,
                'pharmacy_exist' => $item->pharmacy_exist,
                'pharmacy_running' => $item->pharmacy_running,
                'clinic_exist' => $item->clinic_exist,
                'clinic_running' => $item->clinic_running,
                'logistics_exist' => $item->logistics_exist,
                'logistics_running' => $item->logistics_running,
                'storage_exist' => $item->storage_exist,
                'storage_running' => $item->storage_running,
                'other_businesses_exist' => $item->other_businesses_exist,
                'other_businesses_running' => $item->other_businesses_running,
                'information' => $item->information

            ];
        });
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return [
            "No",
            "Nama Kecamatan",
            "Nama Desa/Kelurahan",
            "Nama KDKMP",
            "Rencana Bisnis",
            "Ada Rencana Bisnis",
            "Tidak Ada Rencana Bisnis",
            "Ada Rencana Bisnis",
            "Tidak Ada Rencana Bisnis",
            "Ada Rencana Bisnis",
            "Tidak Ada Rencana Bisnis",
            "Ada Rencana Bisnis",
            "Tidak Ada Rencana Bisnis",
            "Ada Rencana Bisnis",
            "Tidak Ada Rencana Bisnis",
            "Ada Rencana Bisnis",
            "Tidak Ada Rencana Bisnis",
            "Ada Rencana Bisnis",
            "Tidak Ada Rencana Bisnis",
            "Keterangan",

        ];
    }
}
