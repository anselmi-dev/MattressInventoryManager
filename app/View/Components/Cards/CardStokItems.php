<?php

namespace App\View\Components\Cards;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product;

class CardStokItems extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards.card-stok-items', [
            'collection' => Product::whereNotCombinations()->orderBy('average_sales_difference', 'asc')->paginate(5)
        ]);
    }
}
