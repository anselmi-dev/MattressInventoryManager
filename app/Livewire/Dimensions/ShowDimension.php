<?php

namespace App\Livewire\Dimensions;

use App\Models\Dimension as Model;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDimension extends Component
{
    use WithPagination;

    public Model $model;

    public function mount(Model $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.dimensions.show-dimension', [
            'products' => $this->model->products()->averageSalesForLastDays()->paginate(10),
        ]);
    }
}
