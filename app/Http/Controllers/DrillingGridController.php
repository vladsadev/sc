<?php

namespace App\Http\Controllers;

use App\Models\DrillingGrid;
use Illuminate\Support\Facades\Storage;

class DrillingGridController extends Controller
{
    /**
     * Display the drilling grid dashboard.
     */
    public function index()
    {
        return view('dashboard.malla');
    }

    /**
     * Download the PDF file for the drilling grid.
     */
    public function downloadPdf()
    {
        $grid = DrillingGrid::first();

        if (!$grid || !$grid->pdf_file || !Storage::disk('public')->exists($grid->pdf_file)) {
            abort(404, 'Archivo no encontrado.');
        }

        return Storage::disk('public')->download($grid->pdf_file, 'malla_' . $grid->name . '.pdf');
    }
}
