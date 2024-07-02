<?php

namespace App\Filament\Clusters\UserProfile\Pages;

use App\Filament\Clusters\UserProfile;
use App\Models\User;
use App\Models\Demolay;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static string $view = 'filament.clusters.user-profile.pages.edit-profile';

    protected static ?string $cluster = UserProfile::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Editar Perfil';

    protected ?string $heading = '';

    protected ?string $subheading = '';

    public ?array $data = [];

    public User $user;
    public Demolay $demolay;

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->demolay = $this->user->demolay()->first();
        // @phpstan-ignore-next-line
        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'sisdm' => $this->demolay->sisdm,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Editar Perfil')
                    ->columns([
                        'sm' => 1,
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->autofocus()
                            ->autocomplete('name')
                            ->placeholder('Seu nome completo')
                            ->validationMessages([
                                'required' => 'O nome é obrigatório.',
                            ]),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->required()
                            ->email()
                            ->autocomplete('email')
                            ->placeholder('Seu melhor email')
                            ->validationMessages([
                                'required' => 'O email é obrigatório.',
                                'email' => 'O email deve ser válido.',
                            ]),
                    ])
                    ->icon('heroicon-o-pencil-square'),
            ])->statePath('data');
    }
}
