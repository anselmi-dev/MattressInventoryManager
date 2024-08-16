<?php

namespace App\Livewire\Combinations;

use App\Models\Combination as Model;
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

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.combinations.index-combinations')
            ->with([
                'filterGenericData' => $this->getFilterGenericData(),
                'columns' => $this->getColumns(),
                'rows' => $this->getRows(),
                'customView' => $this->customView(),
            ]);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown()
            ->setFilterSlideDownDefaultStatusEnabled();
    }

    public function columns(): array
    {
        return [
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
            ViewComponentColumn::make(__('Cover'), 'id')
                ->component('laravel-livewire-tables.link-product')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => optional(optional($row->cover)->code)->value,
                    'link' => route('products.model', ['model' => optional($row->cover)->id]),
                    'type' => 'cover'
                ]),
            ViewComponentColumn::make(__('Top'), 'id')
                ->component('laravel-livewire-tables.link-product')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => optional(optional($row->top)->code)->value,
                    'link' => route('products.model', ['model' => optional($row->top)->id]),
                    'type' => 'top'
                ]),
            ViewComponentColumn::make(__('Base'), 'id')
                ->component('laravel-livewire-tables.link-product')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => optional(optional($row->base)->code)->value,
                    'link' => route('products.model', ['model' => optional($row->base)->id]),
                    'type' => 'base'
                ]),
            ViewComponentColumn::make(__('Stock'), 'stock')
                ->component('laravel-livewire-tables.stock')
                ->sortable()
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $value,
                ]),
            Column::make(__('Created at'), 'created_at')
                ->searchable()
                ->sortable(),
            Column::make(__('Updated at'), 'updated_at')
                ->searchable()
                ->sortable()
                ->deselected(),
            ViewComponentColumn::make(__('Actions'), 'id')
                ->component('laravel-livewire-tables.action-column-combinations')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                    'editLink' => route('combinations.model', $row),
                    'deleteEmit' => 'combinations:delete',
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
