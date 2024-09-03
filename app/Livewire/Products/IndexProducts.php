<?php

namespace App\Livewire\Products;

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

class IndexProducts extends DataTableComponent
{
    use WireUiActions;

    protected $model = Model::class;

    protected $listeners = [
        'products:delete' => 'delete'
    ];

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.products.index-products')
            ->with([
                'filterGenericData' => $this->getFilterGenericData(),
                'columns' => $this->getColumns(),
                // 'rows' => $this->getRows(),
                // 'customView' => $this->customView(),
            ]);
    }

    public function builder(): Builder
    {
        return Model::query()->whereNotCombinations();
    }
    
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown()
            ->setDefaultSort('id', 'desc')
            ->setPerPage(25)
            ->setColumnSelectEnabled()
            ->setRememberColumnSelectionStatus(true)
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
            ViewComponentColumn::make(__('Media'), 'id')
                ->component('laravel-livewire-tables.products.average_sales_media')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => optional($row)->average_sales_quantity ?? 0
                ]),
            Column::make(__('Width'), 'dimension.width')
                ->searchable()
                ->sortable()
                ->format(fn ($value) => appendCentimeters($value)),
            Column::make(__('Height'), 'dimension.height')
                ->searchable()
                ->sortable()
                ->format(fn ($value) => appendCentimeters($value)),
            ViewComponentColumn::make(__('Stock'), 'stock')
                ->component('laravel-livewire-tables.products.average-stock')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $value,
                    'stock_order' => doubleval(optional($row)->stock_order ?? 0),
                    'row' => doubleval(optional($row)->average_sales_quantity ?? 0),
                ]),
            BooleanColumn::make(__('Visible'), 'visible')->sortable(),
            Column::make(__('Minimum Order'), 'minimum_order')
                ->searchable()
                ->sortable(),
            Column::make(__('Created at'), 'created_at')
                ->searchable()
                ->sortable(),
            Column::make(__('Updated at'), 'updated_at')
                ->searchable()
                ->sortable()
                ->deselected(),
            ViewComponentColumn::make(__(''), 'id')
                ->component('laravel-livewire-tables.action-column')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                    'editLink' => $row->route_edit,
                    'showLink' => $row->route_show,
                    'deleteEmit' => 'products:delete',
                    'order' => 'products:order',
                ])->hideIf(auth()->user()->hasRole('operator')),
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
            SelectFilter::make(__('Type'))
                ->options([
                    '' => __('All'),
                    'base' => __('Bases'),
                    'cover' => __('Covers'),
                    'top' => __('Tops'),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->when($value, function ($query) use ($value) {
                        $query->where('type', $value);
                    });
                }),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'generateOrder' => __('Generate order'),
        ];
    }

    public function generateOrder()
    {
        $products_id = $this->getSelected();
     
        $this->clearSelected();

        $this->dispatch('openModal', component: 'orders.generate-order-modal', arguments: ['product_ids' => $products_id]);
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

    protected function refreshDataTableComponent ()
    {
        $this->dispatch('refreshDatatable');
    }
}
