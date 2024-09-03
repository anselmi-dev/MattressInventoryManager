<?php

namespace App\Livewire\Combinations;

use Livewire\Component;
use App\Models\Product as Model;
use App\Models\Product;
use App\Http\Requests\CombinationRequest as RequestModel;
use App\Traits\HandlesModelForm;
use Illuminate\Support\Facades\Cache;

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

    protected function getType()
    {
        return 'combinations';
    }

    protected function getRedirectRoute()
    {
        return 'combinations.index';
    }

    public function render()
    {
        return view('livewire.combinations.model-combination');
    }

    public function mount($model = null)
    {
        // Obtiene el nombre de la clase del modelo
        $modelClass = $this->getModelClass();

        $this->model = $model ? $modelClass::findOrFail($model) : new $modelClass;

        $fill = ($this->getRequestInstance())->fill();

        $this->form = $this->model->only($fill);

        if ($this->model->exists) {
            
            $this->form['base_id'] = optional($this->model->base)->id;
            
            $this->form['cover_id'] = optional($this->model->cover)->id;
            
            $this->form['top_id'] = optional($this->model->top)->id;
        }
    }

    public function submit()
    {
        $this->validate();

        if ($this->model->exists) {
            $this->model->update($this->form);

            $this->model->combinedProducts()->sync([
                $this->form['base_id'],
                $this->form['cover_id'],
                $this->form['top_id'],
            ]);

            $this->notification(__("Successfully updated."));

        } else {
            
            $this->form['type'] = 'combination';
            
            $model = $this->model->create($this->form);

            $model->combinedProducts()->sync([
                $this->form['base_id'],
                $this->form['cover_id'],
                $this->form['top_id'],
            ]);

            $this->notification(__("Se creó correctamente."));
        }

        return $this->redirect(route($this->getRedirectRoute()), navigate: true);
    }
    
    public function getTopsProperty ()
    {
        return Product::orderBy('id')
            ->where('type', 'top')
            ->when(optional($this->form)['dimension_id'], function ($query) {
                $query->where('dimension_id', $this->form['dimension_id']);
            })
            ->when($this->model->getKey(), function ($query) {
                $query->withTrashed()
                    ->whereNull('deleted_at')
                    ->orWhere('id', $this->model->top_id);
            })->get();
    }

    public function getCoversProperty ()
    {
        return Product::orderBy('id')
            ->where('type', 'cover')
            ->when(optional($this->form)['dimension_id'], function ($query) {
                $query->where('dimension_id', $this->form['dimension_id']);
            })
            ->when($this->model->getKey(), function ($query) {
                $query->withTrashed()
                    ->whereNull('deleted_at')
                    ->orWhere('id', $this->model->top_id);
            })->get();
    }

    public function getBasesProperty ()
    {
        return Product::orderBy('id')
            ->where('type', 'base')
            ->when(optional($this->form)['dimension_id'], function ($query) {
                $query->where('dimension_id', $this->form['dimension_id']);
            })
            ->when($this->model->getKey(), function ($query) {
                $query->withTrashed()
                    ->whereNull('deleted_at')
                    ->orWhere('id', $this->model->top_id);
            })->get();
    }

    public function getDimensionsProperty ()
    {
        return Cache::rememberForever('selector:dimension', function () {
            return \App\Models\Dimension::orderBy('id')->orderBy('width')->get()->map(function ($dimension) {
                return [
                    'id' => $dimension->id,
                    'code' => "{$dimension->code}",
                    'description' => "{$dimension->width}x{$dimension->height}cm"
                ];
            });
        });
    }
}
