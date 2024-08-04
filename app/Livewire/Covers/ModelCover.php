<?php

namespace App\Livewire\Covers;

use Livewire\Component;
use App\Models\Cover as Model;
use App\Http\Requests\CoverRequest as RequestModel;
use App\Traits\HandlesModelForm;

class ModelCover extends Component
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
        return 'covers.index';
    }

    public function render()
    {
        return view('livewire.covers.model-cover');
    }

}
