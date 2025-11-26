<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductSaleImport;
use App\Models\ProductLot;

class ProcessPendingProductSaleImports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-pending-product-sale-imports {--id= : ID de la importación}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesa las importaciones de ventas pendientes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $productSaleImports = ProductSaleImport::when($this->option('id') , function ($query) {
            return $query->where('id', $this->option('id'));
        })
        ->whereStatusPending()
        ->get();

        $this->withProgressBar($productSaleImports, fn (ProductSaleImport $productSaleImport) => $productSaleImport->runProcess());

        return Command::SUCCESS;
    }
}
