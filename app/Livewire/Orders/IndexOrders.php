<?php

namespace App\Livewire\Orders;

use App\Models\Order as Model;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\BooleanColumn,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class IndexOrders extends DataTableComponent
{
    use WireUiActions;

    protected $listeners = [
        'orders:delete' => 'delete',
    ];

    protected $model = Model::class;

    public function builder(): Builder
    {
        return Model::query()->rawProducts()->with([
        ]);
    }

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.orders.index-orders')
            ->with([
                'filterGenericData' => $this->getFilterGenericData(),
                'columns' => $this->getColumns(),
                // 'rows' => $this->getRows(),
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
        // products_count
        // products_quantity
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable()
                ->deselected(),
            Column::make(__('Email'), 'email')
                ->sortable(),
            Column::make(__('Status'), 'status')
                ->sortable()
                ->format(fn ($value) => __($value)),
            ViewComponentColumn::make(__('Parts'), 'id')
                ->component('laravel-livewire-tables.value')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $row->products_count ?? 0,
                    'icon' => 'shopping-cart',
                ])
                ->sortable(),
            ViewComponentColumn::make(__('Quantity'), 'id')
                ->component('laravel-livewire-tables.value')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => optional($row)->products_quantity ?? 0,
                    'icon' => 'archive-box',
                ])
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
                    'showLink' => route('orders.show', ['model' => $row->id]),
                    'deleteEmit' => 'orders:delete',
                ]),
        ];
    }

    public function filters(): array
    {
        return [
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
