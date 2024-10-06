<?php

namespace App\Jobs;

use App\Models\FactusolProduct;
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
        $this->stock_change  = $stock_change;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->stock_change->status == 'processed') {
            return;
        }

        if (app()->isProduction()) {
            $factusolService = new FactusolService();
            
            $factusolService->update_stock($this->stock_change->product->code, $this->stock_change->quantity);
        }

        $this->stock_change->product->factusolProduct->increment('ACTSTO', $this->stock_change->quantity);

        $this->stock_change->status = 'processed';
        
        $this->stock_change->save();
    }
}
