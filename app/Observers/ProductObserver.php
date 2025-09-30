<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        event(new ProductCreated($product));

        $this->refreshCache();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        event(new ProductUpdated($product));

        $this->refreshCache();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $product->code = $product->code . '_DELETED';

        $product->reference = $product->reference . '_DELETED';

        $product->save();

        $this->refreshCache();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $product->code = str_replace('_DELETED', '', $product->code);

        $product->reference = str_replace('_DELETED', '', $product->reference);

        $product->save();

        $this->refreshCache();
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $this->refreshCache();
    }

    protected function refreshCache ()
    {
        Cache::flush('count_products');
    }
}
