<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;

class CustomPage extends Page implements HasForms, HasInfolists
{
    use InteractsWithForms;

    public Model $record;

    protected static bool $shouldRegisterNavigation = false;

    public function setTitle(string $title): void
    {
        self::$title = $title;
    }

    public static function getNavigationUrl(): string
    {
        return route(self::getRouteName(), ['tenant' => Filament::getTenant()]);
    }
}
