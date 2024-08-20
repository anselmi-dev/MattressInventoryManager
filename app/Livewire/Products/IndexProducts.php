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
                'rows' => $this->getRows(),
                'customView' => $this->customView(),
            ]);
    }

    public function builder(): Builder
    {
        return Model::query();
    }
    
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown()
            ->setDefaultSort('id', 'desc')
            ->setFilterSlideDownDefaultStatusEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make(__('Code'))
                ->label(function ($row) {
                    return optional($row->code)->value;
                })
                ->sortable()
                ->searchable(function (Builder $query, $searchTerm) {
                    $query->whereHas('code', function ($query) use ($searchTerm) {
                        $query->where('value', 'like', "%$searchTerm%");
                    });
                }),
            Column::make(__('Width'), 'dimension.width')
                ->searchable()
                ->sortable()
                ->format(fn ($value) => appendCentimeters($value)),
            Column::make(__('Height'), 'dimension.height')
                ->searchable()
                ->sortable()
                ->format(fn ($value) => appendCentimeters($value)),
            ViewComponentColumn::make(__('Stock'), 'stock')
                ->component('laravel-livewire-tables.stock')
                ->sortable()
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $value,
                ]),
            BooleanColumn::make(__('Visible'), 'visible')->sortable(),
            Column::make(__('Created at'), 'created_at')
                ->searchable()
                ->sortable(),
            Column::make(__('Updated at'), 'updated_at')
                ->searchable()
                ->sortable()
                ->deselected(),
            auth()->user()->hasRole('operator') ? NULL : ViewComponentColumn::make(__('Actions'), 'id')
                ->component('laravel-livewire-tables.action-column')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                    'editLink' => route('products.model', $row),
                    'deleteEmit' => 'products:delete',
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
