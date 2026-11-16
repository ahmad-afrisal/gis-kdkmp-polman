<?php

namespace App\Exports;

use App\Models\FormThree;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormThreeExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return FormThree::with('cooperation')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_koperasi' => $item->cooperation->name ?? '-',
                    'financing_partner' => $item->financing_partner,
                    'bh_deed' => $item->bh_deed ? 'Ya' : 'Tidak',
                    'cooperative_nik' => $item->cooperative_nik ? 'Ya' : 'Tidak',
                    'cooperative_bank_account' => $item->cooperative_bank_account ? 'Ya' : 'Tidak',
                    'npwp' => $item->npwp ? 'Ya' : 'Tidak',
                    'nib' => $item->nib ? 'Ya' : 'Tidak',
                    'business_activity_plan' => $item->business_activity_plan ? 'Ya' : 'Tidak',
                    'capex' => $item->capex ? 'Ya' : 'Tidak',
                    'opex' => $item->opex ? 'Ya' : 'Tidak',
                    'other_equipment' => $item->other_equipment ? 'Ya' : 'Tidak',
                    'information' => $item->information,
                    'created_at' => $item->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Koperasi',
            'Mitra Pembiayaan',
            'Akta BH',
            'NIK Koperasi',
            'Rekening Koperasi',
            'NPWP',
            'NIB',
            'Rencana Kegiatan Usaha',
            'CAPEX',
            'OPEX',
            'Peralatan Lain',
            'Informasi',
            'Tanggal Input',
        ];
    }
}