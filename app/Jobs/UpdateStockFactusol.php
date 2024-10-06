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

    /**
     * Create a new job instance.
     */
    public function __construct (string $code, int $quantity)
    {
        $this->code  = $code;

        $this->quantity = $quantity;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $factusolService = new FactusolService();

        $factusolService->update_stock($this->code, $this->quantity);
    }
}
