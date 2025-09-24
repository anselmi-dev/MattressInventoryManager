<?php

namespace App\Listeners\Product;

use App\Events\ProductCreated;

class InitializeProductStock
{
    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        $event->product->stock_change()->create([
            'old' => 0,
            'new' => $event->product->stock,
            'quantity' => $event->product->stock
        ]);
    }
}
