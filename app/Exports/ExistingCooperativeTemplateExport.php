<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExistingCooperativeTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ExistingCooperativeTemplateSheet(),
            new ExistingCooperativeReferenceSheet(),
        ];
    }
}
