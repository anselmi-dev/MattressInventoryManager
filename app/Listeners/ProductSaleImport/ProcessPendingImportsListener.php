<?php

namespace App\Listeners\ProductSaleImport;

use App\Events\ProductSaleImportCompletedEvent;
use Illuminate\Support\Facades\Artisan;

class ProcessPendingImportsListener
{
    /**
     * Handle the event.
     */
    public function handle(ProductSaleImportCompletedEvent $event): void
    {
        // Artisan::call('app:process-pending-product-sale-imports');
    }
}

