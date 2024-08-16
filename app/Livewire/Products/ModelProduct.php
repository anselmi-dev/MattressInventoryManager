<?php

namespace App\Livewire\Products;

use Livewire\Component;

use App\Models\Product as Model;
use App\Http\Requests\ProductRequest as RequestModel;
use App\Traits\HandlesModelForm;

class ModelProduct extends Component
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
    
    protected function getRedirectRoute()
    {
        return 'products.index';
    }

    public function render()
    {
        return view('livewire.products.model-product');
    }

    public function getDimensionsProperty ()
    {
        return \App\Models\Dimension::orderBy('id')->get();
    }

    public function getTypesProperty ()
    {
        return [
            [
                'id' => 'top',
                'label' => __('Top'),
            ],
            [
                'id' => 'cover',
                'label' => __('Cover'),
            ],
            [
                'id' => 'base',
                'label' => __('Base')
            ],
        ];
    }
}
