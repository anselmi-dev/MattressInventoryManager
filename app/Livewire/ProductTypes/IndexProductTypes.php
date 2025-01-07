<?php

namespace App\Livewire\ProductTypes;

use App\Models\ProductType as Model;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\BooleanColumn,
    Views\Columns\ArrayColumn,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;

class IndexProductTypes extends DataTableComponent
{
    use WireUiActions;

    protected $model = Model::class;

    protected $listeners = [
        'product_types:delete' => 'delete'
    ];

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.product-types.index-product-types')
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
            Column::make(__('Name'), 'name')
                ->sortable(),
            BooleanColumn::make(__('Part'), 'part')
                ->sortable(),
            ArrayColumn::make(__('Contains'), 'contains')
                ->data(fn($value, $row) => ($row->contains))
                ->outputFormat(fn($index, $value) => $value)
                ->separator('<br />')
                ->sortable(),
            Column::make(__('Created at'), 'created_at')
                ->searchable()
                ->sortable(),
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
                    'deleteEmit' => 'product_types:delete',
                ])->hideIf(auth()->user()->hasRole('operator')),
        ];
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

    protected function refreshDataTableComponent (): void
    {
        $this->dispatch('refreshDatatable');
    }
}