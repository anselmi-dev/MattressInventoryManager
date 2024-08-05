<?php

namespace App\Observers;

use App\Models\Cover;
use Illuminate\Support\Facades\Cache;

class CoverObserver
{
    /**
     * Handle the Cover "created" event.
     */
    public function created(Cover $cover): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Cover "updated" event.
     */
    public function updated(Cover $cover): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Cover "deleted" event.
     */
    public function deleted(Cover $cover): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Cover "restored" event.
     */
    public function restored(Cover $cover): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Cover "force deleted" event.
     */
    public function forceDeleted(Cover $cover): void
    {
        $this->refreshCache();
    }

    protected function refreshCache ()
    {
        Cache::flush('count:covers');
    }
}
