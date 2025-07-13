<?php

namespace App\Exports;

use App\Models\Property;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PropertiesSampleExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        $columns = Schema::getColumnListing('properties');

        return array_diff($columns, ['id', 'user_id', 'created_at', 'updated_at','embedding']);
    }
}
