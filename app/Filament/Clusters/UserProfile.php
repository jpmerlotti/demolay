<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class UserProfile extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
