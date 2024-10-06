<?php

namespace App\View\Components\Cards;

use App\Models\Sale;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardLatestSales extends Component
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
        return view('components.cards.card-latest-sales', [
            'collection' => Sale::orderBy('FECFAC', 'desc')->paginate(5)
        ]);
    }
}
