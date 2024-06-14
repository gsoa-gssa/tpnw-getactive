<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OneclickResource\Pages;
use App\Filament\Resources\OneclickResource\RelationManagers;
use App\Models\Oneclick;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OneclickResource extends Resource
{
    protected static ?string $model = Oneclick::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Repeater::make('fields')
                    ->required()
                    ->schema([
                        Forms\Components\Select::make('field')
                            ->options([
                                'firstname' => 'First Name',
                                'lastname' => 'Last Name',
                                'email' => 'Email',
                                'zip' => 'Zip',
                                'phone' => 'Phone',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('value')
                            ->required(),
                    ])
                    ->minItems(1)
                    ->helperText('Add fields that can be prefilled with the link e.g. Merge Tags from Mailchimp')
                    ->columnSpanFull(),
                Forms\Components\Tabs::make("Successmessages")
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('German')
                            ->schema([
                                Forms\Components\RichEditor::make('successmessages.de')
                                    ->label('German Success Message')
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('French')
                            ->schema([
                                Forms\Components\RichEditor::make('successmessages.fr')
                                    ->label('French Success Message')
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Italian')
                            ->schema([
                                Forms\Components\RichEditor::make('successmessages.it')
                                    ->label('Italian Success Message')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.name')
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
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOneclicks::route('/'),
            'create' => Pages\CreateOneclick::route('/create'),
            'edit' => Pages\EditOneclick::route('/{record}/edit'),
        ];
    }
}
