<?php

namespace App\Filament\Clusters\UserProfile\Pages;

use App\Filament\Clusters\UserProfile;
use App\Infolists\Components\GenerateApiKey;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\HtmlString;

class ViewUserProfile extends Page implements HasInfolists
{
    use InteractsWithFormActions;
    use InteractsWithInfolists;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    protected static ?string $navigationLabel = 'Perfil';

    protected static ?string $title = 'Ver Perfil';

    protected static ?string $slug = 'Me';

    protected ?string $heading = '';

    protected ?string $subheading = '';

    protected static string $view = 'filament.clusters.user-profile.pages.view-user-profile';

    protected static ?string $cluster = UserProfile::class;

    public ?array $data = [];

    public function personalInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record(auth()->user())
            ->schema([
                Section::make('Informações Pessoais')
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nome'),
                        TextEntry::make('email')
                            ->label('E-mail'),
                    ])
                    ->icon('heroicon-s-user'),
                Section::make('Dados da Conta')
                    ->columns([
                        'default' => 1,
                        'lg' => 3,
                    ])
                    ->icon('heroicon-s-information-circle'),
            ]);
    }
}
