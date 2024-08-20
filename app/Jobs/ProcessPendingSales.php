<?php

namespace App\Jobs;

use App\Models\Code;
use App\Models\Sale;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessPendingSales implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pendingSales = Sale::where('status', 'pending')->get();

        foreach ($pendingSales as $sale) {
            
            $code = Code::with('model')->where('value', $sale->code)->first();

            $sale->status = 'error';

            if (!$code)
                continue;
            elseif (!$code->model)
                continue;
            else {
                $code->model->decrementStock($sale->quantity);

                $sale->status = 'processed';
            }

            $sale->save();
        }
    }
}
