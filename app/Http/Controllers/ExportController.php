<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;

/** OPERA PRINCIPALMENTE EN EL SISTEMA LOCAL O TABLETAS DE INSPECTORES */
class ExportController extends Controller
{
    public function export()
    {
        $inspections = Inspection::with(['equipment', 'issues', 'user'])
            ->where('exported', false)
            ->where('user_id', auth()->id())
            ->get();

        if($inspections->isEmpty()){
            return redirect(route('dashboard'))->with('fail', 'No hay inspecciones para exportar');
        }

        $exportData = [
            'export_info' => [
                'inspector_id' => auth()->id(),
                'inspector_name' => auth()->user()->name,
                'export_date' => now()->toDateTimeString(),
                'total_inspections' => $inspections->count()
            ],
            'inspections' => $inspections->map(function ($inspection) {
                return [
                    // Identificación del equipo (CRÍTICO para la importación)
                    'equipment_code' => $inspection->equipment->code,

                    // Información básica de la inspección
                    'inspection_date' => $inspection->inspection_date,
                    'status' => $inspection->status,
                    'observations' => $inspection->observations,

                    // SECCIÓN 1: REVISIÓN ANTES DE ARRANCAR EL MOTOR
                    'nivel_combustible_checked' => $inspection->nivel_combustible_checked,
                    'nivel_aceite_motor_checked' => $inspection->nivel_aceite_motor_checked,
                    'nivel_refrigerante_checked' => $inspection->nivel_refrigerante_checked,
                    'nivel_aceite_hidraulico_checked' => $inspection->nivel_aceite_hidraulico_checked,
                    'purgar_agua_filtro_checked' => $inspection->purgar_agua_filtro_checked,
                    'polvo_valvula_vacio_checked' => $inspection->polvo_valvula_vacio_checked,
                    'correas_alternador_checked' => $inspection->correas_alternador_checked,
                    'filtro_de_aire_checked' => $inspection->filtro_de_aire_checked,
                    'reservorio_de_grasa_checked' => $inspection->reservorio_de_grasa_checked,
                    'bornes_de_bateria_checked' => $inspection->bornes_de_bateria_checked,
                    'mangueras_de_admision_checked' => $inspection->mangueras_de_admision_checked,
                    'gatas_checked' => $inspection->gatas_checked,

                    // SECCIÓN 2: REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR
                    'pedales_freno_checked' => $inspection->pedales_freno_checked,
                    'alarma_arranque_checked' => $inspection->alarma_arranque_checked,
                    'viga_y_brazo_checked' => $inspection->viga_y_brazo_checked,
                    'sistema_de_rimado_checked' => $inspection->sistema_de_rimado_checked,
                    'sistema_de_aire_checked' => $inspection->sistema_de_aire_checked,
                    'sistema_de_barrido_checked' => $inspection->sistema_de_barrido_checked,
                    'booster_de_agua_checked' => $inspection->booster_de_agua_checked,
                    'regulador_de_aire_lub_checked' => $inspection->regulador_de_aire_lub_checked,
                    'carrete_manguera_agua_checked' => $inspection->carrete_manguera_agua_checked,

                    // SECCIÓN 3: INSPECCIÓN GENERAL
                    'carrete_de_posicionamiento_checked' => $inspection->carrete_de_posicionamiento_checked,
                    'valvula_a_avance_checked' => $inspection->valvula_a_avance_checked,
                    'cable_retroceso_y_tensor_checked' => $inspection->cable_retroceso_y_tensor_checked,
                    'mesa_de_perforadora_checked' => $inspection->mesa_de_perforadora_checked,
                    'dowel_checked' => $inspection->dowel_checked,

                    // SECCIÓN 4: TEMAS NO NEGOCIABLES
                    'freno_de_servicio_checked' => $inspection->freno_de_servicio_checked,
                    'freno_parqueo_checked' => $inspection->freno_parqueo_checked,
                    'controles_perforacion_checked' => $inspection->controles_perforacion_checked,
                    'luces_delanteras_checked' => $inspection->luces_delanteras_checked,
                    'alarma_de_retroceso_checked' => $inspection->alarma_de_retroceso_checked,
                    'bocina_checked' => $inspection->bocina_checked,
                    'cinturon_de_seguridad_checked' => $inspection->cinturon_de_seguridad_checked,
                    'switch_master_checked' => $inspection->switch_master_checked,
                    'paradas_de_emergencia_checked' => $inspection->paradas_de_emergencia_checked,

                    // Horómetros (MUY IMPORTANTES)
                    'engine_hours' => $inspection->engine_hours,
                    'percussion_hours' => $inspection->percussion_hours,
                    'position_hours' => $inspection->position_hours,

                    // EPP
                    'epp_complete' => $inspection->epp_complete,

                    // Issues encontrados durante la inspección
                    'issues' => $inspection->issues->map(function ($issue) {
                        return [
                            'component' => $issue->component,
                            'issue_type' => $issue->issue_type,
                            'description' => $issue->description,
                            'status' => $issue->status,
                            'reported_at' => $issue->reported_at->toDateTimeString(),
                        ];
                    })->toArray()
                ];
            })->toArray()
        ];

        // Marcar como exportadas
        $inspections->each->update(['exported' => true]);

        $filename = 'inspections_' . date('Y-m-d_His') . '_inspector_' . auth()->id() . '.json';

        return response()->json($exportData)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Método adicional para previsualizar las inspecciones pendientes de exportar
     */
    public function preview()
    {
        $pendingInspections = Inspection::with(['equipment', 'issues'])
            ->where('exported', false)
            ->where('user_id', auth()->id())
            ->get();

        return view('dashboard.export-preview', [
            'inspections' => $pendingInspections,
            'count' => $pendingInspections->count()
        ]);
    }

    /**
     * Método para resetear el estado de exportación (útil para desarrollo/testing)
     */
    public function resetExportStatus()
    {
        // Solo en desarrollo
        if (app()->environment('local')) {
            Inspection::where('user_id', auth()->id())
                ->update(['exported' => false]);

            return back()->with('success', 'Estado de exportación reseteado.');
        }

        abort(403);
    }
}
