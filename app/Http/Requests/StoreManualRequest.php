<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManualRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ajustar según tus políticas de autorización
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment_type' => ['required', 'numeric', 'in:0,1'], // Índices del array
            'model' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'in:partes,diagrama,seguridad,operación,mantenimiento'],
            'version' => ['nullable', 'string', 'max:20'],
            'manual_pdf' => ['required', 'file', 'mimes:pdf', 'max:51200'], // 100MB en KB
            'notes' => ['nullable', 'string', 'max:5000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'equipment_type.required' => 'Debe seleccionar un tipo de equipo.',
            'equipment_type.in' => 'El tipo de equipo seleccionado no es válido.',
            'model.required' => 'Debe seleccionar un modelo.',
            'description.required' => 'Debe seleccionar un tipo de manual.',
            'description.in' => 'El tipo de manual seleccionado no es válido.',
            'manual_pdf.required' => 'Debe cargar un archivo PDF.',
            'manual_pdf.file' => 'El archivo cargado no es válido.',
            'manual_pdf.mimes' => 'El archivo debe ser un PDF.',
            'manual_pdf.max' => 'El archivo no debe superar los 50MB.',
            'notes.max' => 'Las notas no pueden superar los 5000 caracteres.',
        ];
    }

    /**
     * Get custom attribute names.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'equipment_type' => 'tipo de equipo',
            'model' => 'modelo',
            'description' => 'tipo de manual',
            'version' => 'versión',
            'manual_pdf' => 'archivo del manual',
            'notes' => 'notas',
        ];
    }
}
