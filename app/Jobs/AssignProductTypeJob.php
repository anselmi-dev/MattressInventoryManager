<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class AssignProductTypeJob implements ShouldQueue
{
    use Queueable;

    protected Product $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $type = $this->getProductType($this->product->name);
    
        $this->product->update([
            'type' => $type
        ]);
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
            if ($product_type->search_product_type($CODART)) {
                $product_type_name = $product_type->name;
                break;
            }
        }

        return $product_type_name;
    }
}
