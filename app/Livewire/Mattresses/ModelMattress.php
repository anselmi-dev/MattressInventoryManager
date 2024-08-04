<?php

namespace App\Livewire\Mattresses;

use Livewire\Component;

use App\Models\Mattress as Model;
use App\Http\Requests\MattressRequest as RequestModel;
use App\Traits\HandlesModelForm;

class ModelMattress extends Component
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
        return 'mattresses.index';
    }

    public function render()
    {
        return view('livewire.mattresses.model-mattress');
    }

    public function getDimensionsProperty ()
    {
        return \App\Models\Dimension::orderBy('id')->get();
    }
}
