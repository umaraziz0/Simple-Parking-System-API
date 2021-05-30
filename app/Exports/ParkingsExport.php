<?php

namespace App\Exports;

use App\Models\Parking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ParkingsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Parking::all();
    }

    public function headings(): array
    {
        return ["ID", "License Plate", "Unique Code", "Exit Time", "Parking Fee", "Enter Time", "Updated At"];
    }
}
