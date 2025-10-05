<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_type_id',
        'code',
        'brand',
        'model',
        'year',
        'status',
        'location',
        'fuel_type',
        'fuel_capacity',
        'last_maintenance',
        'next_maintenance',
        'notes',
        'engine_hours',
        'percussion_hours',
        'position_hours',
        'manual_pdf',
        'equipment_img'

    ];

    protected $casts = [
        'year' => 'integer',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'engine_hours' => 'decimal:1',
        'percussion_hours' => 'decimal:1',
        'position_hours' => 'decimal:1',
    ];

    /**
     * Relaciones
     */
    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }

    /**
     * Scopes útiles
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOfType($query, $typeName)
    {
        return $query->whereHas('equipmentType', function ($query) use ($typeName) {
            $query->where('name', $typeName);
        });
    }

    /**
     * Obtiene la última inspección del equipo
     */


    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Scope para equipos que necesitan inspección
     */
    public function scopeNeedsInspection($query, $daysThreshold = 7)
    {
        return $query->whereDoesntHave('inspections')
            ->orWhereHas('inspections', function ($q) use ($daysThreshold) {
                $q->where('inspection_date', '<', now()->subDays($daysThreshold))
                    ->whereIn('id', function ($subQuery) {
                        $subQuery->selectRaw('MAX(id)')
                            ->from('inspections')
                            ->whereColumn('equipment_id', 'equipment.id');
                    });
            });
    }

    /**
     * Obtiene el estado visual del equipo (para el dashboard)
     */
    public function getStatusDisplayAttribute(): array
    {
        $statusConfig = [
            'active' => [
                'label' => 'Operativo',
                'color' => 'green',
                'icon' => 'fas fa-check-circle'
            ],
            'maintenance' => [
                'label' => 'En Mantenimiento',
                'color' => 'yellow',
                'icon' => 'fas fa-tools'
            ],
            'inactive' => [
                'label' => 'Inactivo',
                'color' => 'gray',
                'icon' => 'fas fa-pause-circle'
            ],
        ];

        return $statusConfig[$this->status] ?? $statusConfig['inactive'];
    }


}
