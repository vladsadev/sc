<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrillingGrid extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pdf_file',
    ];
}
