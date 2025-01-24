<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, FileUpload};

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name', 'Name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set, $state) => $set('slug', \Illuminate\Support\Str::slug($state)))
                    ->maxLength(55),


                TextInput::make('slug', __('Slug'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled(fn(callable $get) => $get('name') === null)
                    ->default(fn(callable $get) => \Illuminate\Support\Str::slug($get('name'))),

                FileUpload::make('image')
                    ->image()
                    //->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->imageResizeTargetWidth(400)
                    ->imageResizeTargetHeight(400)
                    ->helperText(__('Image size should be 400x400.')),


                Textarea::make('description')
                    ->columnSpan(2)


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\ImageColumn::make('image')->label(__('Image'))->size(40),
                Tables\Columns\TextColumn::make('description')->label(__('Description')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
