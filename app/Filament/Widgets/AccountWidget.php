<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as FilamentAccountWidget;

class AccountWidget extends FilamentAccountWidget
{

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 6,
    ];
}
