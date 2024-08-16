<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User as Model;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\{
    DataTableComponent,
    Views\Column,
    Views\Columns\BooleanColumn,
    Views\Columns\ViewComponentColumn,
};
use WireUi\Traits\WireUiActions;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class IndexUsers extends DataTableComponent
{
    use WireUiActions;

    protected $listeners = [
        'users:delete' => 'delete',
    ];

    protected $model = Model::class;

    public function builder(): Builder
    {
        return Model::query()->with('role')->whereHas('roles', function ($query) {
            // $query->where('name', 'develop');
        });
    }

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.users.index-users')
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
            Column::make(__('ID'), 'id')
                ->searchable()
                ->sortable(),
            Column::make(__('Name'), 'name')
                ->searchable()
                ->sortable(),
            Column::make(__('Email'), 'email')
                ->searchable()
                ->sortable(),
                Column::make(__('Role'))
                ->excludeFromColumnSelect()
                ->label(
                    fn ($row, Column $column) => view('components.laravel-livewire-tables.users.role')->with(
                        [
                            'row' => $row
                        ]
                    )
                )->html(),
            Column::make(__('Created at'), 'created_at')
                ->searchable()
                ->sortable(),
            Column::make(__('Updated at'), 'updated_at')
                ->searchable()
                ->sortable()
                ->deselected(),
            ViewComponentColumn::make(__('Actions'), 'id')
                ->component('laravel-livewire-tables.users.action-column')
                ->excludeFromColumnSelect()
                ->attributes(fn ($value, $row, Column $column) => [
                    'id' => $row->id,
                    'editLink'   => route('users.model', $row),
                    'deleteEmit' => 'users:delete',
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('Role'))
                ->options([
                    '' => __('All'),
                    'develop' => __('develop'),
                    'admin' => __('admin'),
                    'operator' => __('operator'),
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->when($value, function ($query) use ($value) {
                        $query->whereHas('roles', function ($query) use ($value) {
                            $query->where('name', $value);
                        });
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
