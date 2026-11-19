<?php

namespace App\Exports;

use App\Models\BusinessActivity;
use App\Models\CooperativeStatus;
use App\Models\District;
use App\Models\Village;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExistingCooperativeReferenceSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection(): Collection
    {
        $references = collect();

        foreach (CooperativeStatus::orderBy('name')->get() as $status) {
            $references->push(['Status Koperasi', $status->id, $status->name, null]);
        }

        foreach (BusinessActivity::orderBy('name')->get() as $activity) {
            $references->push(['Kegiatan Usaha', $activity->id, $activity->name, null]);
        }

        foreach (District::orderBy('name')->get() as $district) {
            $references->push(['Kecamatan', $district->id, $district->name, null]);
        }

        foreach (Village::with('district')->orderBy('name')->get() as $village) {
            $references->push([
                'Desa/Kelurahan',
                $village->id,
                $village->name,
                $village->district->name ?? null,
            ]);
        }

        return $references;
    }

    public function headings(): array
    {
        return ['Jenis Referensi', 'ID', 'Nama', 'Kecamatan'];
    }

    public function title(): string
    {
        return 'Referensi';
    }
}
