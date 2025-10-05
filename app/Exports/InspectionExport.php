<?php

namespace App\Exports;

use App\Models\Inspection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InspectionExport implements FromCollection, WithHeadings
{
    protected $inspections;

    public function __construct($inspections)
    {
        $this->inspections = $inspections;
    }

    public function query()
    {
        return Inspection::query()->with('user');
    }

    public function collection()
    {
        return $this->inspections->map(function ($inspection) {
            return [
                $inspection->inspection_date,
                $inspection->user->name,
                $inspection->status,
                $inspection->observations,
                $inspection->nivel_combustible_checked ? 'Checked' : 'Con observación'
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Fecha de Inspección',
            'Inspector',
            'Estado',
            'Observaciones',
            'Nivel de combustible'
        ];
    }
}
