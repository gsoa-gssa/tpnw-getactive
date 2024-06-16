<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Infolists;
use App\Models\Contact;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ContactResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContactResource\RelationManagers;
use Illuminate\Console\View\Components\Info;
use Parallax\FilamentComments\Infolists\Components\CommentsEntry;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('firstname')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('lastname')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('zip')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\ToggleButtons::make('language')
                    ->options([
                        "de" => "German",
                        "fr" => "French",
                        "it" => "Italian",
                        "en" => "English"
                    ])
                    ->default("de"),
                Forms\Components\Select::make("canton")
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
                        "ZH" => "Zürich"
                    ])
                    ->default("ZH")
                    ->searchable(),
                Forms\Components\Select::make("activities")
                    ->options([
                        "signatureCollection" => "Signature Collection",
                        "certification" => "Certification",
                        "flyerDistribution" => "Flyer Distribution",
                        "supervision" => "Supervision",
                        "miscellaneous" => "Miscellaneous"
                    ])
                    ->multiple(),
                Forms\Components\Select::make("user_responsible_id")
                    ->relationship("user", "name")
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),
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
                Tables\Actions\Action::make('activities')->url(fn($record) => ContactResource::getUrl('activities', ['record' => $record])),
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
            RelationManagers\SignupsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
            'view' => Pages\ViewContact::route('/{record}'),
            'activities' => Pages\ActivityLogPage::route('/{record}/activities'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Personal Information')
                    ->schema([
                        Infolists\Components\Fieldset::make('contact')
                            ->label('Contact Information')
                            ->schema([
                                Infolists\Components\TextEntry::make('firstname'),
                                Infolists\Components\TextEntry::make('lastname'),
                                Infolists\Components\TextEntry::make('email'),
                                Infolists\Components\TextEntry::make('phone'),
                                Infolists\Components\TextEntry::make('zip'),
                                Infolists\Components\TextEntry::make('canton'),
                                Infolists\Components\TextEntry::make('language'),
                                Infolists\Components\TextEntry::make('activities'),
                                Infolists\Components\TextEntry::make('user.name'),
                            ]),
                    ]),
                Infolists\Components\Section::make('Comments')
                    ->schema([
                            CommentsEntry::make('filament_comments')
                                ->columnSpanFull(),
                    ]),
            ]);
    }
}
