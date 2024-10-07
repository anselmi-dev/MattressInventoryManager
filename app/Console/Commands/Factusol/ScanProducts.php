<?php

namespace App\Console\Commands\Factusol;

use App\Models\Product;
use App\Models\ProductType;
use App\Services\FactusolService;
use App\Models\FactusolProduct;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ScanProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-products {--force}';

    protected $last_updated_date_of_products = null;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Factusol for any new products and verify if there are any discrepancies in the stock levels.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $last_updated_date_of_products = settings()->get('last_updated_date_of_products');

        $this->last_updated_date_of_products = $last_updated_date_of_products ? Carbon::parse($last_updated_date_of_products) : null;
        
        $this->withProgressBar($this->getProductsFactusol(), function (array $factusol_product) {
            $this->firstOrCreateProduct($factusol_product);
        });

        $this->info("Fecha de la última actualización " . settings()->get('last_updated_date_of_products'));
    }

    /**
     * Mediante los datos proporcionado de factusol se actualiza o crea el produ
     *
     * @param array $factusol_product
     * @return void
     */
    protected function firstOrCreateProduct (array $factusol_product) 
    {
        $factusol_product = array_reduce($factusol_product, function ($carry, $row) {
            $carry[$row['columna']] = $row['dato'];
            return $carry;
        }, []);

        $this->updateLastUpdatedDate($factusol_product['FUMART']);

        FactusolProduct::firstOrCreate([
            'CODART' => $factusol_product['CODART']
        ], $factusol_product);

        Product::withoutGlobalScopes()->firstOrCreate([
            'code' => trim($factusol_product['CODART']),
        ], [
            'reference' => trim($factusol_product['EANART']),
            'name' => $factusol_product['DESART'],
            'stock' => $factusol_product['ACTSTO'],
            'type' => $this->getProductType($factusol_product['DESART'])
        ]);
    }

    /**
     * Generar query para la api de factusol
     * Tener en cuenta que force no tomará en cuenta la last_updated_date_of_products
     * last_updated_date_of_products es la última fecha de creación del producto de factusol que se haya creado.
     *
     * @return string
     */
    protected function getQuery () :string
    {
        $where_force = (!$this->option('force') && $this->last_updated_date_of_products) ? "WHERE F_ART.FUMART > '{$this->last_updated_date_of_products->toDateTimeString()}'" : '';

        return Str::replaceArray('?', [
            $where_force
        ], "SELECT F_ART.FUMART as FUMART, F_ART.CODART as CODART, F_ART.DESART as DESART, F_ART.EANART as EANART, F_STO.ACTSTO as ACTSTO FROM F_ART JOIN F_STO ON F_ART.CODART = F_STO.ARTSTO ? ORDER BY F_ART.FUMART DESC");
    }

    /**
     * Get products factusol
     * Mediante la query se obtiene los productos de factusol
     *
     * @return array|null
     */
    protected function getProductsFactusol ()
    {
        $factusolService = new FactusolService();

        return $factusolService->query(
            $this->getQuery()
        );
    }

    /**
     * Actualizar la última fecha en la que se creó un producto en factusol
     *
     * @param string $FUMART
     * @return void
     */
    public function updateLastUpdatedDate (string $FUMART)
    {
        $date_to_compare = Carbon::parse($FUMART);

        if (
            !is_null($this->last_updated_date_of_products)
            && $this->last_updated_date_of_products->greaterThan($date_to_compare)
        )
            return;

        $this->last_updated_date_of_products = $date_to_compare;
        
        settings()->set('last_updated_date_of_products', $date_to_compare->toDateTimeString());
    }

    /**
     * Get type product by product code
     *
     * @param string $product
     * @return string
     */
    protected function getProductType (string $CODART)
    {
        $product_types = Cache::remember('product_types', 100, function () {
            return ProductType::all();
        });

        $product_type_name = 'OTRO';

        foreach ($product_types as $key => $product_type) {
            if ($product_type->getProductTypeByContains($CODART)) {
                $product_type_name = $product_type->name;
                break;
            }
        }

        return $product_type_name;
    }
}
