<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as DashboardPage;
// use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Resources\Products\Widgets\LatestProducts;
use App\Filament\Resources\ProductLots\Widgets\StockLotsStatuses;
use App\Filament\Widgets\StockStatusesWidget;

class Dashboard extends DashboardPage
{
    /**
     * @return int | array<string, ?int>
     */
    public function getColumns(): int | array
    {
        return 6;
    }

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            // FilamentInfoWidget::class,
            StockStatusesWidget::class,
            // StockStatusesChart::class,
            LatestProducts::class,
            StockLotsStatuses::class,
        ];
    }
}
