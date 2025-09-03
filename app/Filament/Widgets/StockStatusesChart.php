<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class StockStatusesChart extends ChartWidget
{
    protected ?string $heading = 'Estado de Stock por Producto';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Productos',
                    'data' => [
                        Product::query()->averageSalesForLastDays()->having('STOCK_LOTES', '>=', DB::raw('AVERAGE_SALES * 1.2'))->count(),
                        Product::query()->averageSalesForLastDays()->having('STOCK_LOTES', '>', DB::raw('AVERAGE_SALES'))->having('STOCK_LOTES', '>', DB::raw('AVERAGE_SALES * 1.2'))->count(),
                        Product::query()->averageSalesForLastDays()->having('STOCK_LOTES', '<=', DB::raw('AVERAGE_SALES'))->count(),
                    ],
                    'backgroundColor' => [
                        '#007bff',
                        '#FFC107',
                        '#dc3545',
                    ],
                ],
            ],
            'labels' => [
                'Stock optimo',
                'Stock normal',
                'Stock crítico',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
