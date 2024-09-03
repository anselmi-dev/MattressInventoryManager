<?php

namespace App\View\Components\Products;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Code;
use App\Models\Product;

class CardProduct extends Component
{
    public Product $product;

    /**
     * Create a new component instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.products.card-product');
    }
}
