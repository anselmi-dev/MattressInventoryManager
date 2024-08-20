<?php

namespace App\Livewire\Sales;

use App\Models\Sale as Model;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\BooleanColumn,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class IndexSales extends DataTableComponent
{
    use WireUiActions;

    protected $model = Model::class;

    protected $listeners = [
        'sales:refresh-datatable' => 'refreshDataTableComponent',
        'sales:delete' => 'delete'
    ];

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.sales.index-sales')
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
            ->setDefaultSort('id', 'desc')
            ->setReorderEnabled()
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
            Column::make(__('Quantity'), 'quantity')
                ->sortable()
                ->format(fn ($value) => $value),
            ViewComponentColumn::make(__('Status'), 'status')
                ->component('laravel-livewire-tables.sale-status')
                ->sortable()
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $value,
                ]),
            BooleanColumn::make(__('Issue'), 'id')
                ->setCallback(function(string $value, $row) {
                    return !(bool)$row->issues->count();
                })
                ->sortable(),
            Column::make(__('Created_at'), 'created_at')
                ->sortable(),
            auth()->user()->hasRole('operator') ? NULL : ViewComponentColumn::make(__('Actions'), 'id')
                ->component('laravel-livewire-tables.sales.actions')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('Issues'))
                ->options([
                    '' => __('All'),
                    'issues' => __('With issues'),
                    'without:issues' => __('Without issues'),
                    'issues:other' => __('Other'),
                    'issues:broken' => __('Broken'),
                    'issues:stained' => __('Stained'),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->when($value == 'issues', function ($query) use ($value) {
                        $query->whereHas('issues');
                    })->when($value == 'issues:other', function ($query) use ($value) {
                        $query->whereHas('issues', function ($query) use ($value) {
                            $query->where('type', 'other');
                        });
                    })->when($value == 'issues:broken', function ($query) use ($value) {
                        $query->whereHas('issues', function ($query) use ($value) {
                            $query->where('type', 'broken');
                        });
                    })->when($value == 'issues:stained', function ($query) use ($value) {
                        $query->whereHas('issues', function ($query) use ($value) {
                            $query->where('type', 'stained');
                        });
                    })->when($value == 'without:issues', function ($query) use ($value) {
                        $query->doesntHave('issues');
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
