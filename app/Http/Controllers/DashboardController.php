<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener estadísticas generales
        $stats = $this->getDashboardStats();

        // Obtener detalles por tipo de máquina
        $equipmentTypeDetails = $this->getEquipmentTypeDetails();

        return view('dashboard.index', compact('stats', 'equipmentTypeDetails'));
    }

    /**
     * Obtiene las estadísticas principales del dashboard
     */
    private function getDashboardStats(): array
    {
        $totalEquipment = Equipment::count();

        return [
            'total_fleet' => $totalEquipment,
            'operational' => Equipment::where('status', 'operativa')->count(),
            'in_maintenance' => Equipment::where('status', 'mantenimiento')->count(),
            'out_of_service' => Equipment::whereIn('status', ['inactive', 'retired'])->count(),
        ];
    }

    /**
     * Obtiene los detalles agrupados por tipo de equipo
     */
    private function getEquipmentTypeDetails(): array
    {
        $equipmentTypes = EquipmentType::with(['equipment' => function ($query) {
            $query->with(['inspections' => function ($inspectionQuery) {
                $inspectionQuery->latest('inspection_date');
            }]);
        }])->get();

        $details = [];

        foreach ($equipmentTypes as $type) {
            $equipment = $type->equipment;
            $totalEquipment = $equipment->count();

            if ($totalEquipment > 0) {
                // Contadores por estado
                $operational = $equipment->where('status', 'active')->count();
                $maintenance = $equipment->where('status', 'maintenance')->count();
                $outOfService = $equipment->whereIn('status', ['inactive', 'retired'])->count();

                // Calcular última inspección más reciente del tipo
                $latestInspection = null;
                $oldestInspectionHours = null;

                foreach ($equipment as $eq) {
                    $lastInspection = $eq->inspections->first();
                    if ($lastInspection) {
                        if (!$latestInspection || $lastInspection->inspection_date > $latestInspection) {
                            $latestInspection = $lastInspection->inspection_date;
                        }
                    }
                }

                // Calcular horas desde la última inspección
                if ($latestInspection) {
                    $oldestInspectionHours = Carbon::parse($latestInspection)->diffInHours(now());
                }

                $details[] = [
                    'type_name' => $type->name,
                    'type_id' => $type->id,
                    'total_equipment' => $totalEquipment,
                    'operational' => $operational,
                    'maintenance' => $maintenance,
                    'out_of_service' => $outOfService,
                    'last_inspection_hours_ago' => $oldestInspectionHours,
                    'icon_class' => $this->getEquipmentTypeIcon($type->name),
                    'gradient_class' => $this->getEquipmentTypeGradient($type->name),
                ];
            }
        }

        return $details;
    }

    /**
     * Asigna íconos basados en el tipo de equipo
     */
    private function getEquipmentTypeIcon(string $typeName): string
    {
        // Mapa de íconos - funciona sin archivo de configuración
        $typeIcons = [
            'perforadoras' => 'fas fa-hammer',
            'perforadora' => 'fas fa-hammer',
            'drill' => 'fas fa-hammer',
            'simba' => 'fas fa-hammer',
            'acarreo' => 'fas fa-truck-moving',
            'camion' => 'fas fa-truck-moving',
            'truck' => 'fas fa-truck-moving',
            'volquete' => 'fas fa-truck-moving',
            'excavadora' => 'fas fa-excavator',
            'excavator' => 'fas fa-excavator',
            'pala' => 'fas fa-excavator',
            'cargadora' => 'fas fa-truck-loading',
            'loader' => 'fas fa-truck-loading',
            'cargador' => 'fas fa-truck-loading',
            'compactadora' => 'fas fa-road',
            'compactor' => 'fas fa-road',
            'rodillo' => 'fas fa-road',
            'grua' => 'fas fa-crane',
            'crane' => 'fas fa-crane',
            'montacarga' => 'fas fa-crane',
            'bulldozer' => 'fas fa-tractor',
            'tractor' => 'fas fa-tractor',
            'motoniveladora' => 'fas fa-tractor',
            'generador' => 'fas fa-plug',
            'generator' => 'fas fa-plug',
            'compresor' => 'fas fa-compress-arrows-alt',
            'compressor' => 'fas fa-compress-arrows-alt',
        ];

        $normalizedTypeName = strtolower(trim($typeName));

        // Buscar coincidencia exacta primero
        if (isset($typeIcons[$normalizedTypeName])) {
            return $typeIcons[$normalizedTypeName];
        }

        // Buscar coincidencia parcial
        foreach ($typeIcons as $keyword => $icon) {
            if (stripos($normalizedTypeName, $keyword) !== false) {
                return $icon;
            }
        }

        // Ícono por defecto
        return 'fas fa-cog';
    }

    /**
     * Obtiene el gradiente de color para el tipo de equipo
     */
    private function getEquipmentTypeGradient(string $typeName): string
    {
        // Gradientes de colores - funciona sin archivo de configuración
        $gradients = [
            'perforadoras' => 'from-blue-600/85 to-blue-600',
            'perforadora' => 'from-blue-600/85 to-blue-600',
            'drill' => 'from-blue-600/85 to-blue-600',
            'simba' => 'from-blue-600/85 to-blue-600',
            'acarreo' => 'from-yellow-600/85 to-yellow-600',
            'camion' => 'from-yellow-600/85 to-yellow-600',
            'truck' => 'from-yellow-600/85 to-yellow-600',
            'volquete' => 'from-yellow-600/85 to-yellow-600',
            'excavadora' => 'from-green-600/85 to-green-600',
            'excavator' => 'from-green-600/85 to-green-600',
            'pala' => 'from-green-600/85 to-green-600',
            'cargadora' => 'from-purple-600/85 to-purple-600',
            'loader' => 'from-purple-600/85 to-purple-600',
            'cargador' => 'from-purple-600/85 to-purple-600',
            'compactadora' => 'from-gray-600/85 to-gray-600',
            'compactor' => 'from-gray-600/85 to-gray-600',
            'rodillo' => 'from-gray-600/85 to-gray-600',
            'grua' => 'from-red-600/85 to-red-600',
            'crane' => 'from-red-600/85 to-red-600',
            'montacarga' => 'from-red-600/85 to-red-600',
            'bulldozer' => 'from-orange-600/85 to-orange-600',
            'tractor' => 'from-orange-600/85 to-orange-600',
            'motoniveladora' => 'from-orange-600/85 to-orange-600',
            'generador' => 'from-indigo-600/85 to-indigo-600',
            'generator' => 'from-indigo-600/85 to-indigo-600',
            'compresor' => 'from-pink-600/85 to-pink-600',
            'compressor' => 'from-pink-600/85 to-pink-600',
        ];

        $normalizedTypeName = strtolower(trim($typeName));

        // Buscar coincidencia exacta primero
        if (isset($gradients[$normalizedTypeName])) {
            return $gradients[$normalizedTypeName];
        }

        // Buscar coincidencia parcial
        foreach ($gradients as $keyword => $gradient) {
            if (stripos($normalizedTypeName, $keyword) !== false) {
                return $gradient;
            }
        }

        // Gradiente por defecto
        return 'from-amber-600/85 to-amber-600';
    }


    /**
     * Obtener equipos sin inspección reciente
     */
    public function getEquipmentNeedingInspection()
    {
        $equipmentNeedingInspection = Equipment::with(['equipmentType', 'inspections' => function ($query) {
            $query->latest('inspection_date')->limit(1);
        }])
            ->get()
            ->filter(function ($equipment) {
                $lastInspection = $equipment->inspections->first();

                if (!$lastInspection) {
                    return true; // Sin inspecciones
                }

                // Más de 7 días sin inspección
                return Carbon::parse($lastInspection->inspection_date)->addDays(7) < now();
            })
            ->values();

        return response()->json($equipmentNeedingInspection);
    }
}
