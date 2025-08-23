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
use App\Models\Canton;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\RelationshipConstraint\Operators\IsRelatedToOperator;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
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
                Forms\Components\Select::make('tags')
                    ->relationship(name: 'tags', titleAttribute: 'label')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('label')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname')
                    ->sortable()
                    ->label(__('columnlabels.firstname'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastname')
                    ->sortable()
                    ->label(__('columnlabels.lastname'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->label(__('columnlabels.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->sortable()
                    ->label(__('columnlabels.phone'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->sortable()
                    ->label(__('columnlabels.zip'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('canton')
                    ->sortable()
                    ->label(__('columnlabels.canton'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_signups')
                    ->sortable(query: fn (Builder $query, $direction) => $query->withCount('signups')->orderBy('signups_count', $direction))
                    ->label(__('tablecolumns.contacts.number_of_signups'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->getStateUsing(fn($record) => $record->signups->count()),
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('columnlabels.user'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filters\Filter::make("my_contacts")
                    ->label(__("filterlabels.contacts.my_contacts"))
                    ->toggle()
                    ->default(true)
                    ->query(fn (Builder $query) => $query->where('user_responsible_id', auth()->id())),
                Filters\Filter::make("has_phone")
                    ->label(__("filterlabels.contacts.has_phone"))
                    ->toggle()
                    ->query(fn (Builder $query) => $query->whereNotNull('phone')),
                Filters\Filter::make("no_signups")
                    ->label(__("filterlabels.contacts.no_signups"))
                    ->toggle()
                    ->query(fn (Builder $query) => $query->doesntHave('signups')),
                Filters\Filter::make("has_signups")
                    ->label(__("filterlabels.contacts.has_signups"))
                    ->toggle()
                    ->query(fn (Builder $query) => $query->has('signups')),
                Filters\Filter::make("has_signups_future")
                    ->label(__("filterlabels.contacts.has_signups_future"))
                    ->toggle()
                    ->query(function (Builder $query) {
                        $now = now();
                        $query->whereHas('signups', function ($q) use ($now) {
                            $q->whereHas('event', function ($eventQuery) use ($now) {
                                $eventQuery->where('date', '>=', $now->copy()->addDay()->startOfDay());
                            });
                        });
                    }),
                Filters\Filter::make("no_signups_future")
                    ->label(__("filterlabels.contacts.no_signups_future"))
                    ->toggle()
                    ->query(function (Builder $query) {
                        $now = now();
                        $query->whereDoesntHave('signups', function ($q) use ($now) {
                            $q->whereHas('event', function ($eventQuery) use ($now) {
                                $eventQuery->where('date', '>=', $now->copy()->addDay()->startOfDay());
                            });
                        });
                    }),
                Filters\Filter::make("has_signups_certification")
                    ->label(__("filterlabels.contacts.has_signups_certification"))
                    ->toggle()
                    ->query(function (Builder $query) {
                        $query->whereHas('signups.event', function ($eventQuery) {
                            $eventQuery->where('type', 'certification');
                        });
                    }),
                Filters\Filter::make("has_signups_signaturecollection")
                    ->label(__("filterlabels.contacts.has_signups_signaturecollection"))
                    ->toggle()
                    ->query(function (Builder $query) {
                        $query->whereHas('signups.event', function ($eventQuery) {
                            $eventQuery->where('type', 'signaturecollection');
                        });
                    }),
                Filters\Filter::make("has_certification_activity")
                    ->label(__("filterlabels.contacts.has_certification_activity"))
                    ->toggle()
                    ->query(function (Builder $query) {
                        $query->whereJsonContains('activities', 'certification');
                    }),
                Filters\Filter::make("has_signaturecollection_activity")
                    ->label(__("filterlabels.contacts.has_signaturecollection_activity"))
                    ->toggle()
                    ->query(function (Builder $query) {
                        $query->whereJsonContains('activities', 'signaturecollection');
                    }),
                Filters\Filter::make("orphans")
                    ->label(__("filterlabels.contacts.orphans"))
                    ->toggle()
                    ->query(function (Builder $query) {
                        $query->whereNull('user_responsible_id');
                        $query->whereNull("zip");
                        $query->whereNull("canton");
                    }),
                    Filters\TrashedFilter::make(),
                    QueryBuilder::make()
                        ->constraints([
                            TextConstraint::make('firstname')
                                ->label(__('filterlabels.contacts.firstname')),
                            TextConstraint::make('lastname')
                                ->label(__('filterlabels.contacts.lastname')),
                            TextConstraint::make('email')
                                ->label(__('filterlabels.contacts.email')),
                            TextConstraint::make('phone')
                                ->label(__('filterlabels.contacts.phone')),
                            TextConstraint::make('zip')
                                ->label(__('filterlabels.contacts.zip')),
                            SelectConstraint::make("canton")
                                ->label(__('filterlabels.contacts.canton'))
                                ->multiple()
                                ->options(
                                     Canton::all()->pluck("name." . app()->getLocale(), "code")->toArray()
                                ),
                            RelationshipConstraint::make("tags")
                                ->label(__('filterlabels.contacts.tags'))
                                ->multiple()
                                ->selectable(
                                    IsRelatedToOperator::make()
                                        ->titleAttribute("label")
                                        ->searchable()
                                        ->preload()
                                        ->multiple()
                                ),
                            RelationshipConstraint::make("user")
                                ->label(__('filterlabels.contacts.users'))
                                ->selectable(
                                    IsRelatedToOperator::make()
                                        ->titleAttribute("name")
                                        ->searchable()
                                        ->preload()
                                        ->multiple()
                                )
                        ])
                ], layout: \Filament\Tables\Enums\FiltersLayout::AboveContentCollapsible)
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
                Tables\Actions\RestoreAction::make()
                    ->visible(fn($record) => $record->trashed())
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
            RelationManagers\EmailNotificationsRelationManager::class,
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
                                Infolists\Components\TextEntry::make('tags.label'),
                            ]),
                    ]),
                Infolists\Components\Section::make('Comments')
                    ->schema([
                            CommentsEntry::make('filament_comments')
                                ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
