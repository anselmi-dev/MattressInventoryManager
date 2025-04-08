<?php

namespace App\Livewire\Products;

use App\Models\Product as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\BooleanColumn,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use App\Helpers\Selector;

class IndexProducts extends DataTableComponent
{
    use WireUiActions;

    protected $model = Model::class;

    protected $listeners = [
        'products:delete' => 'delete',
        'products:refresh-datatable' => 'refreshDataTableComponent'
    ];

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.products.index-products')
            ->with([
                'filterGenericData' => $this->getFilterGenericData(),
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                // 'customView' => $this->customView(),
            ]);
    }

    public function builder(): Builder
    {
        return Model::query()->averageSalesForLastDays()->with('dimension')->whereNotCombinations();
    }
    
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown()
            ->setDefaultSort('id', 'desc')
            ->setPerPage(10)
            ->setColumnSelectEnabled()
            ->setRememberColumnSelectionStatus(true)
            ->setFilterSlideDownDefaultStatusEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable()
                ->hideIf(auth()->user()->hasRole('develop')),
            Column::make(__('Code'), 'code')
                ->searchable()
                ->sortable()
                ->deselected(),
            BooleanColumn::make(__('Factusol'), 'factusolProduct.id')
                ->searchable()
                ->sortable(),
            Column::make(__('Reference'), 'reference')
                ->searchable()
                ->sortable(),
            Column::make(__('Name'), 'name')
                ->sortable(),

            // TOTAL_SALES
            Column::make(__('Ventas'), 'TOTAL_SALES')
                ->label(function ($row) {
                    return view('components.laravel-livewire-tables.value', [
                        'value' => doubleval(optional($row)->TOTAL_SALES ?? 0),
                        'tooltip' => 'Ventas en los últimos '. (int) settings()->get('stock:days', 10) . ' días'
                    ]);
                })
                ->html()
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderByRaw("TOTAL_SALES {$direction}")
                ),
            // STOCK_ORDER
            ViewComponentColumn::make(__('Stock'), 'stock')
                ->component('components.laravel-livewire-tables.products.average-stock')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $value,
                    'stock_order' => doubleval(optional($row)->stock_order ?? 0),
                    'AVERAGE_SALES_DIFFERENCE' => doubleval(optional($row)->AVERAGE_SALES_DIFFERENCE ?? 0),
                    'AVERAGE_SALES' => doubleval(optional($row)->AVERAGE_SALES ?? 0),
                    'AVERAGE_SALES_PER_DAY' => doubleval(optional($row)->AVERAGE_SALES_PER_DAY ?? 0),
                    'TOTAL_SALES' => doubleval(optional($row)->TOTAL_SALES ?? 0),
                ])
                ->sortable(),
            Column::make(__('Dimension'), 'dimension.code')
                ->eagerLoadRelations()
                ->sortable(),
            Column::make(__('Type'), 'type')
                ->searchable()
                ->sortable(),
            Column::make(__('Min. Order'), 'minimum_order')
                ->searchable()
                ->sortable(),
            Column::make(__('Created at'), 'created_at')
                ->searchable()
                ->sortable()
                ->deselected(),
            Column::make(__('Updated at'), 'updated_at')
                ->searchable()
                ->sortable()
                ->deselected(),
            ViewComponentColumn::make(__('Actions'), 'id')
                ->component('components.laravel-livewire-tables.action-column')
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
        $options_dimensions = \App\Models\Dimension::orderBy('id')
        ->orderBy('width')
        ->get()
        ->pluck('description','id');
        
        $options_dimensions = array_merge(['0' => __('All')], $options_dimensions->toArray());

        return [
            SelectFilter::make(__('Stock'))
                ->options(Selector::stocks())
                ->filter(function(Builder $builder, string $value) {
                    $builder->when($value == 'available', function ($query) {
                        $query->available(true);
                    })->when($value == 'unavailable', function ($query) {
                        $query->unavailable(true);
                    });
                }),
            SelectFilter::make(__('Type'))
                ->options(Selector::productTypes())
                ->filter(function(Builder $builder, string $value) {
                    $builder->when($value, function ($query) use ($value) {
                        $query->where('type', $value);
                    })->when($value == '', function ($query) use ($value) {
                        $query->where('type', '!=', 'other');
                    });
                }),
            SelectFilter::make(__('Dimension'))
                ->options($options_dimensions)
                ->filter(function(Builder $builder, string $value) {
                    $builder->when($value, function ($query) use ($value) {
                        $query->where('dimension_id', $value);
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

    public function generateOrder(): void
    {
        $products_id = $this->getSelected();
     
        $this->clearSelected();

        $this->dispatch('openModal', component: 'orders.generate-order-modal', arguments: ['product_ids' => $products_id]);
    }

    public function delete($id): void
    {
        Model::whereIn('id', [$id])->delete();

        $this->refreshDataTableComponent();

        $this->notification()->success(
            'Maravilloso!',
            __("Se ha eliminado exitosamente el registro en el sistema."),
        );
    }

    public function refreshDataTableComponent (): void
    {
        $this->dispatch('refreshDatatable');
    }
}
