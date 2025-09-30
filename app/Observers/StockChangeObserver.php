<?php

namespace App\Observers;

use App\Models\StockChange;
use App\Jobs\StockChangeFactusol;

class StockChangeObserver
{
    /**
     * Handle the StockChange "created" event.
     */
    public function created(StockChange $stockChange): void
    {
        StockChangeFactusol::dispatch($stockChange);
    }

    /**
     * Handle the StockChange "updated" event.
     */
    public function updated(StockChange $stockChange): void
    {
        if ($stockChange->isDirty('status')) {

            if ($stockChange->status == 'processed') {

                $new_stock = $stockChange->isAddOperation() ? ($stockChange->quantity + $stockChange->product_lot->product->stock) : $stockChange->quantity;

                $stockChange->product_lot->product->update([
                    'stock' => $new_stock
                ]);
            }
        }
    }
}
