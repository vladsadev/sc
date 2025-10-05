<?php
// Crear este archivo: app/View/Components/DashboardAlerts.php

namespace App\View\Components;

use App\Models\Equipment;
use Illuminate\View\Component;
use Carbon\Carbon;

class DashboardAlerts extends Component
{
    public $criticalAlerts;
    public $warningAlerts;
    public $infoAlerts;

    public function __construct()
    {
        $this->criticalAlerts = $this->getCriticalAlerts();
        $this->warningAlerts = $this->getWarningAlerts();
        $this->infoAlerts = $this->getInfoAlerts();
    }

    private function getCriticalAlerts(): array
    {
        $alerts = [];

        // Equipos fuera de servicio
        $outOfServiceCount = Equipment::whereIn('status', ['inactive', 'retired'])->count();
        if ($outOfServiceCount > 0) {
            $alerts[] = [
                'type' => 'critical',
                'icon' => 'fas fa-exclamation-triangle',
                'title' => 'Equipos fuera de servicio',
                'message' => "{$outOfServiceCount} equipo(s) requieren atención inmediata",
                'action' => route('equipment.index', ['status' => 'inactive']),
                'action_text' => 'Ver equipos'
            ];
        }

        // Equipos sin inspección por más de 14 días
        $noInspectionCount = Equipment::whereDoesntHave('inspections')
            ->orWhereHas('inspections', function ($q) {
                $q->where('inspection_date', '<', now()->subDays(14))
                    ->whereIn('id', function ($subQuery) {
                        $subQuery->selectRaw('MAX(id)')
                            ->from('inspections')
                            ->whereColumn('equipment_id', 'equipment.id');
                    });
            })->count();

        if ($noInspectionCount > 0) {
            $alerts[] = [
                'type' => 'critical',
                'icon' => 'fas fa-clipboard-check',
                'title' => 'Inspecciones críticas pendientes',
                'message' => "{$noInspectionCount} equipo(s) sin inspección por más de 14 días",
                'action' => route('equipment.index', ['needs_inspection' => true]),
                'action_text' => 'Inspeccionar ahora'
            ];
        }

        return $alerts;
    }

    private function getWarningAlerts(): array
    {
        $alerts = [];

        // Equipos en mantenimiento
        $maintenanceCount = Equipment::where('status', 'maintenance')->count();
        if ($maintenanceCount > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'fas fa-tools',
                'title' => 'Equipos en mantenimiento',
                'message' => "{$maintenanceCount} equipo(s) actualmente en mantenimiento",
                'action' => route('equipment.index', ['status' => 'maintenance']),
                'action_text' => 'Ver detalles'
            ];
        }

        // Mantenimientos próximos (próximos 7 días)
        $upcomingMaintenance = Equipment::whereNotNull('next_maintenance')
            ->where('next_maintenance', '<=', now()->addDays(7))
            ->where('next_maintenance', '>=', now())
            ->count();

        if ($upcomingMaintenance > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'fas fa-calendar-alt',
                'title' => 'Mantenimientos próximos',
                'message' => "{$upcomingMaintenance} equipo(s) requieren mantenimiento esta semana",
                'action' => route('equipment.index', ['upcoming_maintenance' => true]),
                'action_text' => 'Programar'
            ];
        }

        return $alerts;
    }

    private function getInfoAlerts(): array
    {
        $alerts = [];

        // Inspecciones realizadas hoy
        $todayInspections = \DB::table('inspections')
            ->whereDate('inspection_date', today())
            ->count();

        if ($todayInspections > 0) {
            $alerts[] = [
                'type' => 'info',
                'icon' => 'fas fa-check-circle',
                'title' => 'Inspecciones completadas hoy',
                'message' => "{$todayInspections} inspección(es) realizadas exitosamente",
                'action' => route('reportes'),
                'action_text' => 'Ver reportes'
            ];
        }

        return $alerts;
    }

    public function render()
    {
        return view('components.dashboard-alerts');
    }
}
