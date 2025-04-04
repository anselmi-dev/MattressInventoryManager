<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale as Model;

class ShowSale extends Component
{
    public Model $model;

    public function mount(Model $model)
    {
        $this->model = $model;
        $this->model->load(['product_sales', 'product_sales.product']);
    }

    public function render()
    {
        return view('livewire.sales.show-sale');
    }
}
