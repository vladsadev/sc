<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Maintenance;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function index(Request $request): View
    {
        return view();
    }

    public function show(Maintenance $maintenance): View
    {
        $maintenance->load(['equipment.equipmentType', 'user']);

        return view('maintenances.show', compact('maintenance'));
    }

    public function store(StoreMaintenanceRequest $request): RedirectResponse
    {
        // Obtener el equipo para verificar su estado
        $equipment = Equipment::findOrFail($request->equipment_id);

        // Verificar nuevamente que el equipo no esté en mantenimiento
        if ($equipment->status === 'mantenimiento') {
            return redirect()
                ->back()
                ->withInput()
                ->with('fail', 'El equipo ya se encuentra en mantenimiento.');
        }

        // Obtener los datos validados
        $validated = $request->validated();

        try {
            // Crear el mantenimiento
            $maintenance = Maintenance::create([
                'equipment_id' => $validated['equipment_id'],
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'scheduled_date' => $validated['scheduled_date'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'observations' => $validated['observations'] ?? null,
                'duration_hours' => $validated['duration_hours'] ?? null,
            ]);

            // Actualizar el estado del equipo a "mantenimiento"
            $equipment->update(['status' => 'mantenimiento']);
            // Actualizar el ultimo mantenimiento del equipo
            $equipment->update(
                [
                    'last_maintenance' => $validated['scheduled_date']
                ]);

            return redirect()
                ->route('equipment.index')
//                ->route('maintenances.show', $maintenance)
                ->with('success', 'Mantenimiento programado exitosamente.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al programar el mantenimiento. Por favor, inténtelo nuevamente.');
        }
    }

    public function create(Equipment $equipment)
    {
        // Verificar que el equipo no esté ya en mantenimiento
        if ($equipment->status === 'mantenimiento') {
            return redirect()
                ->route('equipment.show', $equipment)
                ->with('fail', 'El equipo ya se encuentra en mantenimiento.');
        }

        return view('maintenances.create', [
            'equipment' => $equipment,
            'user' => Auth::user()
        ]);
    }

    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance)
    {
        // Implementar lógica de actualización según necesidades
    }

    public function edit(Maintenance $maintenance): View
    {
        return view('maintenances.edit', compact('maintenance'));
    }

    public function destroy(Maintenance $maintenance): RedirectResponse
    {
        try {
            // Obtener el equipo antes de eliminar el mantenimiento
            $equipment = $maintenance->equipment;

            // Eliminar el mantenimiento
            $maintenance->delete();

            // Restaurar el estado del equipo a "operativa" si no tiene otros mantenimientos pendientes
            $pendingMaintenances = Maintenance::where('equipment_id', $equipment->id)
                ->where('scheduled_date', '>=', now()->format('Y-m-d'))
                ->count();

            if ($pendingMaintenances === 0) {
                $equipment->update(['status' => 'operativa']);
            }

            return redirect()
                ->route('maintenances.index')
                ->with('success', 'Mantenimiento eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al eliminar el mantenimiento.');
        }
    }

    /**
     * Métodos adicionales para gestión de estados de mantenimiento
     */

    public function start(Maintenance $maintenance): RedirectResponse
    {
        try {
            // Lógica para iniciar mantenimiento
            // Aquí podrías agregar campos como started_date si los necesitas más adelante

            return redirect()
                ->route('maintenances.show', $maintenance)
                ->with('success', 'Mantenimiento iniciado correctamente.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al iniciar el mantenimiento.');
        }
    }

    public function complete(Maintenance $maintenance): RedirectResponse
    {
        try {
            // Lógica para completar mantenimiento
            // Restaurar equipo a estado operativo
            $maintenance->equipment->update(['status' => 'operativa']);

            return redirect()
                ->route('maintenances.show', $maintenance)
                ->with('success', 'Mantenimiento completado. El equipo ha vuelto al estado operativo.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al completar el mantenimiento.');
        }
    }

    public function cancel(Maintenance $maintenance): RedirectResponse
    {
        try {
            // Lógica para cancelar mantenimiento
            // Restaurar equipo a estado operativo
            $maintenance->equipment->update(['status' => 'operativa']);

            return redirect()
                ->route('maintenances.show', $maintenance)
                ->with('success', 'Mantenimiento cancelado. El equipo ha vuelto al estado operativo.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al cancelar el mantenimiento.');
        }
    }
}
