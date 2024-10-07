<?php

namespace App\Livewire\ProductTypes;

use Livewire\Component;
use App\Models\ProductType as Model;
use App\Http\Requests\ProductTypeRequest as RequestModel;
use App\Traits\HandlesModelForm;

class ModelProductTypes extends Component
{
    use HandlesModelForm;

    protected function getModelClass()
    {
        return Model::class;
    }

    protected function getRequestInstance()
    {
        return new RequestModel($prefix = 'form');
    }

    protected function getType()
    {
        return null;
    }

    protected function getRedirectRoute()
    {
        return 'product_types.index';
    }

    public function render()
    {
        return view('livewire.product-types.model-product-types');
    }
}
