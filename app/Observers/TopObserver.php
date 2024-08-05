<?php

namespace App\Observers;

use App\Models\Top;
use Illuminate\Support\Facades\Cache;

class TopObserver
{
    /**
     * Handle the Top "created" event.
     */
    public function created(Top $top): void
    {
        $this->refreshCache();   
    }

    /**
     * Handle the Top "updated" event.
     */
    public function updated(Top $top): void
    {
        $this->refreshCache();   
    }

    /**
     * Handle the Top "deleted" event.
     */
    public function deleted(Top $top): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Top "restored" event.
     */
    public function restored(Top $top): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Top "force deleted" event.
     */
    public function forceDeleted(Top $top): void
    {
        $this->refreshCache();
    }

    protected function refreshCache ()
    {
        Cache::flush('count:tops');
    }
}
