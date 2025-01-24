<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Infolists\Components\Tabs;


class Preferences extends Page
{
    use Forms\Concerns\InteractsWithForms;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.preferences';
    protected static bool $shouldRegisterNavigation = false;


    public $company_name;
    public $logo;
    public $banner;
    public $company_description;
    public $custom_message;
    public $company_phone;
    public $company_email;
    public $company_website;
    public $company_address;
    public $company_founding_date;
    public $company_tax_id;
    public $company_primary_color;
    public $company_secondary_color;
    public $company_timezone;

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => 'Mi Empresa',
            'logo' => null,
            'banner' => null,
            'company_description' => null,
            'custom_message' => 'Bienvenido a nuestra plataforma',
        ]);
    }


    protected function getFormSchema(): array
    {
        return [

            Forms\Components\TextInput::make('company_name')
                ->label('Company Name')
                ->required()
                ->maxLength(255),


            Forms\Components\FileUpload::make('logo')
                ->label(__('Logo of your company'))
                ->image()
                ->required(),


            Forms\Components\FileUpload::make('banner')
                ->label(__('Banner of your company'))
                ->image()
                ->required(),

            Forms\Components\Textarea::make('company_description')
                ->label(__('Description'))
                ->helperText(__('Describe your company'))
                ->maxLength(255),

            Forms\Components\TextInput::make('company_phone')
                ->label(__('Contact Phone')) // Traducción del label
                ->tel(),

            Forms\Components\TextInput::make('company_email')
                ->label(__('Email')) // Traducción del label
                ->email()
                ->required(),

            Forms\Components\TextInput::make('company_website')
                ->label(__('Website')) // Traducción del label
                ->url()
                ->placeholder(__('https://www.example.com')),

            Forms\Components\Textarea::make('company_address')
                ->label(__('Address')) // Traducción del label
                ->helperText(__('The company\'s physical address')),

            Forms\Components\DatePicker::make('company_founding_date')
                ->label(__('Founding Date')) // Traducción del label
                ->helperText(__('Select the date the company was founded')),

            Forms\Components\TextInput::make('company_tax_id')
                ->label(__('Tax ID')) // Traducción del label
                ->required()
                ->helperText(__('For example: TIN, CIF, RFC, or equivalent')),

            Forms\Components\ColorPicker::make('company_primary_color')
                ->label(__('Primary Brand Color')),

            Forms\Components\ColorPicker::make('company_secondary_color')
                ->label(__('Secondary Brand Color')),

            Forms\Components\Select::make('company_timezone')
                ->label(__('Timezone')) // Traducción del label
                ->options(timezone_identifiers_list())
                ->required(),


            Forms\Components\Textarea::make('custom_message')
                ->label(__('Personalized Message'))
                ->helperText('Este mensaje se mostrará en la página de inicio')
                ->maxLength(500),
        ];
    }

    public function submitPreferences()
    {
        $data = $this->form->getState();

        // Aquí puedes almacenar o procesar las preferencias ingresadas
        dd($data); // Verifica los datos ingresados
    }


}
