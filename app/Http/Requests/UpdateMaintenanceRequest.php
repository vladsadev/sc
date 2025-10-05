<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajustar según tu lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Campos obligatorios
            'equipment_id' => 'required|exists:equipment,id',
            'type' => 'required|in:preventivo,correctivo,emergencia,inspeccion',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'title' => 'required|string|max:255',

            // Campos opcionales
            'started_date' => 'nullable|date|after_or_equal:scheduled_date',
            'completed_date' => 'nullable|date|after_or_equal:started_date',
            'description' => 'nullable|string|max:2000',
            'work_performed' => 'nullable|string|max:2000',
            'observations' => 'nullable|string|max:2000',

            // Campos numéricos
            'cost' => 'nullable|numeric|min:0|max:99999999.99',
            'duration_hours' => 'nullable|integer|min:1|max:8760', // Max 1 año
            'hours_interval' => 'nullable|integer|min:1|max:10000',

            // Fechas adicionales
            'next_maintenance_suggested' => 'nullable|date|after:scheduled_date',

            // Repuestos como texto (se procesará en el controlador)
            'parts_used_text' => 'nullable|string|max:2000'
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            // Campos obligatorios
            'equipment_id.required' => 'Debe seleccionar un equipo.',
            'equipment_id.exists' => 'El equipo seleccionado no es válido.',
            'type.required' => 'Debe seleccionar un tipo de mantenimiento.',
            'type.in' => 'El tipo de mantenimiento seleccionado no es válido.',
            'scheduled_date.required' => 'La fecha programada es obligatoria.',
            'scheduled_date.date' => 'La fecha programada debe ser una fecha válida.',
            'scheduled_date.after_or_equal' => 'La fecha programada no puede ser anterior a hoy.',
            'title.required' => 'El título del mantenimiento es obligatorio.',
            'title.max' => 'El título no puede exceder 255 caracteres.',

            // Fechas
            'started_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'started_date.after_or_equal' => 'La fecha de inicio no puede ser anterior a la fecha programada.',
            'completed_date.date' => 'La fecha de finalización debe ser una fecha válida.',
            'completed_date.after_or_equal' => 'La fecha de finalización no puede ser anterior a la fecha de inicio.',

            // Campos numéricos
            'cost.numeric' => 'El costo debe ser un número.',
            'cost.min' => 'El costo no puede ser negativo.',
            'cost.max' => 'El costo excede el límite máximo permitido.',
            'duration_hours.integer' => 'La duración debe ser un número entero.',
            'duration_hours.min' => 'La duración debe ser al menos 1 hora.',
            'duration_hours.max' => 'La duración no puede exceder 8760 horas (1 año).',
            'hours_interval.integer' => 'El intervalo de horas debe ser un número entero.',
            'hours_interval.min' => 'El intervalo debe ser al menos 1 hora.',
            'hours_interval.max' => 'El intervalo no puede exceder 10000 horas.',

            // Fechas adicionales
            'next_maintenance_suggested.date' => 'La fecha del próximo mantenimiento debe ser válida.',
            'next_maintenance_suggested.after' => 'La fecha del próximo mantenimiento debe ser posterior a la fecha programada.',

            // Texto
            'description.max' => 'La descripción no puede exceder 2000 caracteres.',
            'work_performed.max' => 'El trabajo realizado no puede exceder 2000 caracteres.',
            'observations.max' => 'Las observaciones no pueden exceder 2000 caracteres.',
            'parts_used_text.max' => 'La lista de repuestos no puede exceder 2000 caracteres.'
        ];
    }
}
