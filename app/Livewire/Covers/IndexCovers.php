<?php

namespace App\Livewire\Covers;

use App\Models\Cover as Model;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\BooleanColumn,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;

class IndexCovers extends DataTableComponent
{
    use WireUiActions;

    protected $model = Model::class;

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.covers.index-covers')
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
                ->sortable(),
            Column::make(__('Stock'), 'stock')
                ->sortable(),
            BooleanColumn::make(__('Visible'), 'available')->sortable(),
            ViewComponentColumn::make(__('Actions'), 'id')
                ->component('laravel-livewire-tables.action-column')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                    'editLink' => route('covers.model', $row),
                    'deleteEmit' => 'covers:delete',
                ]),
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
