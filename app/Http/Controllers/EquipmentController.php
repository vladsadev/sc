<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipment = Equipment::latest()->with(['equipmentType' ])->paginate(6);

        return view('equipment.index', [
            'equipment' => $equipment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $eTypes = EquipmentType::all();

        return view('equipment.edit', [
            'equipment' => $equipment,
            'eTypes' => $eTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        try {
            $validatedData = $request->validated();

            // Verificar si se solicitó eliminar la imagen
            if ($request->input('remove_image') == '1') {
                if ($equipment->equipment_img) {
                    // Eliminar la imagen del storage
                    $oldImgPath = storage_path('app/public/' . $equipment->equipment_img);
                    if (file_exists($oldImgPath)) {
                        unlink($oldImgPath);
                    } else {
                        Storage::disk('public')->delete($equipment->equipment_img);
                    }
                    // Marcar para actualizar como null
                    $validatedData['equipment_img'] = null;
                }
            }

            // Manejar la actualización de la imagen (subir nueva)
            if ($request->hasFile('equipment_img')) {
                // Eliminar la imagen anterior si existe
                if ($equipment->equipment_img) {
                    $oldImgPath = storage_path('app/public/' . $equipment->equipment_img);
                    if (file_exists($oldImgPath)) {
                        unlink($oldImgPath);
                    } else {
                        Storage::disk('public')->delete($equipment->equipment_img);
                    }
                }
                $imagePath = $request->file('equipment_img')->store('equipment/images', 'public');
                $validatedData['equipment_img'] = $imagePath;
            }

            // Actualizar el equipo
            $equipment->update($validatedData);

            // Redireccionar con mensaje de éxito
            return redirect()
                ->route('equipment.show', $equipment)
                ->with('success', 'Equipo actualizado exitosamente');

        } catch (\Exception $e) {
            // Log del error
            \Log::error('Error al actualizar equipo: ' . $e->getMessage());

            // Si hubo error con archivos nuevos, eliminarlos
            if (isset($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el equipo: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request)
    {

//        dd($request->all());

        try {
            // Obtener datos validados
            $validatedData = $request->validated();

            // Manejar la carga de la imagen del equipo
            if ($request->hasFile('equipment_img')) {
                $imagePath = $request->file('equipment_img')->store('equipment/images', 'public');
                $validatedData['equipment_img'] = $imagePath;
            }

            // Crear el equipo con los datos validados
            $equipment = Equipment::create($validatedData);

            // Redireccionar con mensaje de éxito
            return redirect()
                ->route('equipment.index')
                ->with('success', 'Equipo creado exitosamente');

        } catch (\Exception $e) {
            // Log del error para debugging
            \Log::error('Error al crear equipo: ' . $e->getMessage());

            // Si hubo error y se subieron archivos, eliminarlos
            if (isset($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el equipo: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eTypes = EquipmentType::all();

        return view('equipment.create', [
            'eTypes' => $eTypes
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Equipment $equipment)
    {
        // Verificar si el equipo tiene inspecciones asociadas
        $hasInspections = $equipment->inspections()->exists();

        if ($hasInspections && !$request->has('force_delete')) {
            // Contar las inspecciones para mostrar información al usuario
            $inspectionCount = $equipment->inspections()->count();

            return redirect()
                ->back()
                ->with('warning', "Este equipo tiene {$inspectionCount} inspección(es) asociada(s). ¿Estás seguro de que deseas eliminarlo junto con todas sus inspecciones?")
                ->with('equipment_to_delete', $equipment->id);
        }

        try {
            // Eliminar archivos asociados
            if ($equipment->manual_pdf) {
                Storage::disk('public')->delete($equipment->manual_pdf);
            }
            if ($equipment->equipment_img) {
                Storage::disk('public')->delete($equipment->equipment_img);
            }


            // Si el usuario confirmó la eliminación o no hay inspecciones
            if ($hasInspections) {
                // Eliminar primero las inspecciones asociadas
                $equipment->inspections()->delete();
            }

            // Eliminar también los mantenimientos si existen
            if ($equipment->maintenances()->exists()) {
                $equipment->maintenances()->delete();
            }


            // Finalmente eliminar el equipo
            $equipment->delete();

            return redirect()
                ->route('equipment.index')
                ->with('success', 'Equipo eliminado exitosamente junto con todos sus registros asociados.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el equipo: ' . $e->getMessage());
        }
    }

    /**
     * Método para confirmar eliminación forzada
     */
    public function confirmDelete(Equipment $equipment)
    {
        $inspectionCount = $equipment->inspections()->count();
        $maintenanceCount = $equipment->maintenances()->count();

        return view('equipment.confirm-delete', compact('equipment', 'inspectionCount', 'maintenanceCount'));
    }


}
