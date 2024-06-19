<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Filters;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EventResource\RelationManagers;

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
                Forms\Components\TextInput::make('contact')
                    ->email()
                    ->maxLength(255)
                    ->helperText('Email address for contact person')
                    ->default(auth()->user()->email),
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
                    ->helperText('Should people be able to signup for this event or is it assign only?')
                    ->columnSpanFull()
                    ->label('Is public?'),
                Forms\Components\Toggle::make('reassign')
                    ->default(false)
                    ->onColor('success')
                    ->offColor('danger')
                    ->label('Must signups be reassigned?')
                    ->columnSpanFull()
                    ->helperText('If event is a placeholder for multiple smaller events.'),
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
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
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
            ->filters([
                Filters\Filter::make("only_future")
                    ->label(__("filterlables.events.only_future"))
                    ->default(true)
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('date', '>=', now())),
                Filters\Filter::make("must_reassign")
                    ->label(__("filterlables.events.must_reassign"))
                    ->default(false)
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('reassign', true)),
                Filters\Filter::make("my_events")
                    ->label(__("filterlables.events.my_events"))
                    ->default(true)
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereHas('users', fn (Builder $query) => $query->where('user_id', auth()->id()))),
                Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('activities')->url(fn($record) => EventResource::getUrl('activities', ['record' => $record])),
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
}
