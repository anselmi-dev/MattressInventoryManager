<?php

namespace App\Livewire\Bases;

use Livewire\Component;
use App\Models\Base as Model;
use App\Http\Requests\BaseRequest as RequestModel;
use App\Traits\HandlesModelForm;

class ModelBase extends Component
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
        return 'bases.index';
    }

    public function render()
    {
        return view('livewire.bases.model-bases');
    }

    public function getDimensionsProperty ()
    {
        return \App\Models\Dimension::orderBy('id')->get();
    }
}
