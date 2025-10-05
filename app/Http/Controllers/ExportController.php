<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;


/** OPERA PRINCIPALMENTE EN EL SISTEMA LOCAL O TABLETAS DE INSPECTORES */
class ExportController extends Controller
{
    public function export()
    {
        $inspections = Inspection::with(['equipment', 'issues'])
            ->where('exported', false)
            ->where('user_id', auth()->id())
            ->get();

        $exportData = [
            'export_info' => [
                'inspector_id' => auth()->id(),
                'inspector_name' => auth()->user()->name,
                'export_date' => now()->toDateTimeString(),
                'total_inspections' => $inspections->count()
            ],
            'inspections' => $inspections->map(function ($inspection) {
                return [
                    'equipment_code' => $inspection->equipment->code,
                    // ... mapear todos los campos
                ];
            })
        ];

        // Marcar como exportadas
        $inspections->each->update(['exported' => true]);

        $filename = 'inspections_' . date('Y-m-d') . '_' . auth()->id() . '.json';

        return response()->json($exportData)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
