<?php

namespace App\Console\Commands;

use App\Models\Dimension;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ScanDimensionByProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-dimension-by-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene las dimensiones de los productos mediante su Código';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::all();

        $products->map(function ($product) {
            $code = $product->code;

            $dimention = $this->firstOrCreateDimensionByCode($code);

            $product->dimension_id = optional($dimention)->id;

            $product->save();
        });

        Artisan::call('cache:clear');
    }

    /**
     * First or Create Dimension by Product Code
     *
     * @param string $code
     * @return Dimension|null
     */
    protected function firstOrCreateDimensionByCode (string $code)
    {
        $xdimention = $this->getDimensionByString($code);
            
        if (is_null($xdimention))
            return null;

        $explode_dimention = explode('x', $xdimention);

        if (count($explode_dimention)) {
            return Dimension::firstOrCreate([
                'width' => (int) $explode_dimention[0],
                'height' => (int) $explode_dimention[1],
            ], [
                'visible' => true,
                'code' => 'DIMEN' . $xdimention,
                'description' => $xdimention,
            ]);
        }

        return null;
    }

    /**
     * Get 'WidthXHeight' by Product Code
     *
     * @param string $string
     * @return string|null
     */
    protected function getDimensionByString(string $string) {
        preg_match('/\d+x\d+/i', strtolower($string), $matches);

        return $matches[0] ?? null;
    }
}
