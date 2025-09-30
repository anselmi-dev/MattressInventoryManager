<?php

namespace App\Console\Commands\Fixed;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class FixedStockLocal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fixed-stock-local {--alert : Enviar alerta si el stock local es diferente al stock de los lotes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el stock local de los productos. Sincroniza el stock local con el stock de los lotes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->withProgressBar(Product::get(), function (Product $product) {

            $stockLots = $product->lots->sum('quantity');

            if ($product->stock == $stockLots)
                return;

            if ($this->option('alert')) {
                Log::emergency("El stock local de {$product->code} es diferente al stock de los lotes. Stock local: {$product->stock} Stock de los lotes: {$stockLots}");
            }

            Product::withoutEvents(function () use ($product, $stockLots) {

                $product->stock = $stockLots;

                $product->save();

            });
        });

        $this->info(PHP_EOL . "Stock local actualizado correctamente.");

        return Command::SUCCESS;
    }
}
