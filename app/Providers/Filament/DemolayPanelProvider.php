<?php

namespace App\Providers\Filament;

use App\Filament\Clusters\UserProfile\Pages\ViewUserProfile;
use App\Filament\Admin\Pages\AdminDashboard;
use App\Filament\Pages\Auth\Registration;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Models\Chapter;
use Filament\Enums\ThemeMode;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Theme;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DemolayPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->tenant(Chapter::class, 'tenant')
            // ->tenantDomain('{tenant:tenant}.localhost')
            ->tenantMenu(false)
            // ->path('demolay')
            ->id('demolay')
            ->brandName('GoDM')
            // ->brandLogo(fn(): string => 'https://joaopedromerlotti.com.br/images/branco.png')
            // ->brandLogoHeight('8rem')
            // ->darkModeBrandLogo('https://joaopedromerlotti.com.br/images/preto.png')
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->demolay->name)
                    ->url(fn(): string => ViewUserProfile::getUrl()),
                'logout' => MenuItem::make()
                    ->label('Sair')
            ])
            ->breadcrumbs(false)
            ->login(Login::class)
            ->registration(Registration::class)
            ->colors([
                'primary' => Color::Amber,
                'success' => Color::Emerald,
                'danger' => Color::hex('#BB0A1E'),
            ])
            ->viteTheme('resources/css/filament/demolay/theme.css')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationItems([
                NavigationItem::make('Admin')
                    ->label('Painel de Administrador')
                    ->icon('heroicon-s-lock-closed')
                    ->visible(fn(): bool => auth()->user()->type === 'admin')
                    ->hidden(fn(): bool => auth()->user()->type != 'admin')
                    ->url(fn() => route('filament.admin.pages.admin-dashboard'))
            ])
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn() => view('components.footer')
            );
    }
}
