<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Maintenance;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class MaintenanceTable extends DataTableComponent
{
    protected $model = Maintenance::class;

    protected $listeners = ['deleteConfirmed'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // Configuración para mejor presentación visual

        $this->setDefaultSort('created_at', 'desc');
        $this->setPerPageAccepted([5, 10, 15, -1]);
        $this->resetPage();
        $this->setPerPage(5);
        $this->setBulkActions([
            'deleteSelected' => 'Borrar',
        ]);


    }

    public function columns(): array
    {
        return [
            Column::make('id', 'id')->hideIf(true),

            Column::make("Cod Equipo", "equipment.code")->sortable()
                ->searchable(),

            Column::make("F. Registro", "created_at")
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('d-m-Y'))
                ->sortable(),

            Column::make("F. Programada", "scheduled_date")
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('d-m-Y'))
                ->sortable(),

            Column::make("Título", "title")
                ->sortable(),
            Column::make("Mantenimiento", "type")
                ->sortable(),

            Column::make("Detalle", "description")->sortable()
                ->searchable(),
            Column::make("Horas Requeridas", "duration_hours")->sortable()
                ->searchable(),
            // Información del usuario responsable
            Column::make("Inspector", "user.name")->sortable()
                ->searchable(),
        ];
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Maintenance::query()
            ->with([
                'equipment.equipmentType',
                'user',
            ]);
    }

    public function deleteSelected()
    {
        // Solo pedimos confirmación
        $this->dispatch('confirmDelete', count($this->getSelected()));
    }

    public function deleteConfirmed()
    {
        if (\Gate::allows('admin-access')) {
            if ($this->getSelected()) {
                $count = count($this->getSelected());
                Maintenance::whereIn('id', $this->getSelected())->delete();
                $this->clearSelected();

                session()->flash('success', "Se han eliminado {$count} registro(s) correctamente.");

                $this->dispatch('$refresh');
                return;
            }
        }

        $this->clearSelected();
        session()->flash('fail', 'No tienes los permisos necesarios');
        $this->dispatch('$refresh');
    }

}
