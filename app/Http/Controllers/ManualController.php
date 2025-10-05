<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManualRequest;
use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Los manuales se cargarán via Livewire DataTable
        return view('manuals.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManualRequest $request)
    {
        try {
            DB::beginTransaction();

            // Obtener el array de equipos para mapear el índice al nombre real
            $equipments = $this->getEquipments();
            $equipmentIndex = (int)$request->equipment_type;

            // Validar que el índice existe
            if (!isset($equipments[$equipmentIndex])) {
                throw new \Exception('Tipo de equipo inválido');
            }

            $equipmentType = $equipments[$equipmentIndex]['type'];

            // Validar que el modelo pertenece al tipo de equipo seleccionado
            if (!in_array($request->model, $equipments[$equipmentIndex]['models'])) {
                throw new \Exception('El modelo seleccionado no corresponde al tipo de equipo');
            }

            // Validar que la descripción es válida para el tipo de equipo
            if (!in_array($request->description, $equipments[$equipmentIndex]['description'])) {
                throw new \Exception('El tipo de manual seleccionado no es válido');
            }

            // Verificar si ya existe un manual con la misma combinación
            $existingManual = Manual::where('equipment_type', $equipmentType)
                ->where('model', $request->model)
                ->where('manual_type', $request->description)
                ->where('version', $request->version ?? null)
                ->first();

            if ($existingManual) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Ya existe un manual con la misma combinación de tipo de equipo, modelo, tipo de manual y versión.');
            }

            // Procesar el archivo PDF
            $file = $request->file('manual_pdf');
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            // Generar hash del archivo para detectar duplicados
            $fileHash = hash_file('sha256', $file->getRealPath());

            // Verificar si ya existe un archivo con el mismo hash
            $duplicateFile = Manual::where('file_hash', $fileHash)->first();
            if ($duplicateFile) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('warning', 'Este archivo PDF ya ha sido cargado anteriormente para: ' .
                        $duplicateFile->equipment_type . ' - ' .
                        $duplicateFile->model . ' - ' .
                        $duplicateFile->manual_type);
            }

            // Generar nombre único para el archivo
            // Formato: tipo_modelo_tipoManual_timestamp_random.pdf
            $cleanEquipmentType = Str::slug($equipmentType, '_');
            $cleanModel = Str::slug($request->model, '_');
            $cleanManualType = Str::slug($request->description, '_');
            $timestamp = now()->format('Ymd_His');
            $random = Str::random(6);

            $fileName = "{$cleanEquipmentType}_{$cleanModel}_{$cleanManualType}_{$timestamp}_{$random}.pdf";

            // Guardar el archivo en storage/app/public/manuals
            $path = $file->storeAs('manuals', $fileName, 'public');

            if (!$path) {
                throw new \Exception('Error al guardar el archivo PDF');
            }

            // Crear el registro en la base de datos
            $manual = Manual::create([
                'equipment_type' => $equipmentType,
                'model' => $request->model,
                'manual_type' => $request->description,
                'version' => $request->version,
                'file_path' => $path,
                'original_filename' => $originalName,
                'file_size' => $fileSize,
                'file_hash' => $fileHash,
                'notes' => $request->notes,
                'uploaded_by' => auth()->id(),
                'status' => 'active',
                'published_date' => now(),
            ]);

            DB::commit();

            // Log de la operación exitosa
            Log::info('Manual creado exitosamente', [
                'manual_id' => $manual->id,
                'user_id' => auth()->id(),
                'equipment_type' => $equipmentType,
                'model' => $request->model,
                'manual_type' => $request->description,
            ]);

            return redirect()
                ->route('manual.index')
                ->with('success', 'Manual cargado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Si hubo error y se creó el archivo, eliminarlo
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            Log::error('Error al crear manual: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request_data' => $request->except('manual_pdf'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al cargar el manual: ' . $e->getMessage());
        }
    }

    /**
     * Array con la configuración de equipos
     */
    private function getEquipments()
    {
        return [
            [
                'type' => 'De acarreo',
                'models' => ['ST7', 'ST2G', 'MT2010', 'MT2200'],
                'description' => ['partes', 'diagrama', 'seguridad', 'operación', 'mantenimiento']
            ],
            [
                'type' => 'Perforación',
                'models' => ['SIMBA S7 D', 'BOOMER S1 D', 'BOOMER T1 D'],
                'description' => ['partes', 'diagrama', 'seguridad', 'operación', 'mantenimiento']
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipments = $this->getEquipments();
        return view('manuals.create', compact('equipments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Manual $manual)
    {
        // Incrementar contador de descargas/vistas
        $manual->increment('download_count');

        // Retornar el PDF para visualización
        return response()->file(storage_path('app/public/' . $manual->file_path));
    }

    /**
     * Download the manual PDF
     */
    public function download(Manual $manual)
    {
        // Incrementar contador de descargas
        $manual->increment('download_count');

        // Generar nombre descriptivo para la descarga
        $downloadName = Str::slug($manual->equipment_type . ' ' .
                $manual->model . ' ' .
                $manual->manual_type . ' ' .
                ($manual->version ?? ''), '_') . '.pdf';

        return Storage::disk('public')->download($manual->file_path, $downloadName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manual $manual)
    {
        $equipments = $this->getEquipments();
        return view('manuals.edit', compact('manual', 'equipments'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manual $manual)
    {
        try {
            DB::beginTransaction();

            // Guardar la ruta del archivo antes de eliminar el registro
            $filePath = $manual->file_path;

            // Cambiar estado a archivado en lugar de eliminar (soft delete lógico)
            $manual->update([
                'status' => 'archived',
                'updated_by' => auth()->id()
            ]);

            // Opcionalmente, eliminar el archivo físico
            Storage::disk('public')->delete($filePath);

            $manual->delete();

            DB::commit();

            return redirect()
                ->route('manual.index')
                ->with('success', 'Manual archivado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al eliminar manual: ' . $e->getMessage(), [
                'manual_id' => $manual->id,
                'user_id' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el manual.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manual $manual)
    {
        // Implementar lógica de actualización si es necesaria
        // Similar al store pero permitiendo actualizar el archivo opcionalmente
    }
}
