<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Services\FactusolService;
use App\Models\StockChange;

class StockChangeFactusol implements ShouldQueue
{
    use Queueable;

    protected StockChange $stock_change;

    /**
     * Create a new job instance.
     */
    public function __construct (StockChange $stock_change)
    {
        $this->stock_change = $stock_change;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->stock_change->isProcessed)
            return;

        if ($this->stock_change->isSetOperation()) {
            $stock = $this->stock_change->new;
        }

        if ($this->stock_change->isAddOperation()) {
            $stock = $this->stock_change->quantity;
        }

        $response = (new FactusolService())->updateStockFactusol($this->stock_change->product_lot->product->code, $stock);

        if ($response) {
            $this->stock_change->setStatusProcessed();
        }
    }
}
