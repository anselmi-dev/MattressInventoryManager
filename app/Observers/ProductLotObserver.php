<?php

namespace App\Observers;

use App\Models\ProductLot;

class ProductLotObserver
{
    /**
     * Handle the ProductLot "created" event.
     */
    public function created(ProductLot $productLot): void
    {
        $productLot->stock_change()->create([
            'old' => 0,
            'new' => $productLot->quantity,
            'quantity' => $productLot->quantity,
            'message' => "Stock actualizado al crear el lote #{$productLot->name} ({$productLot->id})",
        ]);
    }

    /**
     * Handle the ProductLot "updated" event.
     */
    public function updated(ProductLot $productLot): void
    {
        if ($productLot->isDirty('quantity')) {

            $old_quantity = (int) $productLot->getOriginal('quantity');

            $new_quantity = (int) $productLot->quantity;

            $productLot->stock_change()->create([
                'old' => $old_quantity,
                'new' => $new_quantity,
                'quantity' => $new_quantity - ($old_quantity),
                'message' => "Stock actualizado lote #{$productLot->name} ({$productLot->id})",
            ]);
        }
    }
}
