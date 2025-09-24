<?php

namespace App\Listeners\Product;

use App\Events\ProductCreated;
use App\Jobs\AssociateProductTypeJob;

class AssociateProductType
{
    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        AssociateProductTypeJob::dispatchSync($event->product);
    }
}
