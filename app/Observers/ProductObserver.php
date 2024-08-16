<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $top): void
    {
        $this->refreshCache();   
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $top): void
    {
        $this->refreshCache();   
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $top): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $top): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $top): void
    {
        $this->refreshCache();
    }

    protected function refreshCache ()
    {
        Cache::flush('count:products');
    }
}
