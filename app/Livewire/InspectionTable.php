<?php

namespace App\Livewire;

use App\Exports\InspectionExport;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Inspection;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Carbon\Carbon;


class InspectionTable extends DataTableComponent
{
    protected $model = Inspection::class;

    // Agregar listeners para los eventos
    protected $listeners = ['deleteConfirmed'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('inspection_date', 'desc');
        $this->setPerPageAccepted([5, 10, 15, -1]);
        $this->resetPage();
        $this->setPerPage(5);
        $this->setBulkActions([
            'deleteSelected' => 'Borrar',
            'exportSelected' => 'Exportar'
        ]);

        $this->setFiltersEnabled();
        $this->setFiltersVisibilityEnabled();

        $this->setFilterLayoutSlideDown();
        $this->setFiltersVisibilityStatus(true);
    }

    public function columns(): array
    {
        return [
            Column::make('id', 'id')->hideIf(true),

            Column::make("Cod Equipo", "equipment.code")
                ->sortable()
                ->searchable(),

            Column::make("Fecha y Hora", "inspection_date")
                ->format(fn($value) => Carbon::parse($value)->format('d-m-Y H:i'))
                ->sortable()
                ->searchable(),

            Column::make("Tipo de Equipo", "equipment.equipmentType.name")
                ->sortable()
                ->searchable(),

            Column::make("Marca", "equipment.brand")
                ->sortable()
                ->searchable(),

            Column::make("Modelo", "equipment.model")
                ->sortable()
                ->searchable(),

            LinkColumn::make('Acciones')
                ->title(fn() => 'Ver Inspección')
                ->location(fn($row) => route('inspection.show', $row->id))
                ->attributes(fn($row) => [
                    'class' => 'bg-yellow-main hover:bg-blue-main cursor-pointer px-4 py-2 text-sm font-semibold rounded-md text-white transition-colors duration-300 inline-flex items-center justify-center',
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            DateFilter::make('Fecha Y Hora')
                ->config([
                    'min' => '2020-01-01',
                    'max' => now()->format('Y-m-d'),
                    'pillFormat' => 'd M Y',
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->whereDate('inspections.inspection_date', '=', $value);
                })
                ->setFilterPillTitle('Fecha')
                ->setFilterPillValues([
                    '' => 'Cualquier fecha',
                ]),
        ];
    }


    public function builder(): Builder
    {
        return Inspection::query()
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
                Inspection::whereIn('id', $this->getSelected())->delete();
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

    public function exportSelected()
    {
        if ($this->getSelected()) {
            $inspections = Inspection::whereIn('id', $this->getSelected())->get();
            return Excel::download(new InspectionExport($inspections), 'inspections.xlsx');
        }
    }



}
