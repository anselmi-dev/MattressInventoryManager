<?php

namespace App\Livewire\Dimensions;

use Livewire\Component;

use App\Models\Dimension as Model;
use App\Http\Requests\DimensionRequest as RequestModel;
use App\Traits\HandlesModelForm;

class ModelDimension extends Component
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
        return 'dimensions.index';
    }

    public function render()
    {
        return view('livewire.dimensions.model-dimension');
    }

}
