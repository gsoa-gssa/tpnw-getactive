<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Oneclick;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\OneclickResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OneclickResource\RelationManagers;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;


class OneclickResource extends Resource
{
    protected static ?string $model = Oneclick::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uuid')
                    ->default(\Illuminate\Support\Str::uuid()->toString())
                    ->readOnly()
                    ->columnSpanFull(),
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
                    ->default([
                        [
                            'field' => 'email',
                            'value' => '',
                        ]
                    ])
                    ->minItems(1)
                    ->hintAction(
                        Action::make('mailchimp_defaults')
                            ->label(__("actionlables.mailchimp_defaults"))
                            ->action(function (Set $set, $state){
                                $fields[] = [
                                    'field' => 'firstname',
                                    'value' => '*|FNAME|*',
                                ];
                                $fields[] = [
                                    'field' => 'lastname',
                                    'value' => '*|LNAME|*',
                                ];
                                $fields[] = [
                                    'field' => 'phone',
                                    'value' => '*|PHONE|*',
                                ];
                                $fields[] = [
                                    'field' => 'zip',
                                    'value' => '*|ZIP|*',
                                ];
                                $fields[] = [
                                    'field' => 'email',
                                    'value' => '*|EMAIL|*',
                                ];
                                return $set('fields', $fields);
                            })
                    )
                    ->columns(2)
                    ->columnSpanFull(),
                Forms\Components\Tabs::make("Successmessages")
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('German')
                            ->schema([
                                Forms\Components\RichEditor::make('successmessage.de')
                                    ->label('German Success Message')
                                    ->default(<<<EOD
                                    <h1>Danke vielmals für deine Anmeldung ❣️</h1>
                                    <p><b>Super cool, dass du an unserer Veranstaltung teilnimmst!</b> Wir werden uns ganz bald mit Details bei dir melden.</p>
                                    EOD)
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('French')
                            ->schema([
                                Forms\Components\RichEditor::make('successmessage.fr')
                                    ->label('French Success Message')
                                    ->default(<<<EOD
                                    <h1>Merci beaucoup pour votre inscription ❣️</h1>
                                    <p><b>C'est super cool que vous participez à notre événement!</b> Nous vous contacterons très bientôt avec des détails.</p>
                                    EOD)
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Italian')
                            ->schema([
                                Forms\Components\RichEditor::make('successmessage.it')
                                    ->label('Italian Success Message')
                                    ->default(<<<EOD
                                    <h1>Grazie mille per la tua iscrizione ❣️</h1>
                                    <p><b>È fantastico che tu partecipi al nostro evento!</b> Ti contatteremo molto presto con i dettagli.</p>
                                    EOD)
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', "name->" . app()->getLocale())
                    ->searchable()
                    ->preload()
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
                Tables\Actions\ActionGroup::make([
                    CopyAction::make()->copyable(
                        function (Oneclick $oneclick) {
                            $url = "https://go.atomwaffenverbot.ch/oneclick/" . $oneclick->uuid;
                            foreach ($oneclick->fields as $field) {
                                $separator = strpos($url, "?") === false ? "?" : "&";
                                $url .= $separator . $field["field"] . "=" . $field["value"];
                            }
                            return $url;
                        }
                    )->label(__("actionlables.copy.de")),
                    CopyAction::make()->copyable(
                        function (Oneclick $oneclick) {
                            $url = "https://go.interdiction-armes-nucleaires.ch/oneclick/" . $oneclick->uuid;
                            foreach ($oneclick->fields as $field) {
                                $separator = strpos($url, "?") === false ? "?" : "&";
                                $url .= $separator . $field["field"] . "=" . $field["value"];
                            }
                            return $url;
                        }
                    )->label(__("actionlables.copy.fr")),
                    CopyAction::make()->copyable(
                        function (Oneclick $oneclick) {
                            $url = "https://go.divieto-armi-nucleari.ch/oneclick/" . $oneclick->uuid;
                            foreach ($oneclick->fields as $field) {
                                $separator = strpos($url, "?") === false ? "?" : "&";
                                $url .= $separator . $field["field"] . "=" . $field["value"];
                            }
                            return $url;
                        }
                    )->label(__("actionlables.copy.it")),
                ])
                ->button()
                ->label(__("actionlables.copy")),
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
            'view' => Pages\ViewOneclick::route('/{record}'),
        ];
    }
}
