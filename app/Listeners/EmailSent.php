<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\OwnEmailSentModel;
use App\Models\ExcelEmail;
use App\Models\Order;

class EmailSent implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($model_id = $event->sent_email->getHeader('X-Model-ID')) {
            Order::where('id', $model_id)->update([
                'sent_email_id' => $event->sent_email->id
            ]);
        }
    }
}
