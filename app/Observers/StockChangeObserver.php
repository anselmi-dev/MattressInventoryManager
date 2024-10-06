<?php

namespace App\Observers;

use App\Models\StockChange;

class StockChangeObserver
{
    /**
     * Handle the StockChange "created" event.
     */
    public function created(StockChange $stockChange): void
    {
        //
    }

    /**
     * Handle the StockChange "updated" event.
     */
    public function updated(StockChange $stockChange): void
    {
        //
    }

    /**
     * Handle the StockChange "deleted" event.
     */
    public function deleted(StockChange $stockChange): void
    {
        //
    }

    /**
     * Handle the StockChange "restored" event.
     */
    public function restored(StockChange $stockChange): void
    {
        //
    }

    /**
     * Handle the StockChange "force deleted" event.
     */
    public function forceDeleted(StockChange $stockChange): void
    {
        //
    }
}
