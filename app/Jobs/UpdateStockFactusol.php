<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\FactusolService;

class UpdateStockFactusol implements ShouldQueue
{
    use Queueable;

    protected string $code;

    protected int $quantity;

    protected bool $force = false;

    /**
     * Create a new job instance.
     */
    public function __construct (string $code, int $quantity, bool $force = false)
    {
        $this->code  = $code;

        $this->quantity = $quantity;

        $this->force = $force;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (app()->isProduction()) {
            $factusolService = new FactusolService();
            
            $response = $factusolService->update_stock($this->code, $this->quantity, $this->force);
            
            dd($response);
        }
    }
}
