<?php

namespace App\Livewire;

use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Manual;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ManualTable extends DataTableComponent
{
    protected $model = Manual::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPerPageAccepted([10, 15, -1]);
        $this->resetPage();
        $this->setPerPage(10);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->hideIf(true)
                ->sortable()
                ->searchable(),

            Column::make("Agregado", "published_date")
                ->format(fn($value) => Carbon::parse($value)->format('d-m-Y'))
                ->sortable()
                ->searchable(),

            Column::make("Equipo", "equipment_type")
                ->sortable()
                ->searchable(),

            Column::make("Modelo", "model")
                ->sortable()
                ->searchable(),

            Column::make("Manual de", "manual_type")
                ->sortable()
                ->searchable(),

            Column::make("Version", "version")
                ->sortable()
                ->searchable(),

            Column::make("Nombre Del archivo", "original_filename")
                ->sortable()
                ->searchable(),

            Column::make('Acciones')
                ->label(
                    fn($row) => view('manuals.partials.actions', ['manual' => $row])
                )
                ->html(),
        ];
    }
}
