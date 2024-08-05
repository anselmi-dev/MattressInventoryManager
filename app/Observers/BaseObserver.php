<?php

namespace App\Observers;

use App\Models\Base;

class BaseObserver
{
    /**
     * Handle the Base "created" event.
     */
    public function created(Base $base): void
    {
        //
    }

    /**
     * Handle the Base "updated" event.
     */
    public function updated(Base $base): void
    {
        //
    }

    /**
     * Handle the Base "deleted" event.
     */
    public function deleted(Base $base): void
    {
        //
    }

    /**
     * Handle the Base "restored" event.
     */
    public function restored(Base $base): void
    {
        //
    }

    /**
     * Handle the Base "force deleted" event.
     */
    public function forceDeleted(Base $base): void
    {
        //
    }
}
