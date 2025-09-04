<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Collection;

class StockStatusesWidget extends Widget
{
    protected string $view = 'filament.widgets.stock-statuses-widget';

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = [
        'md' => 6,
        'xl' => 6,
    ];

    public function getStockStatuses(): Collection
    {
        $products = Product::query()->averageSalesForLastDays()->orderBy('AVERAGE_SALES_DIFFERENCE', 'asc')->get()->filter(function ($product) {
            return $product->AVERAGE_SALES_DIFFERENCE < 0;
        });

        return $products;
    }
}
