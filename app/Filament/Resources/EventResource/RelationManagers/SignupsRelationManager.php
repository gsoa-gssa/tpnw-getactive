<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Models\Contact;
use Filament\Forms;
use Filament\Tables;
use App\Models\Event;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SignupsRelationManager extends RelationManager
{
    protected static string $relationship = 'signups';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make("contact_id")
                    ->relationship(
                        "contact",
                        "id"
                    )
                    ->searchable()
                    ->preload()
                    ->columnSpanFull()
                    ->getOptionLabelFromRecordUsing(fn(Contact $contact) => $contact->firstname . " " . $contact->lastname . " (" . $contact->email . ")"),
                Forms\Components\ToggleButtons::make('status')
                    ->options([
                        'signup' => __("signup.status.signup"),
                        'confirmed' => __("signup.status.confirmed"),
                    ])
                    ->inline()
                    ->default('confirmed'),
                Forms\Components\Select::make('event_id')
                    ->relationship(
                        'event',
                        'name->de',
                        modifyQueryUsing: function (Builder $query) {
                            $query->where('date', '>=', date('Y-m-d', strtotime(now())));
                            $query->orderBy('date', 'asc');
                            $query->where("reassign", false);
                        }
                    )
                    ->getOptionLabelFromRecordUsing(fn (Event $event) => date("d.m.Y", strtotime($event->date)) . ": " . $event->getTranslatable('name', app()->getLocale()))
                    ->searchable()
                    ->preload(),
                Forms\Components\Toggle::make('confirmation_email')
                    ->label(__("signup.confirmation_email"))
                    ->default(true),
                Forms\Components\Toggle::make('reminder_email')
                    ->label(__("signup.reminder_email"))
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make("status")
                    ->icon(fn (string $state): string => match ($state) {
                        'signup' => 'heroicon-o-question-mark-circle',
                        'confirmed' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        'no-show' => 'heroicon-o-face-frown',
                        'attended' => 'heroicon-s-shield-check',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'signup' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'warning',
                        'no-show' => 'danger',
                        'attended' => 'success',
                    })
                    ->label('Status'),
                Tables\Columns\TextColumn::make('contact.email')
                    ->url(fn ($record) => route('filament.admin.resources.contacts.view', $record->contact))
                    ->label(__("signup.email")),
                Tables\Columns\TextColumn::make('contact.firstname')
                    ->label(__("signup.firstname")),
                Tables\Columns\TextColumn::make('contact.lastname')
                    ->label(__("signup.lastname")),
                Tables\Columns\TextColumn::make('contact.phone')
                    ->label(__("signup.phone")),
                Tables\Columns\TextColumn::make('contact.zip')
                    ->label(__("signup.zip")),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'signup' => __("signup.status.signup"),
                        'confirmed' => __("signup.status.confirmed"),
                        'cancelled' => __("signup.status.cancelled"),
                        'no-show' => __("signup.status.no-show"),
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make('my_contacts')
                    ->label(__("filterlabels.contacts.my_contacts"))
                    ->toggle()
                    ->default(false)
                    ->modifyQueryUsing(function (Builder $query) {
                        $query->whereHas('contact', function ($query) {
                            $query->where('user_responsible_id', auth()->id());
                        });
                        return $query;
                    }),
                Tables\Filters\SelectFilter::make("canton")
                    ->label(__("filterlabels.contacts.canton"))
                    ->multiple()
                    ->query(function ($query, $state) {
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
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\ExportAction::make()
                    ->label('Export Signups')
                    ->exporter('App\Filament\Exports\SignupExporter'),
            ])
            ->actions([
                Tables\Actions\Action::make("confirm_signup")
                        ->label(__("actionlabels.signup.confirm"))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status === 'signup' && !$record->event->reassign)
                        ->action(fn ($record) => $record->update(['status' => 'confirmed'])),
                Tables\Actions\Action::make("edit")
                    ->icon('heroicon-o-pencil-square')
                    ->label(__("actionlabels.signups.edit"))
                    ->url(fn ($record) => route('filament.admin.resources.signups.edit', $record)),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make("cancel_signup")
                        ->label(__("actionlabels.signup.cancel"))
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update(['status' => 'cancelled'])),
                    Tables\Actions\Action::make("no_show_signup")
                        ->label(__("actionlabels.signup.no_show"))
                        ->icon('heroicon-o-face-frown')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update(['status' => 'no-show'])),
                    Tables\Actions\DeleteAction::make(),
                ])->visible(fn ($record) => $record->status === 'signup' && !$record->event->reassign),
                Tables\Actions\Action::make("reset_signup")
                    ->label(__("actionlabels.signup.reset"))
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(fn ($record) => $record->update(['status' => 'signup']))
                    ->visible(fn ($record) => $record->status !== 'signup' && !$record->event->reassign),
                Tables\Actions\EditAction::make()
                    ->label(__("actionlabels.signups.reassign"))
                    ->icon('heroicon-o-arrows-right-left')
                    ->visible(fn ($record) => $record->event->reassign)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make("confirm_signups")
                        ->label(__("actionlabels.signups.confirm"))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'confirmed'])),
                    Tables\Actions\BulkAction::make("cancel_signups")
                        ->label(__("actionlabels.signups.cancel"))
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'cancelled'])),
                    Tables\Actions\BulkAction::make("no_show_signups")
                        ->label(__("actionlabels.signups.no_show"))
                        ->icon('heroicon-o-face-frown')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'no-show'])),
                    Tables\Actions\BulkAction::make("reset_signups")
                        ->label(__("actionlabels.signups.reset"))
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'signup'])),
                ]),
            ]);
    }

    /**
     * Turn of read only for view page
     */
    public function isReadOnly(): bool
    {
        return false;
    }
}
