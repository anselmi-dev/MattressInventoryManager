<?php

namespace App\Observers;

use App\Models\Combination;

class CombinationObserver
{
    /**
     * Handle the Combination "created" event.
     */
    public function created(Combination $combination): void
    {
        //
    }

    /**
     * Handle the Combination "updated" event.
     */
    public function updated(Combination $combination): void
    {
        //
    }

    /**
     * Handle the Combination "deleted" event.
     */
    public function deleted(Combination $combination): void
    {
        //
    }

    /**
     * Handle the Combination "restored" event.
     */
    public function restored(Combination $combination): void
    {
        //
    }

    /**
     * Handle the Combination "force deleted" event.
     */
    public function forceDeleted(Combination $combination): void
    {
        //
    }
}
