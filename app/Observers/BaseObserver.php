<?php

namespace App\Observers;

use App\Models\Base;
use Illuminate\Support\Facades\Cache;

class BaseObserver
{
    /**
     * Handle the Base "created" event.
     */
    public function created(Base $base): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Base "updated" event.
     */
    public function updated(Base $base): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Base "deleted" event.
     */
    public function deleted(Base $base): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Base "restored" event.
     */
    public function restored(Base $base): void
    {
        $this->refreshCache();
    }

    /**
     * Handle the Base "force deleted" event.
     */
    public function forceDeleted(Base $base): void
    {
        $this->refreshCache();
    }

    protected function refreshCache ()
    {
        Cache::flush('bases:covers');
    }
}
