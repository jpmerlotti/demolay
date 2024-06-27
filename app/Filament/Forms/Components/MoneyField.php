<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class MoneyField extends Field
{
    protected string $view = 'filament.forms.components.money-field';

    protected function setUp(): void
    {
        parent::setUp();
    }
}
