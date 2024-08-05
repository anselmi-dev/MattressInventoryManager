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
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make(__('Code'), 'code')
                ->searchable()
                ->sortable(),
            Column::make(__('Description'), 'description')
                ->searchable()
                ->sortable(),
            Column::make(__('Quantity'), 'quantity')
                ->sortable()
                ->format(fn ($value) => $value),
            Column::make(__('Created_at'), 'created_at')
                ->sortable(),
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
