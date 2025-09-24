<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

abstract class WidgetCustom extends Widget
{
    public ?Model $record = null;

    protected static ?Model $model = null;

    public static function setModel(Model $model): void
    {
        if (!$model instanceof Model) {
            throw new \Exception('Model must be an instance of Illuminate\Database\Eloquent\Model');
        }

        static::$model = $model;
    }

    public static function getModel(): ?Model
    {
        return static::$model;
    }
}
