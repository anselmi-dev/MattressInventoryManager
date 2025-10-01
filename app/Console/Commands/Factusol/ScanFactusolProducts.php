<?php

namespace App\Console\Commands\Factusol;

use Illuminate\Console\Command;
use App\Models\FactusolProduct;
use App\Services\FactusolHttpService;
use Illuminate\Support\Facades\Artisan;

class ScanFactusolProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-factusol-products {--code= : Filtrar los productos por código}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener los productos de Factusol y sincronizarlos a la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $where = $this->option('code') ? "AND F_ART.CODART = '{$this->option('code')}'" : '';

        $response = (new FactusolHttpService())->consultaQuery("SELECT F_ART.CODART FROM F_ART JOIN F_STO ON F_ART.CODART = F_STO.ARTSTO $where");


        $codarts = collect($response->resultado)->map(function ($item) {
            return $this->reduceFactusol($item);
        });

        $this->withProgressBar($codarts, function (object $record) {
            $this->handleFactusolProduct($record);
        });

        $this->info(PHP_EOL . PHP_EOL . "<fg=white>🗑️ Eliminando los productos que no existen en la base de datos de Factusol");

        if (!$this->option('code')) {

            $deleted = FactusolProduct::whereNotIn('CODART', $codarts->pluck('CODART'))->delete();

            if ($deleted)
                $this->info("<fg=white>✅ Eliminación de productos completada");
            else
                $this->info("<fg=white>❌ No se encontraron productos para eliminar");
        }

        return Command::SUCCESS;
    }

    protected function handleFactusolProduct(object $item): bool
    {
        if (FactusolProduct::whereCODART($item->CODART)->first())
            return false;

        Artisan::queue('app:scan-products', [
            '--code' => $item->CODART,
            '--force' => true
        ]);

        return true;
    }

    protected function reduceFactusol(array $item): object
    {
        return (object) array_reduce($item, function ($carry, $row) {
            $carry[$row->columna] = $row->dato;
            return $carry;
        }, []);
    }
}
