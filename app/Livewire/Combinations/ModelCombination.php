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
        return \App\Models\Top::orderBy('id')->when($this->model->getKey(), function ($query) {
            $query->withTrashed()
                ->whereNull('deleted_at')
                ->orWhere('id', $this->model->top_id);
        })->get();
    }

    public function getCoversProperty ()
    {
        return \App\Models\Cover::orderBy('id')->when($this->model->getKey(), function ($query) {
            $query->withTrashed()
                ->whereNull('deleted_at')
                ->orWhere('id', $this->model->cover_id);
        })->select('id', 'code', 'description')->get();
    }

    public function getBasesProperty ()
    {
        return \App\Models\Base::orderBy('id')->when($this->model->getKey(), function ($query) {
            $query->withTrashed()
                ->whereNull('deleted_at')
                ->orWhere('id', $this->model->base_id);
        })->get();
    }
}
