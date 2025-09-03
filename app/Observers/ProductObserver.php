<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Jobs\StockChangeFactusol;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $product->stock_change()->create([
            'old' => 0,
            'new' => $product->stock,
            'quantity' => $product->stock
        ]);

        $this->refreshCache();
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if ($product->isDirty('stock')) {

            $old_stock = (int) $product->getOriginal('stock');

            $new_stock = (int) $product->stock;

            $stock_change = $product->stock_change()->create([
                'old' => $old_stock,
                'new' => $new_stock,
                'quantity' => $new_stock - ($old_stock)
            ]);

            StockChangeFactusol::dispatch($stock_change);
        }

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
        $this->refreshCache();

        $product->code = str_replace('_DELETED', '', $product->code);

        $product->reference = str_replace('_DELETED', '', $product->reference);

        $product->save();
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
