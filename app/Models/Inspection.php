<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inspection
 *
 * @property int $id
 * @property int $equipment_id
 * @property int $user_id
 * @property \Carbon\Carbon $inspection_date
 * @property string $status
 * @property string|null $observations
 * @property float|null $engine_hours Lectura del horómetro del motor al momento de la inspección
 * @property float|null $percussion_hours Lectura del horómetro de percusión al momento de la inspección
 * @property float|null $position_hours Lectura del horómetro de posicionamiento al momento de la inspección
 * @property bool $epp_complete
 */
class Inspection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'inspection_date' => 'datetime',
        'epp_complete' => 'boolean',

        // Cast para los horómetros
        'engine_hours' => 'decimal:1',
        'percussion_hours' => 'decimal:1',
        'position_hours' => 'decimal:1',

        // SECCIÓN 1: REVISIÓN ANTES DE ARRANCAR EL MOTOR
        'nivel_combustible_checked'      => 'boolean',
        'nivel_aceite_motor_checked'     => 'boolean',
        'nivel_refrigerante_checked'     => 'boolean',
        'nivel_aceite_hidraulico_checked'=> 'boolean',
        'purgar_agua_filtro_checked'     => 'boolean',
        'polvo_valvula_vacio_checked'    => 'boolean',
        'correas_alternador_checked'     => 'boolean',
        'filtro_de_aire_checked'         => 'boolean',
        'reservorio_de_grasa_checked'    => 'boolean',
        'bornes_de_bateria_checked'      => 'boolean',
        'mangueras_de_admision_checked'  => 'boolean',
        'gatas_checked'                  => 'boolean',

        // SECCIÓN 2: REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR
        'pedales_freno_checked'          => 'boolean',
        'alarma_arranque_checked'        => 'boolean',
        'viga_y_brazo_checked'           => 'boolean',
        'sistema_de_rimado_checked'      => 'boolean',
        'sistema_de_aire_checked'        => 'boolean',
        'sistema_de_barrido_checked'     => 'boolean',
        'booster_de_agua_checked'        => 'boolean',
        'regulador_de_aire_lub_checked'  => 'boolean',
        'carrete_manguera_agua_checked'  => 'boolean',

        // SECCIÓN 3: INSPECCIÓN GENERAL
        'carrete_de_posicionamiento_checked' => 'boolean',
        'valvula_a_avance_checked'           => 'boolean',
        'cable_retroceso_y_tensor_checked'   => 'boolean',
        'mesa_de_perforadora_checked'        => 'boolean',
        'dowel_checked'                      => 'boolean',

        // SECCIÓN 4: TEMA NO NEGOCIABLES
        'freno_de_servicio_checked'          => 'boolean',
        'freno_parqueo_checked'              => 'boolean',
        'controles_perforacion_checked'      => 'boolean',
        'luces_delanteras_checked'           => 'boolean',
        'alarma_de_retroceso_checked'        => 'boolean',
        'bocina_checked'                     => 'boolean',
        'cinturon_de_seguridad_checked'      => 'boolean',
        'switch_master_checked'              => 'boolean',
        'paradas_de_emergencia_checked'      => 'boolean',

    ];

    /**
     * Relaciones
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issues()
    {
        return $this->hasMany(InspectionIssue::class);
    }

    /**
     * MÉTODOS HELPER PARA HORÓMETROS
     */

    /**
     * Obtener la inspección anterior para este equipo
     */
    public function previousInspection()
    {
        return self::where('equipment_id', $this->equipment_id)
            ->where('inspection_date', '<', $this->inspection_date)
            ->orderBy('inspection_date', 'desc')
            ->first();
    }

    /**
     * Obtener la siguiente inspección para este equipo
     */
//    public function nextInspection()
//    {
//        return self::where('equipment_id', $this->equipment_id)
//            ->where('inspection_date', '>', $this->inspection_date)
//            ->orderBy('inspection_date', 'asc')
//            ->first();
//    }

    /**
     * Calcular las horas de motor trabajadas desde la inspección anterior
     */
    public function getEngineHoursWorkedAttribute(): float
    {
        $previous = $this->previousInspection();
        if (!$previous || !$previous->engine_hours) {
            // Si no hay inspección previa, retornar las horas actuales
            return 0;
        }
        return max(0, ($this->engine_hours ?? 0) - $previous->engine_hours);
    }

    /**
     * Calcular las horas de percusión trabajadas desde la inspección anterior
     */
    public function getPercussionHoursWorkedAttribute(): float
    {
        $previous = $this->previousInspection();
        if (!$previous || !$previous->percussion_hours) {
            return 0;
        }
        return max(0, ($this->percussion_hours ?? 0) - $previous->percussion_hours);
    }

    /**
     * Calcular las horas de posicionamiento trabajadas desde la inspección anterior
     */
    public function getPositionHoursWorkedAttribute(): float
    {
        $previous = $this->previousInspection();
        if (!$previous || !$previous->position_hours) {
            return 0;
        }
        return max(0, ($this->position_hours ?? 0) - $previous->position_hours);
    }

    /**
     * Obtener un resumen de horas trabajadas
     */
    public function getHoursWorkedSummaryAttribute(): array
    {
        return [
            'engine' => $this->engine_hours_worked,
            'percussion' => $this->percussion_hours_worked,
            'position' => $this->position_hours_worked,
            'total' => $this->engine_hours_worked + $this->percussion_hours_worked + $this->position_hours_worked
        ];
    }

    /**
     * Verificar si los horómetros han aumentado correctamente
     */
    public function hasValidHourReadings(): bool
    {
        $previous = $this->previousInspection();

        if (!$previous) {
            return true; // Primera inspección siempre es válida
        }

        // Verificar que ninguna lectura sea menor que la anterior
        if ($this->engine_hours < $previous->engine_hours ||
            $this->percussion_hours < $previous->percussion_hours ||
            $this->position_hours < $previous->position_hours) {
            return false;
        }

        return true;
    }

    /**
     * Obtener el promedio de horas trabajadas por día desde la última inspección
     */
    public function getAverageHoursPerDayAttribute(): array
    {
        $previous = $this->previousInspection();

        if (!$previous) {
            return [
                'engine' => 0,
                'percussion' => 0,
                'position' => 0
            ];
        }

        $daysBetween = $this->inspection_date->diffInDays($previous->inspection_date);

        if ($daysBetween == 0) {
            return [
                'engine' => 0,
                'percussion' => 0,
                'position' => 0
            ];
        }

        return [
            'engine' => round($this->engine_hours_worked / $daysBetween, 1),
            'percussion' => round($this->percussion_hours_worked / $daysBetween, 1),
            'position' => round($this->position_hours_worked / $daysBetween, 1)
        ];
    }

    /**
     * Scope para obtener inspecciones con lecturas anormales
     */
    public function scopeWithAbnormalReadings($query)
    {
        return $query->whereRaw('
            (SELECT engine_hours FROM inspections i2
             WHERE i2.equipment_id = inspections.equipment_id
             AND i2.inspection_date < inspections.inspection_date
             ORDER BY i2.inspection_date DESC LIMIT 1) > inspections.engine_hours
        ');
    }

    /**
     * Obtener el estado formateado
     */
    public function getFormattedStatusAttribute(): string
    {
        return match($this->status) {
            'completada' => 'Completada',
            'completada_con_observaciones' => 'Completada con observaciones',
            'requiere_atencion_urgente' => 'Requiere atención urgente',
            default => ucfirst($this->status)
        };
    }

    /**
     * Obtener clase CSS para el estado
     */
//    public function getStatusClassAttribute(): string
//    {
//        return match($this->status) {
//            'completada' => 'bg-green-100 text-green-800',
//            'completada_con_observaciones' => 'bg-yellow-100 text-yellow-800',
//            'requiere_atencion_urgente' => 'bg-red-100 text-red-800',
//            default => 'bg-gray-100 text-gray-800'
//        };
//    }
}
