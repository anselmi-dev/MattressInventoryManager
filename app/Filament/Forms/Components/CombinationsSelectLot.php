<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Closure;
use App\Models\ProductLot;
use Illuminate\Database\Eloquent\Collection;

class CombinationsSelectLot extends Field
{
    protected string $view = 'filament.forms.components.combinations-select-lot';

    protected ProductLot|Closure|null $lot = null;

    public function lot (ProductLot|Closure|null $lot): static
    {
        $this->lot = $lot;

        return $this;
    }

    public function getLot (): ProductLot|null
    {
        return $this->evaluate($this->lot);
    }

    public function getRelatedLots (): Collection
    {
        $productLot = $this->getLot();

        return $productLot->relatedLots()->with('relatedLot', 'relatedLot.product', 'relatedLot.product.factusolProduct')->get();
    }
}
