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
            'Update Profil KDKMP',
            'Potensi Desa',
            'Gerai Sembako',
            'Gerai Apotek',
            'Gerai Pergudangan',
            'Gerai Klinik',
            'Gerai Logistik',
            'Gerai USP',
            'Gerai Usaha Lain',
            'RAT',
            'Jumlah Anggota Awal',
            'Penambahan Anggota',
            'Kendala',
            'Keterangan'
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
            $row->profile_update ? 'Sudah' : 'Belum', // Mengubah Boolean ke Iya/Tidak
            $row->village_potential ? 'Sudah' : 'Belum', // Mengubah Boolean ke Iya/Tidak
            $row->grocery_outlet  ? 'Iya' : 'Tidak', // Mengubah Boolean ke Iya/Tidak
            $row->pharmacy_outlet  ? 'Iya' : 'Tidak', // Mengubah Boolean ke Iya/Tidak
            $row->warehousing_outlet  ? 'Iya' : 'Tidak', // Mengubah Boolean ke Iya/Tidak
            $row->clinic_outlet  ? 'Iya' : 'Tidak', // Mengubah Boolean ke Iya/Tidak
            $row->logistics_outlet  ? 'Iya' : 'Tidak', // Mengubah Boolean ke Iya/Tidak
            $row->usp_outlet  ? 'Iya' : 'Tidak', // Mengubah Boolean ke Iya/Tidak
            $row->other_businesses_outlet  ? 'Iya' : 'Tidak', // Mengubah Boolean ke Iya/Tidak
            $row->rat ? 'Sudah' : 'Belum', // Mengubah Boolean ke Iya/Tidak
            $row->initial_membership, // Mengubah Boolean ke Iya/Tidak
            $row->addition_of_members, // Mengubah Boolean ke Iya/Tidak
            $row->problem, // Mengubah Boolean ke Iya/Tidak
            $row->information, // Mengubah Boolean ke Iya/Tidak
        ];
    }
}
