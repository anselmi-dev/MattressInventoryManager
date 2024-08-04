<?php

namespace App\Livewire\Tops;

use Livewire\Component;

use App\Models\Top as Model;
use App\Http\Requests\TopRequest as RequestModel;
use App\Traits\HandlesModelForm;

class ModelTop extends Component
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
        return 'tops.index';
    }

    public function render()
    {
        return view('livewire.tops.model-top');
    }

}
