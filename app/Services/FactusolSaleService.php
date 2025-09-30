<?php

namespace App\Services;

use App\Models\FactusolSale;
use App\Models\ProductSale;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Artisan;

class FactusolSaleService
{
    protected ?FactusolSale $sale = null;

    protected MessageBag $messageBag;

    /**
     * Set the product model instance
     */
    public function setModel(FactusolSale $sale): self
    {
        $this->sale = $sale;

        $this->messageBag = new MessageBag();

        return $this;
    }

    public function repairProductsSales (): void
    {
        $this->sale->product_sales()->each(function (ProductSale $productSale) {
            $productSale->delete();
        });

        Artisan::call('app:scan-sales', [
            '--code' => $this->sale->CODFAC,
            '--force' => true,
            '--no-events' => true,
        ]);
    }
}
