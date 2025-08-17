<?php

namespace App\Livewire\Combinations;

use App\Models\Product as Model;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class ShowCombinations extends Component
{
    use WithPagination;

    public Model $model;

    public function mount(Model $model)
    {
        $this->model = Model::findOrFail($model->id);
    }

    public function render()
    {
        return view('livewire.combinations.show-combinations', [
            'sales' => $this->model->sales()->paginate(5, ['*'], 'salesPage'),
            'orders' => $this->model->orders()->rawProducts()->paginate(5, ['*'], 'ordersPage'),
        ]);
    }

    #[Computed(persist: true)]
    public function averageSales()
    {
        return Model::averageSalesForLastDays()->find($this->model->id);
    }
}
