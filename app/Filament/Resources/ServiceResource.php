<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Illuminate\Support\Str;
use Filament\Forms\Components\{RichEditor, TagsInput, Textarea, TextInput, Select, FileUpload, TimePicker, Toggle};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, ImageColumn, ToggleColumn};

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function getNavigationGroup(): ?string
    {
        return __('Service Management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required()
                    ->maxLength(55),
                TextInput::make('slug')
                    ->label(__('Slug'))
                    ->disabled(fn(callable $get): bool => $get('name') === null),

                TagsInput::make('tags')
                    ->label(__('Tags'))
                    ->separator(',')
                    ->suggestions(fn(): array => \App\Models\Tag::all()->pluck('name')->toArray()),

                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->helperText(__('If this service is active or not.'))
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->default(true),

                Select::make('category_id')
                    ->label(__('Category'))
                    ->options(fn(): array => \App\Models\Category::all()->pluck('name', 'id')->toArray())
                    ->required(),

                TextInput::make('price')
                    ->label(__('Price'))
                    ->numeric()
                    ->required(),

                FileUpload::make('image')
                    ->label(__('Image'))
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth(600)
                    ->imageResizeTargetHeight(600)
                    ->helperText(__('Image size should be 600x600.'))
                    ->required(),

                FileUpload::make('attachments')
                    ->label(__('Attachment'))
                    ->multiple()
                    ->image()
                    ->imageResizeTargetWidth(600)
                    ->imageResizeTargetHeight(600)
                    ->maxFiles(5),

                TimePicker::make('duration')
                    ->label(__('Duration'))
                    ->datalist([
                        '0:15',
                        '0:30',
                        '0:45',
                        '1:00',
                        '1:15',
                        '1:30',
                        '1:45',
                        '2:00',
                        '2:15',
                        '2:30',
                        '2:45',
                        '3:00',
                        '3:15',
                        '3:30',
                        '3:45',
                        '4:00',
                        '4:15',
                        '4:30',
                        '4:45',
                        '5:00',
                        '5:15',
                        '5:30',
                        '5:45',
                        '6:00',
                        '6:15',
                        '6:30',
                        '6:45',
                        '7:00',
                        '7:15',
                        '7:30',
                        '7:45',
                        '8:00',
                        '8:15',
                        '8:30',
                        '8:45',
                        '9:00',
                        '9:15',
                        '9:30',
                        '9:45',
                        '10:00',
                        '10:15',
                        '10:30',
                        '10:45',
                        '11:00',
                        '11:15',
                        '11:30',
                        '11:45',
                        '12:00',
                    ])
                    ->required(),

                Textarea::make('description')
                    ->label(__('Description'))
                    ->columnSpan(2),

                RichEditor::make('short_description')
                    ->label(__('Short Description'))
                    ->columnSpan(2),

                TextInput::make('user_id')
                    ->label(__('User'))
                    ->default(fn(callable $get): int => auth()->id())
                    ->readOnly()
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->sortable()
                    ->numeric(decimalPlaces: 2),

                ImageColumn::make('image')
                    ->label(__('Image')),
                TextColumn::make('duration')
                    ->label(__('Duration'))
                    ->sortable(),
                TextColumn::make('tags')
                    ->label(__('Tags'))
                    ->badge()
                    ->separator(',')
                    ->toggleable(),

                TextColumn::make('description')
                    ->label(__('Description'))
                    ->limit(50),
                TextColumn::make('short_description')
                    ->label(__('Short Description'))
                    ->limit(50)
                    ->toggleable(true, true)
                    ->html(),

                TextColumn::make('category.name')->label(__('Category')),
                TextColumn::make('user.name')->label(__('User')),
                ToggleColumn::make('is_active')->label(__('Is Active')),
                /*TextColumn::make('is_active')
                    ->label(__('Is Active'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                        default => 'gray',
                    })

                ->toggleable(),*/
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
