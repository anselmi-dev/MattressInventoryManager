<?php

namespace App\Observers;

use App\Models\Combination;
use Illuminate\Support\Facades\Cache;

class CombinationObserver
{
    /**
     * Handle the Combination "created" event.
     */
    public function created(Combination $combination): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Combination "updated" event.
     */
    public function updated(Combination $combination): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Combination "deleted" event.
     */
    public function deleted(Combination $combination): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Combination "restored" event.
     */
    public function restored(Combination $combination): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Combination "force deleted" event.
     */
    public function forceDeleted(Combination $combination): void
    {
        $this->refreshCache();
    }

    protected function refreshCache ()
    {
        Cache::flush('combinations:covers');
    }
}
