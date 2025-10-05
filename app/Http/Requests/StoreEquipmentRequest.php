<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
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
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'code' => 'required|string|max:20|min:3|uppercase|unique:equipment,code',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'status' => 'required|in:operativa,mantenimiento,inactiva',

            // Campos opcionales
            'fuel_type' => 'nullable|in:diesel,gasolina,eléctrico',
            'fuel_capacity' => 'nullable|numeric|min:0|max:99999.99',

            // Archivos opcionales
            'manual_pdf' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
            'equipment_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
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
            'code.unique' => 'Este código de equipo ya existe.',
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
        ];
    }
}
