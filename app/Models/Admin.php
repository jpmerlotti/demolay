<?php

namespace App\Models;

use App\Enums\UserTypesEnum;
use Filament\Panel;

class Admin extends User
{
    public $fillable = [
        'type' => UserTypesEnum::adm->value,
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
