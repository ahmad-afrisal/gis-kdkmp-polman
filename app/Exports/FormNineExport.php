<?php

namespace App\Exports;

use App\Models\FormNine;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormNineExport implements FromQuery, WithMapping, WithHeadings
{
    public function query()
    {
        return FormNine::with('cooperation');
    }

    public function map($item): array
    {
        $status = match ((int) $item->outlet_status) {
            0 => 'Belum Ada',
            1 => 'Belum Buka',
            2 => 'Operasional',
            default => '-',
        };

        return [
            $item->id,
            $item->cooperation->name ?? '-',
            $item->cooperation->village->district->name,
            $item->cooperation->bussinessAssistant->name,
            $status,
            $item->number_of_employees_2025,
            $item->number_of_employees_2026,
            $item->outlet_operations_guide ? 'Ya' : 'Tidak',
            $item->problem,
            $item->information,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama KDKMP',
            'Kecamatan',
            'Nama BA',
            'Status Outlet',
            'Jumlah Pegawai 2025',
            'Jumlah Pegawai 2026',
            'Panduan Operasional Outlet',
            'Problem',
            'Information',
        ];
    }
}
