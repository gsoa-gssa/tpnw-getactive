<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SignupResource\Pages;
use App\Filament\Resources\SignupResource\RelationManagers;
use App\Models\Signup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SignupResource extends Resource
{
    protected static ?string $model = Signup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\ToggleButtons::make('status')
                    ->options([
                        'signup' => 'Signup',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'no-show' => 'No Show',
                    ])
                    ->inline()
                    ->default('signup')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\RichEditor::make('comment')
                    ->columnSpanFull()
                    ->nullable(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name->de')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'email')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact.email')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListSignups::route('/'),
            'create' => Pages\CreateSignup::route('/create'),
            'edit' => Pages\EditSignup::route('/{record}/edit'),
            'view' => Pages\ViewSignup::route('/{record}'),
        ];
    }
}
