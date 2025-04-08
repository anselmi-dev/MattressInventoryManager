<?php

namespace App\Livewire\Combinations;

use App\Models\Product as Model;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\BooleanColumn,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class IndexCombinations extends DataTableComponent
{
    use WireUiActions;

    protected $listeners = [
        'combinations:delete' => 'delete',
        'after:combinations:manufacture' => 'refreshDataTableComponent',
    ];

    protected $model = Model::class;

    public function builder(): Builder
    {
        return Model::query()->whereCombinations();
    }

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.combinations.index-combinations')
            ->with([
                'filterGenericData' => $this->getFilterGenericData(),
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                // 'customView' => $this->customView(),
            ]);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown()
            ->setDefaultSort('id', 'desc')
            ->setPerPage(25)
            ->setFilterSlideDownDefaultStatusEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make(__('Code'), 'code')
                ->searchable()
                ->sortable(),
            Column::make(__('Name'), 'name')
                ->searchable()
                ->sortable(),
            Column::make(__('Dimension'), 'dimension.description')
                ->searchable()
                ->sortable()
                ->format(fn ($value) => $value ?? 'N/D'),
            ViewComponentColumn::make(__('Media'), 'id')
                ->component('components.laravel-livewire-tables.products.average_sales_media')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => optional($row)->AVERAGE_SALES ?? 0
                ]),
            ViewComponentColumn::make(__('Stock'), 'stock')
                ->component('components.laravel-livewire-tables.products.average-stock')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $value,
                    'stock_order' => doubleval(optional($row)->stock_order ?? 0),
                    'row' => doubleval(optional($row)->AVERAGE_SALES ?? 0),
                ]),
            Column::make(__('Created at'), 'created_at')
                ->searchable()
                ->sortable(),
            Column::make(__('Updated at'), 'updated_at')
                ->searchable()
                ->sortable()
                ->deselected(),
            ViewComponentColumn::make(__(''), 'id')
                ->component('components.laravel-livewire-tables.combinations.actions')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                    'editLink' => route('combinations.model', ['model' => $row->id]),
                    'deleteEmit' => 'combinations:delete',
                    'manufacture' => 'combinations:create',
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('Stock'))
                ->options([
                    '' => __('All'),
                    'available' => __('Available'),
                    'unavailable' => __('Unavailable'),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->when($value == 'available', function ($query) {
                        $query->available(true);
                    })->when($value == 'unavailable', function ($query) {
                        $query->unavailable(true);
                    });
                }),
        ];
    }

    public function delete($id)
    {
        Model::whereIn('id', [$id])->delete();

        $this->refreshDataTableComponent();

        $this->notification()->success(
            'Maravilloso!',
            __("Se ha eliminado exitosamente el registro en el sistema."),
        );
    }

    public function refreshDataTableComponent ()
    {
        $this->dispatch('refreshDatatable');
    }
}
