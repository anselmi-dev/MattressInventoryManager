<?php

namespace App\Livewire\Orders;

use App\Models\{
    Order,
    Product
};
use App\Mail\OrderShipped;
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

    /**
     * Confirmar el envio del correo
     * order:next:processed:message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm_delivery ()
    {
        $this->order->status = 'processed';

        $this->order->order_products->map(function($order_product) {
            $order_product->product->increment('stock', $order_product->quantity);
            $order_product->status = 'processed';
            $order_product->save();
        });

        $this->order->save();

        $this->redirectSelf();
    }

    /**
     * Confirmar que llegó el pedido solicitado
     * order:next:shipped:message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm_shipment ()
    {
        $this->validate();

        $this->order->status = 'shipped';

        $this->order->save();

        if (settings()->get('notification', true)) {
            Mail::to($this->order->email)->queue(new OrderShipped($this->order));
        }

        $this->redirectSelf();
    }

    /**
     * Confirmar la cancelación de la orden.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm_canceld ()
    {
        $this->order->status = 'canceled';

        $this->order->save();

        // order:next:canceled:message

        $this->redirectSelf();
    }

    /**
     * Eliminar la orden pendiente
     * No se puede eliminar después de haber cambiado el estado.
     *
     * @param string|int|array $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string|int|array $id)
    {
        Order::whereIn('id', is_array($id) ? $id : [$id])->delete();

        return $this->redirect(route('orders.index'), navigate: true);
    }

    /**
     *
     * @return \Illuminate\Http\RedirectResponse The redirect response to the order's page.
     */
    public function redirectSelf ()
    {
        return $this->redirect(route('orders.show', ['model' => $this->order->id]), navigate: true);
    }

    /**
     * Agregar más producto a la orden pendiente.
     * No se puede agregar más cuando la orden se encuentra en enviado, es decir, cuando ya se mandó el correo
     *
     * @return void
     */
    public function addPart (): void
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
