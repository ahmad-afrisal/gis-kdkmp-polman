<?php

namespace App\Exports;

use App\Models\FormSix;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// class FormSixExport implements FromCollection, WithHeadings, WithDrawings,
class FormSixExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = FormSix::with('cooperation')
            ->whereNotNull('asset')->get();
        $no = 1;
        return $data->map(function ($item) use (&$no) {
            return [
                'no' => $no++,
                'district' => $item->cooperation->village->district->name,
                'ba' => $item->cooperation->bussinessAssistant->name,
                'name' => $item->cooperation->name,
                'picture_land' => $item->picture_land,
                'latitude' => $item->latitude,
                'longitude' => $item->longitude,
                'width_land' => $item->width_land,
                'long_land' => $item->long_land,
                'letter_land' => $item->letter_land,
                'road_condition' => $item->road_condition,
                'asset' => $item->asset,
                'is_build' => $item->is_build ? 'Ya' : 'Tidak',
                'persentase' => $item->persentase,
                'progress' => $item->progress,
                'distance' => $item->distance,
                'internet_access' => $item->internet_access,
                'water_access' => $item->water_access,
                'electricity_access' => $item->electricity_access,
                'description' => $item->description

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
            "Nama BA",
            "Nama KDKMP",
            "Foto Lahan",
            "Latitude",
            "Longitude",
            "Lebar Lahan",
            "Panjang Lahan",
            "Surat Lahan",
            "Kondisi Jalan",
            "Aset",
            "Status Pembanguna",
            "Persentase (%)",
            "Progress",
            "Jarak ke Pemukiman",
            "Akses Internet",
            "Akses Air",
            "Akses Listrik",
            "Keterangan"
        ];
    }

    // public function drawings()
    // {
    //     $drawings = [];

    //     $rows = FormSix::whereNotNull('asset')->get();
    //     $rowNumber = 2; // row 1 adalah heading

    //     foreach ($rows as $item) {
    //         if ($item->picture_land && file_exists(public_path('storage/' . $item->picture_land))) {
    //             $drawing = new Drawing();
    //             $drawing->setName('Foto');
    //             $drawing->setDescription('Foto Lahan');
    //             $drawing->setPath(public_path('storage/' . $item->picture_land)); // path gambar
    //             $drawing->setHeight(80); // tinggi gambar

    //             // letakkan di kolom C (kolom gambar)
    //             $drawing->setCoordinates('C' . $rowNumber);

    //             $drawings[] = $drawing;
    //         }

    //         $rowNumber++;
    //     }

    //     return $drawings;
    // }
}
