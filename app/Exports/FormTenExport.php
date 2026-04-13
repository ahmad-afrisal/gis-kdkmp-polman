<?php
namespace App\Exports;

use App\Models\FormTen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormTenExport implements FromCollection, WithMapping, WithHeadings
{
    private $rowNumber = 0;

    public function collection()
    {
        // Mengambil data dengan eager loading agar tidak berat (N+1 Problem)
        return FormTen::with('cooperation')->get();
    }

    // Header untuk Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama KDKMP',
            'Kecamatan',
            'Nama BA',
            'Status RAT',
        ];
    }

    // Mapping data per baris
    public function map($row): array
    {
        return [
            ++$this->rowNumber, // No Urut
            $row->cooperation->name ?? '-', 
            $row->cooperation->village->district->name,
            $row->cooperation->bussinessAssistant->name,
            $row->rat ? 'Sudah' : 'Belum', // Mengubah Boolean ke Iya/Tidak
        ];
    }
}