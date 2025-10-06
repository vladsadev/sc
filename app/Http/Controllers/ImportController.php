<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Inspection;
use App\Models\InspectionIssue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'file' => 'required|file|mimes:json|max:10240' // Max 10MB
        ]);

        try {
            DB::beginTransaction();

            // Leer y decodificar el archivo JSON
            $jsonContent = file_get_contents($request->file('file'));
            $data = json_decode($jsonContent, true);

            // Validar estructura básica del JSON
            if (!isset($data['export_info']) || !isset($data['inspections'])) {
                throw new \Exception('Formato de archivo inválido. Falta información de exportación.');
            }

            // Generar identificador único para este lote de importación
            $batch = 'BATCH_' . now()->format('Ymd_His') . '_' . uniqid();

            // Preparar resultados
            $results = [
                'success' => 0,
                'failed' => [],
                'warnings' => [],
                'batch_id' => $batch,
                'inspector_info' => $data['export_info']
            ];

            // Verificar si el inspector existe en el sistema central
            $inspectorId = $data['export_info']['inspector_id'];
            $inspector = User::find($inspectorId);

            if (!$inspector) {
                // Opción 1: Usar un usuario genérico para inspectores externos
                $inspector = User::firstOrCreate(
                    ['email' => 'inspector.externo@sistema.com'],
                    [
                        'name' => 'Inspector Externo',
                        'password' => bcrypt('temp_password_' . uniqid()),
                        'occupation' => 'Inspector'
                    ]
                );
                $results['warnings'][] = "Inspector ID {$inspectorId} no encontrado. Usando usuario genérico.";
                $inspectorId = $inspector->id;
            }

            // Procesar cada inspección
            foreach ($data['inspections'] as $index => $inspectionData) {
                try {
                    // Buscar equipo por código
                    $equipment = Equipment::where('code', $inspectionData['equipment_code'])->first();

                    if (!$equipment) {
                        $results['failed'][] = "Inspección #" . ($index + 1) .
                            ": Equipo con código '{$inspectionData['equipment_code']}' no encontrado en el sistema.";
                        continue;
                    }

                    // Verificar si ya existe una inspección idéntica (evitar duplicados)
                    $existingInspection = Inspection::where('equipment_id', $equipment->id)
                        ->where('inspection_date', $inspectionData['inspection_date'])
                        ->where('user_id', $inspectorId)
                        ->first();

                    if ($existingInspection) {
                        $results['warnings'][] = "Inspección #" . ($index + 1) .
                            ": Ya existe una inspección para el equipo {$equipment->code} en la fecha {$inspectionData['inspection_date']}";
                        continue;
                    }

                    // Crear la inspección con TODOS los campos
                    $inspection = Inspection::create([
                        'equipment_id' => $equipment->id,
                        'user_id' => $inspectorId,
                        'inspection_date' => $inspectionData['inspection_date'],
                        'status' => $inspectionData['status'],
                        'observations' => $inspectionData['observations'],

                        // SECCIÓN 1: REVISIÓN ANTES DE ARRANCAR EL MOTOR
                        'nivel_combustible_checked' => $inspectionData['nivel_combustible_checked'],
                        'nivel_aceite_motor_checked' => $inspectionData['nivel_aceite_motor_checked'],
                        'nivel_refrigerante_checked' => $inspectionData['nivel_refrigerante_checked'],
                        'nivel_aceite_hidraulico_checked' => $inspectionData['nivel_aceite_hidraulico_checked'],
                        'purgar_agua_filtro_checked' => $inspectionData['purgar_agua_filtro_checked'],
                        'polvo_valvula_vacio_checked' => $inspectionData['polvo_valvula_vacio_checked'],
                        'correas_alternador_checked' => $inspectionData['correas_alternador_checked'],
                        'filtro_de_aire_checked' => $inspectionData['filtro_de_aire_checked'],
                        'reservorio_de_grasa_checked' => $inspectionData['reservorio_de_grasa_checked'],
                        'bornes_de_bateria_checked' => $inspectionData['bornes_de_bateria_checked'],
                        'mangueras_de_admision_checked' => $inspectionData['mangueras_de_admision_checked'],
                        'gatas_checked' => $inspectionData['gatas_checked'],

                        // SECCIÓN 2: REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR
                        'pedales_freno_checked' => $inspectionData['pedales_freno_checked'],
                        'alarma_arranque_checked' => $inspectionData['alarma_arranque_checked'],
                        'viga_y_brazo_checked' => $inspectionData['viga_y_brazo_checked'],
                        'sistema_de_rimado_checked' => $inspectionData['sistema_de_rimado_checked'],
                        'sistema_de_aire_checked' => $inspectionData['sistema_de_aire_checked'],
                        'sistema_de_barrido_checked' => $inspectionData['sistema_de_barrido_checked'],
                        'booster_de_agua_checked' => $inspectionData['booster_de_agua_checked'],
                        'regulador_de_aire_lub_checked' => $inspectionData['regulador_de_aire_lub_checked'],
                        'carrete_manguera_agua_checked' => $inspectionData['carrete_manguera_agua_checked'],

                        // SECCIÓN 3: INSPECCIÓN GENERAL
                        'carrete_de_posicionamiento_checked' => $inspectionData['carrete_de_posicionamiento_checked'],
                        'valvula_a_avance_checked' => $inspectionData['valvula_a_avance_checked'],
                        'cable_retroceso_y_tensor_checked' => $inspectionData['cable_retroceso_y_tensor_checked'],
                        'mesa_de_perforadora_checked' => $inspectionData['mesa_de_perforadora_checked'],
                        'dowel_checked' => $inspectionData['dowel_checked'],

                        // SECCIÓN 4: TEMAS NO NEGOCIABLES
                        'freno_de_servicio_checked' => $inspectionData['freno_de_servicio_checked'],
                        'freno_parqueo_checked' => $inspectionData['freno_parqueo_checked'],
                        'controles_perforacion_checked' => $inspectionData['controles_perforacion_checked'],
                        'luces_delanteras_checked' => $inspectionData['luces_delanteras_checked'],
                        'alarma_de_retroceso_checked' => $inspectionData['alarma_de_retroceso_checked'],
                        'bocina_checked' => $inspectionData['bocina_checked'],
                        'cinturon_de_seguridad_checked' => $inspectionData['cinturon_de_seguridad_checked'],
                        'switch_master_checked' => $inspectionData['switch_master_checked'],
                        'paradas_de_emergencia_checked' => $inspectionData['paradas_de_emergencia_checked'],

                        // Horómetros
                        'engine_hours' => $inspectionData['engine_hours'],
                        'percussion_hours' => $inspectionData['percussion_hours'],
                        'position_hours' => $inspectionData['position_hours'],

                        // EPP
                        'epp_complete' => $inspectionData['epp_complete'],

                        // Campos de tracking
                        'import_batch' => $batch,
                        'exported' => false // Se marca como no exportada en el sistema central
                    ]);

                    // Actualizar los horómetros del equipo si son más recientes
                    if ($inspection->engine_hours > ($equipment->engine_hours ?? 0)) {
                        $equipment->update([
                            'engine_hours' => $inspection->engine_hours,
                            'percussion_hours' => $inspection->percussion_hours,
                            'position_hours' => $inspection->position_hours,
                        ]);
                    }

                    // Crear issues si existen
                    if (isset($inspectionData['issues']) && is_array($inspectionData['issues'])) {
                        foreach ($inspectionData['issues'] as $issueData) {
                            InspectionIssue::create([
                                'inspection_id' => $inspection->id,
                                'user_id' => $inspectorId,
                                'component' => $issueData['component'],
                                'issue_type' => $issueData['issue_type'],
                                'description' => $issueData['description'],
                                'status' => $issueData['status'],
                                'reported_at' => $issueData['reported_at'],
                            ]);
                        }
                    }

                    $results['success']++;

                } catch (\Exception $e) {
                    $results['failed'][] = "Inspección #" . ($index + 1) .
                        ": Error al procesar - " . $e->getMessage();
                    Log::error('Error importando inspección', [
                        'index' => $index,
                        'data' => $inspectionData,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();

            // Log de la importación
            Log::info('Importación completada', $results);

            return back()->with('import_results', $results);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error general en importación', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Método para ver el historial de importaciones
     */
    public function history()
    {
        $batches = Inspection::select('import_batch', DB::raw('COUNT(*) as count'), DB::raw('MIN(created_at) as imported_at'))
            ->whereNotNull('import_batch')
            ->groupBy('import_batch')
            ->orderBy('imported_at', 'desc')
            ->paginate(10);

        return view('dashboard.import-history', compact('batches'));
    }
}
