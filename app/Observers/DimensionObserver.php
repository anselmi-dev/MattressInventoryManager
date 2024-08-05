<?php

namespace App\Observers;

use App\Models\Dimension;
use Illuminate\Support\Facades\Cache;

class DimensionObserver
{
    /**
     * Handle the Dimension "created" event.
     */
    public function created(Dimension $dimension): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Dimension "updated" event.
     */
    public function updated(Dimension $dimension): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Dimension "deleted" event.
     */
    public function deleted(Dimension $dimension): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Dimension "restored" event.
     */
    public function restored(Dimension $dimension): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Dimension "force deleted" event.
     */
    public function forceDeleted(Dimension $dimension): void
    {
        $this->refreshCache();
    }

    protected function refreshCache ()
    {
        Cache::flush('count:dimensions');
    }
}
