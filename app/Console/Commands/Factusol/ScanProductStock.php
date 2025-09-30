<?php

namespace App\Console\Commands\Factusol;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\FactusolProductStock;
use App\Services\FactusolService;

class ScanProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-product-stock {--force} {--code=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener el stock de los productos de factusol y almacenarlos en la base de datos. además, se verifica que el stock de los productos coincida con el de factusol';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::when($this->option('code'), function ($query) {
            $query->whereCode($this->option('code'));
        })
        ->when(!$this->option('force'), function ($query) {
            $query->whereDoesntHave('factusolProductStock');
        })
        ->each(fn (Product $product) => $this->getStockFactusol($product));

        return Command::SUCCESS;
    }

    protected function getStockFactusol (Product $product): void
    {
        try {
            $F_STOC = (new FactusolService())->getStockFactusol($product->code);

            FactusolProductStock::updateOrCreate([
                'ARTSTO' => $F_STOC[0]->dato,
                'ALMSTO' => $F_STOC[1]->dato,
            ], [
                'MINSTO' => $F_STOC[2]->dato,
                'MAXSTO' => $F_STOC[3]->dato,
                'ACTSTO' => $F_STOC[4]->dato,
                'DISSTO' => $F_STOC[5]->dato,
                'UBISTO' => $F_STOC[6]->dato,
            ]);

            if ($F_STOC[4]->dato !== $product->stock)
                $this->info("<fg=red>Producto: {$product->code} Stock factusol: ({$F_STOC[4]->dato}) Stock local: ({$product->stock})");
            else
                $this->info("<fg=green>Producto: {$product->code} Stock factusol: ({$F_STOC[4]->dato}) Stock local: ({$product->stock})");

        } catch (\Throwable $th) {

            $this->error("Producto: {$product->code} Error: {$th->getMessage()}");

        }
    }
}
