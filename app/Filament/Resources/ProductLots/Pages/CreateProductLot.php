<?php

namespace App\Filament\Resources\ProductLots\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductLots\ProductLotResource;

class CreateProductLot extends CreateRecord
{
    protected static string $resource = ProductLotResource::class;
}
