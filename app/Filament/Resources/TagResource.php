<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Illuminate\Support\Str;
use Filament\Forms\Components\{TextInput, ColorPicker};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\{ColorColumn, TextColumn};
use Filament\Tables\Filters\SelectFilter;


class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->maxLength(25)
                    ->required(),
                TextInput::make('slug')
                    ->label(__('Slug'))
                    ->disabled(fn(callable $get): bool => $get('name') === null)
                    ->unique(ignoreRecord: true)
                    ->required(),
                ColorPicker::make('color')->label(__('Color')),
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
                TextColumn::make('slug')->label(__('Slug')),
                ColorColumn::make('color')->label(__('Color')),
            ])
            ->filters([
                SelectFilter::make('color')
                    ->options(fn(): array => Tag::all()->pluck('color', 'color')->toArray())
                    ->multiple()
                    ->label(__('Color')),

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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
