<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use App\Filament\Resources\Orders\Schemas\OrderForm;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

}
