<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use App\Models\Signup;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SignupResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SignupResource\RelationManagers;
use Parallax\FilamentComments\Infolists\Components\CommentsEntry;

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
                        'signup' => __("signup.status.signup"),
                        'confirmed' => __("signup.status.confirmed"),
                        'cancelled' => __("signup.status.cancelled"),
                        'no-show' => __("signup.status.no-show"),
                        'attended' => __("signup.status.attended"),
                    ])
                    ->inline()
                    ->default('signup')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\RichEditor::make('additional_information')
                    ->columnSpanFull()
                    ->label(__('signup.additional_information'))
                    ->helperText(__('signup.additional_information_helper'))
                    ->nullable(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name->de')
                    ->getOptionLabelFromRecordUsing(fn (Event $event) => $event->getTranslatable('name', app()->getLocale()))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'email')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Toggle::make('confirmation_email')
                    ->default(true)
                    ->label(__('signup.confirmation_email')),
                Forms\Components\Toggle::make('reminder_email')
                    ->default(true)
                    ->label(__('signup.reminder_email')),
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'signup' => __("signup.status.signup"),
                        'confirmed' => __("signup.status.confirmed"),
                        'cancelled' => __("signup.status.cancelled"),
                        'no-show' => __("signup.status.no-show"),
                        'attended' => __("signup.status.attended"),
                    ])
                    ->label(__('signup.status')),
                Tables\Filters\SelectFilter::make('event_id')
                    ->relationship('event', 'name->de')
                    ->getOptionLabelFromRecordUsing(fn (Event $event) => $event->getTranslatable('name', app()->getLocale()))
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('contact_id')
                    ->relationship('contact', 'email')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make("canton")
                    ->label(__("filterlables.contacts.canton"))
                    ->multiple()
                    ->modifyQueryUsing(function (Builder $query, $state) {
                        if (!$state['values']) {
                            return $query;
                        }
                        $query->whereHas('contact', function ($query) use ($state) {
                            $query->whereIn('canton', $state["values"]);
                        });
                    })
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
                    ]),
                Tables\Filters\SelectFilter::make("eventcanton")
                    ->label(__("filterlables.events.canton"))
                    ->multiple()
                    ->modifyQueryUsing(function (Builder $query, $state) {
                        if (!$state['values']) {
                            return $query;
                        }
                        $query->whereHas('event', function ($query) use ($state) {
                            $query->whereIn('canton', $state["values"]);
                        });
                    })
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
            RelationManagers\EmailNotificationRelationManager::class,
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Personal Information')
                    ->schema([
                        Infolists\Components\Fieldset::make('signup')
                            ->label(__("signup.infolist.label"))
                            ->schema([
                                Infolists\Components\IconEntry::make("status")
                                    ->icon(fn (Signup $signup) => match ($signup->status) {
                                        'signup' => 'heroicon-o-question-mark-circle',
                                        'confirmed' => 'heroicon-o-check-circle',
                                        'cancelled' => 'heroicon-o-x-circle',
                                        'no-show' => 'heroicon-o-face-frown',
                                        'attended' => 'heroicon-s-shield-check',
                                    })
                                    ->color(fn (Signup $signup) => match ($signup->status) {
                                        'signup' => 'warning',
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                        'no-show' => 'danger',
                                        'attended' => 'success',
                                    })
                                    ->label(__("signup.infolist.status")),
                                Infolists\Components\TextEntry::make('contact.email')
                                    ->url(fn (Signup $signup) => route('filament.admin.resources.contacts.view', $signup->contact))
                                    ->label(__("signup.infolist.contact")),
                                Infolists\Components\TextEntry::make('event.name')
                                    ->url(fn (Signup $signup) => route('filament.admin.resources.events.view', $signup->event ?? 1))
                                    ->label(__("signup.infolist.event")),
                            ]),
                    ]),
                Infolists\Components\Section::make('Comments')
                    ->schema([
                            CommentsEntry::make('filament_comments')
                                ->columnSpanFull(),
                    ]),
            ]);
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
