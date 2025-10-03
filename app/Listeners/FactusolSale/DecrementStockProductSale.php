<?php

namespace App\Listeners\FactusolSale;

use App\Models\FactusolSale;
class DecrementStockProductSale
{
    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        if ($event->productSale->is_pending) {
            $this->handleFactusolSaleCreated($event->productSale->sale);
        }
    }

    public function handleFactusolSaleCreated(FactusolSale $factusolSale): void
    {
        $factusolSale->decrementStockSale();
    }
}
