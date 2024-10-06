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
    }

    public function render()
    {
        return view('livewire.sales.show-sale');
    }
}
