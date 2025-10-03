<?php

namespace App\Filament\Pages;

use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;
use Illuminate\Contracts\Support\Htmlable;

class Backups extends BaseBackups
{
    public static function canAccess(): bool
    {
        return true;
    }
}
