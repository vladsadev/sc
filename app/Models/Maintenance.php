<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Maintenance extends Model
{

    protected $fillable = [
        'equipment_id',
        'user_id',
        'type',
        'scheduled_date',
        'title',
        'description',
        'observations',
        'duration_hours',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    // Relaciones
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
