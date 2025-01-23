<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Pages\Auth\Register as FilamentRegister;

class Register extends FilamentRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getRoleFormComponent(),
                    ])
                    ->statePath('data'),
            )
        ];
    }

    protected function getRoleFormComponent(): Component
    {
        return Select::make('role', __('Role'))
            ->options([
                'customer' => 'Customer',
                'provider' => 'Provider',
            ])
            ->default('user')
            ->required();
    }
}
