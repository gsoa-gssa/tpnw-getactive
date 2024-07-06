<?php

namespace App\Filament\Resources\ContactResource\RelationManagers;

use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SignupsRelationManager extends RelationManager
{
    protected static string $relationship = 'signups';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->preload()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('event.name')
                    ->label('Event'),
                Tables\Columns\IconColumn::make("status")
                    ->icon(fn (string $state): string => match ($state) {
                        'signup' => 'heroicon-o-question-mark-circle',
                        'confirmed' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        'no-show' => 'heroicon-o-face-frown',
                        'attended' => 'heroicon-o-shield-check',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'signup' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'warning',
                        'no-show' => 'danger',
                        'attended' => 'success',
                    })
                    ->label('Status')
            ])
            ->filters([
                Tables\Filters\Filter::make("my_events")
                    ->label(__("filterlables.events.my_events"))
                    ->modifyQueryUsing(function (Builder $query){
                        $query->whereHas('event', function (Builder $query) {
                            $query->whereHas("users", function (Builder $query) {
                                $query->where("user_id", auth()->id());
                            });
                        });
                        return $query;
                    })
                    ->toggle()
                    ->default(false),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'signup' => __("signup.status.signup"),
                        'confirmed' => __("signup.status.confirmed"),
                        'cancelled' => __("signup.status.cancelled"),
                        'no-show' => __("signup.status.no-show"),
                    ])
                    ->label('Status'),
                Tables\Filters\Filter::make("only_future")
                    ->label(__("filterlables.events.only_future"))
                    ->default(true)
                    ->toggle()
                    ->modifyQueryUsing(function (Builder $query) {
                        $query->whereHas('event', function ($query) {
                            $query->where('date', '>=', date('Y-m-d', strtotime('today')));
                        });
                        return $query;
                    }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make("confirm_signup")
                        ->label(__("actionlabels.signup.confirm"))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => $record->status != 'confirmed')
                        ->action(fn ($record) => $record->update(['status' => 'confirmed'])),
                Tables\Actions\Action::make("edit")
                    ->icon('heroicon-o-pencil-square')
                    ->label(__("actionlabels.signups.edit"))
                    ->url(fn ($record) => route('filament.admin.resources.signups.edit', $record)),
                Tables\Actions\EditAction::make("quick_edit")
                    ->icon('heroicon-o-forward')
                    ->label(__("actionlabels.signups.quick_edit")),
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
                ])->visible(fn ($record) => $record->status === 'signup'),
                Tables\Actions\Action::make("reset_signup")
                    ->label(__("actionlabels.signup.reset"))
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(fn ($record) => $record->update(['status' => 'signup']))
                    ->visible(fn ($record) => $record->status !== 'signup'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Remove readOnly constraint.
     */
    public function isReadOnly(): bool
    {
        return false;
    }
}
