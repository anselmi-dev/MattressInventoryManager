<?php

namespace App\Livewire\Combinations;

use App\Helpers\Selector;
use Livewire\Component;
use App\Models\Product as Model;
use App\Models\Product;
use App\Http\Requests\CombinationRequest as RequestModel;
use App\Traits\HandlesModelForm;
use Illuminate\Support\Arr;
use App\Models\Dimension;

class ModelCombination extends Component
{
    use HandlesModelForm;

    public $new = [
        'part' => null,
        'filters' => [
            'type' => '',
            'dimension_id' => ''
        ]
    ];

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
        
        $this->form = $this->model->only(($this->getRequestInstance())->fill());

        if ($this->model->exists) {
            $this->model->combinedProducts->map(function ($product) {
                $this->form['products'][] = $product;
            });
        } else {
            $this->form['products'] = [];
        }

        $this->form['type'] = 'COLCHON';
    }

    public function submit()
    {
        $this->validate();

        $model = Model::updateOrCreate(
            Arr::only($this->form, ['code']),
            Arr::only($this->form, [
                'name',
                'type',
                'dimension_id',
                'minimum_order_notification_enabled',
                'minimum_order',
                'stock',
                'visible',
                'description',
            ])
        );
        
        $model->combinedProducts()->sync(collect($this->form['products'])->pluck('id')->toArray());

        if ($model->wasRecentlyCreated) {
            $model->decrementStockProducts($model->stock);
        }

        $this->notification($model->wasRecentlyCreated ? __('Record created successfully.') : __("Successfully updated."));

        return $this->redirect(route($this->getRedirectRoute()), navigate: true);
    }
    
    public function addPart (): void
    {
        $this->validate([
            'new.part' => ['required', 'exists:products,id'],
        ], [
            'new.part.required' => 'Seleccione una parte',
        ]);

        if ($product = Product::find($this->new['part'])) {
   
            $this->form['products'][] = $product;
            
            $this->new = [
                'part' => null,
                'filters' => [
                    'type' => ''
                ]
            ];
        } else {
            $this->notification(__('Not Found'));
        }
    }

    public function remove ($index): void
    {
        unset($this->form['products'][$index]);
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
                    'label' => $dimension->code,
                    'description' => $dimension->description ?? $dimension->label
                ];
            });
    }

    public function getProductTypesProperty ()
    {
        return Selector::productTypes();
    }

    public function getPathAsyncDataProperty (): array
    {
        return [
            'api' => route('api.parts.index'),
            'method' => 'GET',
            'params' => [
                'type' => optional($this->new['filters'])['type'],
                'dimension_id' => optional($this->new['filters'])['dimension_id'],
            ]
        ];
    }

    public function preventSubmit ()
    {
        $this->validate();

        if (
            $this->model->getKey() && $this->model->stock != (int) $this->form['stock']
        ) {
            $this->dialog()->confirm([
                'title'       => __("El stock de la combinación ha sido modificado. El stock se actualizará en Factusol."),
                'acceptLabel' => __("Yes, proceed"),
                'method'      => 'submit',
                'params'      => 'Saved',
            ]);
        } else {
            $this->submit();
        }
    }
}
