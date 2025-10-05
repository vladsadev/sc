<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\Inspection;
use App\Models\InspectionIssue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InspectionForm extends Component
{
    // Propiedades públicas (reactivas)
    public Equipment $equipment;
    public $observations = '';
    public $engineHours = 0.0;
    public $percussionHours = 0.0;
    public $positionHours = 0.0;

    public $checkedItems = [];
    public $reportedIssues = [];
    public $epp = false;

    // Configuración de inspección
    public $inspectionConfig = [];
    public $sectionProgress = [];

    // Modal de problemas
    public $showIssueModal = false;
    public $currentIssueComponent = '';
    public $currentIssue = [
        'component' => '',
        'tipo_problema' => '',
        'severidad' => 'media',
        'descripcion' => '',
//        'accion_recomendada' => 'Monitoreo continuo'
    ];

    // Reglas de validación
    protected $rules = [
        'currentIssue.tipo_problema' => 'required|string',
        'currentIssue.severidad' => 'required|in:baja,media,alta,critica',
        'currentIssue.descripcion' => 'required|string|min:10',
//        'currentIssue.accion_recomendada' => 'required|string',

        'engineHours' => 'required|numeric|min:0',
        'percussionHours' => 'required|numeric|min:0',
        'positionHours' => 'required|numeric|min:0',
        'epp' => 'accepted'
    ];

    protected $messages = [
        'currentIssue.tipo_problema.required' => 'Debe seleccionar el tipo de problema',
        'currentIssue.severidad.required' => 'Debe seleccionar la severidad',
        'currentIssue.descripcion.required' => 'Debe describir el problema',
        'currentIssue.descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
        'currentIssue.accion_recomendada.required' => 'Debe seleccionar una acción recomendada',

        'engineHours.required' => 'Las horas del motor son requeridas',
        'engineHours.numeric' => 'Las horas del motor deben ser un número válido',
        'engineHours.min' => 'Las horas del motor no pueden ser negativas',
        'percussionHours.required' => 'Las horas de percusión son requeridas',
        'percussionHours.numeric' => 'Las horas de percusión deben ser un número válido',
        'percussionHours.min' => 'Las horas de percusión no pueden ser negativas',
        'positionHours.required' => 'Las horas de posicionamiento son requeridas',
        'positionHours.numeric' => 'Las horas de posicionamiento deben ser un número válido',
        'positionHours.min' => 'Las horas de posicionamiento no pueden ser negativas',
        'epp.accepted' => 'Debe confirmar que cuenta con el EPP requerido'
    ];

    // Montar el componente con el equipo
    public function mount(Equipment $equipment)
    {
        $this->equipment = $equipment;
        $this->loadInspectionConfig();
        $this->initializeSectionProgress();

        // Prellenar los horómetros con los valores actuales del equipo
        // Esto facilita al operador ya que normalmente los valores aumentan
        $this->engineHours = $equipment->engine_hours ?? 0;
        $this->percussionHours = $equipment->percussion_hours ?? 0;
        $this->positionHours = $equipment->position_hours ?? 0;
    }

    // Cargar configuración desde el archivo
    private function loadInspectionConfig()
    {
        $this->inspectionConfig = config('inspection-items');
    }

    // Inicializar el progreso por sección
    private function initializeSectionProgress()
    {
        foreach ($this->inspectionConfig['sections'] as $sectionKey => $section) {
            $this->sectionProgress[$sectionKey] = [
                'total' => count($section['items']),
                'checked' => 0,
                'issues' => 0
            ];
        }
    }

    // Propiedades computadas existentes...
    public function getProgressProperty()
    {
        $totalItems = 0;
        $checkedItems = 0;

        foreach ($this->inspectionConfig['sections'] as $section) {
            $totalItems += count($section['items']);
        }

        $checkedItems = count($this->checkedItems);

        return $totalItems > 0 ? round(($checkedItems / $totalItems) * 100) : 0;
    }

    public function getTotalItemsProperty()
    {
        $total = 0;
        foreach ($this->inspectionConfig['sections'] as $section) {
            $total += count($section['items']);
        }
        return $total;
    }

    public function getIssuesCountProperty()
    {
        return count($this->reportedIssues);
    }

    // Métodos de toggle y gestión de issues (mantener los existentes)
    public function toggleItem($key)
    {
        if (in_array($key, $this->checkedItems)) {
            $this->checkedItems = array_values(array_diff($this->checkedItems, [$key]));
        } else {
            $this->checkedItems[] = $key;
            // Si tenía un problema reportado, lo quitamos
            unset($this->reportedIssues[$key]);
        }

        // Actualizar progreso de la sección
        $sectionKey = $this->getItemSection($key);
        if ($sectionKey) {
            $this->updateSectionProgress($sectionKey);
        }
    }

    private function getItemSection($itemKey)
    {
        foreach ($this->inspectionConfig['sections'] as $sectionKey => $section) {
            if (array_key_exists($itemKey, $section['items'])) {
                return $sectionKey;
            }
        }
        return null;
    }

    private function updateSectionProgress($sectionKey)
    {
        $checked = 0;
        $issues = 0;

        foreach ($this->inspectionConfig['sections'][$sectionKey]['items'] as $itemKey => $itemLabel) {
            if (in_array($itemKey, $this->checkedItems)) {
                $checked++;
            }
            if (isset($this->reportedIssues[$itemKey])) {
                $issues++;
            }
        }

        $this->sectionProgress[$sectionKey]['checked'] = $checked;
        $this->sectionProgress[$sectionKey]['issues'] = $issues;
    }

    // Métodos para el modal de problemas (mantener los existentes)
    public function openIssueModal($component)
    {
        $this->currentIssueComponent = $component;

        // Si ya existe un problema reportado, cargar sus datos
        if (isset($this->reportedIssues[$component])) {
            $this->currentIssue = $this->reportedIssues[$component];
        } else {
            // Resetear el formulario
            $this->currentIssue = [
                'component' => $component,
                'tipo_problema' => '',
                'severidad' => 'media',
                'descripcion' => '',
                'accion_recomendada' => 'Monitoreo continuo'
            ];
        }

        $this->showIssueModal = true;
    }

    public function saveIssue()
    {
        $this->validate([
            'currentIssue.tipo_problema' => 'required|string',
//            'currentIssue.severidad' => 'required|in:baja,media,alta,critica',
//            'currentIssue.descripcion' => 'required|string|min:10',
//            'currentIssue.accion_recomendada' => 'required|string',
        ]);

        // Guardar el problema
        $this->reportedIssues[$this->currentIssueComponent] = $this->currentIssue;

        // Quitar el item de los checkeados si estaba marcado
        $this->checkedItems = array_values(array_diff($this->checkedItems, [$this->currentIssueComponent]));

        // Actualizar el progreso
        $sectionKey = $this->getItemSection($this->currentIssueComponent);
        if ($sectionKey) {
            $this->updateSectionProgress($sectionKey);
        }

        // Cerrar el modal
        $this->closeIssueModal();

        session()->flash('issue_saved', 'Problema reportado exitosamente');
    }

    public function closeIssueModal()
    {
        $this->showIssueModal = false;
        $this->resetValidation();
    }

    public function removeIssue($component)
    {
        unset($this->reportedIssues[$component]);

        // Actualizar el progreso
        $sectionKey = $this->getItemSection($component);
        if ($sectionKey) {
            $this->updateSectionProgress($sectionKey);
        }
    }

    public function submit()
    {
        // Validaciones
        $this->validate([
            'epp' => 'accepted',
            'engineHours' => 'required|numeric|min:0',
            'percussionHours' => 'required|numeric|min:0',
            'positionHours' => 'required|numeric|min:0',
        ]);

        // Verificar que se haya realizado al menos una inspección
        if (count($this->checkedItems) == 0 && count($this->reportedIssues) == 0) {
            $this->addError('inspection', 'Debe inspeccionar al menos un elemento antes de enviar el formulario');
            return;
        }

        // Verificar que todas las secciones estén completas si es requerido
        if ($this->inspectionConfig['settings']['require_all_items']) {
            foreach ($this->inspectionConfig['sections'] as $sectionKey => $section) {
                if (!$this->isSectionComplete($sectionKey)) {
                    $this->addError('inspection', 'Debe completar todos los elementos de la sección: ' . $section['title']);
                    return;
                }
            }
        }

        // VALIDACIÓN ADICIONAL: Las lecturas actuales no pueden ser menores que las anteriores
        $currentEngineHours = $this->equipment->engine_hours ?? 0;
        $currentPercussionHours = $this->equipment->percussion_hours ?? 0;
        $currentPositionHours = $this->equipment->position_hours ?? 0;

        if ($this->engineHours < $currentEngineHours) {
            $this->addError('engineHours', "Las horas del motor no pueden ser menores al valor actual registrado ({$currentEngineHours} horas)");
            return;
        }

        if ($this->percussionHours < $currentPercussionHours) {
            $this->addError('percussionHours', "Las horas de percusión no pueden ser menores al valor actual registrado ({$currentPercussionHours} horas)");
            return;
        }

        if ($this->positionHours < $currentPositionHours) {
            $this->addError('positionHours', "Las horas de posicionamiento no pueden ser menores al valor actual registrado ({$currentPositionHours} horas)");
            return;
        }

        DB::beginTransaction();

        try {
            // Preparar datos para guardar la inspección
            $inspectionData = [
                'equipment_id' => $this->equipment->id,
                'user_id' => Auth::id(),
                'inspection_date' => now(),
                'status' => $this->determineStatus(),
                'observations' => $this->observations,
                // Guardar las lecturas actuales de los horómetros
                'engine_hours' => $this->engineHours,
                'percussion_hours' => $this->percussionHours,
                'position_hours' => $this->positionHours,
                'epp_complete' => $this->epp,
            ];

            // Establecer TODOS los campos booleanos
            foreach ($this->inspectionConfig['sections'] as $sectionKey => $section) {
                foreach ($section['items'] as $itemKey => $itemLabel) {
                    $columnName = $itemKey . '_checked';
                    $inspectionData[$columnName] = false;
                }
            }

            // Establecer como true solo los que están marcados
            foreach ($this->checkedItems as $itemKey) {
                $columnName = $itemKey . '_checked';
                $inspectionData[$columnName] = true;
            }

            // Debug para verificar los datos antes de guardar
            Log::info('Datos de inspección a guardar:', $inspectionData);

            // Crear la inspección
            $inspection = Inspection::create($inspectionData);

            // Guardar los problemas reportados
            foreach ($this->reportedIssues as $issue) {
                InspectionIssue::create([
                    'inspection_id' => $inspection->id,
                    'user_id' => Auth::id(),
                    'component' => $issue['component'],
                    'issue_type' => $issue['tipo_problema'],
                    'description' => $issue['descripcion'],
                    'reported_at' => now(),
                    'status' => 'abierto'
                ]);
            }

            // Calcular las horas trabajadas desde la última lectura
            $hoursWorkedEngine = $this->engineHours - $currentEngineHours;
            $hoursWorkedPercussion = $this->percussionHours - $currentPercussionHours;
            $hoursWorkedPosition = $this->positionHours - $currentPositionHours;

            // ACTUALIZAR EL EQUIPO con las nuevas lecturas
            $this->equipment->update([
                'engine_hours' => $this->engineHours,
                'percussion_hours' => $this->percussionHours,
                'position_hours' => $this->positionHours,
            ]);

            DB::commit();

            // Log de éxito con información detallada
            Log::info('Inspección guardada exitosamente', [
                'inspection_id' => $inspection->id,
                'equipment_id' => $this->equipment->id,
                'lecturas' => [
                    'motor' => ['actual' => $this->engineHours, 'anterior' => $currentEngineHours, 'trabajadas' => $hoursWorkedEngine],
                    'percusion' => ['actual' => $this->percussionHours, 'anterior' => $currentPercussionHours, 'trabajadas' => $hoursWorkedPercussion],
                    'posicionamiento' => ['actual' => $this->positionHours, 'anterior' => $currentPositionHours, 'trabajadas' => $hoursWorkedPosition],
                ],
                'issues_count' => count($this->reportedIssues)
            ]);

            // Mensaje de éxito detallado
            $successMessage = 'Inspección guardada exitosamente. ';
            
            session()->flash('success', $successMessage);

            return redirect()->route('equipment.show', $this->equipment);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar inspección:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->addError('save', 'Error al guardar la inspección: ' . $e->getMessage());
        }
    }

    // Verificar si una sección está completa
    public function isSectionComplete($sectionKey)
    {
        $section = $this->inspectionConfig['sections'][$sectionKey];
        foreach ($section['items'] as $itemKey => $itemLabel) {
            if (!in_array($itemKey, $this->checkedItems) && !isset($this->reportedIssues[$itemKey])) {
                return false;
            }
        }
        return true;
    }

    // Determinar el estado basado en los problemas
    private function determineStatus()
    {
        if (count($this->reportedIssues) === 0) {
            return 'completada';
        }

        // Verificar si hay problemas críticos
        foreach ($this->reportedIssues as $issue) {
            if ($issue['severidad'] === 'critica') {
                return 'requiere_atencion_urgente';
            }
        }

        return 'completada_con_observaciones';
    }

    // Método de renderizado
    public function render()
    {
        return view('livewire.inspection-form');
    }
}
