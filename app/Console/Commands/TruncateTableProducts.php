<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class TruncateTableProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:truncate-table-products {--factursol} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borrar de manera lógica todo los productos. además, se le aplicará el stock 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app()->isProduction() && !$this->option('force')) {
            $this->error('El comando solo se podrá lanzar en producción');
            return;
        }
        
        Product::withoutEvents(function () {
            Product::withoutGlobalScopes()->update([
                'deleted_at' => now(),
                'stock' => 0
            ]);
        });

        $this->info('Se reinició el stock de todo los productos. además, se aplicó el softdelete');
    }
}
