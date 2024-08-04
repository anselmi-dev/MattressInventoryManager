<?php

namespace App\Livewire\Combinations;

use Livewire\Component;
use App\Models\Combination as Model;
use App\Http\Requests\CombinationRequest as RequestModel;
use App\Traits\HandlesModelForm;

class ModelCombination extends Component
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
        return 'combinations.index';
    }

    public function render()
    {
        return view('livewire.combinations.model-combination');
    }

    public function getTopsProperty ()
    {
        return \App\Models\Top::orderBy('id')->select('id', 'code', 'description')->get();
    }

    public function getCoversProperty ()
    {
        return \App\Models\Cover::orderBy('id')->select('id', 'code', 'description')->get();
    }

    public function getMattressesProperty ()
    {
        return \App\Models\Mattress::orderBy('id')->get();
    }
}
