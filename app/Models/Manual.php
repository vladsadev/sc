<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Manual extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'equipment_type',
        'model',
        'manual_type',
        'version',
        'file_path',
        'original_filename',
        'file_size',
        'file_hash',
        'notes',
        'uploaded_by',
        'updated_by',
        'download_count',
        'status',
        'published_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'download_count' => 'integer',
        'published_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who uploaded the manual.
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the user who last updated the manual.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the file size formatted for display.
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get the full URL of the manual file.
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    /**
     * Check if the file exists in storage.
     */
    public function fileExists(): bool
    {
        return Storage::disk('public')->exists($this->file_path);
    }

    /**
     * Scope to get only active manuals.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get manuals by equipment type.
     */
    public function scopeByEquipmentType($query, string $type)
    {
        return $query->where('equipment_type', $type);
    }

    /**
     * Scope to get manuals by model.
     */
    public function scopeByModel($query, string $model)
    {
        return $query->where('model', $model);
    }

    /**
     * Scope to get manuals by manual type.
     */
    public function scopeByManualType($query, string $type)
    {
        return $query->where('manual_type', $type);
    }

    /**
     * Get display name for the manual type
     */
    public function getManualTypeDisplayAttribute(): string
    {
        $types = [
            'partes' => 'Partes',
            'diagrama' => 'Diagrama',
            'seguridad' => 'Seguridad',
            'operación' => 'Operación',
            'mantenimiento' => 'Mantenimiento',
        ];

        return $types[$this->manual_type] ?? $this->manual_type;
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        // Cuando se elimine un manual, también eliminar el archivo
        static::deleting(function ($manual) {
            if ($manual->fileExists()) {
                Storage::disk('public')->delete($manual->file_path);
            }
        });
    }
}
