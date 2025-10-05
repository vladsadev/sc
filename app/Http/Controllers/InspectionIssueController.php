<?php

namespace App\Http\Controllers;

use App\Models\InspectionIssue;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionIssueController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspection_id' => 'required|exists:inspections,id',
            'componente' => 'required|string|max:255',
            'tipo_problema' => 'required|string',
            'severidad' => 'required|in:baja,media,alta,critica',
            'descripcion' => 'required|string',
            'accion_recomendada' => 'required|string',
        ]);

        $issue = InspectionIssue::create([
            'inspection_id' => $validated['inspection_id'],
            'user_id' => Auth::id(),
            'component' => $validated['componente'],
            'issue_type' => $validated['tipo_problema'],
            'severity' => $validated['severidad'],
            'description' => $validated['descripcion'],
            'recommended_action' => $validated['accion_recomendada'],
            'reported_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Problema reportado exitosamente',
            'issue' => $issue
        ]);
    }
}
