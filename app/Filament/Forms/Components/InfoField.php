<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class InfoField extends Field
{
    protected string $view = 'filament.forms.components.info-field';

    protected ?string $title = null;

    protected ?string $description = null;

    public function title(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
