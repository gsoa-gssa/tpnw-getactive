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
                    ->relationship('event', 'name->de')
                    ->getOptionLabelFromRecordUsing(function(Event $event) {
                        return date("d.m.Y", strtotime($event->date)) . ": " . $event->getTranslatable('name', app()->getLocale());
                    })
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
                Tables\Columns\TextColumn::make('status')
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
                    ->default(true),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
