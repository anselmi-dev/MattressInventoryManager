<?php

namespace App\Filament\Resources\Orders\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Orders\OrderResource;

class RetrunIndexAction extends Action
{
    public static function make(?string $name = 'return_to_index'): static
    {
        return parent::make($name)
            ->label(__('Volver a la lista de órdenes'))
            ->icon(Heroicon::ArrowRight)
            ->iconPosition(\Filament\Support\Enums\IconPosition::After)
            ->color('gray')
            ->url(OrderResource::getUrl());
    }
}
