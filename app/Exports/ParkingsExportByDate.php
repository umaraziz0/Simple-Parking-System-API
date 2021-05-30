<?php

namespace App\Exports;

use App\Models\Parking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class ParkingsExportByDate implements FromQuery, WithHeadings
{
    use Exportable;

    public function dateRange($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;

        return $this;
    }

    public function query()
    {
        return Parking::query()->whereBetween("updated_at", [$this->fromDate, $this->toDate]);
    }

    public function headings(): array
    {
        return ["ID", "License Plate", "Unique Code", "Exit Time", "Parking Fee", "Enter Time", "Updated At"];
    }
}
