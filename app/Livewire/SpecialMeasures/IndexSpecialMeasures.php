<?php

namespace App\Livewire\SpecialMeasures;

use App\Models\ProductSale as Model;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\BooleanColumn,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class IndexSpecialMeasures extends DataTableComponent
{
    use WireUiActions;

    protected $model = Model::class;

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.special-measures.index-special-measures')
            ->with([
                'filterGenericData' => $this->getFilterGenericData(),
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                'customView' => $this->customView(),
            ]);
    }

    public function builder(): Builder
    {
        return Model::query()->with('special_measurement')->where('DESLFA', 'like', "%MED. ESPECIAL%")->orWhere('DESLFA', 'like', "%MEDIDA ESPECIAL%");
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown()
            ->setDefaultSort('id', 'desc')
            ->setPerPage(25)
            ->setFilterSlideDownDefaultStatusEnabled()
            ->setTdAttributes(function(Column $column, $row, $columnIndex, $rowIndex) {
                if ($column->isField('DESLFA'))
                    return [
                        'default' => false,
                        'class' => 'px-2 py-3 whitespace-normal text-sm font-medium dark:text-white',
                    ];
             
                return [];
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make(__('Código'), 'ARTLFA')
                ->searchable()
                ->sortable(),
            Column::make(__('Product'), 'DESLFA')
                ->searchable()
                ->sortable(),
            BooleanColumn::make(__('Manufacture'), 'special_measurement.id')
                ->searchable()
                ->sortable(),
            ViewComponentColumn::make(__(''), 'id')
                ->component('laravel-livewire-tables.special-measures.action-column')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('Fabricado'))
                ->options([
                    '' => __('All'),
                    '2' => __('Por Fabricar'),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->when((int)$value == 1, function ($query) use ($value) {
                        $query->whereHas('special_measurement');
                    })->when((int)$value == 2, function ($query) use ($value) {
                        $query->whereDoesntHave('special_measurement');
                    });
                }),
        ];
    }

    protected function refreshDataTableComponent ()
    {
        $this->dispatch('refreshDatatable');
    }
}
