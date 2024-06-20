<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Contact;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Filters;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Filament\Exports\ContactExporter;
use App\Filament\Imports\ContactImporter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Console\View\Components\Info;
use App\Filament\Resources\ContactResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContactResource\RelationManagers;
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
                    ->unique(ignoreRecord: true)
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
                        "de" => __("languages.de"),
                        "fr" => __("languages.fr"),
                        "it" => __("languages.it"),
                        "en" => __("languages.en"),
                    ])
                    ->inline()
                    ->default("de"),
                Forms\Components\Select::make("canton")
                    ->options([
                        "AG" => __("cantons.AG"),
                        "AR" => __("cantons.AR"),
                        "AI" => __("cantons.AI"),
                        "BL" => __("cantons.BL"),
                        "BS" => __("cantons.BS"),
                        "BE" => __("cantons.BE"),
                        "FR" => __("cantons.FR"),
                        "GE" => __("cantons.GE"),
                        "GL" => __("cantons.GL"),
                        "GR" => __("cantons.GR"),
                        "JU" => __("cantons.JU"),
                        "LU" => __("cantons.LU"),
                        "NE" => __("cantons.NE"),
                        "NW" => __("cantons.NW"),
                        "OW" => __("cantons.OW"),
                        "SG" => __("cantons.SG"),
                        "SH" => __("cantons.SH"),
                        "SO" => __("cantons.SO"),
                        "SZ" => __("cantons.SZ"),
                        "TG" => __("cantons.TG"),
                        "TI" => __("cantons.TI"),
                        "UR" => __("cantons.UR"),
                        "VD" => __("cantons.VD"),
                        "VS" => __("cantons.VS"),
                        "ZG" => __("cantons.ZG"),
                        "ZH" => __("cantons.ZH")
                    ])
                    ->searchable(),
                Forms\Components\Select::make("activities")
                    ->options([
                        "signaturecollection" => "Signature Collection",
                        "certification" => "Certification",
                        "flyerdistribution" => "Flyer Distribution",
                        "supervision" => "Supervision",
                        "miscellaneous" => "Miscellaneous"
                    ])
                    ->multiple(),
                Forms\Components\Select::make("user_responsible_id")
                    ->relationship("user", "name")
                    ->preload()
                    ->default(auth()->id())
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
                    ->sortable()
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
                Filters\Filter::make("my_contacts")
                    ->label(__("filterlables.contacts.my_contacts"))
                    ->toggle()
                    ->default(true)
                    ->query(fn (Builder $query) => $query->where('user_responsible_id', auth()->id())),
                Filters\SelectFilter::make("canton")
                    ->label(__("filterlables.contacts.canton"))
                    ->multiple()
                    ->options([
                        "AG" => __("cantons.AG"),
                        "AR" => __("cantons.AR"),
                        "AI" => __("cantons.AI"),
                        "BL" => __("cantons.BL"),
                        "BS" => __("cantons.BS"),
                        "BE" => __("cantons.BE"),
                        "FR" => __("cantons.FR"),
                        "GE" => __("cantons.GE"),
                        "GL" => __("cantons.GL"),
                        "GR" => __("cantons.GR"),
                        "JU" => __("cantons.JU"),
                        "LU" => __("cantons.LU"),
                        "NE" => __("cantons.NE"),
                        "NW" => __("cantons.NW"),
                        "OW" => __("cantons.OW"),
                        "SG" => __("cantons.SG"),
                        "SH" => __("cantons.SH"),
                        "SO" => __("cantons.SO"),
                        "SZ" => __("cantons.SZ"),
                        "TG" => __("cantons.TG"),
                        "TI" => __("cantons.TI"),
                        "UR" => __("cantons.UR"),
                        "VD" => __("cantons.VD"),
                        "VS" => __("cantons.VS"),
                        "ZG" => __("cantons.ZG"),
                        "ZH" => __("cantons.ZH")
                    ])
            ])
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->label(__('buttonlabels.import.contacts'))
                    ->importer(ContactImporter::class),
                Tables\Actions\ExportAction::make()
                    ->label(__('buttonlabels.export.contacts'))
                    ->exporter(ContactExporter::class),
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
