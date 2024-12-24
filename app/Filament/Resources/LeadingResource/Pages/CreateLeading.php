<?php

namespace App\Filament\Resources\LeadingResource\Pages;

use App\Filament\Resources\LeadingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\View\View;

class CreateLeading extends CreateRecord
{
    protected static string $resource = LeadingResource::class;
    protected static ?string $title = 'Cadastrar Nova Gestão';

    public function mount(): void
    {
        parent::mount();

        FilamentView::registerRenderHook(
            PanelsRenderHook::PAGE_HEADER_WIDGETS_BEFORE,
            fn(): View => view('components.create-leading-warn')
        );
    }
}
