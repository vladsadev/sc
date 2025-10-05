<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Inspection;
use App\Models\InspectionIssue;
use Illuminate\Http\Request;

/** OPERA PRINCIPALMENTE EN EL SISTEMA CENTRAL O DEL SERVIDOR */
class ImportController extends Controller
{
    public function showImportForm()
    {
        return view('dashboard.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json|max:10240'
        ]);

        $data = json_decode(file_get_contents($request->file), true);
        $batch = 'BATCH_' . now()->timestamp;

        $results = [
            'success' => 0,
            'failed' => [],
        ];

        foreach ($data['inspections'] as $inspectionData) {
            // Buscar equipo por código
            $equipment = Equipment::where('code', $inspectionData['equipment_code'])->first();

            if (!$equipment) {
                $results['failed'][] = "Equipo {$inspectionData['equipment_code']} no encontrado";
                continue;
            }

            // Crear inspección
            $inspection = Inspection::create([
                'equipment_id' => $equipment->id,
                'user_id' => $data['export_info']['inspector_id'],
                'import_batch' => $batch,
                // ... mapear todos los campos
            ]);

            // Crear issues si existen
            foreach ($inspectionData['issues'] ?? [] as $issue) {
                InspectionIssue::create([
                    'inspection_id' => $inspection->id,
                    // ... campos del issue
                ]);
            }

            $results['success']++;
        }

        return back()->with('import_results', $results);
    }

}
