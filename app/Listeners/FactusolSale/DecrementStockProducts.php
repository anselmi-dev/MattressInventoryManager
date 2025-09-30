<?php

namespace App\Listeners\FactusolSale;

use App\Events\FactusolSaleCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class DecrementStockProducts implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(FactusolSaleCreated $event): void
    {
        $event->sale->decrementStock();
    }
}
