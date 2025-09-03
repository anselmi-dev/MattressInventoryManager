<?php

namespace App\Filament\Tables\Columns;

use Filament\Support\Components\Contracts\HasEmbeddedView;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Model;

class StockColumn extends Column
{
    protected string $view = 'filament.tables.columns.stock-column';

    public function getStock(): ?string
    {
        $record = $this->getRecord();

        if ($record->stock_order) {
            return $record->STOCK_LOTES . ' + ' . $record->stock_order;
        }

        return $record->STOCK_LOTES;
    }

    public function getColor(): ?string
    {
        $record = $this->getRecord();

        return color_average_stock($record->STOCK_LOTES, $record->AVERAGE_SALES);
    }

    public function getMessage(): ?string
    {
        $record = $this->getRecord();

        return message_average_stock($record->STOCK_LOTES, $record->AVERAGE_SALES, $record->AVERAGE_SALES_DIFFERENCE);
    }

    /**
     * @return array<string>
     */
    public function getSortColumns(Model $record): array
    {
        return $this->sortColumns ?? $this->getDefaultSortColumns($record);
    }

}
