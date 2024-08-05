<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Infolists;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Table;
use Filament\Tables\Filters;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Contact;
use Filament\Infolists\Infolist;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make("Event Content")
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('German')
                            ->schema([
                                Forms\Components\TextInput::make('name.de')
                                    ->label('Name'),
                                Forms\Components\TextInput::make('location.de')
                                    ->label('Location'),
                                Forms\Components\TextInput::make('time.de')
                                    ->label('Time'),
                                Forms\Components\RichEditor::make('description.de')
                                    ->label('Description'),
                            ]),
                        Forms\Components\Tabs\Tab::make('French')
                            ->schema([
                                Forms\Components\TextInput::make('name.fr')
                                    ->label('Name'),
                                Forms\Components\TextInput::make('location.fr')
                                    ->label('Location'),
                                Forms\Components\TextInput::make('time.fr')
                                    ->label('Time'),
                                Forms\Components\RichEditor::make('description.fr')
                                    ->label('Description'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Italian')
                            ->schema([
                                Forms\Components\TextInput::make('name.it')
                                    ->label('Name'),
                                Forms\Components\TextInput::make('location.it')
                                    ->label('Location'),
                                Forms\Components\TextInput::make('time.it')
                                    ->label('Time'),
                                Forms\Components\RichEditor::make('description.it')
                                    ->label('Description'),
                            ]),
                    ])
                    ->columnSpanFull(),
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
                Forms\Components\Select::make("contact_id")
                    ->relationship("contact", "id")
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('firstname')
                            ->required(),
                        Forms\Components\TextInput::make('lastname')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->required(),
                        Forms\Components\TextInput::make('zip')
                            ->required(),
                    ])
                    ->editOptionForm([
                        Forms\Components\TextInput::make('firstname')
                            ->required(),
                        Forms\Components\TextInput::make('lastname')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->required(),
                        Forms\Components\TextInput::make('zip')
                            ->required(),
                    ])
                    ->getOptionLabelFromRecordUsing(fn (Contact $contact) => $contact->firstname . " " . $contact->lastname . " (" . $contact->email . ")")
                    ->default(Contact::where("email", auth()->user()->email)->first()->id ?? null),
                Forms\Components\Select::make('type')
                    ->options([
                        "signaturecollection" => "Signature Collection",
                        "certification" => "Certification"
                    ])
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make("users")
                    ->relationship("users", "name")
                    ->preload()
                    ->default([auth()->id()])
                    ->multiple()
                    ->searchable(),
                Forms\Components\Toggle::make('visibility')
                    ->default(true)
                    ->onColor('success')
                    ->offColor('danger')
                    ->helperText(__('events.create.visibility_helper'))
                    ->columnSpanFull()
                    ->label(__('events.create.visibility')),
                Forms\Components\Toggle::make('reassign')
                    ->default(false)
                    ->onColor('success')
                    ->live()
                    ->helperText(__('events.create.reassign_helper'))
                    ->columnSpanFull()
                    ->label(__('events.create.reassign')),
                Forms\Components\Select::make('subevents')
                    ->searchable()
                    ->relationship('subevents', 'id')
                    ->getSearchResultsUsing(fn($query, $search) => $query->where('name', 'like', '%' . $search . '%'))
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->getTranslatable('name', app()->getLocale()))
                    ->preload()
                    ->columnSpanFull()
                    ->visible(fn(Get $get) => $get('reassign'))
                    ->multiple()
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
                        'certification' => 'heroicon-o-document-check',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_signups')
                    ->label(__("tablecolumns.events.number_of_signups"))
                    ->getStateUsing(fn (Event $event) => $event->signups->count())
                    ->sortable(query: fn (Builder $query, $direction) => $query->withCount('signups')->orderBy('signups_count', $direction)),
                Tables\Columns\TextColumn::make('users.name')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->defaultSort("date", "asc")
            ->filters([
                Filters\Filter::make("only_future")
                    ->label(__("filterlabels.events.only_future"))
                    ->default(true)
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('date', '>=', date('Y-m-d', strtotime('today')))),
                Filters\Filter::make("my_events")
                    ->label(__("filterlabels.events.my_events"))
                    ->default(true)
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereHas('users', fn (Builder $query) => $query->where('user_id', auth()->id()))),
                Filters\SelectFilter::make("canton")
                    ->label(__("filterlabels.events.canton"))
                    ->multiple()
                    ->options([
                        "national" => __("cantons.national"),
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
                    ]),
                Filters\SelectFilter::make("users")
                    ->label(__("filterlabels.contacts.users"))
                    ->multiple()
                    ->options(
                        \App\Models\User::all()->pluck("name", "id")->toArray()
                    )
                    ->modifyQueryUsing(function (Builder $query, $state){
                        if (!$state['values']) {
                            return $query;
                        }
                        return $query->whereHas('users', fn($query) => $query->whereIn('user_id', $state['values']));
                    }),
                Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('activities')->url(fn($record) => EventResource::getUrl('activities', ['record' => $record])),
                Tables\Actions\RestoreAction::make()
                    ->visible(fn($record) => $record->trashed())
            ])
            ->headerActions([
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'activities' => Pages\ActivityLogPage::route('/{record}/activities'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /**
     * Infolist
     */
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make("Event Information")
                    ->schema([
                        Infolists\Components\TextEntry::make('date')
                            ->date("d.m.Y")
                            ->label('Date'),
                        InfoLists\Components\TextEntry::make('canton')
                            ->label('Canton'),
                        InfoLists\Components\TextEntry::make('type')
                            ->label('Type'),
                        InfoLists\Components\IconEntry::make('visibility')
                            ->icon(fn($state) => $state ? 'heroicon-o-eye' : 'heroicon-o-eye-slash')
                            ->label('Visibility'),
                        Infolists\Components\Tabs::make("Event Content")
                            ->tabs([
                                Infolists\Components\Tabs\Tab::make('German')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name.de')
                                            ->label('Name'),
                                        Infolists\Components\TextEntry::make('location.de')
                                            ->label('Location'),
                                        Infolists\Components\TextEntry::make('time.de')
                                            ->label('Time'),
                                        Infolists\Components\TextEntry::make('description.de')
                                            ->label('Description'),
                                    ]),
                                Infolists\Components\Tabs\Tab::make('French')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name.fr')
                                            ->label('Name'),
                                        Infolists\Components\TextEntry::make('location.fr')
                                            ->label('Location'),
                                        Infolists\Components\TextEntry::make('time.fr')
                                            ->label('Time'),
                                        Infolists\Components\TextEntry::make('description.fr')
                                            ->label('Description'),
                                    ]),
                                Infolists\Components\Tabs\Tab::make('Italian')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name.it')
                                            ->label('Name'),
                                        Infolists\Components\TextEntry::make('location.it')
                                            ->label('Location'),
                                        Infolists\Components\TextEntry::make('time.it')
                                            ->label('Time'),
                                        Infolists\Components\TextEntry::make('description.it')
                                            ->label('Description'),
                                    ]),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]
                )
                    ->columns(2),
                Infolists\Components\Section::make(__("events.infolist.section.contact"))
                    ->schema([
                        Infolists\Components\TextEntry::make('contact.firstname')
                            ->url(fn($record) => ContactResource::getUrl('view', ['record' => $record->contact_id]))
                            ->label("First Name"),
                        Infolists\Components\TextEntry::make('contact.lastname')
                            ->url(fn($record) => ContactResource::getUrl('view', ['record' => $record->contact_id]))
                            ->label("Last Name"),
                        InfoLists\Components\TextEntry::make('contact.email')
                            ->url(fn($record) => ContactResource::getUrl('view', ['record' => $record->contact_id]))
                            ->label('Email'),
                        InfoLists\Components\TextEntry::make('contact.phone')
                            ->url(fn($record) => ContactResource::getUrl('view', ['record' => $record->contact_id]))
                            ->label('Phone'),
                        InfoLists\Components\TextEntry::make('contact.zip')
                            ->url(fn($record) => ContactResource::getUrl('view', ['record' => $record->contact_id]))
                            ->label('Zip'),
                        InfoLists\Components\TextEntry::make('contact.canton')
                            ->url(fn($record) => CantonResource::getUrl('edit', ['record' => \App\Models\Canton::where('code', $record->contact->canton)->first()->id ?? 1]))
                            ->label('Canton'),
                    ]
                )
                    ->columns(2),
            ]);
        }
}
