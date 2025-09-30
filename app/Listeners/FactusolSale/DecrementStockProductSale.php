<?php

namespace App\Listeners\FactusolSale;

use App\Events\FactusolProductSalePlotUpdated;

class DecrementStockProductSale
{
    /**
     * Handle the event.
     */
    public function handle(FactusolProductSalePlotUpdated $event): void
    {
        if ($event->productSale->product_lot_id && is_null($event->productSale->processed_at)) {
            $event->productSale->decrementStock();
        }
    }
}
