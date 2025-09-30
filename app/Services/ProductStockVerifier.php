<?php

namespace App\Services;

use App\Models\Product;
use App\Services\FactusolService;
use Illuminate\Support\MessageBag;

class ProductStockVerifier
{
    protected ?Product $product = null;

    protected MessageBag $messageBag;

    /**
     * Set the product model instance
     */
    public function setModel(Product $product): self
    {
        $this->product = $product;

        $this->messageBag = new MessageBag();

        return $this;
    }

    /**
     * Verify stock against Factusol
     */
    public function verify(): bool
    {
        if (!$this->product) {
            throw new \LogicException("Product model is not set.");
        }

        $factusolStock = $this->getFactusolStock($this->product->code);

        $productStock = $this->product->stock;

        if ((int) $productStock === (int) $factusolStock) {

            $this->messageBag->add('message', "El stock del producto {$this->product->code} coincide con el stock de Factusol.");

            return true;
        }

        $this->messageBag->add('message', "El stock del producto {$this->product->code} no coincide con el stock de Factusol. ({$productStock} !== {$factusolStock})");

        return false;
    }

    /**
     * Mock / integración real con Factusol
     */
    protected function getFactusolStock(string $productCode): int
    {
        $factusolStock = (new FactusolService())->getStockFactusol($productCode);

        return $factusolStock[1]['dato'];
    }
}
