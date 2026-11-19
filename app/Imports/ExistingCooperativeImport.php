<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExistingCooperativeImport implements ToCollection, WithHeadingRow
{
    private ?Collection $importedRows = null;

    public function collection(Collection $rows): void
    {
        $this->importedRows = $rows;
    }

    public function rows(): Collection
    {
        return $this->importedRows ?? collect();
    }
}
