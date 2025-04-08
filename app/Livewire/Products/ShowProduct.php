<?php

namespace App\Livewire\Products;

use App\Models\Product as Model;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProduct extends Component
{
    use WithPagination;

    public Model $model;

    public function mount(Model $model)
    {
        $this->model = Model::averageSalesForLastDays()->findOrFail($model->id);
    }

    public function render()
    {
        return view('livewire.products.show-product', [
            'sales' => $this->model->sales()->paginate(5, ['*'], 'salesPage'),
            'orders' => $this->model->orders()->rawProducts()->paginate(5, ['*'], 'ordersPage'),
        ]);
    }
}
