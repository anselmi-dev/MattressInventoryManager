<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class InfoWidget extends Widget
{
    protected string $view = 'filament.widgets.info-widget';

    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;

    protected static ?string $title = null;

    protected static ?string $description = null;

    protected static ?string $action = null;

    public function mount(?string $title = null, ?string $description = null, ?string $action = null): void
    {
        static::setTitle($title);

        static::setDescription($description);

        static::setAction($action);
    }

    public static function setTitle(?string $title): void
    {
        static::$title = $title;
    }

    public static function getTitle(): ?string
    {
        return static::$title;
    }

    public static function setDescription(?string $description): void
    {
        static::$description = $description;
    }
    public static function getDescription(): ?string
    {
        return static::$description;
    }

    public static function setAction(?string $action): void
    {
        static::$action = $action;
    }

    public static function getAction(): ?string
    {
        return static::$action;
    }
}
