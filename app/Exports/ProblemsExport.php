<?php

namespace App\Exports;

use App\Models\Problem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class ProblemsExport implements FromQuery, WithMapping, WithHeadings, WithCustomStartCell, WithEvents
{
    // Query data yang akan diexport
    public function query()
    {
        return Problem::query()->orderBy('updated_at', 'desc');
    }

    // Menentukan baris data dimulai (Baris 4), karena 1-3 untuk Judul & Tanggal
    public function startCell(): string
    {
        return 'A4';
    }

    // Header Kolom (Akan muncul di baris 4)
    public function headings(): array
    {
        return [
            'ID',
            'Kecamatan',
            'KDKMP',
            'BA',
            'Permasalahan',
            'Solusi',
            'Status',
            'Priority',
            'Tanggal Masalah',
            'Terakhir Update'
        ];
    }

    // Mapping data agar rapi
    public function map($problem): array
    {
        return [
            $problem->id,
            $problem->cooperation->village->district->name,
            $problem->cooperation->name,
            $problem->cooperation->bussinessAssistant->name,
            $problem->problem,
            $problem->solution,
            $problem->status,
            $problem->priority,
            Carbon::parse($problem->date_problem)->translatedFormat('d F Y'),
            Carbon::parse($problem->updated_at)->translatedFormat('d F Y H:i'),
        ];
    }

    // Mengisi Judul dan Tanggal Export menggunakan Events
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Judul di Baris 1
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->setCellValue('A1', 'LAPORAN DATA PERMASALAHAN');
                
                // Tanggal Export di Baris 2
                $event->sheet->setCellValue('A2', 'Tanggal Export: ' . Carbon::now()->translatedFormat('l, d F Y H:i'));
                
                // Styling (Opsional: Membuat Bold Judul)
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A4:H4')->getFont()->setBold(true);
            },
        ];
    }
}