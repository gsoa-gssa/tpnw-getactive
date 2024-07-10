<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CantonResource\Pages;
use App\Filament\Resources\CantonResource\RelationManagers;
use App\Models\Canton;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CantonResource extends Resource
{
    protected static ?string $model = Canton::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make("name")
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('German')
                            ->schema([
                                Forms\Components\TextInput::make('name.de')
                                    ->label('Name'),
                            ])
                            ->label(__("misc.languages.de")),
                        Forms\Components\Tabs\Tab::make('French')
                            ->schema([
                                Forms\Components\TextInput::make('name.fr')
                                    ->label('Name'),
                            ])
                            ->label(__("misc.languages.fr")),
                        Forms\Components\Tabs\Tab::make('Italian')
                            ->schema([
                                Forms\Components\TextInput::make('name.it')
                                    ->label('Name'),
                            ])
                            ->label(__("misc.languages.it")),
                    ])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(2),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name.' . app()->getLocale())
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListCantons::route('/'),
            'create' => Pages\CreateCanton::route('/create'),
            'edit' => Pages\EditCanton::route('/{record}/edit'),
        ];
    }
}
