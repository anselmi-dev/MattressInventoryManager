<?php

namespace App\Livewire\Products;

use App\Helpers\Selector;
use Livewire\Component;

use App\Models\Product as Model;
use App\Http\Requests\ProductRequest as RequestModel;
use App\Traits\HandlesModelForm;
use App\Models\Dimension;

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
        return Dimension::when($this->model->getKey(), function ($query) {
            $query->withTrashed()
                ->where(function ($query) {
                    $query->whereNull('deleted_at')
                        ->orWhere('id', (int) $this->model->dimension_id);
                });
        })
        ->orderBy('width')
        ->get()
        ->map(function ($dimension) {
            return [
                'value' => $dimension->id,
                'label' => $dimension->id . ' - ' . $dimension->code,
                'description' => $dimension->description ?? $dimension->label
            ];
        })->toArray();
    }

    public function getProductTypesProperty ()
    {
        return Selector::productTypes();
    }

    public function preventSubmit ()
    {
        $this->validate();

        if (
            $this->model->getKey() && $this->model->stock != (int) $this->form['stock']
        ) {
            $this->dialog()->confirm([
                'title'       => __("The product's stock has been modified. The stock will be updated in Factusol."),
                'acceptLabel' => __("Yes, proceed"),
                'method'      => 'submit',
                'params'      => 'Saved',
            ]);
        } else {
            $this->submit();
        }
    }
}
