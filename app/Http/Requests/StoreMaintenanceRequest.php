<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMaintenanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Campos obligatorios
            'equipment_id' => [
                'required',
                'exists:equipment,id',
                // Validación personalizada para verificar que el equipo no esté en mantenimiento
                Rule::exists('equipment', 'id')->where(function ($query) {
                    return $query->where('status', '!=', 'mantenimiento');
                }),
            ],
            'type' => 'required|in:preventivo,correctivo,emergencia',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'title' => 'required|string|max:255',

            // Campos opcionales
            'description' => 'nullable|string|max:2000',
            'observations' => 'nullable|string|max:2000',

            // Campo numérico
            'duration_hours' => 'nullable|integer|min:1|max:8760', // Max 1 año en horas
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
            'equipment_id.exists' => 'El equipo seleccionado no es válido o ya se encuentra en mantenimiento.',
            'type.required' => 'Debe seleccionar un tipo de mantenimiento.',
            'type.in' => 'El tipo de mantenimiento seleccionado no es válido.',
            'scheduled_date.required' => 'La fecha programada es obligatoria.',
            'scheduled_date.date' => 'La fecha programada debe ser una fecha válida.',
            'scheduled_date.after_or_equal' => 'La fecha programada no puede ser anterior a hoy.',
            'title.required' => 'El título del mantenimiento es obligatorio.',
            'title.max' => 'El título no puede exceder 255 caracteres.',

            // Campos opcionales
            'description.max' => 'La descripción no puede exceder 2000 caracteres.',
            'observations.max' => 'Las observaciones no pueden exceder 2000 caracteres.',

            // Campo numérico
            'duration_hours.integer' => 'La duración debe ser un número entero.',
            'duration_hours.min' => 'La duración debe ser al menos 1 hora.',
            'duration_hours.max' => 'La duración no puede exceder 8760 horas (1 año).',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Limpiar el campo duration_hours si viene vacío
        if ($this->duration_hours === '') {
            $this->merge(['duration_hours' => null]);
        }
    }
}
