<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInspectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambiado de false a true
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'equipment_id' => 'required|exists:equipment,id',
            'observations' => 'nullable|string|max:1000',
            'items' => 'nullable|array',
            'items.*' => 'nullable',
            'epp' => 'nullable',
            'reported_issues' => 'nullable|json'
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'equipment_id.required' => 'Debe seleccionar un equipo.',
            'equipment_id.exists' => 'El equipo seleccionado no es válido.',
            'inspector_name.required' => 'El nombre del inspector es obligatorio.',
            'inspector_name.max' => 'El nombre del inspector no puede exceder 255 caracteres.',
            'work_hours.numeric' => 'Las horas de trabajo deben ser un número.',
            'work_hours.min' => 'Las horas de trabajo no pueden ser negativas.',
            'inspection_date.required' => 'La fecha de inspección es obligatoria.',
            'inspection_date.date' => 'Debe proporcionar una fecha válida.',
            'inspection_items.required' => 'Debe completar los items de inspección.',
            'inspection_items.array' => 'Los items de inspección deben ser un array.',
            'total_items.required' => 'Se debe especificar el total de items.',
            'checked_items.required' => 'Se debe especificar los items verificados.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Contar items automáticamente si no se proporcionan
        if (!$this->has('total_items') && $this->has('inspection_items')) {
            $this->merge([
                'total_items' => count($this->inspection_items ?? []),
            ]);
        }

        if (!$this->has('checked_items') && $this->has('inspection_items')) {
            $this->merge([
                'checked_items' => count(array_filter($this->inspection_items ?? [], fn($item) => $item === true || $item === '1' || $item === 1)),
            ]);
        }
    }
}
