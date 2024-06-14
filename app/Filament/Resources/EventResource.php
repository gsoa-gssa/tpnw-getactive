<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('visibility')
                    ->default(true)
                    ->onColor('success')
                    ->offColor('danger')
                    ->label('Is public?'),
                Forms\Components\ToggleButtons::make('language')
                    ->options([
                        'de' => 'German',
                        'fr' => 'French',
                        'it' => 'Italian',
                    ])
                    ->inline()
                    ->default('de'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->native(false)
                    ->displayFormat('d.m.Y')
                    ->required(),
                Forms\Components\Select::make('canton')
                    ->options([
                        "AG" => "Aargau",
                        "AR" => "Appenzell Ausserrhoden",
                        "AI" => "Appenzell Innerrhoden",
                        "BL" => "Basel-Landschaft",
                        "BS" => "Basel-Stadt",
                        "BE" => "Bern",
                        "FR" => "Freiburg",
                        "GE" => "Genf",
                        "GL" => "Glarus",
                        "GR" => "Graubünden",
                        "JU" => "Jura",
                        "LU" => "Luzern",
                        "NE" => "Neuenburg",
                        "NW" => "Nidwalden",
                        "OW" => "Obwalden",
                        "SG" => "St. Gallen",
                        "SH" => "Schaffhausen",
                        "SO" => "Solothurn",
                        "SZ" => "Schwyz",
                        "TG" => "Thurgau",
                        "TI" => "Tessin",
                        "UR" => "Uri",
                        "VD" => "Waadt",
                        "VS" => "Wallis",
                        "ZG" => "Zug",
                        "ZH" => "Zürich",
                        "national" => "National"
                    ])
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('contact')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('type')
                    ->options([
                        "signaturecollection" => "Signature Collection",
                        "certification" => "Certification"
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('canton'),
                Tables\Columns\TextColumn::make('location')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('type')
                    ->icon(fn (string $state): string => match ($state) {
                        'signaturecollection' => 'heroicon-o-pencil',
                        'certification' => 'heroicon-o-clipboard-check',
                    })
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
