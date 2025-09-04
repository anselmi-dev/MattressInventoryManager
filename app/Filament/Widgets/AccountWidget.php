<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as FilamentAccountWidget;

class AccountWidget extends FilamentAccountWidget
{
    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = [
        'md' => 6,
        'xl' => 6,
    ];
}
