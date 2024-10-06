<?php

namespace App\Livewire\Orders;

use App\Helpers\Selector;
use App\Models\Order;
use LivewireUI\Modal\ModalComponent;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class GenerateOrderModal extends ModalComponent
{
    public array $products = [];

    public $email = '';

    public $message = '';

    public $confirm = false;

    public $new = [
        'part' => null,
        'filters' => [
            'type' => '',
            'dimension_id' => ''
        ]
    ];

    public function rules ()
    {
        return [
            'products' => 'required',
            // 'message' => 'required',
            // 'email' => 'required',
            // 'confirm' => 'required|accepted',
        ];
    }

    protected function messages ()
    {
        return [
            'products.*.quantity' => __('Quantity'),
        ];
    }

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public static function closeModalOnEscapeIsForceful(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
    
    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public function mount(array|int $product_ids)
    {
        Product::whereIn('id', is_array($product_ids) ? $product_ids : [$product_ids])
            ->get()
            ->map(function ($product) {
                $this->products[] = (object) [
                    'id' => $product->id,
                    'minimum_order' => (int)$product->minimum_order,
                    'quantity' => (int) (is_null($product->minimum_order) ? 0 : $product->minimum_order),
                    'type' => $product->type,
                    'name' => $product->name,
                    'stock' => $product->stock,
                    'code' => $product->code,
                    'stock_color' => (int)$product->stock_color,
                ];
            });
    }

    public function render()
    {
        return view('livewire.orders.generate-order-modal');
    }

    public function submit ()
    {
        $this->validate();

        $order = new Order();

        $order->message = view('livewire.orders.template-email', [
            'products' => $this->products
        ])->render();

        $order->email = settings()->get('order:email', 'anselmi@infinety.es');

        $order->save();

        foreach ($this->products as $product) {
            $order->products()->attach($product->id, [
                'quantity' => $product->quantity,
                'attribute_data' => json_encode($product)
            ]);
        }

        $this->closeModal();

        return $this->redirect(route('orders.show', ['model' => $order->id]), navigate: true);
    }

    public function addPart (): void
    {
        $this->validate([
            'new.part' => 'required'
        ], [
            'new.part.required' => 'Seleccione una parte',
        ]);

        if ($product = Product::find($this->new['part'])) {
            $this->products[] = (object) [
                'id' => $product->id,
                'minimum_order' => (int)$product->minimum_order,
                'quantity' => (int)$product->minimum_order,
                'type' => $product->type,
                'name' => $product->name,
                'stock' => $product->stock,
                'code' => $product->code,
                'stock_color' => (int)$product->stock_color,
            ];

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
        unset($this->products[$index]);
    }

    public function getProductTypesProperty ()
    {
        return Selector::productTypes();
    }

    public function getDimensionsProperty ()
    {
        return Selector::dimensions();
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
}
