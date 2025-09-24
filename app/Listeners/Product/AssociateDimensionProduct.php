<?php

namespace App\Listeners\Product;

use App\Events\ProductCreated;
use App\Jobs\AssociateDimensionProductJob;

class AssociateDimensionProduct
{
    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        AssociateDimensionProductJob::dispatchSync($event->product);
    }
}
