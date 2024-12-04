<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegistration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class Registration extends BaseRegistration
{
    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getNameFormComponent()->label('Nome Completo')
                ->validationMessages([
                    'required' => 'O nome é obrigatório',
                    'string' => 'O nome deve ser uma string',
                    'max' => 'O nome deve ter no máximo 255 caracteres',
                ]),
            $this->getEmailFormComponent()->label('Email')
                ->validationMessages([
                    'required' => 'O email é obrigatório',
                    'email' => 'O email deve ser um email válido',
                    'max' => 'O email deve ter no máximo 255 caracteres',
                    'unique' => 'O email já está em uso',
                ]),
            TextInput::make('phone')->label('Telefone')
                ->mask('(99) 99999-9999')
                ->required(true)
                ->length(15)
                ->validationMessages([
                    'min' => 'O número de telefone deve ter 11 números',
                    'max' => 'O número de telefone deve ter 11 números',
                ]),
            TextInput::make('sisdm')->label('ID SISDM')
                ->required(),
            DatePicker::make('birthdate')->label('Data de Nascimento')->required(true)
                ->maxDate(now()->subYears(12)->toDateString()),
            $this->getPasswordFormComponent()->label('Senha')
                ->rules([
                    Password::default()
                        ->mixedCase()
                        ->numbers()
                ])->validationMessages([
                    'required' => 'A senha é obrigatória',
                    'min' => 'A senha deve ter pelo menos 8 caracteres',
                    'same' => 'A senha deve ser igual à confirmação de senha',
                    'password.mixed' => 'A senha deve conter letras maiúsculas e minúsculas',
                    'password.symbols' => 'A senha deve conter símbolos',
                    'password.numbers' => 'A senha deve conter números',
                    'password.letters' => 'A senha deve conter letras',
                ]),
            TextInput::make('passwordConfirmation')
                ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
                ->password()
                ->revealable(filament()->arePasswordsRevealable())
                ->required()
                ->dehydrated(false),
        ]);
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $user = DB::transaction(function () {
            $data = $this->form->getState();

            return $this->handleRegistration($data);
        });

        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }

    protected function handleRegistration(array $data): Model
    {
        $user = $this->getUserModel()::create($data);

        unset($data['email'], $data['password']);

        $user->demolay()->create($data);

        return $user;
    }

    public function getHeading(): string|Htmlable
    {
        return 'Registrar';
    }

    public function loginAction(): Action
    {
        return parent::loginAction()->label('Já tem uma conta? Faça login aqui.');
    }
}
