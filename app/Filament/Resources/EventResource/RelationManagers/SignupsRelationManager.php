<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
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
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'email')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'signup' => 'Signup',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'no-show' => 'No Show',
                    ])
                    ->default('signup')
                    ->required(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name->de')
                    ->searchable()
                    ->preload()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\IconColumn::make("status")
                    ->icon(fn (string $state): string => match ($state) {
                        'signup' => 'heroicon-o-question-mark-circle',
                        'confirmed' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        'no-show' => 'heroicon-o-face-frown',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'signup' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'warning',
                        'no-show' => 'danger'
                    })
                    ->label('Status'),
                Tables\Columns\TextColumn::make('contact.email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('contact.firstname')
                    ->label('First Name')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact.lastname')
                    ->label('Last Name')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact.zip')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact.phone')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'signup' => 'Signup',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'no-show' => 'No Show',
                    ])
                    ->default('signup')
                    ->label('Status'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\ExportAction::make()
                    ->label('Export Signups')
                    ->exporter('App\Filament\Exports\SignupExporter'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make("confirm_signup")
                        ->label(__("actionlabels.signup.confirm"))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($record) => $record->update(['status' => 'confirmed'])),
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
