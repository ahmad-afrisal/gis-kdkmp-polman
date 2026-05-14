<?php

namespace App\Exports;

use App\Models\FormEight;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FormEightExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    private $rowNumber = 0;

    public function query()
    {
        return FormEight::with([
            'cooperation.village.district',
            'cooperation.bussinessAssistant'
        ]);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama KDKMP',
            'Kecamatan',
            'Nama BA',
            'Kesiapan Lahan',
            'Pembangunan Toko',
            'Kendaraan',
            'Meja dan Kursi',
            'Etalase',
            'Komputer',
            'Kendala',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        $storeDevelopment = match ((int) $row->store_development) {
            0 => 'Belum',
            1 => 'Selesai',
            2 => 'Tidak Terbangun',
            default => '-',
        };

        return [
            ++$this->rowNumber,

            $row->cooperation?->name ?? '-',

            $row->cooperation?->village?->district?->name ?? '-',

            $row->cooperation?->bussinessAssistant?->name ?? '-',

            $row->land_readiness ? 'Siap' : 'Belum',

            $storeDevelopment,

            $row->vehicle ? 'Ada' : 'Tidak Ada',

            $row->table_and_chair ? 'Ada' : 'Tidak Ada',

            $row->display_case ? 'Ada' : 'Tidak Ada',

            $row->computer ? 'Ada' : 'Tidak Ada',

            $row->problem ?? '-',

            $row->information ?? '-',


        ];
    }
}
