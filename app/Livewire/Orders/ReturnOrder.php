<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use LivewireUI\Modal\ModalComponent;
use App\Models\Product;
use App\Models\OrderProduct;

class ReturnOrder extends ModalComponent
{
    public Order $order;

    public $products = [];

    public function rules ()
    {
        return [
            'products' => 'required'
            // 'products.*.return' => 'required|integer|min:1|gt:quantity'
            // 'message' => 'required',
            // 'email' => 'required',
            // 'confirm' => 'required|accepted',
        ];
    }

    protected function messages ()
    {
        return [
            // 'products.*.return' => __('Quantity'),
            // 'products.*.quantity' => __('Quantity'),
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

    public function mount(Order $order)
    {
        $this->order = $order;

        $this->order->order_products->map(function($order_product) {
            $product = $order_product->product;
            $this->products[] = (object)[
                'order_product_id' => $order_product->id,
                'order_product_quantity' => (int)$order_product->quantity - (int)$order_product->return,
                'quantity' => $order_product->id,
                'return' => 0,
                'id' => $product->id,
                'code' => $product->code,
                'type' => $product->type,
                'name' => $product->name,
                'stock' => $product->stock,
                'stock_color' => $product->stock_color,
            ];
        });
    }

    public function render()
    {
        return view('livewire.orders.return-order');
    }

    public function submit ()
    {
        $this->validate();

        foreach ($this->products as $key => $product) {
            $orderProduct = OrderProduct::find($product->order_product_id);

            $orderProduct->return = $orderProduct->return + (int)$product->return;

            $orderProduct->save();

            $orderProduct->product->decrementStock((int)$product->return);
        }

        $this->closeModal();

        return $this->redirect(route('orders.show', ['model' => $this->order->id]), navigate: true);
    }
}
