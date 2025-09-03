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
        $productLot->product->update([
            'stock' => $productLot->product->stock + $productLot->quantity
        ]);
    }

    /**
     * Handle the ProductLot "updated" event.
     */
    public function updated(ProductLot $productLot): void
    {
        if ($productLot->isDirty('quantity')) {
            $oldQuantity = $productLot->getOriginal('quantity');

            $newQuantity = $productLot->quantity;

            $productLot->product->update([
                'stock' => $productLot->product->stock + ($newQuantity - $oldQuantity)
            ]);
        }
    }

    /**
     * Handle the ProductLot "deleted" event.
     */
    public function deleted(ProductLot $productLot): void
    {
        $productLot->product->update([
            'stock' => $productLot->product->stock - $productLot->quantity
        ]);
    }

    /**
     * Handle the ProductLot "restored" event.
     */
    public function restored(ProductLot $productLot): void
    {
        $productLot->product->update([
            'stock' => $productLot->product->stock + $productLot->quantity
        ]);
    }

    /**
     * Handle the ProductLot "force deleted" event.
     */
    public function forceDeleted(ProductLot $productLot): void
    {
    }
}
