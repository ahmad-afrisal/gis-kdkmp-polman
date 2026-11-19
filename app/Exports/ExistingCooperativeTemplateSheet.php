<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExistingCooperativeTemplateSheet implements FromArray, WithColumnFormatting, WithHeadings, WithTitle
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
            'nik',
            'nama_koperasi',
            'nomor_badan_hukum',
            'bentuk_koperasi',
            'jenis_koperasi',
            'model_pengelolaan',
            'status_koperasi_id',
            'kegiatan_usaha_id',
            'kelompok_koperasi',
            'kecamatan_id',
            'desa_kelurahan_id',
            'alamat',
            'latitude',
            'longitude',
            'kode_pos',
            'nomor_telepon',
            'email',
            'jumlah_anggota',
            'nama_ketua',
            'nama_sekretaris',
            'nama_bendahara',
            'nama_wakil_ketua_bidang_keanggotaan',
            'nama_wakil_ketua_bidang_usaha',
            'nama_ketua_pengawas',
            'nama_anggota_pengawas_i',
            'nama_anggota_pengawas_ii',
        ];
    }

    public function columnFormats(): array
    {
        return array_fill_keys(range('A', 'Z'), NumberFormat::FORMAT_TEXT);
    }

    public function title(): string
    {
        return 'Data Koperasi';
    }
}
