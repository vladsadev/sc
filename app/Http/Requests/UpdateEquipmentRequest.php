<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
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
        // Obtener el ID del equipo que se está editando
        $equipmentId = $this->route('equipment')->id;

        return [
            // Campos obligatorios
            'equipment_type_id' => 'required|exists:equipment_types,id',

            // Código único pero excluyendo el registro actual
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('equipment', 'code')->ignore($equipmentId)
            ],

            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'status' => 'required|in:operativa,mantenimiento,inactiva',
            'location' => 'required|in:Interior mina,Exterior mina,Área de Mantenimiento,Apartada de la Empresa',

            // Campos opcionales
            'fuel_type' => 'nullable|in:diesel,gasolina,eléctrico',
            'fuel_capacity' => 'nullable|numeric|min:0|max:99999.99',

            // Archivos opcionales (en actualización)
            'equipment_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB

            // Fechas de mantenimiento (pueden actualizarse)
            'last_maintenance' => 'nullable|date|before_or_equal:today',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            // Campos obligatorios
            'equipment_type_id.required' => 'Debe seleccionar un tipo de equipo.',
            'equipment_type_id.exists' => 'El tipo de equipo seleccionado no es válido.',
            'code.required' => 'El código del equipo es obligatorio.',
            'code.unique' => 'Este código de equipo ya existe en otro registro.',
            'code.max' => 'El código no puede tener más de 20 caracteres.',
            'brand.required' => 'La marca es obligatoria.',
            'brand.max' => 'La marca no puede tener más de 100 caracteres.',
            'model.required' => 'El modelo es obligatorio.',
            'model.max' => 'El modelo no puede tener más de 100 caracteres.',
            'year.required' => 'El año es obligatorio.',
            'year.integer' => 'El año debe ser un número entero.',
            'year.min' => 'El año debe ser mayor o igual a 1990.',
            'year.max' => 'El año no puede ser mayor al próximo año.',
            'status.required' => 'Debe seleccionar un estado.',
            'status.in' => 'El estado seleccionado no es válido.',
            'location.required' => 'Debe seleccionar una ubicación.',
            'location.in' => 'La ubicación seleccionada no es válida.',

            // Campos opcionales
            'fuel_type.in' => 'El tipo de combustible seleccionado no es válido.',
            'fuel_capacity.numeric' => 'La capacidad de combustible debe ser un número.',
            'fuel_capacity.min' => 'La capacidad de combustible no puede ser negativa.',
            'fuel_capacity.max' => 'La capacidad de combustible es demasiado grande.',

            // Archivos
            'manual_pdf.file' => 'El manual debe ser un archivo.',
            'manual_pdf.mimes' => 'El manual debe ser un archivo PDF.',
            'manual_pdf.max' => 'El manual no puede pesar más de 10MB.',
            'equipment_img.image' => 'El archivo debe ser una imagen.',
            'equipment_img.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'equipment_img.max' => 'La imagen no puede pesar más de 5MB.',

            // Fechas
            'last_maintenance.date' => 'La fecha del último mantenimiento debe ser válida.',
            'last_maintenance.before_or_equal' => 'La fecha del último mantenimiento no puede ser futura.',
            'next_maintenance.date' => 'La fecha del próximo mantenimiento debe ser válida.',
            'next_maintenance.after' => 'La fecha del próximo mantenimiento debe ser futura.',
        ];
    }
}
