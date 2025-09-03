<?php

namespace App\Filament\Tables\Columns;

use Filament\Support\Components\Contracts\HasEmbeddedView;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Model;

class StockCombinationColumn extends Column
{
    protected string $view = 'filament.tables.columns.stock-column';

    public function getStock(): ?string
    {
        $record = $this->getRecord();

        if ($record->stock_order) {
            return $record->stock . ' + ' . $record->stock_order;
        }

        return $record->stock;
    }

    public function getColor(): ?string
    {
        $record = $this->getRecord();

        return color_average_stock($record->stock, $record->AVERAGE_SALES);
    }

    public function getMessage(): ?string
    {
        $record = $this->getRecord();

        return message_average_stock($record->stock, $record->AVERAGE_SALES, $record->AVERAGE_SALES_DIFFERENCE);
    }

    /**
     * @return array<string>
     */
    public function getSortColumns(Model $record): array
    {
        return $this->sortColumns ?? $this->getDefaultSortColumns($record);
    }

}
