<?php

namespace App\Livewire\Dimensions;

use App\Models\Dimension as Model;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;

class IndexDimensions extends DataTableComponent
{
    use WireUiActions;

    protected $model = Model::class;

    protected $listeners = [
        'dimensions:delete' => 'delete',
    ];

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.dimensions.index-dimensions')
            ->with([
                'filterGenericData' => $this->getFilterGenericData(),
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                'customView' => $this->customView(),
            ]);
    }

    public function builder(): Builder
    {
        return Model::query()->WithProductCount();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown()
            ->setDefaultSort('id', 'desc')
            ->setUseHeaderAsFooterEnabled()
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
            Column::make(__('Description'), 'description')
                ->searchable()
                ->sortable(),
            Column::make(__('Width'), 'width')
                ->searchable()
                ->sortable()
                ->format(fn ($value) => appendCentimeters($value)),
            Column::make(__('Height'), 'height')
                ->searchable()
                ->sortable()
                ->format(fn ($value) => appendCentimeters($value)),
            Column::make(__('Products'), 'products_count')
                ->label(function ($row) {
                    return view('components.laravel-livewire-tables.value', [
                        'value' => $row->products_count,
                        'icon' => 'archive-box',
                        'tooltip' => __('Products associated with the dimension')
                    ]);
                })
                ->html()
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderByRaw("products_count {$direction}")
                ),
            Column::make(__('Created at'), 'created_at')
                ->searchable()
                ->label(function ($row) {
                    return optional($row->created_at)->format('Y-m-d');
                })
                ->sortable(),
            Column::make(__('Updated at'), 'updated_at')
                ->searchable()
                ->sortable()
                ->label(function ($row) {
                    return optional($row->created_at)->format('Y-m-d');
                })
                ->deselected(),
            ViewComponentColumn::make(__(''), 'id')
                ->component('laravel-livewire-tables.action-column')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                    'editLink' => $row->route_edit,
                    'showLink' => $row->route_show,
                    'deleteEmit' => 'dimensions:delete',
                ])
                ->hideIf(auth()->user()->hasRole('operator')),
        ];
    }

    /**
     * Delete model(s)
     *
     * @param array|int|string $id
     * @return void
     */
    public function delete(array|int|string $id):void
    {
        Model::whereIn('id', is_array($id) ? $id : [$id])->delete();

        $this->refreshDataTableComponent();

        $this->notification()->success(
            'Maravilloso!',
            __("Se ha eliminado exitosamente el registro en el sistema."),
        );
    }

    /**
     *
     * @return void
     */
    protected function refreshDataTableComponent (): void
    {
        $this->dispatch('refreshDatatable');
    }
}
