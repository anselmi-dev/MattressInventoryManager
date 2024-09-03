<?php

namespace App\Livewire\Orders;

use App\Models\{
    Order,
    Product
};
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ShowOrder extends Component
{
    public Order $order;

    public $new = [
        'part' => null
    ];

    public function rules ()
    {
        return [
            'order.message' => 'required|min:50',
            'order.email' => 'required|email',
        ];
    }
    
    public function mount(Order $model)
    {
        $this->order = $model;
    }

    protected $listeners = [
        'order:delete' => 'delete'
    ];

    public function render()
    {
        return view('livewire.orders.show-order');
    }

    public function confirm_shipment ()
    {
        $this->validate();

        $this->order->status = 'shipped';

        $this->order->save();

        Mail::to($this->order->email)->later(now()->addSeconds(1), new \App\Mail\OrderShipped($this->order));

        // order:next:shipped:message

        $this->redirectSelf();
    }

    public function confirm_delivery ()
    {
        $this->order->status = 'processed';

        $this->order->order_products->map(function($order_product) {
            $order_product->product->increment('stock', $order_product->quantity);
            $order_product->status = 'processed';
            $order_product->save();
        });

        $this->order->save();
        
        // order:next:processed:message

        $this->redirectSelf();
    }

    public function confirm_canceld ()
    {
        $this->order->status = 'canceled';

        $this->order->save();

        // order:next:canceled:message

        $this->redirectSelf();
    }

    public function delete($id)
    {
        Order::whereIn('id', [$id])->delete();

        return $this->redirect(route('orders.index'), navigate: true);
    }

    public function redirectSelf ()
    {
        return $this->redirect(route('orders.show', ['model' => $this->order->id]), navigate: true);
    }

    public function addPart ()
    {
        $this->validate([
            'new.part' => 'required'
        ]);

        $product = Product::find($this->new['part']);

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

        $this->new['part'] = null;
    }
}
