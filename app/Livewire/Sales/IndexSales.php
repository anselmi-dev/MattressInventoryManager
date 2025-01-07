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
                // 'customView' => $this->customView(),
            ]);
    }

    
    public function builder(): Builder
    {
        return Model::query()->with([
            
        ]);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setFilterLayoutSlideDown()
            ->setDefaultSort('CODFAC', 'desc')
            ->setPerPage(25)
            ->setFilterSlideDownDefaultStatusEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make('#Factusol', 'CODFAC')->searchable()->sortable(),
            Column::make(__('Cod. Client'), 'CLIFAC')->searchable()->sortable(),
            Column::make(__('Client'), 'CNOFAC')->searchable()->sortable(),
            ViewComponentColumn::make(__('Parts'), 'id')
                ->component('components.laravel-livewire-tables.value')
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $row->quantity ?? 0,
                    'icon' => 'shopping-cart',
                ])
                ->sortable(),
            Column::make(__('Total'), 'TOTFAC')->searchable()->sortable(),
            ViewComponentColumn::make(__('Status'), 'ESTFAC')
                ->component('components.laravel-livewire-tables.sales.status')
                ->sortable()
                ->attributes(fn ($value, $row, Column $column) => [
                    'value' => $value,
                ]),
            Column::make('FECFAC', 'FECFAC')->sortable()
                ->format(function ($value) {
                    return $value ? $value->format('Y-m-d') : null;
                }),
            ViewComponentColumn::make(__(''), 'id')
                ->component('components.laravel-livewire-tables.action-column')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                    'showLink' => route('sales.show', ['model' => $row->id]),
                ])
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
